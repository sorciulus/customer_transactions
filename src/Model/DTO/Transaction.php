<?php 

namespace Report\Model\DTO;

use DateTime;

class Transaction
{
    private $customerId;

    private $transactionDate;

    private $value;

    public function __construct(int $customerId, DateTime $transactionDate, string $value)
    {
        $this->customerId = $customerId;
        $this->transactionDate = $transactionDate;
        $this->value = $value;
    }

    /**
     * Get the value of customerId
     */ 
    public function getCustomerId()
    {
        return $this->customerId;
    }

    /**
     * Get the value of transactionDate
     */ 
    public function getTransactionDate()
    {
        return $this->transactionDate;
    }

    /**
     * Get the value of value
     */ 
    public function getValue()
    {
        return $this->value;
    }
}