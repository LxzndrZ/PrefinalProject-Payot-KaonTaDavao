@props(['eatery'])

<div class="bg-white rounded shadow p-4">
    <div class="flex justify-between items-start">
        <a href="{{ route('eateries.show', $eatery) }}" class="text-lg font-semibold hover:underline">{{ $eatery->name }}</a>
        @if (! $eatery->is_open)
            <span class="bg-red-100 text-red-700 text-xs px-2 py-1 rounded">Closed</span>
        @endif
    </div>

    <p class="text-sm mt-1">
        <a href="{{ route('districts.show', $eatery->district) }}" class="text-orange-700 hover:underline">{{ $eatery->district->name }}</a>
        &middot;
        @if ($eatery->price_range === 'budget') ₱ @elseif ($eatery->price_range === 'mid') ₱₱ @else ₱₱₱ @endif
    </p>

    @if ($eatery->specialty)
        <p class="text-sm text-gray-600">{{ $eatery->specialty }}</p>
    @endif

    <div class="flex flex-wrap gap-1 mt-2">
        @foreach ($eatery->features as $feature)
            <a href="{{ route('eateries.index', ['feature' => $feature->name]) }}"
               class="bg-orange-100 text-orange-800 text-xs px-2 py-1 rounded">{{ $feature->name }}</a>
        @endforeach
    </div>

    <p class="text-sm mt-2">
        @if ($eatery->reviews_count > 0)
            <x-rating :rating="$eatery->reviews_avg_rating" />
            ({{ $eatery->reviews_count }} {{ $eatery->reviews_count == 1 ? 'review' : 'reviews' }})
        @else
            No reviews yet
        @endif
    </p>
</div>