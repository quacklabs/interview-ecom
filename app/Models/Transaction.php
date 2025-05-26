<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Account;
use App\Models\User;

use App\Enums\TransactionType;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'account_id',
        'payment_id',
        'price_amount',
        'pay_amount',
        'price_currency',
        'pay_currency',
        'order_id',
        'order_description',
        'sub_id',
        'is_debit',
        'type',
        'payment_status', 
    ];

    protected $appends = [
        'open', 'name'
    ];

    public function account() {
        return $this->belongsTo(Account::class, 'account_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getOpenAttribute() {
        return !TransactionType::isEqual($this->type, TransactionType::SUBSCRIPTION) && ($this->payment_status != 'finished');
    }

    public function getNameAttribute() {
        switch(TransactionType::fromString($this->type)) {
            case TransactionType::PROMO_CREDIT:
                return 'Promotional credit';
            case TransactionType::WALLET_PAYMENT:
                return 'in-app payment';
            case TransactionType::WALLET_DEPOSIT:
                return 'Deposit';
            default:
                return 'Unknown';
        }
    }
}
