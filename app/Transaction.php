<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Transaction extends Model
{
    protected $fillable = ['user_id', 'type', 'amount', 'category_id', 'src_account_id', 'dest_account_id', 'details', 'spent_on', 'wallet_id'];

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
}
