<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserPropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Start with a base query
        $query = Property::with('portfolio');
        
        // Filter by batch_no if provided
        if ($request->filled('batch_no')) {
            $query->where('batch_no', $request->batch_no);
        }
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('address', 'LIKE', "%{$search}%")
                  ->orWhere('city', 'LIKE', "%{$search}%")
                  ->orWhere('state', 'LIKE', "%{$search}%")
                  ->orWhere('country', 'LIKE', "%{$search}%")
                  ->orWhere('postal_code', 'LIKE', "%{$search}%")
                  ->orWhere('usage', 'LIKE', "%{$search}%")
                  ->orWhere('category', 'LIKE', "%{$search}%");
            });
        }
        
        // Additional filters
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        
        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('portfolio_id')) {
            $query->where('portfolio_id', $request->portfolio_id);
        }
        
        // Execute the query with pagination
        $properties = $query->paginate(10);
        
        // Get unique values for filters dropdowns
        $batchNumbers = Property::select('batch_no')->distinct()->pluck('batch_no');
        $categories = Property::select('category')->distinct()->pluck('category');
        $cities = Property::select('city')->distinct()->pluck('city');
        $portfolios = Portfolio::where('status', 'active')->get();
        
        return view('user.properties.index', compact(
            'properties', 
            'batchNumbers', 
            'categories', 
            'cities', 
            'portfolios'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $portfolios = Portfolio::where('status', 'active')->get();

        return view('user.properties.create', compact('portfolios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'portfolio_id' => 'required|exists:portfolios,id',
            'category' => 'required|string|max:255',
            'batch_no' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'postal_code' => 'required|string|max:255',
            'land_size' => 'required|numeric|min:0',
            'gross_floor_area' => 'required|numeric|min:0',
            'usage' => 'required|string|max:255',
            'value' => 'required|numeric|min:0',
            'ownership' => 'required|string|max:255',
            'share_amount' => 'required|numeric|min:0',
            'market_value' => 'required|numeric|min:0',
            'status' => 'nullable|string|in:active,inactive'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $property = Property::findOrFail($id);
        $property->portfolio_id = $request->portfolio_id;
        $property->category = $request->category;
        $property->batch_no = $request->batch_no;
        $property->name = $request->name;
        $property->address = $request->address;
        $property->city = $request->city;
        $property->state = $request->state;
        $property->country = $request->country;
        $property->postal_code = $request->postal_code;
        $property->land_size = $request->land_size;
        $property->gross_floor_area = $request->gross_floor_area;
        $property->usage = $request->usage;
        $property->value = $request->value;
        $property->ownership = $request->ownership;
        $property->share_amount = $request->share_amount;
        $property->market_value = $request->market_value;
        $property->status = $request->status ?? $property->status;
        
        $property->save();

        return redirect()->route('properties-info.show', $property)
            ->with('success', 'Property updated successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $property = Property::with(['portfolio', 'tenants', 'checklists', 'siteVisits'])->findOrFail($id);

        return view('user.properties.show', compact('property'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $property = Property::findOrFail($id);
        $portfolios = Portfolio::where('status', 'active')->get();

        return view('user.properties.edit', compact('property', 'portfolios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'portfolio_id' => 'required|exists:portfolios,id',
            'category' => 'required|string|max:255',
            'batch_no' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'postal_code' => 'required|string|max:255',
            'land_size' => 'required|numeric|min:0',
            'gross_floor_area' => 'required|numeric|min:0',
            'usage' => 'required|string|max:255',
            'value' => 'required|numeric|min:0',
            'ownership' => 'required|string|max:255',
            'share_amount' => 'required|numeric|min:0',
            'market_value' => 'required|numeric|min:0',
            'status' => 'nullable|string|in:active,inactive'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $property = Property::findOrFail($id);
        $property->portfolio_id = $request->portfolio_id;
        $property->category = $request->category;
        $property->batch_no = $request->batch_no;
        $property->name = $request->name;
        $property->address = $request->address;
        $property->city = $request->city;
        $property->state = $request->state;
        $property->country = $request->country;
        $property->postal_code = $request->postal_code;
        $property->land_size = $request->land_size;
        $property->gross_floor_area = $request->gross_floor_area;
        $property->usage = $request->usage;
        $property->value = $request->value;
        $property->ownership = $request->ownership;
        $property->share_amount = $request->share_amount;
        $property->market_value = $request->market_value;
        $property->status = $request->status ?? $property->status;
        
        $property->save();

        return redirect()->route('properties-info.show', $property)
            ->with('success', 'Property updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $property = Property::findOrFail($id);
        $property->delete();

        return redirect()->route('properties-info.index')
            ->with('success', 'Property deleted successfully.');
    }
}
