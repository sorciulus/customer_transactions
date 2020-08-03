<?php

use PHPUnit\Framework\TestCase;
use Report\Service\CurrencyExchange;

class CurrencyExchangeTest extends TestCase
{
    public function testCurrencyExchange()
    {
        $exchange = new CurrencyExchange();

        $this->assertInstanceOf(CurrencyExchange::class, $exchange);
    }

    public function testConvertCurrency()
    {
        $exchange = new CurrencyExchange();

        $result = $exchange->convert('£50.00');

        $this->assertEquals(55.56, $result);
    }
}