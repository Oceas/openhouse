@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                        Lead Details
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-2">
                        {{ $lead->full_name }} - {{ $lead->property->title }}
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

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Lead Information -->
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl border border-gray-200 dark:border-gray-700">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">
                            Lead Information
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Basic Information -->
                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">
                                    Full Name
                                </label>
                                <p class="text-lg font-medium text-gray-900 dark:text-white">
                                    {{ $lead->full_name }}
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">
                                    Email Address
                                </label>
                                <p class="text-lg font-medium text-gray-900 dark:text-white">
                                    <a href="mailto:{{ $lead->email }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-500">
                                        {{ $lead->email }}
                                    </a>
                                </p>
                            </div>

                            @if($lead->phone)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">
                                        Phone Number
                                    </label>
                                    <p class="text-lg font-medium text-gray-900 dark:text-white">
                                        <a href="tel:{{ $lead->phone }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-500">
                                            {{ $lead->phone }}
                                        </a>
                                    </p>
                                </div>
                            @endif

                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">
                                    Lead Status
                                </label>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $lead->lead_status_color }}">
                                    {{ \App\Models\VisitorSignin::getLeadStatusOptions()[$lead->lead_status] ?? 'Unknown' }}
                                </span>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">
                                    Lead Score
                                </label>
                                <div class="flex items-center">
                                    <span class="text-lg font-semibold text-gray-900 dark:text-white mr-2">
                                        {{ $lead->lead_score }}/10
                                    </span>
                                    <div class="flex-1 bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                        <div class="bg-indigo-600 h-2 rounded-full" style="width: {{ ($lead->lead_score / 10) * 100 }}%"></div>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">
                                    Signed In
                                </label>
                                <p class="text-lg font-medium text-gray-900 dark:text-white">
                                    {{ $lead->signed_in_at->format('M j, Y g:i A') }}
                                </p>
                            </div>

                            @if($lead->last_contacted_at)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">
                                        Last Contacted
                                    </label>
                                    <p class="text-lg font-medium text-gray-900 dark:text-white">
                                        {{ $lead->last_contacted_at->format('M j, Y g:i A') }}
                                        <span class="text-sm text-gray-500">({{ $lead->getDaysSinceLastContact() }} days ago)</span>
                                    </p>
                                </div>
                            @endif
                        </div>

                        <!-- Interest Information -->
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-6 mt-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                                Interest Details
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">
                                        Timeline to Buy
                                    </label>
                                    <p class="text-lg font-medium text-gray-900 dark:text-white">
                                        {{ ucfirst(str_replace('_', ' ', $lead->timeline_to_buy ?? 'Not specified')) }}
                                    </p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">
                                        Budget Range
                                    </label>
                                    <p class="text-lg font-medium text-gray-900 dark:text-white">
                                        {{ $lead->budget_range }}
                                    </p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">
                                        Current Home Status
                                    </label>
                                    <p class="text-lg font-medium text-gray-900 dark:text-white">
                                        {{ ucfirst($lead->current_home_status ?? 'Not specified') }}
                                    </p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">
                                        Source
                                    </label>
                                    <p class="text-lg font-medium text-gray-900 dark:text-white">
                                        {{ ucfirst(str_replace('_', ' ', $lead->source ?? 'Not specified')) }}
                                    </p>
                                </div>
                            </div>

                            <!-- Interest Checkboxes -->
                            <div class="mt-4 space-y-2">
                                @if($lead->interested_in_similar_properties)
                                    <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                        <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Interested in similar properties
                                    </div>
                                @endif

                                @if($lead->interested_in_financing_info)
                                    <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                        <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Interested in financing information
                                    </div>
                                @endif

                                @if($lead->interested_in_market_analysis)
                                    <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                        <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Interested in market analysis
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Notes -->
                        @if($lead->notes)
                            <div class="border-t border-gray-200 dark:border-gray-700 pt-6 mt-6">
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">
                                    Notes
                                </label>
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                    <p class="text-gray-900 dark:text-white whitespace-pre-line">
                                        {{ $lead->notes }}
                                    </p>
                                </div>
                            </div>
                        @endif

                        <!-- Interaction History -->
                        @if($lead->interaction_history && count($lead->interaction_history) > 0)
                            <div class="border-t border-gray-200 dark:border-gray-700 pt-6 mt-6">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                                    Interaction History
                                </h3>
                                <div class="space-y-3">
                                    @foreach($lead->interaction_history as $interaction)
                                        <div class="flex items-start space-x-3 p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                            <div class="flex-shrink-0">
                                                <div class="w-2 h-2 bg-indigo-500 rounded-full mt-2"></div>
                                            </div>
                                            <div class="flex-1">
                                                <p class="text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ ucfirst($interaction['type']) }}
                                                </p>
                                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                                    {{ $interaction['description'] }}
                                                </p>
                                                <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">
                                                    {{ \Carbon\Carbon::parse($interaction['timestamp'])->format('M j, Y g:i A') }}
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Action Panel -->
            <div class="lg:col-span-1">
                <!-- Status Update -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl border border-gray-200 dark:border-gray-700 mb-6">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                            Update Status
                        </h3>
                        <form method="POST" action="{{ route('leads.update-status', $lead) }}">
                            @csrf
                            @method('PATCH')
                            <div class="mb-4">
                                <label for="lead_status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Lead Status
                                </label>
                                <select name="lead_status" id="lead_status" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                    @foreach(\App\Models\VisitorSignin::getLeadStatusOptions() as $value => $label)
                                        <option value="{{ $value }}" {{ $lead->lead_status == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-4">
                                <label for="status_notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Notes (Optional)
                                </label>
                                <textarea name="notes" id="status_notes" rows="3" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white" placeholder="Add notes about this status change..."></textarea>
                            </div>
                            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                                Update Status
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl border border-gray-200 dark:border-gray-700 mb-6">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                            Quick Actions
                        </h3>
                        <div class="space-y-3">
                            <button onclick="markContacted('{{ $lead->id }}')"
                                    class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-3 rounded-lg font-medium transition-colors duration-200 flex items-center justify-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                Mark as Contacted
                            </button>

                            <button onclick="scheduleFollowUp('{{ $lead->id }}')"
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded-lg font-medium transition-colors duration-200 flex items-center justify-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Schedule Follow-up
                            </button>

                            <button onclick="addNote('{{ $lead->id }}')"
                                    class="w-full bg-purple-600 hover:bg-purple-700 text-white px-4 py-3 rounded-lg font-medium transition-colors duration-200 flex items-center justify-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Add Note
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Property Information -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl border border-gray-200 dark:border-gray-700">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                            Property Information
                        </h3>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">
                                    Property
                                </label>
                                <p class="text-gray-900 dark:text-white font-medium">
                                    {{ $lead->property->title }}
                                </p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">
                                    Address
                                </label>
                                <p class="text-gray-900 dark:text-white">
                                    {{ $lead->property->full_address }}
                                </p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">
                                    Price
                                </label>
                                <p class="text-gray-900 dark:text-white font-semibold">
                                    {{ $lead->property->formatted_price }}
                                </p>
                            </div>
                            <div class="pt-3">
                                <a href="{{ route('properties.show', $lead->property) }}"
                                   class="w-full bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center justify-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    View Property
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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

<!-- Schedule Follow-up Modal -->
<div id="followUpModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Schedule Follow-up</h3>
            <form id="followUpForm" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="follow_up_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Date</label>
                    <input type="date" name="follow_up_date" id="follow_up_date" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                </div>
                <div class="mb-4">
                    <label for="follow_up_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Time</label>
                    <input type="time" name="follow_up_time" id="follow_up_time" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                </div>
                <div class="mb-4">
                    <label for="follow_up_reason" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Reason</label>
                    <input type="text" name="reason" id="follow_up_reason" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white" placeholder="e.g., Follow-up call, Property showing">
                </div>
                <div class="mb-4">
                    <label for="follow_up_notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Notes (Optional)</label>
                    <textarea name="notes" id="follow_up_notes" rows="3" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white" placeholder="Add any notes..."></textarea>
                </div>
                <div class="flex space-x-3">
                    <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                        Schedule
                    </button>
                    <button type="button" onclick="closeFollowUpModal()" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Note Modal -->
<div id="noteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Add Note</h3>
            <form id="noteForm" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="note_content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Note</label>
                    <textarea name="note" id="note_content" rows="4" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white" placeholder="Add your note here..."></textarea>
                </div>
                <div class="flex space-x-3">
                    <button type="submit" class="flex-1 bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                        Add Note
                    </button>
                    <button type="button" onclick="closeNoteModal()" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-lg font-medium transition-colors duration-200">
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

function scheduleFollowUp(leadId) {
    const modal = document.getElementById('followUpModal');
    const form = document.getElementById('followUpForm');
    form.action = `/leads/${leadId}/follow-up`;
    modal.classList.remove('hidden');
}

function addNote(leadId) {
    const modal = document.getElementById('noteModal');
    const form = document.getElementById('noteForm');
    form.action = `/leads/${leadId}/notes`;
    modal.classList.remove('hidden');
}

function closeContactModal() {
    const modal = document.getElementById('contactModal');
    modal.classList.add('hidden');
}

function closeFollowUpModal() {
    const modal = document.getElementById('followUpModal');
    modal.classList.add('hidden');
}

function closeNoteModal() {
    const modal = document.getElementById('noteModal');
    modal.classList.add('hidden');
}
</script>
@endsection
