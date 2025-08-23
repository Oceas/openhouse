@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Team Management</h1>
                    <p class="mt-2 text-gray-600">Manage your teams and collaborate with others</p>
                </div>
                @if(!$ownedTeam)
                    <a href="{{ route('teams.create') }}" class="bg-indigo-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-indigo-700 transition-colors">
                        Create Team
                    </a>
                @endif
            </div>
        </div>

        <!-- Owned Team -->
        @if($ownedTeam)
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
            <div class="p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 mb-2">{{ $ownedTeam->name }}</h2>
                        <p class="text-gray-600 mb-4">{{ $ownedTeam->description }}</p>
                        <div class="flex items-center space-x-4 text-sm text-gray-500">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Owner
                            </span>
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"/>
                                </svg>
                                {{ $ownedTeam->users()->count() }} members
                            </span>
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm3 2a1 1 0 000 2h6a1 1 0 100-2H7zm0 4a1 1 0 000 2h6a1 1 0 100-2H7zm0 4a1 1 0 000 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                                </svg>
                                {{ $ownedTeam->properties()->count() }} properties
                            </span>
                        </div>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('teams.show', $ownedTeam) }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700 transition-colors">
                            View Team
                        </a>
                        <a href="{{ route('teams.edit', $ownedTeam) }}" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors">
                            Settings
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Joined Teams -->
        @if($joinedTeams->count() > 0)
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Teams You've Joined</h3>
                <div class="space-y-4">
                    @foreach($joinedTeams as $team)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="font-medium text-gray-900">{{ $team->name }}</h4>
                                <p class="text-sm text-gray-600 mt-1">{{ $team->description }}</p>
                                <div class="flex items-center space-x-4 text-sm text-gray-500 mt-2">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                                        </svg>
                                        {{ $team->owner->name }}
                                    </span>
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"/>
                                        </svg>
                                        {{ $team->users()->count() }} members
                                    </span>
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm3 2a1 1 0 000 2h6a1 1 0 100-2H7zm0 4a1 1 0 000 2h6a1 1 0 100-2H7zm0 4a1 1 0 000 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $team->properties()->count() }} properties
                                    </span>
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <a href="{{ route('teams.show', $team) }}" class="bg-indigo-600 text-white px-3 py-1 rounded text-sm font-medium hover:bg-indigo-700 transition-colors">
                                    View
                                </a>
                                <form action="{{ route('teams.leave', $team) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to leave this team?')">
                                    @csrf
                                    <button type="submit" class="bg-red-100 text-red-700 px-3 py-1 rounded text-sm font-medium hover:bg-red-200 transition-colors">
                                        Leave
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- No Teams Message -->
        @if(!$ownedTeam && $joinedTeams->count() === 0)
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No teams yet</h3>
                <p class="mt-1 text-sm text-gray-500">Get started by creating your first team or joining an existing one.</p>
                <div class="mt-6">
                    <a href="{{ route('teams.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                        Create Team
                    </a>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
