<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Bond;
use App\Models\RatingMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class UserRatingMovementController extends Controller
{
    /**
     * Display a listing of the resource.
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

        return view('user.rating-movements.index', compact('ratingMovements', 'searchTerm'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $bonds = Bond::get();
        return view('user.rating-movements.create', compact('bonds'));
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

        try {
            $ratingMovement = RatingMovement::create($validated);
            return redirect()->route('rating-movements-info.show', $ratingMovement)->with('success', 'Rating movement created successfully');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error creating: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(RatingMovement $rating_movements_info)
    {
        $ratingMovement = $rating_movements_info;
        $ratingMovement->load('bond.issuer');
        return view('user.rating-movements.show', compact('ratingMovement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RatingMovement $rating_movements_info)
    {
        $ratingMovement = $rating_movements_info;
        $bonds = Bond::get();
        return view('user.rating-movements.edit', compact('ratingMovement', 'bonds'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RatingMovement $rating_movements_info)
    {
        $ratingMovement = $rating_movements_info;
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

        try {
            $ratingMovement->update($validated);
            return redirect()->route('rating-movements-info.show', $ratingMovement)->with('success', 'Rating movement updated successfully');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error updating: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RatingMovement $rating_movements_info)
    {
        $ratingMovement = $rating_movements_info;

        try {
            $ratingMovement->delete();
            return redirect()->route('rating-movements-info.index')->with('success', 'Rating movement deleted successfully');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error deleting: ' . $e->getMessage());
        }
    }
}
