<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaperReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'paper_id','reviewer_id','score','comments','recommendation','status',
    ];

    public function paper()    { return $this->belongsTo(Paper::class); }
    public function reviewer() { return $this->belongsTo(Attendee::class, 'reviewer_id'); }
}