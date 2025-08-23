<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\VisitorSignin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Carbon\Carbon;

class LeadController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display the leads dashboard.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // Get all leads for user's properties
        $leads = VisitorSignin::whereHas('property', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->with('property')
        ->orderBy('created_at', 'desc');

        // Filter by status
        if ($request->filled('status')) {
            $leads->where('lead_status', $request->status);
        }

        // Filter by property
        if ($request->filled('property_id')) {
            $leads->where('property_id', $request->property_id);
        }

        // Search by name or email
        if ($request->filled('search')) {
            $search = $request->search;
            $leads->where(function ($query) use ($search) {
                $query->where('first_name', 'like', "%{$search}%")
                      ->orWhere('last_name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $leads = $leads->paginate(20);

        // Get user's properties for filter
        $properties = Property::where('user_id', $user->id)->get();

        // Get lead statistics
        $stats = $this->getLeadStats($user->id);

        return view('leads.index', compact('leads', 'properties', 'stats'));
    }

    /**
     * Show lead details.
     */
    public function show(VisitorSignin $lead)
    {
        $this->authorize('view', $lead);

        $lead->load('property');

        return view('leads.show', compact('lead'));
    }

    /**
     * Update lead status.
     */
    public function updateStatus(Request $request, VisitorSignin $lead)
    {
        $this->authorize('update', $lead);

        $request->validate([
            'lead_status' => 'required|in:new,contacted,qualified,showing_scheduled,offer_made,closed,lost',
            'notes' => 'nullable|string|max:1000',
        ]);

        $lead->lead_status = $request->lead_status;

        if ($request->filled('notes')) {
            $lead->notes = $request->notes;
        }

        // Add interaction
        $lead->addInteraction('status_change', "Status changed to: " . $request->lead_status, Auth::id());

        $lead->save();

        return back()->with('success', 'Lead status updated successfully.');
    }

    /**
     * Mark lead as contacted.
     */
    public function markContacted(Request $request, VisitorSignin $lead)
    {
        $this->authorize('update', $lead);

        $request->validate([
            'contact_method' => 'required|in:email,phone,text,in_person',
            'notes' => 'nullable|string|max:1000',
        ]);

        $lead->markAsContacted($request->contact_method);

        if ($request->filled('notes')) {
            $lead->notes = $request->notes;
        }

        $lead->save();

        return back()->with('success', 'Lead marked as contacted.');
    }

    /**
     * Schedule follow-up.
     */
    public function scheduleFollowUp(Request $request, VisitorSignin $lead)
    {
        $this->authorize('update', $lead);

        $request->validate([
            'follow_up_date' => 'required|date|after:today',
            'follow_up_time' => 'required|date_format:H:i',
            'reason' => 'required|string|max:255',
            'notes' => 'nullable|string|max:1000',
        ]);

        $followUpDateTime = Carbon::parse($request->follow_up_date . ' ' . $request->follow_up_time);

        $lead->scheduleFollowUp($followUpDateTime, $request->reason);

        if ($request->filled('notes')) {
            $lead->notes = $request->notes;
        }

        $lead->save();

        return back()->with('success', 'Follow-up scheduled successfully.');
    }

    /**
     * Add note to lead.
     */
    public function addNote(Request $request, VisitorSignin $lead)
    {
        $this->authorize('update', $lead);

        $request->validate([
            'note' => 'required|string|max:1000',
        ]);

        $currentNotes = $lead->notes ? $lead->notes . "\n\n" : '';
        $lead->notes = $currentNotes . now()->format('M j, Y g:i A') . " - " . $request->note;

        $lead->addInteraction('note_added', $request->note, Auth::id());
        $lead->save();

        return back()->with('success', 'Note added successfully.');
    }

    /**
     * Get leads that need follow-up.
     */
    public function followUps()
    {
        $user = Auth::user();

        $overdueLeads = VisitorSignin::whereHas('property', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->where('next_follow_up_at', '<', now())
        ->whereNotIn('lead_status', ['closed', 'lost'])
        ->with('property')
        ->orderBy('next_follow_up_at', 'asc')
        ->get();

        $upcomingLeads = VisitorSignin::whereHas('property', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->where('next_follow_up_at', '>=', now())
        ->where('next_follow_up_at', '<=', now()->addDays(7))
        ->whereNotIn('lead_status', ['closed', 'lost'])
        ->with('property')
        ->orderBy('next_follow_up_at', 'asc')
        ->get();

        return view('leads.follow-ups', compact('overdueLeads', 'upcomingLeads'));
    }

    /**
     * Get lead statistics.
     */
    private function getLeadStats($userId)
    {
        $leads = VisitorSignin::whereHas('property', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        });

        $totalLeads = $leads->count();
        $newLeads = $leads->where('lead_status', 'new')->count();
        $contactedLeads = $leads->where('lead_status', 'contacted')->count();
        $qualifiedLeads = $leads->where('lead_status', 'qualified')->count();
        $closedLeads = $leads->where('lead_status', 'closed')->count();

        $overdueFollowUps = $leads->where('next_follow_up_at', '<', now())
            ->whereNotIn('lead_status', ['closed', 'lost'])
            ->count();

        $conversionRate = $totalLeads > 0 ? round(($closedLeads / $totalLeads) * 100, 1) : 0;

        return [
            'total' => $totalLeads,
            'new' => $newLeads,
            'contacted' => $contactedLeads,
            'qualified' => $qualifiedLeads,
            'closed' => $closedLeads,
            'overdue_follow_ups' => $overdueFollowUps,
            'conversion_rate' => $conversionRate,
        ];
    }

    /**
     * Export leads.
     */
    public function export(Request $request)
    {
        $user = Auth::user();

        $leads = VisitorSignin::whereHas('property', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->with('property')
        ->get();

        $filename = 'leads-export-' . now()->format('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($leads) {
            $file = fopen('php://output', 'w');

            // CSV headers
            fputcsv($file, [
                'Name',
                'Email',
                'Phone',
                'Property',
                'Lead Status',
                'Lead Score',
                'Signed In',
                'Last Contacted',
                'Contact Attempts',
                'Notes'
            ]);

            // CSV data
            foreach ($leads as $lead) {
                fputcsv($file, [
                    $lead->full_name,
                    $lead->email,
                    $lead->phone,
                    $lead->property->title,
                    $lead->lead_status,
                    $lead->lead_score,
                    $lead->signed_in_at->format('Y-m-d H:i:s'),
                    $lead->last_contacted_at ? $lead->last_contacted_at->format('Y-m-d H:i:s') : '',
                    $lead->contact_attempts,
                    $lead->notes
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
