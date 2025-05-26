<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Transaction;
use App\Enums\TransactionType;

class Account extends Model
{
    use HasFactory;
    protected $table = 'accounts';

    protected $fillable = [
        "user_id",
        "identifier",
        "type"
    ];


    protected $appends = [
        'balance'
    ];

    /**
     * Always encrypt the password when it is updated.
     *
     * @param $value
    * @return string
    */
    public function setIdentifierAttribute($value) {
        // we generate a nuban compliant identifier for the wallet first.
        // if the app ever needs to plug into NIBSS in the future, we are already ahead
        $fullAccountNumber = '090' . $value;
        $checkDigit = $this->calculateNubanChecksum($fullAccountNumber);
        $nuban = $fullAccountNumber . $checkDigit;

        $this->attributes['identifier'] = $nuban;
    }


    public function getBalanceAttribute() {

        $debits = Transaction::where('is_debit', true)->where('account_id', $this->id)->where('payment_status', 'finished')->sum('pay_amount');

        $credits = Transaction::where('is_debit', false)->where('account_id', $this->id)
        ->where('payment_status', 'finished')
        ->sum('pay_amount');
        return floatval($credits - $debits);
    }

    public function transactions() {
        return $this->hasMany(Transaction::class, 'account_id');
    }

    private function calculateNubanChecksum($accountNumber) {
        // Convert the account number to an array of digits
        $digits = array_map('intval', str_split($accountNumber));
    
        // Weight each digit based on its position
        $weights = [3, 7, 3, 7, 3, 7, 3, 7, 3, 7];
        
        // Calculate the weighted sum
        $sum = 0;
        for ($i = 0; $i < 10; $i++) {
            $sum += $digits[$i] * $weights[$i];
        }
    
        // Calculate the modulus 10 of the sum
        $modulus = $sum % 10;
    
        // Subtract the modulus from 10 to get the check digit
        $checkDigit = ($modulus === 0) ? 0 : (10 - $modulus);
    
        return $checkDigit;
    }

}
