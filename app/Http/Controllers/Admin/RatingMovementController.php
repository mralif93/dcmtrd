<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RatingMovement;
use App\Models\Bond;
use Illuminate\Support\Carbon;

class RatingMovementController extends Controller
{
    /**
     * Display a listing of the resource with search/filter.
     */
    public function index(Request $request)
    {
        $searchTerm = $request->input('search');
        
        $ratingMovements = RatingMovement::with('bond')
            ->when($searchTerm, function ($query) use ($searchTerm) {
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('rating_agency', 'like', "%{$searchTerm}%")
                      ->orWhere('rating', 'like', "%{$searchTerm}%")
                      ->orWhere('rating_action', 'like', "%{$searchTerm}%")
                      ->orWhereHas('bond', function($q) use ($searchTerm) {
                          $q->where('bond_sukuk_name', 'like', "%{$searchTerm}%")
                            ->orWhere('isin_code', 'like', "%{$searchTerm}%");
                      });
                });
            })
            ->latest('effective_date')
            ->paginate(10)
            ->withQueryString();

        return view('admin.rating-movements.index', compact('ratingMovements', 'searchTerm'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $bonds = Bond::active()->get();
        return view('admin.rating-movements.create', compact('bonds'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'bond_id' => 'required|exists:bonds,id',
            'rating_agency' => 'required|string|max:100',
            'effective_date' => 'required|date',
            'rating_tenure' => 'required|string|max:50',
            'rating' => 'required|string|max:50',
            'rating_action' => 'required|string|max:50',
            'rating_outlook' => 'required|string|max:50',
            'rating_watch' => 'nullable|string|max:50',
        ]);
        $ratingMovement = RatingMovement::create($validated);
        return redirect()->route('rating-movements.show', $ratingMovement)->with('success', 'Rating movement created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(RatingMovement $ratingMovement)
    {
        return view('admin.rating-movements.show', [
            'ratingMovement' => $ratingMovement->load('bond.issuer')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RatingMovement $ratingMovement)
    {
        $bonds = Bond::active()->get();
        return view('admin.rating-movements.edit', compact('ratingMovement', 'bonds'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RatingMovement $ratingMovement)
    {
        $validated = $request->validate([
            'bond_id' => 'required|exists:bonds,id',
            'rating_agency' => 'required|string|max:100',
            'effective_date' => 'required|date',
            'rating_tenure' => 'required|string|max:50',
            'rating' => 'required|string|max:50',
            'rating_action' => 'required|string|max:50',
            'rating_outlook' => 'required|string|max:50',
            'rating_watch' => 'nullable|string|max:50',
        ]);
        $ratingMovement->update($validated);
        return redirect()->route('rating-movements.show', $ratingMovement)->with('success', 'Rating movement updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RatingMovement $ratingMovement)
    {
        $ratingMovement->delete();
        return redirect()->route('rating-movements.index')->with('success', 'Rating movement deleted successfully');
    }
}