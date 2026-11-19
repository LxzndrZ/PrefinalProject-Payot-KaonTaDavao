@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Add Eatery</h1>
    <form method="POST" action="{{ route('eateries.store') }}" class="bg-white rounded shadow p-6">
        @csrf
        @include('eateries._form')
        <button type="submit" class="mt-4 bg-orange-600 text-white px-4 py-2 rounded">Save eatery</button>
    </form>
@endsection