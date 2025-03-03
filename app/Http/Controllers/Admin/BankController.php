<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use Illuminate\Http\Request;

class BankController extends Controller
{
    /**
     * Display a listing of banks.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $banks = Bank::paginate(10);
        
        return view('admin.banks.index', compact('banks'));
    }

    /**
     * Show the form for creating a new bank.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.banks.create');
    }

    /**
     * Store a newly created bank in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string|in:active,inactive'
        ]);

        Bank::create($request->all());
        
        return redirect()->route('banks.index')
            ->with('status', 'Bank created successfully');
    }

    /**
     * Display the specified bank.
     *
     * @param  \App\Models\Bank  $bank
     * @return \Illuminate\View\View
     */
    public function show(Bank $bank)
    {
        return view('admin.banks.show', compact('bank'));
    }

    /**
     * Show the form for editing the specified bank.
     *
     * @param  \App\Models\Bank  $bank
     * @return \Illuminate\View\View
     */
    public function edit(Bank $bank)
    {
        return view('admin.banks.edit', compact('bank'));
    }

    /**
     * Update the specified bank in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bank  $bank
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Bank $bank)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string|in:active,inactive'
        ]);

        $bank->update($request->all());
        
        return redirect()->route('banks.index')
            ->with('status', 'Bank updated successfully');
    }

    /**
     * Remove the specified bank from storage.
     *
     * @param  \App\Models\Bank  $bank
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Bank $bank)
    {
        $bank->delete();
        
        return redirect()->route('banks.index')
            ->with('status', 'Bank deleted successfully');
    }
}
