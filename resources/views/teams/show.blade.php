@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-start">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">{{ $team->name }}</h1>
                    <p class="mt-2 text-gray-600">{{ $team->description }}</p>
                    <div class="flex items-center space-x-4 text-sm text-gray-500 mt-2">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                            </svg>
                            {{ $team->owner->name }} (Owner)
                        </span>
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"/>
                            </svg>
                            {{ $teamMembers->count() }} members
                        </span>
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm3 2a1 1 0 000 2h6a1 1 0 100-2H7zm0 4a1 1 0 000 2h6a1 1 0 100-2H7zm0 4a1 1 0 000 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                            </svg>
                            {{ $properties->total() }} properties
                        </span>
                    </div>
                </div>
                <div class="flex space-x-3">
                    @if($team->isOwner(auth()->user()))
                        <a href="{{ route('teams.edit', $team) }}" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors">
                            Settings
                        </a>
                    @endif
                    <a href="{{ route('teams.members', $team) }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700 transition-colors">
                        Manage Members
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Team Properties -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-semibold text-gray-900">Team Properties</h2>
                            <a href="{{ route('properties.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700 transition-colors">
                                Add Property
                            </a>
                        </div>
                        
                        @if($properties->count() > 0)
                            <div class="space-y-4">
                                @foreach($properties as $property)
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h3 class="font-medium text-gray-900">{{ $property->title }}</h3>
                                            <p class="text-sm text-gray-600 mt-1">{{ $property->full_address }}</p>
                                            <div class="flex items-center space-x-4 text-sm text-gray-500 mt-2">
                                                <span>{{ $property->formatted_price }}</span>
                                                <span>{{ $property->bedrooms }} beds</span>
                                                <span>{{ $property->bathrooms }} baths</span>
                                                <span class="capitalize">{{ $property->status }}</span>
                                            </div>
                                        </div>
                                        <div class="flex space-x-2">
                                            <a href="{{ route('properties.show', $property) }}" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">
                                                View
                                            </a>
                                            <a href="{{ route('properties.edit', $property) }}" class="text-gray-600 hover:text-gray-700 text-sm font-medium">
                                                Edit
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            
                            @if($properties->hasPages())
                                <div class="mt-6">
                                    {{ $properties->links() }}
                                </div>
                            @endif
                        @else
                            <div class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No properties yet</h3>
                                <p class="mt-1 text-sm text-gray-500">Get started by adding your first property.</p>
                                <div class="mt-6">
                                    <a href="{{ route('properties.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                        Add Property
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Recent Visitors -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Recent Visitors</h2>
                        
                        @if($recentVisitors->count() > 0)
                            <div class="space-y-4">
                                @foreach($recentVisitors as $visitor)
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h3 class="font-medium text-gray-900">{{ $visitor->name }}</h3>
                                            <p class="text-sm text-gray-600 mt-1">{{ $visitor->email }} • {{ $visitor->phone }}</p>
                                            <p class="text-sm text-gray-500 mt-1">Visited {{ $visitor->property->title }}</p>
                                            <div class="flex items-center space-x-4 text-sm text-gray-500 mt-2">
                                                <span>{{ $visitor->created_at->diffForHumans() }}</span>
                                                @if($visitor->lead_score)
                                                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">
                                                        Score: {{ $visitor->lead_score }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <a href="{{ route('visitor-signins.show', $visitor) }}" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No visitors yet</h3>
                                <p class="mt-1 text-sm text-gray-500">Visitor sign-ins will appear here.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-8">
                <!-- Team Members -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-lg font-semibold text-gray-900">Team Members</h2>
                            @if($team->canInviteUsers(auth()->user()))
                                <button onclick="document.getElementById('inviteModal').classList.remove('hidden')" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">
                                    Invite
                                </button>
                            @endif
                        </div>
                        
                        <div class="space-y-3">
                            @foreach($teamMembers as $member)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center">
                                        <span class="text-sm font-medium text-indigo-600">{{ substr($member->name, 0, 1) }}</span>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">{{ $member->name }}</p>
                                        <p class="text-xs text-gray-500">{{ ucfirst($member->pivot->role) }}</p>
                                    </div>
                                </div>
                                @if($team->isOwner($member))
                                    <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full">Owner</span>
                                @endif
                            </div>
                            @endforeach
                        </div>
                        
                        <div class="mt-4">
                            <a href="{{ route('teams.members', $team) }}" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">
                                View all members →
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h2>
                        <div class="space-y-3">
                            <a href="{{ route('properties.create') }}" class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                                <svg class="w-5 h-5 text-indigo-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                <span class="text-sm font-medium text-gray-900">Add Property</span>
                            </a>
                            <a href="{{ route('analytics.index') }}" class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                                <svg class="w-5 h-5 text-indigo-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                                <span class="text-sm font-medium text-gray-900">View Analytics</span>
                            </a>
                            <a href="{{ route('leads.index') }}" class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                                <svg class="w-5 h-5 text-indigo-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                <span class="text-sm font-medium text-gray-900">Manage Leads</span>
                            </a>
                        </div>
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
