<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FinancialType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FinancialTypeController extends Controller
{
    /**
     * Display a listing of the financial types.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $financialTypes = FinancialType::paginate(10);
        
        return view('admin.financial-types.index', compact('financialTypes'));
    }

    /**
     * Show the form for creating a new financial type.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.financial-types.create');
    }

    /**
     * Store a newly created financial type in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:financial_types',
            'description' => 'nullable|string',
            'status' => 'nullable|string|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $financialType = new FinancialType();
            $financialType->name = $request->name;
            $financialType->description = $request->description;
            $financialType->status = $request->status ?? 'active';
            $financialType->save();
            
            return redirect()->route('financial-types.index')
                ->with('success', 'Financial type created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error creating financial type: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified financial type.
     *
     * @param  \App\Models\FinancialType  $financialType
     * @return \Illuminate\Http\Response
     */
    public function show(FinancialType $financialType)
    {
        return view('admin.financial-types.show', compact('financialType'));
    }

    /**
     * Show the form for editing the specified financial type.
     *
     * @param  \App\Models\FinancialType  $financialType
     * @return \Illuminate\Http\Response
     */
    public function edit(FinancialType $financialType)
    {
        return view('admin.financial-types.edit', compact('financialType'));
    }

    /**
     * Update the specified financial type in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FinancialType  $financialType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FinancialType $financialType)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:financial_types,name,' . $financialType->id,
            'description' => 'nullable|string',
            'status' => 'nullable|string|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $financialType->name = $request->name;
            $financialType->description = $request->description;
            $financialType->status = $request->status ?? $financialType->status;
            $financialType->save();
            
            return redirect()->route('financial-types.index')
                ->with('success', 'Financial type updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error updating financial type: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified financial type from storage.
     *
     * @param  \App\Models\FinancialType  $financialType
     * @return \Illuminate\Http\Response
     */
    public function destroy(FinancialType $financialType)
    {
        try {
            // Check if this financial type is in use
            if ($financialType->financials()->count() > 0) {
                return redirect()->back()
                    ->with('error', 'Cannot delete this financial type because it is associated with one or more financial records.');
            }
            
            $financialType->delete();
            
            return redirect()->route('financial-types.index')
                ->with('success', 'Financial type deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error deleting financial type: ' . $e->getMessage());
        }
    }
}
