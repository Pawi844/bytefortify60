<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SurveyResponse extends Model
{
    use HasFactory;

    protected $fillable = ['survey_id','attendee_id','answers'];

    public function survey()   { return $this->belongsTo(Survey::class); }
    public function attendee() { return $this->belongsTo(Attendee::class); }
}