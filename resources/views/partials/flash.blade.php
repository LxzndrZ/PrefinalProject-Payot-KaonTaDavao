@if (session('status'))
    <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded mb-4">
        {{ session('status') }}
    </div>
@endif