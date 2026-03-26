<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaperField extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id','label','field_type','options','is_required','sort_order','help_text',
    ];

    protected $casts = ['is_required' => 'boolean'];

    public function event() { return $this->belongsTo(Event::class); }
}