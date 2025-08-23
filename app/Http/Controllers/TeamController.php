<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class TeamController extends Controller
{
    /**
     * Display the team dashboard.
     */
    public function index()
    {
        $user = auth()->user();
        $ownedTeam = $user->ownedTeam;
        $joinedTeams = $user->teams()->where('owner_id', '!=', $user->id)->get();

        return view('teams.index', compact('ownedTeam', 'joinedTeams'));
    }

    /**
     * Show the form for creating a new team.
     */
    public function create()
    {
        return view('teams.create');
    }

    /**
     * Store a newly created team.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $user = auth()->user();

        // Check if user already owns a team
        if ($user->ownedTeam) {
            return redirect()->route('teams.index')
                ->with('error', 'You already own a team. You can only own one team.');
        }

        $team = Team::createForUser($user, $request->all());

        return redirect()->route('teams.show', $team)
            ->with('success', 'Team created successfully!');
    }

    /**
     * Display the specified team.
     */
    public function show(Team $team)
    {
        $user = auth()->user();
        
        if (!$team->hasUser($user) && !$team->isOwner($user)) {
            abort(403, 'You do not have access to this team.');
        }

        $teamMembers = $team->users()->withPivot('role')->get();
        $properties = $team->properties()->latest()->paginate(10);
        $recentVisitors = $team->visitorSignins()->with('property')->latest()->take(5)->get();

        return view('teams.show', compact('team', 'teamMembers', 'properties', 'recentVisitors'));
    }

    /**
     * Show the form for editing the team.
     */
    public function edit(Team $team)
    {
        $user = auth()->user();
        
        if (!$team->isOwner($user)) {
            abort(403, 'Only the team owner can edit team settings.');
        }

        return view('teams.edit', compact('team'));
    }

    /**
     * Update the specified team.
     */
    public function update(Request $request, Team $team)
    {
        $user = auth()->user();
        
        if (!$team->isOwner($user)) {
            abort(403, 'Only the team owner can edit team settings.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $team->update($request->all());

        return redirect()->route('teams.show', $team)
            ->with('success', 'Team updated successfully!');
    }

    /**
     * Show team members management.
     */
    public function members(Team $team)
    {
        $user = auth()->user();
        
        if (!$team->hasUser($user)) {
            abort(403, 'You do not have access to this team.');
        }

        $teamMembers = $team->users()->withPivot('role')->get();
        $pendingInvitations = []; // TODO: Implement invitation system

        return view('teams.members', compact('team', 'teamMembers', 'pendingInvitations'));
    }

    /**
     * Invite a new member to the team.
     */
    public function invite(Request $request, Team $team)
    {
        $user = auth()->user();
        
        if (!$team->canInviteUsers($user)) {
            abort(403, 'You do not have permission to invite users.');
        }

        $request->validate([
            'email' => 'required|email|max:255',
            'role' => 'required|in:member,admin',
        ]);

        // Check if user already exists
        $invitedUser = User::where('email', $request->email)->first();

        if ($invitedUser && $team->hasUser($invitedUser)) {
            return back()->with('error', 'This user is already a member of the team.');
        }

        if ($invitedUser) {
            // User exists, add them to team
            $team->users()->attach($invitedUser->id, ['role' => $request->role]);
            
            // TODO: Send notification email
        } else {
            // User doesn't exist, create invitation
            // TODO: Implement invitation system
        }

        return back()->with('success', 'Invitation sent successfully!');
    }

    /**
     * Remove a member from the team.
     */
    public function removeMember(Request $request, Team $team)
    {
        $user = auth()->user();
        
        if (!$team->isAdmin($user)) {
            abort(403, 'You do not have permission to remove members.');
        }

        $memberId = $request->member_id;
        $member = User::findOrFail($memberId);

        if ($team->isOwner($member)) {
            return back()->with('error', 'Cannot remove the team owner.');
        }

        if ($member->id === $user->id) {
            return back()->with('error', 'Cannot remove yourself. Transfer ownership first.');
        }

        $team->users()->detach($memberId);

        return back()->with('success', 'Member removed successfully!');
    }

    /**
     * Update member role.
     */
    public function updateMemberRole(Request $request, Team $team)
    {
        $user = auth()->user();
        
        if (!$team->isOwner($user)) {
            abort(403, 'Only the team owner can change member roles.');
        }

        $request->validate([
            'member_id' => 'required|exists:users,id',
            'role' => 'required|in:member,admin',
        ]);

        $memberId = $request->member_id;
        $member = User::findOrFail($memberId);

        if ($team->isOwner($member)) {
            return back()->with('error', 'Cannot change the team owner\'s role.');
        }

        $team->users()->updateExistingPivot($memberId, ['role' => $request->role]);

        return back()->with('success', 'Member role updated successfully!');
    }

    /**
     * Transfer team ownership.
     */
    public function transferOwnership(Request $request, Team $team)
    {
        $user = auth()->user();
        
        if (!$team->isOwner($user)) {
            abort(403, 'Only the team owner can transfer ownership.');
        }

        $request->validate([
            'new_owner_id' => 'required|exists:users,id',
        ]);

        $newOwner = User::findOrFail($request->new_owner_id);

        if (!$team->hasUser($newOwner)) {
            return back()->with('error', 'The new owner must be a team member.');
        }

        $team->update(['owner_id' => $newOwner->id]);

        return redirect()->route('teams.show', $team)
            ->with('success', 'Team ownership transferred successfully!');
    }

    /**
     * Leave the team.
     */
    public function leave(Team $team)
    {
        $user = auth()->user();
        
        if ($team->isOwner($user)) {
            return back()->with('error', 'Team owners cannot leave. Transfer ownership first.');
        }

        if (!$team->hasUser($user)) {
            return back()->with('error', 'You are not a member of this team.');
        }

        $team->users()->detach($user->id);

        return redirect()->route('teams.index')
            ->with('success', 'You have left the team successfully.');
    }

    /**
     * Delete the team.
     */
    public function destroy(Team $team)
    {
        $user = auth()->user();
        
        if (!$team->isOwner($user)) {
            abort(403, 'Only the team owner can delete the team.');
        }

        $team->delete();

        return redirect()->route('teams.index')
            ->with('success', 'Team deleted successfully!');
    }
}
