@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                        Analytics Dashboard
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-2">
                        Track your performance and optimize your real estate business
                    </p>
                </div>
                <div class="flex items-center space-x-4">
                    <form method="GET" class="flex items-center space-x-2">
                        <input type="date" name="start_date" value="{{ $startDate }}"
                               class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm">
                        <span class="text-gray-500">to</span>
                        <input type="date" name="end_date" value="{{ $endDate }}"
                               class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                            Update
                        </button>
                    </form>
                    <a href="{{ route('analytics.export', ['start_date' => $startDate, 'end_date' => $endDate]) }}"
                       class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Export
                    </a>
                </div>
            </div>
        </div>

        <!-- Overview Metrics -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Leads</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $analytics['overview']['total_leads'] }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            @if($analytics['overview']['growth_rate'] > 0)
                                <span class="text-green-600">+{{ $analytics['overview']['growth_rate'] }}%</span>
                            @elseif($analytics['overview']['growth_rate'] < 0)
                                <span class="text-red-600">{{ $analytics['overview']['growth_rate'] }}%</span>
                            @else
                                <span class="text-gray-500">0%</span>
                            @endif
                            vs last period
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Conversion Rate</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $analytics['overview']['conversion_rate'] }}%</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $analytics['overview']['closed_leads'] }} closed deals</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Avg Lead Score</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $analytics['lead_scoring']['average_score'] }}/10</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $analytics['lead_scoring']['high_value_percentage'] }}% high-value leads</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-orange-100 dark:bg-orange-900/30 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Response Time</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $analytics['response_time']['average_response_time'] }}h</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Average hours to first contact</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row 1 -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Monthly Trends Chart -->
            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Monthly Trends</h3>
                <div class="relative" style="height: 300px;">
                    <canvas id="monthlyTrendsChart"></canvas>
                </div>
            </div>

            <!-- Lead Status Distribution -->
            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Lead Status Distribution</h3>
                <div class="relative" style="height: 300px;">
                    <canvas id="leadStatusChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Charts Row 2 -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Lead Sources -->
            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Lead Sources</h3>
                <div class="relative" style="height: 300px;">
                    <canvas id="leadSourcesChart"></canvas>
                </div>
            </div>

            <!-- Timeline Analytics -->
            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Buyer Timeline</h3>
                <div class="relative" style="height: 300px;">
                    <canvas id="timelineChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Property Performance -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700 mb-8">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Top Performing Properties</h3>
            @if($analytics['property_performance']->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Property</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Leads</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Avg Score</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Price</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($analytics['property_performance'] as $property)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $property['title'] }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $property['leads_count'] }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $property['avg_lead_score'] }}/10
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $property['price'] }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($property['status'] === 'active') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400
                                            @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 @endif">
                                            {{ ucfirst($property['status']) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500 dark:text-gray-400 text-center py-8">No property performance data available</p>
            @endif
        </div>

        <!-- Insights -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Key Insights</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                        <h4 class="font-medium text-blue-900 dark:text-blue-100">Growth Trend</h4>
                    </div>
                    <p class="text-sm text-blue-700 dark:text-blue-300 mt-2">
                        @if($analytics['overview']['growth_rate'] > 0)
                            Your leads are growing by {{ $analytics['overview']['growth_rate'] }}% compared to last period. Keep up the momentum!
                        @elseif($analytics['overview']['growth_rate'] < 0)
                            Lead generation has decreased by {{ abs($analytics['overview']['growth_rate']) }}%. Consider reviewing your marketing strategies.
                        @else
                            Lead generation is stable. Focus on improving conversion rates.
                        @endif
                    </p>
                </div>

                <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-4">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-600 dark:text-green-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h4 class="font-medium text-green-900 dark:text-green-100">Conversion Rate</h4>
                    </div>
                    <p class="text-sm text-green-700 dark:text-green-300 mt-2">
                        @if($analytics['overview']['conversion_rate'] > 10)
                            Excellent conversion rate of {{ $analytics['overview']['conversion_rate'] }}%! Your follow-up process is working well.
                        @elseif($analytics['overview']['conversion_rate'] > 5)
                            Good conversion rate of {{ $analytics['overview']['conversion_rate'] }}%. Consider improving your lead nurturing process.
                        @else
                            Conversion rate of {{ $analytics['overview']['conversion_rate'] }}% needs improvement. Focus on better lead qualification and follow-up.
                        @endif
                    </p>
                </div>

                <div class="bg-purple-50 dark:bg-purple-900/20 rounded-lg p-4">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-purple-600 dark:text-purple-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                        </svg>
                        <h4 class="font-medium text-purple-900 dark:text-purple-100">Lead Quality</h4>
                    </div>
                    <p class="text-sm text-purple-700 dark:text-purple-300 mt-2">
                        @if($analytics['lead_scoring']['average_score'] > 7)
                            High-quality leads with average score of {{ $analytics['lead_scoring']['average_score'] }}/10. Focus on converting these hot leads!
                        @elseif($analytics['lead_scoring']['average_score'] > 5)
                            Moderate lead quality with average score of {{ $analytics['lead_scoring']['average_score'] }}/10. Improve lead qualification.
                        @else
                            Lead quality needs improvement with average score of {{ $analytics['lead_scoring']['average_score'] }}/10. Review your lead generation sources.
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// Monthly Trends Chart
const monthlyTrendsCtx = document.getElementById('monthlyTrendsChart').getContext('2d');
new Chart(monthlyTrendsCtx, {
    type: 'line',
    data: {
        labels: @json($analytics['monthly_trends']->pluck('month')),
        datasets: [{
            label: 'Leads',
            data: @json($analytics['monthly_trends']->pluck('leads')),
            borderColor: '#3B82F6',
            backgroundColor: 'rgba(59, 130, 246, 0.1)',
            tension: 0.4,
            fill: true
        }, {
            label: 'Conversions',
            data: @json($analytics['monthly_trends']->pluck('conversions')),
            borderColor: '#10B981',
            backgroundColor: 'rgba(16, 185, 129, 0.1)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'top',
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    maxTicksLimit: 8
                }
            },
            x: {
                ticks: {
                    maxTicksLimit: 12
                }
            }
        }
    }
});

// Lead Status Distribution Chart
const leadStatusCtx = document.getElementById('leadStatusChart').getContext('2d');
new Chart(leadStatusCtx, {
    type: 'doughnut',
    data: {
        labels: @json($analytics['lead_status_distribution']->pluck('status')),
        datasets: [{
            data: @json($analytics['lead_status_distribution']->pluck('count')),
            backgroundColor: @json($analytics['lead_status_distribution']->pluck('color')),
            borderWidth: 2,
            borderColor: '#ffffff'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    padding: 20,
                    usePointStyle: true
                }
            }
        }
    }
});

