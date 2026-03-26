<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Paper extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id','author_id','title','abstract','keywords','status',
        'decision_comment','decided_at','extra_data',
    ];

    protected $casts = ['decided_at' => 'datetime'];

    public function event()   { return $this->belongsTo(Event::class); }
    public function author()  { return $this->belongsTo(Attendee::class, 'author_id'); }
    public function reviews() { return $this->hasMany(PaperReview::class); }
    public function fields()  { return $this->belongsToMany(PaperField::class, 'paper_field_values')->withPivot('value'); }

    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'submitted'          => 'bg-blue-100 text-blue-800',
            'under_review'       => 'bg-yellow-100 text-yellow-800',
            'accepted'           => 'bg-green-100 text-green-800',
            'rejected'           => 'bg-red-100 text-red-800',
            'revision_requested' => 'bg-orange-100 text-orange-800',
            default              => 'bg-gray-100 text-gray-800',
        };
    }
}