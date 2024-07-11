<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Item;
use App\Models\BorrowedItem;
use App\Models\DamagedItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BorrowedItemController extends Controller
{
    public function index()
    {
        //$borrowedItems = BorrowedItem::all();
        $items = BorrowedItem::all(); // Fetch all items from the database
        return Inertia::render('BorrowedItems', ['items' => $items]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_id' => 'required|integer|exists:items,id',
            'item_name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'unit_of_measure' => 'required|string|max:255',
            'school_level' => 'required|string|max:255',
            'room_number' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'adviser' => 'required|string|max:255'
        ]);

        // Retrieve the item to check stock
        $item = Item::find($request->item_id);

        // Update the item stock
        $item->item_quantity -= $request->quantity;
        BorrowedItem::create($request->all());
        $item->save();
        return redirect()->route('items.index');
    }

    // public function show(BorrowedItem $borrowedItem)
    // {
    //     return response()->json($borrowedItem);
    // }

    public function update(Request $request, BorrowedItem $borrowedItem)
    {
        $borrowedItem->update($request->all());
        return response()->json($borrowedItem);
    }

    public function totalBorrowedQuantityPerItem()
    {
        $totalBorrowedQuantities = DB::table('borrowed_items')
            ->select('item_id', DB::raw('SUM(quantity) as total_quantity'))
            ->groupBy('item_id')
            ->get();
        return response()->json($totalBorrowedQuantities);
    }

    public function returnItem(Request $request)
    {
        $request->validate([
            'item_id' => 'required|integer|exists:borrowed_items,item_id',
            'quantity' => 'required|integer|min:1',
        ]);

        // Find the borrowed item using the item_id
        $borrowedItem = BorrowedItem::where('item_id', $request->item_id)->first();

        // Find the original item
        $item = Item::find($borrowedItem->item_id);

        // Update the item's stock
        $item->item_quantity += $request->quantity;
        $item->save();

        // Delete the borrowed item
        $borrowedItem->delete();

        return redirect()->route('borrowed-items.index');
    }

    public function totalOverdueQuantitiesPerItem()
    {
        // Query to calculate total overdue quantities per item
        $totalOverdueQuantities = DB::table('borrowed_items')
            ->select('item_id', DB::raw('SUM(quantity) as total_overdue'))
            ->where('return_date', '<', now()) // Filter overdue items
            ->groupBy('item_id')
            ->get();

        return response()->json($totalOverdueQuantities);
    }

    public function markAsDamaged(Request $request)
    {
        $request->validate([
            'item_id' => 'required|integer|exists:borrowed_items,id',
            'date_reported' => 'required|date',
        ]);

        $borrowedItem = BorrowedItem::find($request->item_id);
        if ($borrowedItem) {
            // Move to damaged_items table
            DamagedItem::create([
                'item_id' => $borrowedItem->item_id,
                'item_name' => $borrowedItem->item_name,
                'category' => $borrowedItem->category,
                'unit_of_measure' => $borrowedItem->unit_of_measure,
                'school_level' => $borrowedItem->school_level,
                'room_number' => $borrowedItem->room_number,
                'quantity' => $borrowedItem->quantity,
                'report_by' => $request->report_by,
                'description' => $request->description,
                'date_reported' => $request->date_reported,
                'adviser' => $borrowedItem->adviser,
            ]);

            // Remove from borrowed_items table
            $borrowedItem->delete();

            return redirect()->route('borrowed-items.index');
        }
        return redirect()->route('borrowed-items.index');
    }
}
