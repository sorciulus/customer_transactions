<?php

use PHPUnit\Framework\TestCase;
use Report\Exceptions\TransactionNotFound;
use Report\Helper\ParseTransactionCsv;
use Report\Model\DTO\Transaction;
use Report\Model\TransactionRepository;

class TransactionRepositoryTest extends TestCase
{
    private $parser;

    protected function setUp(): void
    {
        $filename = dirname(__DIR__).DIRECTORY_SEPARATOR.'data.csv';
        
        $this->parser = new ParseTransactionCsv($filename);
    }

    public function testTransactionRepositoryClassTest()
    {
        $repository = new TransactionRepository($this->parser);

        $this->assertInstanceOf(TransactionRepository::class, $repository);
    }

    public function testTransactionRepositoryClassResult()
    {
        $repository = new TransactionRepository($this->parser);

        $results = $repository->getTransactionsByCustomerId(1);

        $this->assertTrue(is_array($results));
        
        $this->assertInstanceOf(Transaction::class, end($results));
    }

    public function testGetTransactionByCustomerIdThrowNotFound()
    {
        $this->expectException(TransactionNotFound::class);

        $repository = new TransactionRepository($this->parser);

        $repository->getTransactionsByCustomerId(10);
    }
}
