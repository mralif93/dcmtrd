<?php

// Add this route to your routes/api.php file
Route::get('/checklists/{checklist}', function (App\Models\Checklist $checklist) {
    return response()->json([
        'id' => $checklist->id,
        'name' => $checklist->name,
        'items' => $checklist->items // Assuming you have a relationship named 'items'
    ]);
});