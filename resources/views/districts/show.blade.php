@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold">{{ $district->name }}</h1>
    <p class="mb-4">{{ $reviewCount }} {{ $reviewCount == 1 ? 'review' : 'reviews' }} in {{ $district->name }}</p>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse ($district->eateries as $eatery)
            <x-eatery-card :eatery="$eatery" />
        @empty
            <p>No eateries in this district yet.</p>
        @endforelse
    </div>
@endsection