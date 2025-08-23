@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                        Follow-ups
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-2">
                        Manage your scheduled follow-ups and overdue contacts
                    </p>
                </div>
                <a href="{{ route('leads.index') }}"
                   class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-xl font-medium transition-colors duration-200 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Leads
                </a>
            </div>
        </div>

        <!-- Overdue Follow-ups -->
        @if($overdueLeads->count() > 0)
            <div class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                    <svg class="w-6 h-6 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Overdue Follow-ups ({{ $overdueLeads->count() }})
                </h2>
                <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                    @foreach($overdueLeads as $lead)
                        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-6">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                        {{ $lead->full_name }}
                                    </h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $lead->email }}
                                    </p>
                                </div>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                                    Overdue
                                </span>
                            </div>

                            <div class="space-y-3 mb-4">
                                <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                    {{ $lead->property->title }}
                                </div>

                                <div class="flex items-center text-sm text-red-600 dark:text-red-400">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Due: {{ $lead->next_follow_up_at->format('M j, Y g:i A') }}
                                    <span class="ml-2">({{ $lead->next_follow_up_at->diffForHumans() }})</span>
                                </div>
                            </div>

                            <div class="flex space-x-2">
                                <a href="{{ route('leads.show', $lead) }}"
                                   class="flex-1 bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-200 text-center">
                                    View Details
                                </a>
                                <button onclick="markContacted('{{ $lead->id }}')"
                                        class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-200">
                                    Contact Now
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Upcoming Follow-ups -->
        @if($upcomingLeads->count() > 0)
            <div class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                    <svg class="w-6 h-6 text-orange-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Upcoming Follow-ups ({{ $upcomingLeads->count() }})
                </h2>
                <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                    @foreach($upcomingLeads as $lead)
                        <div class="bg-orange-50 dark:bg-orange-900/20 border border-orange-200 dark:border-orange-800 rounded-xl p-6">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                        {{ $lead->full_name }}
                                    </h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $lead->email }}
                                    </p>
                                </div>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-400">
                                    Upcoming
                                </span>
                            </div>

                            <div class="space-y-3 mb-4">
                                <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                    {{ $lead->property->title }}
                                </div>

                                <div class="flex items-center text-sm text-orange-600 dark:text-orange-400">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    Due: {{ $lead->next_follow_up_at->format('M j, Y g:i A') }}
                                    <span class="ml-2">({{ $lead->next_follow_up_at->diffForHumans() }})</span>
                                </div>
                            </div>

                            <div class="flex space-x-2">
                                <a href="{{ route('leads.show', $lead) }}"
                                   class="flex-1 bg-orange-600 hover:bg-orange-700 text-white px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-200 text-center">
                                    View Details
                                </a>
                                <button onclick="markContacted('{{ $lead->id }}')"
                                        class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-200">
                                    Contact Now
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- No Follow-ups -->
        @if($overdueLeads->count() == 0 && $upcomingLeads->count() == 0)
            <div class="text-center py-12">
                <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-gray-500 dark:text-gray-400">No follow-ups scheduled</p>
                <p class="text-sm text-gray-400 dark:text-gray-500 mt-2">All caught up! No overdue or upcoming follow-ups.</p>
            </div>
        @endif
    </div>
</div>

<!-- Mark Contacted Modal -->
<div id="contactModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Mark as Contacted</h3>
            <form id="contactForm" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="contact_method" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Contact Method</label>
                    <select name="contact_method" id="contact_method" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        <option value="email">Email</option>
                        <option value="phone">Phone</option>
                        <option value="text">Text</option>
                        <option value="in_person">In Person</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="contact_notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Notes (Optional)</label>
                    <textarea name="notes" id="contact_notes" rows="3" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white" placeholder="Add any notes about the contact..."></textarea>
                </div>
                <div class="flex space-x-3">
                    <button type="submit" class="flex-1 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                        Mark Contacted
                    </button>
                    <button type="button" onclick="closeContactModal()" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function markContacted(leadId) {
    const modal = document.getElementById('contactModal');
    const form = document.getElementById('contactForm');
    form.action = `/leads/${leadId}/contact`;
    modal.classList.remove('hidden');
}

function closeContactModal() {
    const modal = document.getElementById('contactModal');
    modal.classList.add('hidden');
}
</script>
@endsection
