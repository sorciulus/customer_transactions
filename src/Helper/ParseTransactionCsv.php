<?php

namespace Report\Helper;

use Exception;
use InvalidArgumentException;
use Report\Contracts\DataLayerInterface;

class ParseTransactionCsv implements DataLayerInterface
{
    /**
     * @var string
     */
    private $filename;

    /**
     * @var array
     */
    private $data = [];
    
    public function __construct(string $filename)
    {
        if (!file_exists($filename)) {
            throw new InvalidArgumentException('File not exists');            
        }

        $this->filename = $filename;
        $this->parse();
    }
  
    private function parse()
    {        
        if (($resource = fopen($this->filename, 'r')) === false) {    
            throw new Exception("Not reading csv file");                    
        }
        $headers = fgetcsv($resource, 0, ';');
        $data = [];
        while (($rowTemp = fgetcsv($resource, 800, ";")) !== false) {
            foreach ($headers as $key => $header) {
                if (isset($rowTemp[$key])) {
                    $row[$header] = $rowTemp[$key];
                }
            }
            array_push($data, $row);
        }
        fclose($resource);        
        $this->data = $data;
    }

    /**
     * @param integer $customerId
     * @return array
     */
    public function getTransactionByCustomerId(int $customerId) : array
    {
        $result = [];
        
        foreach ($this->data as $transaction) {
            if ((int)$transaction['customer'] === $customerId) {
                $result[] = $transaction;
            }            
        }

        return $result;
    }
}