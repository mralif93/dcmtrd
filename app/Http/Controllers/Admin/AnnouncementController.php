<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Issuer; // Removed Bond model import
use Illuminate\Http\Request;
use Carbon\Carbon;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchTerm = $request->input('search');
        
        $announcements = Announcement::with('issuer')
            ->when($searchTerm, function ($query) use ($searchTerm) {
                $query->where(function ($q) use ($searchTerm) {
                    $q->whereDate('announcement_date', $searchTerm)
                      ->orWhere('title', 'like', "%{$searchTerm}%")
                      ->orWhere('category', 'like', "%{$searchTerm}%")
                      ->orWhereHas('issuer', function ($q) use ($searchTerm) {
                          $q->where('issuer_name', 'like', "%{$searchTerm}%");
                      });
                });
            })
            ->latest()
            ->paginate(10);

        return view('admin.announcements.index', [
            'announcements' => $announcements,
            'searchTerm' => $searchTerm
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.announcements.create', [
            'issuers' => Issuer::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'issuer_id' => 'required|exists:issuers,id',
            'category' => 'required|string|max:50',
            'sub_category' => 'nullable|string|max:50',
            'source' => 'required|string|max:100',
            'announcement_date' => 'required|date',
            'title' => 'required|string|max:200',
            'description' => 'required|string',
            'content' => 'required|string',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        if ($request->hasFile('attachment')) {
            $validated['attachment'] = $request->file('attachment')->store('attachments');
        }

        try {
            $announcement = Announcement::create($validated);
            return redirect()->route('announcements.show', $announcement)->with('success', 'Announcement created successfully');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error creating: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Announcement $announcement)
    {
        return view('admin.announcements.show', [
            'announcement' => $announcement->load('issuer')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Announcement $announcement)
    {
        return view('admin.announcements.edit', [
            'announcement' => $announcement,
            'issuers' => Issuer::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Announcement $announcement)
    {
        $validated = $request->validate([
            'issuer_id' => 'required|exists:issuers,id',
            'category' => 'required|string|max:50',
            'sub_category' => 'nullable|string|max:50',
            'source' => 'required|string|max:100',
            'announcement_date' => 'required|date',
            'title' => 'required|string|max:200',
            'description' => 'required|string',
            'content' => 'required|string',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        if ($request->hasFile('attachment')) {
            // Delete old attachment
            if ($announcement->attachment) {
                Storage::delete($announcement->attachment);
            }
            $validated['attachment'] = $request->file('attachment')->store('attachments');
        }

        try {
            $announcement->update($validated);
            return redirect()->route('announcements.show', $announcement)->with('success', 'Announcement updated successfully');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error updating: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Announcement $announcement)
    {
        try {
            if ($announcement->attachment) {
                Storage::delete($announcement->attachment);
            }
            $announcement->delete();
            return redirect()->route('announcements.index')->with('success', 'Announcement deleted successfully');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error deleting: ' . $e->getMessage()])->withInput();
        }
    }
}