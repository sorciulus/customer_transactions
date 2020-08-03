<?php

namespace Report;

use Report\Model\TransactionRepository;
use Report\Service\CurrencyExchange;

class Report
{
    private $exchange;
    
    private $transactionRepository;

    public function __construct(TransactionRepository $repository, CurrencyExchange $currencyExchange)
    {
        $this->transactionRepository = $repository;
        $this->exchange = $currencyExchange;
    }

    public function getTransacionByCustomerId(int $customerId)
    {
        return $this->transactionRepository->getTransactionsByCustomerId($customerId);
    }

    public function convertTransacionByCustomerId(int $customerId, string $convCurrency) : array
    {
        $transactions = $this->getTransacionByCustomerId($customerId);
        $results = [];
        foreach ($transactions as $transaction) {
            $results[] = [
                'customer' => $transaction->getCustomerId(),
                'data' => $transaction->getTransactionDate(),
                'originalValue' => $transaction->getValue(),
                'convertValue' => number_format($this->exchange->convert($transaction->getValue(), $convCurrency), 2)
            ];
        }

        return $results;
    }
}
