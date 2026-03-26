<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MailCommunication extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id','subject','body','recipients','status','sent_by','sent_at','sent_count','send_at',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
        'send_at' => 'datetime',
    ];

    public function event() { return $this->belongsTo(Event::class); }
}