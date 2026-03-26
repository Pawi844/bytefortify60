<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sponsor extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id','name','tier','logo','website','description','contact_name','contact_email',
    ];

    public function event() { return $this->belongsTo(Event::class); }
}