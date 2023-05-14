<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'event_id', 'item_id', 'item_name', 'price', 'payer', 'share_member',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
