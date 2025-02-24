<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ChecklistRequest;
use App\Models\Checklist;
use Illuminate\Http\Request;

class ChecklistController extends Controller
{
    public function index(Request $request)
    {
        $query = Checklist::query();

        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        if ($request->has('is_template')) {
            $query->where('is_template', $request->is_template);
        }

        $checklists = $query->with(['items'])
            ->latest()
            ->paginate(10);

        return response()->json($checklists);
    }

    public function store(ChecklistRequest $request)
    {
        $checklist = Checklist::create($request->validated());

        if ($request->has('items')) {
            $checklist->items()->createMany($request->items);
        }

        return response()->json([
            'message' => 'Checklist created successfully',
            'data' => $checklist->load('items')
        ], 201);
    }

    public function show(Checklist $checklist)
    {
        return response()->json([
            'data' => $checklist->load(['items', 'responses'])
        ]);
    }

    public function update(ChecklistRequest $request, Checklist $checklist)
    {
        $checklist->update($request->validated());

        if ($request->has('items')) {
            // Update or create new items
            $checklist->items()->delete();
            $checklist->items()->createMany($request->items);
        }

        return response()->json([
            'message' => 'Checklist updated successfully',
            'data' => $checklist->load('items')
        ]);
    }

    public function destroy(Checklist $checklist)
    {
        $checklist->delete();

        return response()->json([
            'message' => 'Checklist deleted successfully'
        ]);
    }

    public function duplicate(Checklist $checklist)
    {
        $newChecklist = $checklist->replicate();
        $newChecklist->name = $checklist->name . ' (Copy)';
        $newChecklist->save();

        // Duplicate items
        foreach ($checklist->items as $item) {
            $newItem = $item->replicate();
            $newItem->checklist_id = $newChecklist->id;
            $newItem->save();
        }

        return response()->json([
            'message' => 'Checklist duplicated successfully',
            'data' => $newChecklist->load('items')
        ]);
    }
}