<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ConditionCheck;
use App\Models\Checklist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserConditionCheckController extends Controller
{
    /**
     * Display a listing of the condition checks.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conditionChecks = ConditionCheck::with('checklist')->get();
        
        return view('user.condition-checks.index', compact('conditionChecks'));
    }

    /**
     * Show the form for creating a new condition check.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $checklists = Checklist::where('type', 'condition')->get();
        
        return view('user.condition-checks.create', compact('checklists'));
    }

    /**
     * Store a newly created condition check in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'checklist_id' => 'required|exists:checklists,id',
            'section' => 'required|string|max:255',
            'item_number' => 'required|string|max:10',
            'item_name' => 'required|string|max:255',
            'is_satisfied' => 'boolean',
            'remarks' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->route('condition-checks-info.create')
                ->withErrors($validator)
                ->withInput();
        }

        $conditionCheck = ConditionCheck::create($request->all());

        return redirect()->route('condition-checks-info.show', $conditionCheck)
            ->with('success', 'Condition check created successfully.');
    }

    /**
     * Display the specified condition check.
     *
     * @param  \App\Models\ConditionCheck  $conditionCheck
     * @return \Illuminate\Http\Response
     */
    public function show(ConditionCheck $condition_checks_info)
    {
        $conditionCheck = $condition_checks_info;
        return view('user.condition-checks.show', compact('conditionCheck'));
    }

    /**
     * Show the form for editing the specified condition check.
     *
     * @param  \App\Models\ConditionCheck  $conditionCheck
     * @return \Illuminate\Http\Response
     */
    public function edit(ConditionCheck $condition_checks_info)
    {
        $conditionCheck = $condition_checks_info;
        $checklists = Checklist::where('type', 'condition')->get();
        
        return view('user.condition-checks.edit', compact('conditionCheck', 'checklists'));
    }

    /**
     * Update the specified condition check in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ConditionCheck  $conditionCheck
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ConditionCheck $condition_checks_info)
    {
        $conditionCheck = $condition_checks_info;
        $validator = Validator::make($request->all(), [
            'checklist_id' => 'required|exists:checklists,id',
            'section' => 'required|string|max:255',
            'item_number' => 'required|string|max:10',
            'item_name' => 'required|string|max:255',
            'is_satisfied' => 'boolean',
            'remarks' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->route('condition-checks-info.edit', $conditionCheck->id)
                ->withErrors($validator)
                ->withInput();
        }

        $conditionCheck->update($request->all());

        return redirect()->route('condition-checks-info.show', $conditionCheck)
            ->with('success', 'Condition check updated successfully.');
    }

    /**
     * Remove the specified condition check from storage.
     *
     * @param  \App\Models\ConditionCheck  $conditionCheck
     * @return \Illuminate\Http\Response
     */
    public function destroy(ConditionCheck $condition_checks_info)
    {
        $conditionCheck = $condition_checks_info;
        $conditionCheck->delete();

        return redirect()->route('condition-checks-info.index')
            ->with('success', 'Condition check deleted successfully.');
    }
}
