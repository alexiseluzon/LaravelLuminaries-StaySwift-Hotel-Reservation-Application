<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\DamagedItem;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DamagedItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = DamagedItem::all(); // Fetch all items from the database
        return Inertia::render('DamagedItems', ['items' => $items]);
    }

    public function repairItem(Request $request)
    {
        $request->validate([
            'item_id' => 'required|integer|exists:damaged_items,item_id',
            'quantity' => 'required|integer',
        ]);
    
        // Find the damaged item using the item_id
        $damagedItem = DamagedItem::where('item_id', $request->item_id)->first();
    
        // Find the original item
        $item = Item::find($damagedItem->item_id);
    
        // Update the item's stock
        $item->item_quantity += $request->quantity;
        $item->save();
    
        // Delete the damaged item
        $damagedItem->delete();
    
        return redirect()->route('damaged-items.index');
    }

    public function totalDamagedQuantitiesPerItem()
    {
        $damagedQuantities = DamagedItem::select('item_id', DB::raw('SUM(quantity) as total_damaged'))
            ->groupBy('item_id')
            ->get();
    
        return response()->json($damagedQuantities);
    }
}
