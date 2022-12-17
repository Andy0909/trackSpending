<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'user_id', 'event_name', 'event_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function member()
    {
        return $this->hasMany(Member::class);
    }

    public function item()
    {
        return $this->hasMany(Item::class);
    }
}
