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

    public function generateReport()
    {
        $filename = "SNAIC Inventory Report.csv";

        $callback = function() {
            $file = fopen('php://output', 'w');

            // Header row
            fputcsv($file, ['School Level', 'Total Items', 'Borrowed Items', 'Overdue Items', 'Damaged Items']);

            // Fetch data
            $totals = [
                'Overall Items',
                Item::sum('item_quantity'),
                BorrowedItem::sum('quantity'),
                BorrowedItem::where('status', 'Overdue')->sum('quantity'),
                DamagedItem::sum('quantity'),
                
            ];
            
            $juniorHighInventory = [
                'Junior High School',
                Item::where('school_level', 'Junior High School')->sum('item_quantity'),
                BorrowedItem::where('school_level', 'Junior High School')->sum('quantity'),
                BorrowedItem::where('school_level', 'Junior High School')->where('status', 'Overdue')->sum('quantity'),
                DamagedItem::where('school_level', 'Junior High School')->sum('quantity'),
            ];

            $seniorHighInventory = [
                'Senior High School',
                Item::where('school_level', 'Senior High School')->sum('item_quantity'),
                BorrowedItem::where('school_level', 'Senior High School')->sum('quantity'),
                BorrowedItem::where('school_level', 'Senior High School')->where('status', 'Overdue')->sum('quantity'),
                DamagedItem::where('school_level', 'Senior High School')->sum('quantity'),
            ];

            // Write data
            fputcsv($file, $totals);
            fputcsv($file, $juniorHighInventory);
            fputcsv($file, $seniorHighInventory);

            fclose($file);
        };

        return response()->stream($callback, 200, [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename={$filename}",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ]);
    }
}
