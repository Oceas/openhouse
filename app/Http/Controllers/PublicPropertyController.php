<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class PublicPropertyController extends Controller
{
    /**
     * Display the specified property publicly.
     */
    public function show($address, $oohId)
    {
        $property = Property::findByAddressAndOohId($address, $oohId);

        if (!$property) {
            abort(404);
        }

        return view('public.property.show', compact('property'));
    }
}