// Lead Sources Chart
const leadSourcesCtx = document.getElementById('leadSourcesChart').getContext('2d');
new Chart(leadSourcesCtx, {
    type: 'bar',
    data: {
        labels: @json($analytics['lead_sources']->pluck('source')),
        datasets: [{
            label: 'Leads',
            data: @json($analytics['lead_sources']->pluck('count')),
            backgroundColor: [
                '#3B82F6',
                '#10B981',
                '#F59E0B',
                '#EF4444',
                '#8B5CF6',
                '#F97316',
                '#06B6D4',
                '#84CC16'
            ],
            borderRadius: 4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    maxTicksLimit: 6
                }
            },
            x: {
                ticks: {
                    maxTicksLimit: 8
                }
            }
        }
    }
});

// Timeline Analytics Chart
const timelineCtx = document.getElementById('timelineChart').getContext('2d');
new Chart(timelineCtx, {
    type: 'bar',
    data: {
        labels: @json($analytics['timeline_analytics']->pluck('timeline')),
        datasets: [{
            label: 'Buyers',
            data: @json($analytics['timeline_analytics']->pluck('count')),
            backgroundColor: [
                '#EF4444',
                '#F97316',
                '#F59E0B',
                '#10B981',
                '#3B82F6'
            ],
            borderRadius: 4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    maxTicksLimit: 6
                }
            },
            x: {
                ticks: {
                    maxTicksLimit: 8
                }
            }
        }
    }
});
</script>
@endsection
