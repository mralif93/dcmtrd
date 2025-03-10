<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bond;
use App\Models\RatingMovement;
use Illuminate\Http\Request;
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
                        ->orWhereHas('bond', function ($q) use ($searchTerm) {
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
        $bonds = Bond::get();
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

        try {
            $ratingMovement = RatingMovement::create($validated);
            return redirect()->route('rating-movements.show', $ratingMovement)->with('success', 'Rating movement created successfully');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error creating: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(RatingMovement $ratingMovement)
    {
        $ratingMovement->load('bond.issuer');
        return view('admin.rating-movements.show', compact('ratingMovement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RatingMovement $ratingMovement)
    {
        $bonds = Bond::get();
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

        try {
            $ratingMovement->update($validated);
            return redirect()->route('rating-movements.show', $ratingMovement)->with('success', 'Rating movement updated successfully');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error updating: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RatingMovement $ratingMovement)
    {
        try {
            $ratingMovement->delete();
            return redirect()->route('rating-movements.index')->with('success', 'Rating movement deleted successfully');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error deleting: ' . $e->getMessage());
        }
    }
}
