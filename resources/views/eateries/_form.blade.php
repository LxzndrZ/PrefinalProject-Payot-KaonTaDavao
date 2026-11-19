@if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded mb-4">
        <ul class="list-disc list-inside text-sm">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<label class="block text-sm font-medium">Name</label>
<input type="text" name="name" value="{{ old('name', $eatery->name ?? '') }}" class="border rounded px-3 py-2 w-full">
@error('name')
    <p class="text-red-600 text-sm">{{ $message }}</p>
@enderror

<label class="block text-sm font-medium mt-3">District</label>
<select name="district_id" class="border rounded px-3 py-2 w-full">
    <option value="">Choose a district</option>
    @foreach ($districts as $district)
        <option value="{{ $district->id }}" @selected(old('district_id', $eatery->district_id ?? '') == $district->id)>{{ $district->name }}</option>
    @endforeach
</select>
@error('district_id')
    <p class="text-red-600 text-sm">{{ $message }}</p>
@enderror

<label class="block text-sm font-medium mt-3">Address</label>
<input type="text" name="address" value="{{ old('address', $eatery->address ?? '') }}" class="border rounded px-3 py-2 w-full">
@error('address')
    <p class="text-red-600 text-sm">{{ $message }}</p>
@enderror

<label class="block text-sm font-medium mt-3">Price range</label>
<select name="price_range" class="border rounded px-3 py-2 w-full">
    <option value="">Choose a price range</option>
    @foreach (['budget', 'mid', 'splurge'] as $range)
        <option value="{{ $range }}" @selected(old('price_range', $eatery->price_range ?? '') === $range)>{{ $range }}</option>
    @endforeach
</select>
@error('price_range')
    <p class="text-red-600 text-sm">{{ $message }}</p>
@enderror

<label class="block text-sm font-medium mt-3">Specialty</label>
<input type="text" name="specialty" value="{{ old('specialty', $eatery->specialty ?? '') }}" class="border rounded px-3 py-2 w-full">
@error('specialty')
    <p class="text-red-600 text-sm">{{ $message }}</p>
@enderror

<label class="flex items-center gap-2 mt-3">
    <input type="checkbox" name="is_open" value="1"
           @checked($errors->any() ? old('is_open') : ($eatery->is_open ?? true))>
    Open
</label>
@error('is_open')
    <p class="text-red-600 text-sm">{{ $message }}</p>
@enderror

@php
    // after a failed submit use what was ticked, otherwise the saved features
    $chosen = $errors->any() ? old('features', []) : (isset($eatery) ? $eatery->features->pluck('id')->all() : []);
@endphp
<p class="block text-sm font-medium mt-3">Features</p>
<div class="flex flex-wrap gap-4">
    @foreach ($features as $feature)
        <label class="flex items-center gap-1 text-sm">
            <input type="checkbox" name="features[]" value="{{ $feature->id }}" @checked(in_array($feature->id, $chosen))>
            {{ $feature->name }}
        </label>
    @endforeach
</div>
@error('features')
    <p class="text-red-600 text-sm">{{ $message }}</p>
@enderror
@error('features.*')
    <p class="text-red-600 text-sm">{{ $message }}</p>
@enderror

<label class="block text-sm font-medium mt-3">Permit number</label>
<input type="text" name="permit_no" value="{{ old('permit_no', $eatery->permit->permit_no ?? '') }}" class="border rounded px-3 py-2 w-full">
@error('permit_no')
    <p class="text-red-600 text-sm">{{ $message }}</p>
@enderror

<label class="block text-sm font-medium mt-3">Permit expiry date</label>
<input type="date" name="expires_on"
       value="{{ old('expires_on', isset($eatery) && $eatery->permit ? $eatery->permit->expires_on->format('Y-m-d') : '') }}"
       class="border rounded px-3 py-2 w-full">
@error('expires_on')
    <p class="text-red-600 text-sm">{{ $message }}</p>
@enderror