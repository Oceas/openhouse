<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $properties = auth()->user()->properties()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('properties.index', compact('properties'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $property = new Property();
        return view('properties.create', compact('property'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $this->validateProperty($request);

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $this->uploadImage($request->file('featured_image'), 'featured');
        }

        // Handle gallery images upload
        if ($request->hasFile('gallery_images')) {
            $galleryImages = [];
            foreach ($request->file('gallery_images') as $image) {
                $galleryImages[] = $this->uploadImage($image, 'gallery');
            }
            $validated['gallery_images'] = $galleryImages;
        }

        // Set user_id and generate slug
        $validated['user_id'] = auth()->id();
        $validated['slug'] = Str::slug($validated['title']);

        // Calculate total bathrooms
        $validated['total_bathrooms'] = ($validated['bathrooms'] ?? 0) + ($validated['half_bathrooms'] ?? 0);

        Property::create($validated);

        return redirect()->route('properties.index')
            ->with('success', 'Property created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Property $property)
    {
        if (!Gate::allows('view', $property)) {
            abort(403);
        }
        return view('properties.show', compact('property'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Property $property)
    {
        if (!Gate::allows('update', $property)) {
            abort(403);
        }
        return view('properties.edit', compact('property'));
    }

    /**
     * Update the specified resource in storage.
     */
        public function update(Request $request, Property $property)
    {
        if (!Gate::allows('update', $property)) {
            abort(403);
        }

        $validated = $this->validateProperty($request, $property->id);

        // Handle featured image upload or removal
        if ($request->hasFile('featured_image')) {
            // Delete old image
            if ($property->featured_image) {
                Storage::disk('public')->delete($property->featured_image);
            }
            $validated['featured_image'] = $this->uploadImage($request->file('featured_image'), 'featured');
        } elseif ($request->has('remove_featured_image')) {
            // Remove featured image
            if ($property->featured_image) {
                Storage::disk('public')->delete($property->featured_image);
            }
            $validated['featured_image'] = null;
        } else {
            // Keep existing featured image if no new one uploaded
            $validated['featured_image'] = $property->featured_image;
        }

        // Handle gallery images upload or removal
        if ($request->hasFile('gallery_images')) {
            $galleryImages = $property->gallery_images ?? [];
            foreach ($request->file('gallery_images') as $image) {
                $galleryImages[] = $this->uploadImage($image, 'gallery');
            }
            $validated['gallery_images'] = $galleryImages;
        } else {
            // Keep existing gallery images if no new ones uploaded
            $validated['gallery_images'] = $property->gallery_images;
        }

        // Handle gallery image removals
        if ($request->has('remove_gallery_images')) {
            $galleryImages = $validated['gallery_images'] ?? [];
            $removeIndices = $request->input('remove_gallery_images');

            // Sort indices in descending order to avoid index shifting issues
            rsort($removeIndices);

            foreach ($removeIndices as $index) {
                if (isset($galleryImages[$index])) {
                    // Delete the file from storage
                    Storage::disk('public')->delete($galleryImages[$index]);
                    // Remove from array
                    unset($galleryImages[$index]);
                }
            }

            // Re-index array
            $validated['gallery_images'] = array_values($galleryImages);
        }

        // Update slug if title changed
        if ($property->title !== $validated['title']) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Calculate total bathrooms
        $validated['total_bathrooms'] = ($validated['bathrooms'] ?? 0) + ($validated['half_bathrooms'] ?? 0);

        $property->update($validated);

        return redirect()->route('properties.index')
            ->with('success', 'Property updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Property $property)
    {
        if (!Gate::allows('delete', $property)) {
            abort(403);
        }

        // Delete images
        if ($property->featured_image) {
            Storage::disk('public')->delete($property->featured_image);
        }

        if ($property->gallery_images) {
            foreach ($property->gallery_images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $property->delete();

        return redirect()->route('properties.index')
            ->with('success', 'Property deleted successfully!');
    }

    /**
     * Remove a gallery image.
     */
    public function removeGalleryImage(Request $request, Property $property)
    {
        if (!Gate::allows('update', $property)) {
            abort(403);
        }

        $imageIndex = $request->input('image_index');
        $galleryImages = $property->gallery_images ?? [];

        if (isset($galleryImages[$imageIndex])) {
            Storage::disk('public')->delete($galleryImages[$imageIndex]);
            unset($galleryImages[$imageIndex]);
            $galleryImages = array_values($galleryImages); // Re-index array

            $property->update(['gallery_images' => $galleryImages]);

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 400);
    }

    /**
     * Generate PDF for the property.
     */
    public function generatePdf(Property $property)
    {
        if (!Gate::allows('view', $property)) {
            abort(403);
        }

        $pdf = \PDF::loadView('properties.pdf', compact('property'));

        return $pdf->download($property->slug . '.pdf');
    }

    /**
     * Validate property data.
     */
    private function validateProperty(Request $request, $propertyId = null): array
    {
        $mlsUniqueRule = $propertyId
            ? "unique:properties,mls_number,{$propertyId}"
            : 'unique:properties,mls_number';

        return $request->validate([
            'mls_number' => ['nullable', 'string', 'max:50', $mlsUniqueRule],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'property_type' => ['required', 'string', 'in:single_family,condo,townhouse,multi_family,land,commercial,rental'],
            'status' => ['required', 'string', 'in:active,pending,sold,withdrawn,expired'],

            // Address
            'street_address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:100'],
            'state' => ['required', 'string', 'size:2'],
            'zip_code' => ['required', 'string', 'max:10'],
            'county' => ['nullable', 'string', 'max:100'],
            'subdivision' => ['nullable', 'string', 'max:100'],

            // Pricing
            'list_price' => ['required', 'numeric', 'min:0'],
            'original_price' => ['nullable', 'numeric', 'min:0'],
            'price_per_sqft' => ['nullable', 'string', 'max:50'],

            // Property Details
            'bedrooms' => ['nullable', 'integer', 'min:0'],
            'bathrooms' => ['nullable', 'integer', 'min:0'],
            'half_bathrooms' => ['nullable', 'integer', 'min:0'],
            'square_feet' => ['nullable', 'integer', 'min:0'],
            'lot_size' => ['nullable', 'integer', 'min:0'],
            'lot_size_units' => ['nullable', 'string', 'in:sqft,acres'],
            'year_built' => ['nullable', 'integer', 'min:1800', 'max:' . (date('Y') + 1)],
            'garage_spaces' => ['nullable', 'string', 'max:50'],
            'parking_spaces' => ['nullable', 'string', 'max:50'],

            // Features
            'heating_type' => ['nullable', 'string', 'max:100'],
            'cooling_type' => ['nullable', 'string', 'max:100'],
            'appliances' => ['nullable', 'string', 'max:500'],
            'flooring' => ['nullable', 'string', 'max:200'],
            'roof_type' => ['nullable', 'string', 'max:100'],
            'exterior_features' => ['nullable', 'string', 'max:500'],
            'interior_features' => ['nullable', 'string', 'max:500'],
            'community_features' => ['nullable', 'string', 'max:500'],

            // MLS Fields
            'listing_office' => ['nullable', 'string', 'max:100'],
            'listing_agent' => ['nullable', 'string', 'max:100'],
            'buyer_agent_commission' => ['nullable', 'string', 'max:50'],
            'list_date' => ['nullable', 'date'],
            'expiration_date' => ['nullable', 'date', 'after:list_date'],
            'days_on_market' => ['nullable', 'string', 'max:50'],
            'property_tax' => ['nullable', 'string', 'max:50'],
            'hoa_fees' => ['nullable', 'string', 'max:50'],
            'hoa_frequency' => ['nullable', 'string', 'in:monthly,quarterly,annually'],

            // Open House
            'has_open_house' => ['boolean'],
            'open_house_start' => ['nullable', 'date', 'required_if:has_open_house,1'],
            'open_house_end' => ['nullable', 'date', 'after:open_house_start', 'required_if:has_open_house,1'],
            'open_house_notes' => ['nullable', 'string', 'max:1000'],

            // Media
            'featured_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'gallery_images.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'virtual_tour_url' => ['nullable', 'url', 'max:255'],
            'video_url' => ['nullable', 'url', 'max:255'],

            // SEO
            'meta_title' => ['nullable', 'string', 'max:60'],
            'meta_description' => ['nullable', 'string', 'max:160'],
        ]);
    }

    /**
     * Upload an image and return the path.
     */
    private function uploadImage($image, $type): string
    {
        $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
        $path = $image->storeAs("properties/{$type}", $filename, 'public');

        return $path;
    }
}
