<?php

namespace App\Models\Applicant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentTransaction extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'payment_transactions';
    protected $fillable = [
        'applicant_id ',
        'transaction_id',
        'status',
        'auth_code',
        'amount',
        'card_last4',
        'response_raw',
    ];

}
