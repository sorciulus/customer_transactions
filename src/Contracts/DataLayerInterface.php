<?php

namespace Report\Contracts;

interface DataLayerInterface
{
    public function getTransactionByCustomerId(int $customerId) : array;
}