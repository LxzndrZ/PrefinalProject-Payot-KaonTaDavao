@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Districts</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach ($districts as $district)
            <a href="{{ route('districts.show', $district) }}" class="bg-white rounded shadow p-4 block hover:bg-orange-50">
                <p class="font-semibold">{{ $district->name }}</p>
                <p class="text-sm">{{ $district->eateries_count }} {{ $district->eateries_count == 1 ? 'eatery' : 'eateries' }}</p>
            </a>
        @endforeach
    </div>
@endsection