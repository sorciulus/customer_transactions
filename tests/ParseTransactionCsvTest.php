<?php

use PHPUnit\Framework\TestCase;
use Report\Helper\ParseTransactionCsv;
use Report\Model\DTO\Transaction;

class ParseTransactionCsvTest extends TestCase
{
    private $parser;

    protected function setUp(): void
    {
        $filename = dirname(__DIR__).DIRECTORY_SEPARATOR.'data.csv';
        
        $this->parser = new ParseTransactionCsv($filename);
    }
    
    public function testParseTransactionCsvClass()
    {
        $this->assertInstanceOf(ParseTransactionCsv::class, $this->parser);
    }

    public function testGetTransactionByCustomerId()
    {
        $data = $this->parser->getTransactionByCustomerId(1);

        $this->assertTrue(is_array($data));
    }
}