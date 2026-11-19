@extends('layouts.app')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <div class="bg-white rounded shadow p-4">
            <p class="text-3xl font-bold">{{ $eateryCount }}</p>
            <p>Eateries</p>
        </div>
        <div class="bg-white rounded shadow p-4">
            <p class="text-3xl font-bold">{{ $districtCount }}</p>
            <p>Districts</p>
        </div>
        <div class="bg-white rounded shadow p-4">
            <p class="text-3xl font-bold">{{ $reviewCount }}</p>
            <p>Reviews</p>
        </div>
    </div>

    <h2 class="text-xl font-semibold mb-3">Top Rated</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach ($topRated as $eatery)
            <x-eatery-card :eatery="$eatery" />
        @endforeach
    </div>
@endsection