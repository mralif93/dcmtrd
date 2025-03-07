<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DocumentationItem;
use App\Models\Checklist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DocumentationItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $documentationItems = DocumentationItem::with('checklist')->get();
        
        return view('admin.documentation-items.index', compact('documentationItems'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $checklists = Checklist::where('type', 'documentation')->get();
        
        return view('admin.documentation-items.create', compact('checklists'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'checklist_id' => 'required|exists:checklists,id',
            'item_number' => 'required|string|max:10',
            'document_type' => 'required|string|max:255',
            'description' => 'nullable|string',
            'validity_date' => 'nullable|date',
            'location' => 'nullable|string|max:255',
            'is_prefilled' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->route('documentation-items.create')
                ->withErrors($validator)
                ->withInput();
        }

        $documentationItem = DocumentationItem::create($request->all());

        return redirect()->route('documentation-items.show', $documentationItem)
            ->with('success', 'Documentation item created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(DocumentationItem $documentationItem)
    {
        return view('admin.documentation-items.show', compact('documentationItem'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DocumentationItem $documentationItem)
    {
        $checklists = Checklist::where('type', 'documentation')->get();
        
        return view('admin.documentation-items.edit', compact('documentationItem', 'checklists'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DocumentationItem $documentationItem)
    {
        $validator = Validator::make($request->all(), [
            'checklist_id' => 'required|exists:checklists,id',
            'item_number' => 'required|string|max:10',
            'document_type' => 'required|string|max:255',
            'description' => 'nullable|string',
            'validity_date' => 'nullable|date',
            'location' => 'nullable|string|max:255',
            'is_prefilled' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->route('documentation-items.edit', $documentationItem->id)
                ->withErrors($validator)
                ->withInput();
        }

        $documentationItem->update($request->all());

        return redirect()->route('documentation-items.show', $documentationItem)
            ->with('success', 'Documentation item updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DocumentationItem $documentationItem)
    {
        $documentationItem->delete();

        return redirect()->route('documentation-items.index')
            ->with('success', 'Documentation item deleted successfully.');
    }
}
