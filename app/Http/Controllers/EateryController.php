<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEateryRequest;
use App\Http\Requests\UpdateEateryRequest;
use App\Models\District;
use App\Models\Eatery;
use App\Models\Feature;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EateryController extends Controller
{
    public function index(Request $request)
    {
        $eateries = Eatery::with(['district', 'features'])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->when($request->filled('q'), function ($query) use ($request) {
                // grouped so "name OR specialty" does not break the other filters
                $query->where(function ($inner) use ($request) {
                    $inner->where('name', 'like', '%' . $request->q . '%')
                        ->orWhere('specialty', 'like', '%' . $request->q . '%');
                });
            })
            ->when($request->filled('district'), function ($query) use ($request) {
                $query->where('district_id', $request->district);
            })
            ->when($request->filled('feature'), function ($query) use ($request) {
                $query->whereHas('features', function ($featureQuery) use ($request) {
                    $featureQuery->where('name', $request->feature);
                });
            })
            ->orderBy('name')
            ->paginate(6)
            ->withQueryString();

        $districts = District::orderBy('name')->get();
        $features = Feature::orderBy('name')->get();

        return view('eateries.index', compact('eateries', 'districts', 'features'));
    }

    public function create()
    {
        $districts = District::orderBy('name')->get();
        $features = Feature::orderBy('name')->get();

        return view('eateries.create', compact('districts', 'features'));
    }

    public function store(StoreEateryRequest $request)
    {
        $data = $request->validated();

        $eatery = Eatery::create([
            'district_id' => $data['district_id'],
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
            'address' => $data['address'],
            'price_range' => $data['price_range'],
            'specialty' => $data['specialty'] ?? null,
            'is_open' => $request->boolean('is_open'), // unchecked box = false
        ]);

        // permit through the hasOne relationship, features through the pivot
        $eatery->permit()->create([
            'permit_no' => $data['permit_no'],
            'expires_on' => $data['expires_on'],
        ]);
        $eatery->features()->sync($data['features']);

        return redirect()->route('eateries.show', $eatery)->with('status', 'Eatery added.');
    }

    public function show(Eatery $eatery)
    {
        // load everything the page needs, newest reviews first
        $eatery->load([
            'district',
            'features',
            'permit',
            'dishes',
            'reviews' => function ($query) {
                $query->latest()->orderByDesc('id');
            },
            'reviews.user',
        ]);

        $users = User::orderBy('name')->get();

        return view('eateries.show', compact('eatery', 'users'));
    }

    public function edit(Eatery $eatery)
    {
        $eatery->load(['permit', 'features']);
        $districts = District::orderBy('name')->get();
        $features = Feature::orderBy('name')->get();

        return view('eateries.edit', compact('eatery', 'districts', 'features'));
    }

    public function update(UpdateEateryRequest $request, Eatery $eatery)
    {
        $data = $request->validated();

        $eatery->update([
            'district_id' => $data['district_id'],
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
            'address' => $data['address'],
            'price_range' => $data['price_range'],
            'specialty' => $data['specialty'] ?? null,
            'is_open' => $request->boolean('is_open'),
        ]);

        $eatery->permit()->updateOrCreate([], [
            'permit_no' => $data['permit_no'],
            'expires_on' => $data['expires_on'],
        ]);
        $eatery->features()->sync($data['features']);

        return redirect()->route('eateries.show', $eatery)->with('status', 'Eatery updated.');
    }

    public function destroy(Eatery $eatery)
    {
        // remove the children first so no rows are left behind
        $eatery->permit()->delete();
        $eatery->dishes()->delete();
        $eatery->reviews()->delete();
        $eatery->features()->detach();
        $eatery->delete();

        return redirect()->route('eateries.index')->with('status', 'Eatery deleted.');
    }
}