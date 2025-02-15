<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RatingMovement;
use App\Models\BondInfo;

class RatingMovementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchTerm = $request->input('search');
        
        $ratingMovements = RatingMovement::with('bondInfo')
            ->when($searchTerm, function ($query) use ($searchTerm) {
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('rating_agency', 'like', "%{$searchTerm}%")
                      ->orWhere('rating', 'like', "%{$searchTerm}%")
                      ->orWhere('rating_action', 'like', "%{$searchTerm}%");
                });
            })
            ->latest()
            ->paginate(10);

        return view('admin.rating-movements.index', [
            'ratingMovements' => $ratingMovements,
            'searchTerm' => $searchTerm
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $bondInfos = BondInfo::all();
        return view('admin.rating-movements.create', compact('bondInfos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'bond_info_id' => 'required|exists:bond_infos,id',
            'rating_agency' => 'required|string|max:100',
            'effective_date' => 'required|date',
            'rating_tenure' => 'required|integer|min:1',
            'rating' => 'required|string|max:10',
            'rating_action' => 'required|string|max:50',
            'rating_outlook' => 'required|string|max:50',
            'rating_watch' => 'nullable|string|max:50',
        ]);

        RatingMovement::create($validated);

        return redirect()->route('rating-movements.index')
            ->with('success', 'Rating movement created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(RatingMovement $ratingMovement)
    {
        return view('admin.rating-movements.show', [
            'ratingMovement' => $ratingMovement->load('bondInfo')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RatingMovement $ratingMovement)
    {
        // dd($ratingMovement->toArray());
        $bondInfos = BondInfo::all();
        return view('admin.rating-movements.edit', compact('ratingMovement', 'bondInfos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RatingMovement $ratingMovement)
    {
        $validated = $request->validate([
            'bond_info_id' => 'required|exists:bond_infos,id',
            'rating_agency' => 'required|string|max:100',
            'effective_date' => 'required|date',
            'rating_tenure' => 'required|integer|min:1',
            'rating' => 'required|string|max:10',
            'rating_action' => 'required|string|max:50',
            'rating_outlook' => 'required|string|max:50',
            'rating_watch' => 'nullable|string|max:50',
        ]);

        $ratingMovement->update($validated);

        return redirect()->route('rating-movements.index')
            ->with('success', 'Rating movement updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RatingMovement $ratingMovement)
    {
        $ratingMovement->delete();

        return redirect()->route('rating-movements.index')
            ->with('success', 'Rating movement deleted successfully');
    }
}
