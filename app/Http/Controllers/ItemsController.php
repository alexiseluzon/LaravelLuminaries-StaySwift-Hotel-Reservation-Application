<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Item;

class ItemsController extends Controller
{
    /**
     * Display a listing of the items.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $items = Item::all(); // Fetch all items from the database
        return Inertia::render('Items', ['items' => $items]);
    }

    public function sort(Request $request)
    {
        $column = $request->input('column');
        $order = $request->input('order', 'asc'); // Default order

        $items = Item::orderBy($column, $order)->get();

        return response()->json(['items' => $items]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_name' => 'required|string|max:255',
            'item_quantity' => 'required|integer',
            'category' => 'required|string|max:255',
            'unit_of_measure' => 'required|string|max:255',
            'school_level' => 'required|string|max:255',
            'room_number' => 'required|integer',
            'adviser' => 'required|string|max:255',
        ]);

        $item = Item::create($request->all());

        return redirect()->route('items.index');
    }

    public function update(Request $request, Item $item)
    {
        $validated = $request->validate([
            'item_name' => 'required|string|max:255',
            'item_quantity' => 'required|integer',
            'category' => 'required|string|max:255',
            'unit_of_measure' => 'required|string|max:255',
            'school_level' => 'required|string|max:255',
            'room_number' => 'required|integer',
            'adviser' => 'required|string|max:255',
        ]);

        $item->update($validated);

        return redirect()->route('items.index');
}

    public function destroy(Item $item)
    {
        $item->delete(); // Delete the item
        return redirect()->route('items.index');
    }
}
