@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Team Members</h1>
                    <p class="mt-2 text-gray-600">Manage members and permissions for {{ $team->name }}</p>
                </div>
                @if($team->canInviteUsers(auth()->user()))
                    <button onclick="document.getElementById('inviteModal').classList.remove('hidden')" class="bg-indigo-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-indigo-700 transition-colors">
                        Invite Member
                    </button>
                @endif
            </div>
        </div>

        <!-- Members List -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">Current Members</h2>
                
                <div class="space-y-4">
                    @foreach($teamMembers as $member)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center">
                                    <span class="text-lg font-medium text-indigo-600">{{ substr($member->name, 0, 1) }}</span>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-medium text-gray-900">{{ $member->name }}</h3>
                                    <p class="text-sm text-gray-600">{{ $member->email }}</p>
                                    <div class="flex items-center space-x-2 mt-1">
                                        @if($team->isOwner($member))
                                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-medium">Owner</span>
                                        @else
                                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-medium">{{ ucfirst($member->pivot->role) }}</span>
                                        @endif
                                        <span class="text-xs text-gray-500">Joined {{ $member->pivot->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex items-center space-x-3">
                                @if($team->isOwner(auth()->user()) && !$team->isOwner($member))
                                    <!-- Role Management -->
                                    <div class="relative" x-data="{ open: false }">
                                        <button @click="open = !open" class="bg-gray-100 text-gray-700 px-3 py-1 rounded text-sm font-medium hover:bg-gray-200 transition-colors">
                                            Change Role
                                        </button>
                                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10">
                                            <form action="{{ route('teams.update-member-role', $team) }}" method="POST" class="py-1">
                                                @csrf
                                                <input type="hidden" name="member_id" value="{{ $member->id }}">
                                                <button type="submit" name="role" value="member" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                    Member
                                                </button>
                                                <button type="submit" name="role" value="admin" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                    Admin
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endif
                                
                                @if($team->isAdmin(auth()->user()) && !$team->isOwner($member) && $member->id !== auth()->id())
                                    <!-- Remove Member -->
                                    <form action="{{ route('teams.remove-member', $team) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to remove {{ $member->name }} from the team?')">
                                        @csrf
                                        <input type="hidden" name="member_id" value="{{ $member->id }}">
                                        <button type="submit" class="bg-red-100 text-red-700 px-3 py-1 rounded text-sm font-medium hover:bg-red-200 transition-colors">
                                            Remove
                                        </button>
                                    </form>
                                @endif
                                
                                @if($team->isOwner(auth()->user()) && !$team->isOwner($member))
                                    <!-- Transfer Ownership -->
                                    <form action="{{ route('teams.transfer-ownership', $team) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to transfer ownership to {{ $member->name }}? This action cannot be undone.')">
                                        @csrf
                                        <input type="hidden" name="new_owner_id" value="{{ $member->id }}">
                                        <button type="submit" class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded text-sm font-medium hover:bg-yellow-200 transition-colors">
                                            Make Owner
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Role Descriptions -->
        <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Role Permissions</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="border border-gray-200 rounded-lg p-4">
                        <h3 class="font-medium text-gray-900 mb-2">Owner</h3>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li>• Full team management</li>
                            <li>• Can transfer ownership</li>
                            <li>• Can delete the team</li>
                            <li>• Can change member roles</li>
                            <li>• Can invite/remove members</li>
                        </ul>
                    </div>
                    <div class="border border-gray-200 rounded-lg p-4">
                        <h3 class="font-medium text-gray-900 mb-2">Admin</h3>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li>• Can invite new members</li>
                            <li>• Can remove members</li>
                            <li>• Can manage properties</li>
                            <li>• Can view all analytics</li>
                            <li>• Cannot change ownership</li>
                        </ul>
                    </div>
                    <div class="border border-gray-200 rounded-lg p-4">
                        <h3 class="font-medium text-gray-900 mb-2">Member</h3>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li>• Can view team properties</li>
                            <li>• Can view team analytics</li>
                            <li>• Can manage leads</li>
                            <li>• Can add properties</li>
                            <li>• Cannot manage members</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Invite Modal -->
<div id="inviteModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Invite Team Member</h3>
            <form action="{{ route('teams.invite', $team) }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                        <input type="email" name="email" id="email" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            placeholder="Enter email address">
                    </div>
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                        <select name="role" id="role" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="member">Member</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                </div>
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" onclick="document.getElementById('inviteModal').classList.add('hidden')" 
                        class="bg-gray-100 text-gray-700 px-4 py-2 rounded-md text-sm font-medium hover:bg-gray-200 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-indigo-700 transition-colors">
                        Send Invitation
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
