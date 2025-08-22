@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <!-- Header -->
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Visitor Sign-ins</h2>
                        <p class="text-gray-600 dark:text-gray-400">{{ $property->title }}</p>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('properties.visitors.export', $property) }}"
                           class="bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 hover:bg-green-200 dark:hover:bg-green-800/50 px-4 py-2 rounded-xl font-medium transition-colors duration-200">
                            Export CSV
                        </a>
                        <a href="{{ route('properties.show', $property) }}"
                           class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 px-4 py-2 rounded-xl font-medium transition-colors duration-200">
                            Back to Property
                        </a>
                    </div>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-blue-50 dark:bg-blue-900/30 p-4 rounded-lg">
                        <div class="text-2xl font-bold text-blue-700 dark:text-blue-300">{{ $signins->total() }}</div>
                        <div class="text-sm text-blue-600 dark:text-blue-400">Total Sign-ins</div>
                    </div>
                    <div class="bg-green-50 dark:bg-green-900/30 p-4 rounded-lg">
                        <div class="text-2xl font-bold text-green-700 dark:text-green-300">
                            {{ $signins->where('interested_in_similar_properties', true)->count() }}
                        </div>
                        <div class="text-sm text-green-600 dark:text-green-400">Interested in Similar</div>
                    </div>
                    <div class="bg-purple-50 dark:bg-purple-900/30 p-4 rounded-lg">
                        <div class="text-2xl font-bold text-purple-700 dark:text-purple-300">
                            {{ $signins->where('interested_in_financing_info', true)->count() }}
                        </div>
                        <div class="text-sm text-purple-600 dark:text-purple-400">Want Financing Info</div>
                    </div>
                    <div class="bg-orange-50 dark:bg-orange-900/30 p-4 rounded-lg">
                        <div class="text-2xl font-bold text-orange-700 dark:text-orange-300">
                            {{ $signins->where('timeline_to_buy', 'immediately')->count() }}
                        </div>
                        <div class="text-sm text-orange-600 dark:text-orange-400">Ready to Buy Now</div>
                    </div>
                </div>

                <!-- Sign-ins List -->
                @if($signins->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Visitor</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Contact</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Timeline</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Budget</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Interests</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Signed In</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($signins as $signin)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <div class="h-10 w-10 rounded-full bg-primary flex items-center justify-center">
                                                        <span class="text-white font-medium text-sm">
                                                            {{ strtoupper(substr($signin->first_name, 0, 1) . substr($signin->last_name, 0, 1)) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                        {{ $signin->full_name }}
                                                    </div>
                                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                                        {{ $signin->current_home_status ? ucfirst($signin->current_home_status) : 'Not specified' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 dark:text-white">{{ $signin->email }}</div>
                                            @if($signin->phone)
                                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $signin->phone }}</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($signin->timeline_to_buy)
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                                    @if($signin->timeline_to_buy === 'immediately') bg-red-100 text-red-800
                                                    @elseif($signin->timeline_to_buy === '1-3_months') bg-yellow-100 text-yellow-800
                                                    @elseif($signin->timeline_to_buy === '3-6_months') bg-blue-100 text-blue-800
                                                    @else bg-gray-100 text-gray-800 @endif">
                                                    {{ str_replace('_', ' ', ucfirst($signin->timeline_to_buy)) }}
                                                </span>
                                            @else
                                                <span class="text-gray-400">Not specified</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                            {{ $signin->budget_range }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex flex-wrap gap-1">
                                                @if($signin->interested_in_similar_properties)
                                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Similar</span>
                                                @endif
                                                @if($signin->interested_in_financing_info)
                                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Financing</span>
                                                @endif
                                                @if($signin->interested_in_market_analysis)
                                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">Market</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $signin->signed_in_at->format('M j, Y g:i A') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('properties.visitors.show', [$property, $signin]) }}"
                                               class="text-primary hover:text-primary/80">View Details</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $signins->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="text-gray-400 dark:text-gray-500">
                            <svg class="mx-auto h-12 w-12 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No visitors yet</h3>
                            <p class="text-gray-500 dark:text-gray-400">When visitors sign in through your public property page, they'll appear here.</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
