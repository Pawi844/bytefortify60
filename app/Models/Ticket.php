<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id','name','description','price','quantity','sale_start','sale_end',
        'min_per_order','max_per_order','ticket_type','is_visible',
    ];

    protected $casts = [
        'price'      => 'decimal:2',
        'is_visible' => 'boolean',
        'sale_start' => 'datetime',
        'sale_end'   => 'datetime',
    ];

    public function event()  { return $this->belongsTo(Event::class); }
    public function orders() { return $this->hasMany(Order::class); }

    public function getSoldCountAttribute()
    {
        return $this->orders()->where('status','paid')->count();
    }

    public function getRemainingAttribute()
    {
        return max(0, $this->quantity - $this->sold_count);
    }
}