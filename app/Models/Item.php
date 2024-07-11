<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'item_name',
        'item_quantity',
        'category',
        'unit_of_measure',
        'room_number',
        'school_level',
        'adviser',
        'items_needed',
        'borrowed_items',
        'overdue_items',
        'damaged_items'
    ];
}
