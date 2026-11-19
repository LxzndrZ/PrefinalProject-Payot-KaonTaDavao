@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Eateries</h1>

    <form method="GET" action="{{ route('eateries.index') }}" class="flex flex-col md:flex-row gap-2 mb-6">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search name or specialty"
               class="border rounded px-3 py-2 flex-1 bg-white">

        <select name="district" class="border rounded px-3 py-2 bg-white">
            <option value="">All districts</option>
            @foreach ($districts as $district)
                <option value="{{ $district->id }}" @selected(request('district') == $district->id)>{{ $district->name }}</option>
            @endforeach
        </select>

        <select name="feature" class="border rounded px-3 py-2 bg-white">
            <option value="">All features</option>
            @foreach ($features as $feature)
                <option value="{{ $feature->name }}" @selected(request('feature') === $feature->name)>{{ $feature->name }}</option>
            @endforeach
        </select>

        <button class="bg-orange-600 text-white rounded px-4 py-2">Filter</button>
    </form>

    @if ($eateries->isEmpty())
        <p>No eateries match your filters.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($eateries as $eatery)
                <x-eatery-card :eatery="$eatery" />
            @endforeach
        </div>
    @endif

    <div class="mt-6">{{ $eateries->links() }}</div>
@endsection