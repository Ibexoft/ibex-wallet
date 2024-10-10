<?php
namespace App\Enums;

enum TransactionType
{
    case Expense;
    case Income;
    case Transfer;

    public function label(): string
    {
        return match($this) {
            TransactionType::Expense => 'Expense',
            TransactionType::Income => 'Income',
            TransactionType::Transfer => 'Transfer',
        };
    }
}
