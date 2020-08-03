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

        $result = $exchange->convert('£50.00', 'EUR');

        $this->assertEquals(45.45, number_format($result, 2));
    }
}
