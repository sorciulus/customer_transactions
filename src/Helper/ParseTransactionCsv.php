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
        try {
            $resource = fopen($this->filename, 'r');
            $headers = fgetcsv($resource, 0, ';');

            $data = [];
            while (!feof($resource)) {
                $rowTemp = fgetcsv($resource, 0, ';');
                if (!$rowTemp) {
                    continue;
                }
                foreach ($headers as $key => $header) {
                    if (isset($rowTemp[$key])) {
                        $row[$header] = $rowTemp[$key];
                    }
                }
                array_push($data, $row);
            }
            fclose($resource);
            $this->data = $data;
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }                
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