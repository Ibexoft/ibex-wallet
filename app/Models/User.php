<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'image',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the user accounts.
     */
    public function accounts()
    {
        return $this->hasMany('App\Models\Account');
    }

    /**
     * Get the user wallets.
     */
    public function wallets()
    {
        return $this->hasMany('App\Models\Wallet');
    }

    /**
     * Get the user categories.
     */
    public function categories()
    {
        return $this->hasMany('App\Models\Category');
    }

    /**
     * Get the user transactions.
     */
    public function transactions()
    {
        return $this->hasMany('App\Models\Transaction');
    }


    public function getTotalIncome($no_of_months)
    {
        $startDate = Carbon::now()->subMonths($no_of_months)->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

        return $this->transactions()
            ->where('type', 'income')
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->sum('amount');
    }

    public function getTotalExpense($no_of_months)
    {
        $startDate = Carbon::now()->subMonths($no_of_months)->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

        return $this->transactions()
            ->where('type', 'expense')
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->sum('amount');
    }

    public function getMonthlyIncomeExpense($no_of_months)
    {
        $currentDate = Carbon::now();
        $monthlyData = collect();

        for ($i = 0; $i < $no_of_months; $i++) {
            $startOfMonth = $currentDate->copy()->startOfMonth();
            $endOfMonth = $currentDate->copy()->endOfMonth();

            $income = $this->transactions()
                ->where('type', 'income')
                ->whereBetween('transaction_date', [$startOfMonth, $endOfMonth])
                ->sum('amount');

            $expense = $this->transactions()
                ->where('type', 'expense')
                ->whereBetween('transaction_date', [$startOfMonth, $endOfMonth])
                ->sum('amount');

            $monthlyData->push([
                'month' => $currentDate->format('M Y'),
                'income' => $income,
                'expense' => $expense,
            ]);

            $currentDate->subMonth(); // Move to the previous month
        }

        return $monthlyData;
    }
}
