@extends('layouts.app')

@section('content')
    <div class="bg-white rounded shadow p-6">
        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-2xl font-bold">{{ $eatery->name }}</h1>
                @if (! $eatery->is_open)
                    <span class="bg-red-100 text-red-700 text-xs px-2 py-1 rounded">Closed</span>
                @endif
            </div>
            <div class="flex gap-2">
                <a href="{{ route('eateries.edit', $eatery) }}" class="bg-orange-600 text-white px-3 py-1 rounded">Edit</a>
                <form method="POST" action="{{ route('eateries.destroy', $eatery) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded">Delete</button>
                </form>
            </div>
        </div>

        <p class="mt-2">District:
            <a href="{{ route('districts.show', $eatery->district) }}" class="text-orange-700 hover:underline">{{ $eatery->district->name }}</a>
        </p>
        <p>Address: {{ $eatery->address }}</p>
        <p>Price range: {{ $eatery->price_range }}</p>
        <p>Specialty: {{ $eatery->specialty ?? 'None' }}</p>

        <div class="flex flex-wrap gap-1 mt-2">
            @foreach ($eatery->features as $feature)
                <a href="{{ route('eateries.index', ['feature' => $feature->name]) }}"
                   class="bg-orange-100 text-orange-800 text-xs px-2 py-1 rounded">{{ $feature->name }}</a>
            @endforeach
        </div>
    </div>

    {{-- permit box --}}
    <div class="bg-white rounded shadow p-4 mt-4">
        <h2 class="font-semibold">Business permit</h2>
        @if ($eatery->permit)
            <p>Permit no: {{ $eatery->permit->permit_no }}</p>
            <p>Expires on: {{ $eatery->permit->expires_on->format('F d, Y') }}</p>
            @if ($eatery->permit->expires_on->lt(today()))
                <p class="text-red-600 font-semibold">Permit expired</p>
            @endif
        @else
            <p>No permit on file.</p>
        @endif
    </div>

    {{-- dishes --}}
    <div class="bg-white rounded shadow p-4 mt-4">
        <h2 class="font-semibold mb-2">Dishes</h2>
        <ul>
            @foreach ($eatery->dishes as $dish)
                <li class="flex justify-between border-b py-1">
                    <span>
                        {{ $dish->name }}
                        @if ($dish->is_bestseller)
                            <span class="bg-yellow-200 text-yellow-800 text-xs px-2 py-1 rounded">Bestseller</span>
                        @endif
                    </span>
                    <span>₱{{ number_format($dish->price, 2) }}</span>
                </li>
            @endforeach
        </ul>
    </div>

    {{-- reviews --}}
    <div class="bg-white rounded shadow p-4 mt-4">
        <h2 class="font-semibold mb-2">Reviews</h2>

        @if ($eatery->is_open)
            <form method="POST" action="{{ route('eateries.reviews.store', $eatery) }}" class="mb-4">
                @csrf

                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded mb-3">
                        <ul class="list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <label class="block text-sm font-medium">Reviewer</label>
                <select name="user_id" class="border rounded px-3 py-2 w-full">
                    <option value="">Choose a reviewer</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" @selected(old('user_id') == $user->id)>{{ $user->name }}</option>
                    @endforeach
                </select>
                @error('user_id')
                    <p class="text-red-600 text-sm">{{ $message }}</p>
                @enderror

                <label class="block text-sm font-medium mt-3">Rating</label>
                <select name="rating" class="border rounded px-3 py-2 w-full">
                    <option value="">Choose a rating</option>
                    @for ($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}" @selected(old('rating') == $i)>{{ $i }}</option>
                    @endfor
                </select>
                @error('rating')
                    <p class="text-red-600 text-sm">{{ $message }}</p>
                @enderror

                <label class="block text-sm font-medium mt-3">Review</label>
                <textarea name="body" rows="3" class="border rounded px-3 py-2 w-full">{{ old('body') }}</textarea>
                @error('body')
                    <p class="text-red-600 text-sm">{{ $message }}</p>
                @enderror

                <button type="submit" class="mt-3 bg-orange-600 text-white px-4 py-2 rounded">Post review</button>
            </form>
        @else
            <p class="text-gray-600 mb-4">This eatery is closed. Reviews are paused.</p>
        @endif

        @forelse ($eatery->reviews as $review)
            <div class="border-t py-3">
                <p class="text-sm">
                    <a href="{{ route('reviewers.show', $review->user) }}" class="font-semibold text-orange-700 hover:underline">{{ $review->user->name }}</a>
                    &middot; <x-rating :rating="$review->rating" />
                    &middot; {{ $review->created_at->format('M d, Y') }}
                </p>
                <p>{{ $review->body }}</p>
                <form method="POST" action="{{ route('reviews.destroy', $review) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 text-sm">Delete</button>
                </form>
            </div>
        @empty
            <p>No reviews yet.</p>
        @endforelse
    </div>
@endsection