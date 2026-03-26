<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AccessCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id','code','discount_type','discount','max_uses','expires_at','description',
    ];

    protected $casts = [
        'discount'   => 'decimal:2',
        'expires_at' => 'datetime',
    ];

    public function event()  { return $this->belongsTo(Event::class); }
    public function usages() { return $this->hasMany(Order::class, 'access_code_id'); }
}