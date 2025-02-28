<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Checklist;
use Illuminate\Http\Request;

class ChecklistAPIController extends Controller
{
    /**
     * Get the checklist with its items.
     */
    public function show(Checklist $checklist)
    {
        return response()->json([
            'id' => $checklist->id,
            'name' => $checklist->name,
            'items' => $checklist->items
        ]);
    }
}