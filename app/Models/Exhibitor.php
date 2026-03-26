<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Exhibitor extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id','company_name','booth_number','description','logo',
        'website','contact_name','contact_email','booth_size',
    ];

    public function event() { return $this->belongsTo(Event::class); }
}