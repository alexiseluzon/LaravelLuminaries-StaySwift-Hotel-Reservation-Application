<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\BorrowedItem;
use App\Models\DamagedItem;
use Inertia\Inertia;

class InventoryController extends Controller
{
    public function index()
    {
        // Calculate overall totals
        $totals = [
            'item_quantity' => Item::sum('item_quantity'),
            'borrowed_items' => BorrowedItem::sum('quantity'),
            'overdue_items' => BorrowedItem::where('status', 'Overdue')->sum('quantity'),
            'damaged_items' => DamagedItem::sum('quantity'),
        ];

        // Calculate totals for Junior High School
        $juniorHighInventory = [
            'item_quantity' => Item::where('school_level', 'Junior High School')->sum('item_quantity'),
            'borrowed_items' => BorrowedItem::where('school_level', 'Junior High School')->sum('quantity'),
            'overdue_items' => BorrowedItem::where('school_level', 'Junior High School')->where('status', 'Overdue')
            ->sum('quantity'),
            'damaged_items' => DamagedItem::where('school_level', 'Junior High School')->sum('quantity'),
        ];

        // Calculate totals for Senior High School
        $seniorHighInventory = [
            'item_quantity' => Item::where('school_level', 'Senior High School')->sum('item_quantity'),
            'borrowed_items' => BorrowedItem::where('school_level', 'Senior High School')->sum('quantity'),
            'overdue_items' => BorrowedItem::where('school_level', 'Senior High School')->where('status', 'Overdue')
            ->sum('quantity'),
            'damaged_items' => DamagedItem::where('school_level', 'Senior High School')->sum('quantity'),
        ];

        // Return the Dashboard view with totals
        return Inertia::render('Dashboard', [
            'totals' => $totals,
            'juniorHighInventory' => $juniorHighInventory,
            'seniorHighInventory' => $seniorHighInventory,
        ]);
    }
}
