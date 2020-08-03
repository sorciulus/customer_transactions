<?php

namespace Report\Model;

use DateTime;
use Report\Contracts\DataLayerInterface;
use Report\Exceptions\TransactionNotFound;
use Report\Model\DTO\Transaction;

class TransactionRepository
{
    private $dataLayer;

    public function __construct(DataLayerInterface $dataLayer)
    {
        $this->dataLayer = $dataLayer;
    }

    public function getTransactionsByCustomerId(int $customerId) : array
    {
        $transactions = $this->dataLayer->getTransactionByCustomerId($customerId);

        if (empty($transactions)) {
            throw new TransactionNotFound("No transaction found for customer id : $customerId");            
        }

        $result = [];
        foreach ($transactions as $transaction) {
            $result[] = new Transaction(
                $transaction['customer'],
                new DateTime($transaction['date']),
                $transaction['value']
            );
        }
        
        return $result;
    }
}