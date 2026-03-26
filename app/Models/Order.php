<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id','attendee_id','ticket_id','order_number','total_amount',
        'status','paid_at','refunded_at','payment_method','payment_reference',
        'payment_phone','payment_gateway_response','notes',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'paid_at'      => 'datetime',
        'refunded_at'  => 'datetime',
    ];

    public function event()    { return $this->belongsTo(Event::class); }
    public function attendee() { return $this->belongsTo(Attendee::class); }
    public function ticket()   { return $this->belongsTo(Ticket::class); }

    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'paid'             => 'bg-green-100 text-green-800',
            'pending'          => 'bg-yellow-100 text-yellow-800',
            'pending_payment'  => 'bg-orange-100 text-orange-800',
            'refunded'         => 'bg-red-100 text-red-800',
            'cancelled'        => 'bg-gray-100 text-gray-800',
            default            => 'bg-gray-100 text-gray-800',
        };
    }

    public function getPaymentMethodLabelAttribute()
    {
        return match($this->payment_method) {
            'paystack'     => '💳 Paystack',
            'mpesa'        => '📱 M-Pesa',
            'airtel_money' => '📱 Airtel Money',
            'bank_cheque'  => '🏦 Bank Cheque',
            'bank_deposit' => '🏦 Bank Deposit',
            'free'         => '🎟 Free',
            default        => ucfirst($this->payment_method ?? 'Unknown'),
        };
    }
}