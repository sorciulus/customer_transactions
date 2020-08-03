<?php

use PHPUnit\Framework\TestCase;
use Report\Exceptions\TransactionNotFound;
use Report\Helper\ParseTransactionCsv;
use Report\Model\DTO\Transaction;
use Report\Model\TransactionRepository;
use Report\Report;
use Report\Service\CurrencyExchange;

class ReportClassTest extends TestCase
{
    private $repository;

    protected function setUp(): void
    {
        $filename = dirname(__DIR__).DIRECTORY_SEPARATOR.'data.csv';
        
        $this->repository = new TransactionRepository(new ParseTransactionCsv($filename));
    }

    public function testReportClass()
    {
        $this->assertInstanceOf(Report::class, new Report($this->repository, new CurrencyExchange()));
    }

    public function testGetTransacionByCustomerId()
    {
        $report = new Report($this->repository, new CurrencyExchange());

        $transactions = $report->getTransacionByCustomerId(1);

        $this->assertTrue(is_array($transactions));

        $this->assertInstanceOf(Transaction::class, end($transactions));
    }

    public function testGetConvertTransacionByCustomerId()
    {
        $report = new Report($this->repository, new CurrencyExchange());

        $transactions = $report->convertTransacionByCustomerId(1, 'EUR');

        $this->assertTrue(is_array($transactions));
    }
    
    public function testGetConvertTransacionByCustomerIdException()
    {
        $this->expectException(TransactionNotFound::class);
        
        $report = new Report($this->repository, new CurrencyExchange());

        $transactions = $report->convertTransacionByCustomerId(10, 'EUR');

        $this->assertTrue(is_array($transactions));
    }
}
