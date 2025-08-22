<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class PublicPropertyController extends Controller
{
    /**
     * Display the specified property publicly.
     */
    public function show($slug)
    {
        $property = Property::where('slug', $slug)
            ->where('status', 'active')
            ->firstOrFail();

        return view('public.property.show', compact('property'));
    }
}
