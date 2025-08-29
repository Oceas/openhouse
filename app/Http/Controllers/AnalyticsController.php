<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\VisitorSignin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    /**
     * Display the analytics dashboard.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // Get date range from request or default to last 30 days
        $startDate = $request->get('start_date', now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->format('Y-m-m-d'));

        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);

        // Get analytics data
        $analytics = $this->getAnalyticsData($user->id, $start, $end);

        return view('analytics.index', compact('analytics', 'startDate', 'endDate'));
    }

    /**
     * Get comprehensive analytics data.
     */
    private function getAnalyticsData($userId, $start, $end)
    {
        // Base queries for user's properties and leads
        $propertiesQuery = Property::where('user_id', $userId);
        $leadsQuery = VisitorSignin::whereHas('property', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        });

        // Overall metrics
        $totalProperties = $propertiesQuery->count();
        $activeProperties = $propertiesQuery->where('status', 'active')->count();
        $totalLeads = $leadsQuery->count();
        $newLeads = $leadsQuery->where('lead_status', 'new')->count();
        $qualifiedLeads = $leadsQuery->where('lead_status', 'qualified')->count();
        $closedLeads = $leadsQuery->where('lead_status', 'closed')->count();

        // Conversion rates
        $conversionRate = $totalLeads > 0 ? round(($closedLeads / $totalLeads) * 100, 1) : 0;
        $qualificationRate = $totalLeads > 0 ? round(($qualifiedLeads / $totalLeads) * 100, 1) : 0;

        // Time-based metrics
        $leadsThisMonth = $leadsQuery->whereBetween('created_at', [$start, $end])->count();
        $leadsLastMonth = $leadsQuery->whereBetween('created_at', [
            $start->copy()->subMonth(),
            $start->copy()->subDay()
        ])->count();

        $growthRate = $leadsLastMonth > 0 ? round((($leadsThisMonth - $leadsLastMonth) / $leadsLastMonth) * 100, 1) : 0;

        // Lead scoring analytics
        $averageLeadScore = $leadsQuery->avg('lead_score') ?? 0;
        $highValueLeads = $leadsQuery->where('lead_score', '>=', 7)->count();
        $mediumValueLeads = $leadsQuery->whereBetween('lead_score', [4, 6.9])->count();
        $lowValueLeads = $leadsQuery->where('lead_score', '<', 4)->count();

        // Property performance
        $propertyPerformance = $this->getPropertyPerformance($userId, $start, $end);

        // Lead source analytics
        $leadSources = $this->getLeadSourceAnalytics($userId, $start, $end);

        // Timeline analytics
        $timelineAnalytics = $this->getTimelineAnalytics($userId, $start, $end);

        // Monthly trends
        $monthlyTrends = $this->getMonthlyTrends($userId);

        // Lead status distribution
        $leadStatusDistribution = $this->getLeadStatusDistribution($userId);

        // Response time analytics
        $responseTimeAnalytics = $this->getResponseTimeAnalytics($userId, $start, $end);

        return [
            'overview' => [
                'total_properties' => $totalProperties,
                'active_properties' => $activeProperties,
                'total_leads' => $totalLeads,
                'new_leads' => $newLeads,
                'qualified_leads' => $qualifiedLeads,
                'closed_leads' => $closedLeads,
                'conversion_rate' => $conversionRate,
                'qualification_rate' => $qualificationRate,
                'leads_this_month' => $leadsThisMonth,
                'leads_last_month' => $leadsLastMonth,
                'growth_rate' => $growthRate,
            ],
            'lead_scoring' => [
                'average_score' => round($averageLeadScore, 1),
                'high_value' => $highValueLeads,
                'medium_value' => $mediumValueLeads,
                'low_value' => $lowValueLeads,
                'high_value_percentage' => $totalLeads > 0 ? round(($highValueLeads / $totalLeads) * 100, 1) : 0,
            ],
            'property_performance' => $propertyPerformance,
            'lead_sources' => $leadSources,
            'timeline_analytics' => $timelineAnalytics,
            'monthly_trends' => $monthlyTrends,
            'lead_status_distribution' => $leadStatusDistribution,
            'response_time' => $responseTimeAnalytics,
        ];
    }

    /**
     * Get property performance analytics.
     */
    private function getPropertyPerformance($userId, $start, $end)
    {
        return Property::where('user_id', $userId)
            ->withCount(['visitorSignins' => function ($query) use ($start, $end) {
                $query->whereBetween('created_at', [$start, $end]);
            }])
            ->withAvg(['visitorSignins' => function ($query) use ($start, $end) {
                $query->whereBetween('created_at', [$start, $end]);
            }], 'lead_score')
            ->orderBy('visitor_signins_count', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($property) {
                return [
                    'id' => $property->id,
                    'title' => $property->title,
                    'leads_count' => $property->visitor_signins_count,
                    'avg_lead_score' => round($property->visitor_signins_avg_lead_score ?? 0, 1),
                    'price' => $property->formatted_price,
                    'status' => $property->status,
                ];
            });
    }

    /**
     * Get lead source analytics.
     */
    private function getLeadSourceAnalytics($userId, $start, $end)
    {
        return VisitorSignin::whereHas('property', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
        ->whereBetween('created_at', [$start, $end])
        ->select('source', DB::raw('count(*) as count'))
        ->groupBy('source')
        ->orderBy('count', 'desc')
        ->get()
        ->map(function ($item) {
            return [
                'source' => ucfirst(str_replace('_', ' ', $item->source ?? 'Unknown')),
                'count' => $item->count,
                'percentage' => 0, // Will be calculated in view
            ];
        });
    }

    /**
     * Get timeline analytics.
     */
    private function getTimelineAnalytics($userId, $start, $end)
    {
        return VisitorSignin::whereHas('property', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
        ->whereBetween('created_at', [$start, $end])
        ->select('timeline_to_buy', DB::raw('count(*) as count'))
        ->groupBy('timeline_to_buy')
        ->orderBy('count', 'desc')
        ->get()
        ->map(function ($item) {
            return [
                'timeline' => ucfirst(str_replace('_', ' ', $item->timeline_to_buy ?? 'Unknown')),
                'count' => $item->count,
                'percentage' => 0, // Will be calculated in view
            ];
        });
    }

        /**
     * Get monthly trends.
     */
    private function getMonthlyTrends($userId)
    {
        $months = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months[] = [
                'month' => $date->format('M Y'),
                'date' => $date->format('Y-m'),
                'leads' => 0,
                'conversions' => 0,
            ];
        }

        // Get leads data
        $leadsData = VisitorSignin::whereHas('property', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
        ->where('created_at', '>=', now()->subMonths(12))
        ->select(
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
            DB::raw('count(*) as leads'),
            DB::raw('sum(case when lead_status = "closed" then 1 else 0 end) as conversions')
        )
        ->groupBy('month')
        ->get();

        // Merge data
        foreach ($leadsData as $data) {
            foreach ($months as $key => $month) {
                if ($month['date'] === $data->month) {
                    $months[$key]['leads'] = $data->leads;
                    $months[$key]['conversions'] = $data->conversions;
                    break;
                }
            }
        }

        return collect($months);
    }

    /**
     * Get lead status distribution.
     */
    private function getLeadStatusDistribution($userId)
    {
        return VisitorSignin::whereHas('property', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
        ->select('lead_status', DB::raw('count(*) as count'))
        ->groupBy('lead_status')
        ->orderBy('count', 'desc')
        ->get()
        ->map(function ($item) {
            return [
                'status' => \App\Models\VisitorSignin::getLeadStatusOptions()[$item->lead_status] ?? 'Unknown',
                'count' => $item->count,
                'color' => $this->getStatusColor($item->lead_status),
            ];
        });
    }

    /**
     * Get response time analytics.
     */
    private function getResponseTimeAnalytics($userId, $start, $end)
    {
        $leadsWithContact = VisitorSignin::whereHas('property', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
        ->whereNotNull('last_contacted_at')
        ->whereBetween('created_at', [$start, $end])
        ->get();

        if ($leadsWithContact->isEmpty()) {
            return [
                'average_response_time' => 0,
                'response_time_distribution' => [],
            ];
        }

        $responseTimes = $leadsWithContact->map(function ($lead) {
            return $lead->created_at->diffInHours($lead->last_contacted_at);
        });

        $averageResponseTime = round($responseTimes->avg(), 1);

        // Response time distribution
        $distribution = [
            'same_day' => $responseTimes->filter(fn($time) => $time <= 24)->count(),
            'within_week' => $responseTimes->filter(fn($time) => $time > 24 && $time <= 168)->count(),
            'within_month' => $responseTimes->filter(fn($time) => $time > 168 && $time <= 720)->count(),
            'over_month' => $responseTimes->filter(fn($time) => $time > 720)->count(),
        ];

        return [
            'average_response_time' => $averageResponseTime,
            'response_time_distribution' => $distribution,
        ];
    }

    /**
     * Get status color for charts.
     */
    private function getStatusColor($status)
    {
        return match($status) {
            'new' => '#3B82F6',
            'contacted' => '#F59E0B',
            'qualified' => '#10B981',
            'showing_scheduled' => '#8B5CF6',
            'offer_made' => '#F97316',
            'closed' => '#059669',
            'lost' => '#EF4444',
            default => '#6B7280',
        };
    }

    /**
     * Export analytics data.
     */
    public function export(Request $request)
    {
        $user = Auth::user();
        $startDate = $request->get('start_date', now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->format('Y-m-d'));

        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);

        $analytics = $this->getAnalyticsData($user->id, $start, $end);

        $filename = 'analytics-export-' . now()->format('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($analytics) {
            $file = fopen('php://output', 'w');

            // Overview section
            fputcsv($file, ['ANALYTICS OVERVIEW']);
            fputcsv($file, ['Metric', 'Value']);
            fputcsv($file, ['Total Properties', $analytics['overview']['total_properties']]);
            fputcsv($file, ['Active Properties', $analytics['overview']['active_properties']]);
            fputcsv($file, ['Total Leads', $analytics['overview']['total_leads']]);
            fputcsv($file, ['Conversion Rate', $analytics['overview']['conversion_rate'] . '%']);
            fputcsv($file, ['Growth Rate', $analytics['overview']['growth_rate'] . '%']);
            fputcsv($file, ['Average Lead Score', $analytics['lead_scoring']['average_score']]);

            fputcsv($file, []); // Empty row

            // Property Performance
            fputcsv($file, ['TOP PERFORMING PROPERTIES']);
            fputcsv($file, ['Property', 'Leads', 'Avg Lead Score', 'Price', 'Status']);
            foreach ($analytics['property_performance'] as $property) {
                fputcsv($file, [
                    $property['title'],
                    $property['leads_count'],
                    $property['avg_lead_score'],
                    $property['price'],
                    $property['status']
                ]);
            }

            fputcsv($file, []); // Empty row

            // Lead Sources
            fputcsv($file, ['LEAD SOURCES']);
            fputcsv($file, ['Source', 'Count']);
            foreach ($analytics['lead_sources'] as $source) {
                fputcsv($file, [$source['source'], $source['count']]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
