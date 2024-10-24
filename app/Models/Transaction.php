<?php

namespace App\Models;

use App\Enums\TransactionType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Transaction extends Model
{
    protected $fillable = ['user_id', 'type', 'amount', 'transaction_date', 'category_id', 'src_account_id', 'dest_account_id', 'details', 'spent_on', 'wallet_id'];

    protected $casts = [
        'type' => TransactionType::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    protected static function booted()
    {
        static::created(function ($transaction) {
            $transaction->adjustAccountBalancesOnCreate();
        });

        static::updated(function ($transaction) {
            $transaction->adjustAccountBalancesOnUpdate();
        });

        static::deleted(function ($transaction) {
            $transaction->adjustAccountBalancesOnDelete();
        });
    }

    protected function adjustAccountBalancesOnCreate()
    {
        switch ($this->type) {
            case TransactionType::Expense:
                $this->adjustBalance($this->src_account_id, -$this->amount);
                break;

            case TransactionType::Income:
                $this->adjustBalance($this->src_account_id, $this->amount);
                break;

            case TransactionType::Transfer:
                $this->adjustBalance($this->src_account_id, -$this->amount);
                $this->adjustBalance($this->dest_account_id, $this->amount);
                break;

            // Handle other transaction types as needed
        }
    }

    protected function adjustAccountBalancesOnUpdate()
    {
        $original = $this->getOriginal();

        // Reverse the original transaction
        switch ($original['type']) {
            case TransactionType::Expense:
                $this->adjustBalance($original['src_account_id'], $original['amount']);
                break;

            case TransactionType::Income:
                $this->adjustBalance($original['src_account_id'], -$original['amount']);
                break;

            case TransactionType::Transfer:
                $this->adjustBalance($original['src_account_id'], $original['amount']);
                $this->adjustBalance($original['dest_account_id'], -$original['amount']);
                break;

            // Handle other transaction types as needed
        }

        // Apply the new transaction
        $this->adjustAccountBalancesOnCreate();
    }

    protected function adjustAccountBalancesOnDelete()
    {
        // Reverse the transaction
        switch ($this->type) {
            case TransactionType::Expense:
                $this->adjustBalance($this->src_account_id, $this->amount);
                break;

            case TransactionType::Income:
                $this->adjustBalance($this->src_account_id, -$this->amount);
                break;

            case TransactionType::Transfer:
                $this->adjustBalance($this->src_account_id, $this->amount);
                $this->adjustBalance($this->dest_account_id, -$this->amount);
                break;

            // Handle other transaction types as needed
        }
    }

    private function adjustBalance($accountId, $amount)
    {
        if ($accountId && $amount != 0) {
            Account::where('id', $accountId)->where('user_id', $this->user_id)->increment('balance', $amount);
        }
    }

    // public function tags()
    // {
    //     return $this->belongsToMany(Tag::class);
    // }

    public function src_account()
    {
        return $this->belongsTo(Account::class);
    }

    public function dest_account()
    {
        return $this->belongsTo(Account::class);
    }

    public static function total_balance($user_id)
    {
        // SELECT user_id
        //         , SUM(COALESCE(CASE WHEN `type` = 'income' THEN amount END,0)) income
        //         , SUM(COALESCE(CASE WHEN `type` = 'withdrawal' THEN amount END,0)) withdrawals
        //         , SUM(COALESCE(CASE WHEN `type` = 'income' THEN amount END,0))
        //         - SUM(COALESCE(CASE WHEN `type` = 'withdrawal' THEN amount END,0)) balance
        //     FROM transactions
        //     WHERE user_id = 1
        //     GROUP
        //     BY user_id
        // HAVING balance <> 0

        $balance = DB::table('transactions')
            ->select(DB::raw("SUM(COALESCE(CASE 
                                        WHEN `type` = 'income' THEN amount 
                                        WHEN `type` = 'refund' THEN amount 
                                    END,0)) 
                                    - SUM(COALESCE(CASE 
                                        WHEN `type` = 'expense' THEN amount 
                                        WHEN `type` = 'return' THEN amount 
                                    END,0)) balance"))
            ->where('user_id', '=', $user_id)
            // ->groupBy('status')
            ->get();

        return $balance[0]->balance;
    }

    public static function available_balance($user_id)
    {
        $balance = DB::table('transactions')
            ->select(DB::raw("SUM(COALESCE(CASE 
                            WHEN `type` = 'income' THEN amount 
                            WHEN `type` = 'refund' THEN amount 
                            WHEN `type` = 'settlement d' THEN amount 
                            WHEN `type` = 'borrow' THEN amount 
                        END,0)) 
                        - SUM(COALESCE(CASE 
                            WHEN `type` = 'expense' THEN amount 
                            WHEN `type` = 'return' THEN amount 
                            WHEN `type` = 'lend' THEN amount
                            WHEN `type` = 'settlement w' THEN amount 
                        END,0)) balance"))
            ->where('user_id', '=', $user_id)
            ->get();

        return $balance[0]->balance;
    }

    public static function owed($user_id)
    {
        $balance = DB::table('transactions')
            ->select(DB::raw("SUM(COALESCE(CASE 
                            WHEN `type` = 'borrow' THEN amount 
                        END,0)) 
                        - SUM(COALESCE(CASE 
                            WHEN `type` = 'settlement w' THEN amount 
                        END,0))balance"))
            ->where('user_id', '=', $user_id)
            ->get();

        return $balance[0]->balance;
    }

    public static function other_owed($user_id)
    {
        $balance = DB::table('transactions')
            ->select(DB::raw("SUM(COALESCE(CASE 
                            WHEN `type` = 'lend' THEN amount 
                        END,0)) 
                        - SUM(COALESCE(CASE 
                            WHEN `type` = 'settlement d' THEN amount 
                        END,0)) balance"))
            ->where('user_id', '=', $user_id)
            ->get();

        return $balance[0]->balance;
    }

    public static function month_income($user_id)
    {
        $transactions = DB::table('transactions')
            ->select(DB::raw('SUM(amount) income'))
            ->where('user_id', '=', $user_id)
            ->where('type', '=', '\'income\'')
            ->whereMonth('created_at', 'MONTH(CURRENT_DATE())')
            ->whereYear('created_at', 'YEAR(CURRENT_DATE())')
            ->get();

        return $transactions[0]->income;
    }

    public static function month_expense($user_id)
    {
        $transactions = DB::table('transactions')
            ->select(DB::raw('SUM(amount) expense'))
            ->where('user_id', '=', $user_id)
            ->where('type', '=', '\'expense\'')
            ->whereMonth('created_at', 'MONTH(CURRENT_DATE())')
            ->whereYear('created_at', 'YEAR(CURRENT_DATE())')
            ->get();

        return $transactions[0]->expense;
    }

    public function scopeWithCategories($query, $categories)
    {
        if (!empty($categories)) {
            $query->whereIn('category_id', $categories);
        }
    }

    // Scope to filter by accounts
    public function scopeWithAccounts($query, $accounts)
    {
        if (!empty($accounts)) {
            $query->whereIn('src_account_id', $accounts);
        }
    }

    // Scope to filter by transaction types
    public function scopeWithTransactionTypes($query, $types)
    {
        if (!empty($types)) {
            $query->whereIn('type', $types);
        }
    }

    // Scope to filter by amount range
    public function scopeWithAmountRange($query, $min, $max)
    {
        if (!is_null($min)) {
            $query->where('amount', '>=', $min);
        }
        if (!is_null($max)) {
            $query->where('amount', '<=', $max);
        }
    }

    // Scope to filter by date range
    public function scopeWithDateRange($query, $start, $end)
    {
        if (!is_null($start)) {
            $query->where('transaction_date', '>=', $start);
        }
        if (!is_null($end)) {
            $query->where('transaction_date', '<=', $end);
        }
    }
}
