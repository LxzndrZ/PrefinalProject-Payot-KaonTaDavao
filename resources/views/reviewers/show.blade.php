@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold">{{ $user->name }}</h1>
    <p class="mb-4">{{ $user->reviews->count() }} {{ $user->reviews->count() == 1 ? 'review' : 'reviews' }} written</p>

    @forelse ($user->reviews as $review)
        <div class="bg-white rounded shadow p-4 mb-3">
            <a href="{{ route('eateries.show', $review->eatery) }}" class="font-semibold text-orange-700 hover:underline">{{ $review->eatery->name }}</a>
            &middot; <x-rating :rating="$review->rating" />
            <p class="mt-1">{{ $review->body }}</p>
        </div>
    @empty
        <p>No reviews yet.</p>
    @endforelse
@endsection