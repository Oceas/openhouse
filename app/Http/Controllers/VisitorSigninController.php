<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\VisitorSignin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VisitorSigninController extends Controller
{
    /**
     * Show the sign-in form for a property.
     */
    public function showSigninForm($propertySlug)
    {
        $property = Property::where('slug', $propertySlug)
            ->where('status', 'active')
            ->firstOrFail();

        return view('visitor-signins.signin-form', compact('property'));
    }

    /**
     * Store a new visitor sign-in.
     */
    public function store(Request $request, $propertySlug)
    {
        $property = Property::where('slug', $propertySlug)
            ->where('status', 'active')
            ->firstOrFail();

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:2',
            'zip_code' => 'nullable|string|max:10',
            'current_home_status' => 'nullable|string|in:own,rent,looking,other',
            'timeline_to_buy' => 'nullable|string|in:immediately,1-3_months,3-6_months,6_months_plus,just_browsing',
            'budget_min' => 'nullable|numeric|min:0',
            'budget_max' => 'nullable|numeric|min:0|gte:budget_min',
            'additional_notes' => 'nullable|string|max:1000',
            'source' => 'nullable|string|max:255',
            'interested_in_similar_properties' => 'boolean',
            'interested_in_financing_info' => 'boolean',
            'interested_in_market_analysis' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $signin = VisitorSignin::create([
            'property_id' => $property->id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'zip_code' => $request->zip_code,
            'current_home_status' => $request->current_home_status,
            'timeline_to_buy' => $request->timeline_to_buy,
            'budget_min' => $request->budget_min,
            'budget_max' => $request->budget_max,
            'additional_notes' => $request->additional_notes,
            'source' => $request->source,
            'interested_in_similar_properties' => $request->boolean('interested_in_similar_properties'),
            'interested_in_financing_info' => $request->boolean('interested_in_financing_info'),
            'interested_in_market_analysis' => $request->boolean('interested_in_market_analysis'),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Thank you for signing in! We\'ll be in touch soon.',
            'signin' => $signin
        ]);
    }

    /**
     * Display visitor sign-ins for a property (admin only).
     */
    public function index(Request $request, Property $property)
    {
        // Check if user owns this property
        if ($property->user_id !== auth()->id()) {
            abort(403);
        }

        $signins = $property->visitorSignins()
            ->orderBy('signed_in_at', 'desc')
            ->paginate(20);

        return view('visitor-signins.index', compact('property', 'signins'));
    }

    /**
     * Display a specific visitor sign-in (admin only).
     */
    public function show(Property $property, VisitorSignin $visitorSignin)
    {
        // Check if user owns this property
        if ($property->user_id !== auth()->id()) {
            abort(403);
        }

        // Check if signin belongs to this property
        if ($visitorSignin->property_id !== $property->id) {
            abort(404);
        }

        // Debug information
        \Log::info('Visitor signin show method called', [
            'property_id' => $property->id,
            'visitor_signin_id' => $visitorSignin->id,
            'property_title' => $property->title,
            'visitor_name' => $visitorSignin->full_name
        ]);

        return view('visitor-signins.show', compact('property', 'visitorSignin'));
    }

    /**
     * Export visitor sign-ins as CSV (admin only).
     */
    public function export(Property $property)
    {
        // Check if user owns this property
        if ($property->user_id !== auth()->id()) {
            abort(403);
        }

        $signins = $property->visitorSignins()
            ->orderBy('signed_in_at', 'desc')
            ->get();

        $filename = 'visitor-signins-' . $property->slug . '-' . now()->format('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($signins) {
            $file = fopen('php://output', 'w');

            // CSV headers
            fputcsv($file, [
                'Date',
                'Name',
                'Email',
                'Phone',
                'Address',
                'City',
                'State',
                'Zip Code',
                'Current Home Status',
                'Timeline to Buy',
                'Budget Range',
                'Source',
                'Interested in Similar Properties',
                'Interested in Financing Info',
                'Interested in Market Analysis',
                'Additional Notes',
                'IP Address',
            ]);

            // CSV data
            foreach ($signins as $signin) {
                fputcsv($file, [
                    $signin->signed_in_at->format('Y-m-d H:i:s'),
                    $signin->full_name,
                    $signin->email,
                    $signin->phone,
                    $signin->address,
                    $signin->city,
                    $signin->state,
                    $signin->zip_code,
                    $signin->current_home_status,
                    $signin->timeline_to_buy,
                    $signin->budget_range,
                    $signin->source,
                    $signin->interested_in_similar_properties ? 'Yes' : 'No',
                    $signin->interested_in_financing_info ? 'Yes' : 'No',
                    $signin->interested_in_market_analysis ? 'Yes' : 'No',
                    $signin->additional_notes,
                    $signin->ip_address,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
