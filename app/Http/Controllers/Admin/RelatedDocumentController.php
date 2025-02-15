<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FacilityInformation;
use App\Models\RelatedDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RelatedDocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchTerm = $request->input('search');
        
        $documents = RelatedDocument::with('facility')
            ->when($searchTerm, function ($query) use ($searchTerm) {
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('document_name', 'like', "%{$searchTerm}%")
                      ->orWhere('document_type', 'like', "%{$searchTerm}%")
                      ->orWhereHas('facility', function ($q) use ($searchTerm) {
                          $q->where('facility_name', 'like', "%{$searchTerm}%");
                      });
                });
            })
            ->latest()
            ->paginate(10);

        return view('admin.related-documents.index', [
            'documents' => $documents,
            'searchTerm' => $searchTerm
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.related-documents.create', [
            'facilities' => FacilityInformation::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'facility_id' => 'required|exists:facility_informations,id',
            'document_name' => 'required|max:200',
            'document_type' => 'required|max:50',
            'upload_date' => 'required|date',
            'document_file' => 'required|file|mimes:pdf,xls,xlsx,doc,docx|max:2048'
        ]);

        $file = $request->file('document_file');
        $validated['file_path'] = $file->store('documents');

        RelatedDocument::create($validated);

        return redirect()->route('related-documents.index')
            ->with('success', 'Document uploaded successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(RelatedDocument $relatedDocument)
    {
        return view('admin.related-documents.show', [
            'document' => $relatedDocument->load('facility')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RelatedDocument $relatedDocument)
    {
        return view('admin.related-documents.edit', [
            'document' => $relatedDocument,
            'facilities' => FacilityInformation::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RelatedDocument $relatedDocument)
    {
        $validated = $request->validate([
            'facility_id' => 'required|exists:facility_informations,id',
            'document_name' => 'required|max:200',
            'document_type' => 'required|max:50',
            'upload_date' => 'required|date',
            'document_file' => 'nullable|file|mimes:pdf,xls,xlsx,doc,docx|max:2048'
        ]);

        if ($request->hasFile('document_file')) {
            // Delete old file
            Storage::delete($relatedDocument->file_path);
            // Store new file
            $validated['file_path'] = $request->file('document_file')->store('documents');
        }

        $relatedDocument->update($validated);

        return redirect()->route('related-documents.index')
            ->with('success', 'Document updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RelatedDocument $relatedDocument)
    {
        Storage::delete($relatedDocument->file_path);
        $relatedDocument->delete();

        return redirect()->route('related-documents.index')
            ->with('success', 'Document deleted successfully');
    }
}