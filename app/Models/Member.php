<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'event_id', 'name',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
