<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','slug','description','start_date','end_date','venue','location',
        'timezone','capacity','category','cover_image','status','is_virtual',
        'virtual_link','created_by','website_hero_title','website_hero_subtitle',
        'website_primary_color','website_about','website_show_speakers',
        'website_show_schedule','website_show_sponsors','custom_domain','badge_settings',
    ];

    protected $casts = [
        'start_date'            => 'datetime',
        'end_date'              => 'datetime',
        'is_virtual'            => 'boolean',
        'website_show_speakers' => 'boolean',
        'website_show_schedule' => 'boolean',
        'website_show_sponsors' => 'boolean',
    ];

    public function attendees()    { return $this->hasMany(Attendee::class); }
    public function orders()       { return $this->hasMany(Order::class); }
    public function tickets()      { return $this->hasMany(Ticket::class); }
    public function speakers()     { return $this->hasMany(Speaker::class); }
    public function schedules()    { return $this->hasMany(Schedule::class); }
    public function sponsors()     { return $this->hasMany(Sponsor::class); }
    public function exhibitors()   { return $this->hasMany(Exhibitor::class); }
    public function papers()       { return $this->hasMany(Paper::class); }
    public function surveys()      { return $this->hasMany(Survey::class); }
    public function accessCodes()  { return $this->hasMany(AccessCode::class); }
    public function communications(){ return $this->hasMany(MailCommunication::class); }
    public function paperFields()  { return $this->hasMany(PaperField::class); }
}