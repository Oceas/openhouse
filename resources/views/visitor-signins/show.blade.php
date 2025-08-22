@extends('layouts.app')

@section('content')
<!-- DEBUG: View is being rendered -->
<div style="background: red; color: white; padding: 10px; margin: 10px;">
    DEBUG: Visitor signin show view is being rendered
</div>
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <!-- Simple Test Content -->
                <h1 class="text-2xl font-bold mb-4">Visitor Details Test</h1>

                @if(isset($visitorSignin))
                    <p><strong>Name:</strong> {{ $visitorSignin->full_name }}</p>
                    <p><strong>Email:</strong> {{ $visitorSignin->email }}</p>
                    <p><strong>Property:</strong> {{ $property->title }}</p>
                    <p><strong>Signed in:</strong> {{ $visitorSignin->signed_in_at->format('M j, Y g:i A') }}</p>
                @else
                    <p class="text-red-500">No visitor signin data found!</p>
                @endif

                @if(isset($property))
                    <p><strong>Property ID:</strong> {{ $property->id }}</p>
                @else
                    <p class="text-red-500">No property data found!</p>
                @endif

                <div class="mt-4">
                    <a href="{{ route('properties.visitors.index', $property) }}"
                       class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 px-4 py-2 rounded-xl font-medium transition-colors duration-200">
                        Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
