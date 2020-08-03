<?php

namespace Report\Service;

class CurrencyExchange
{    
    private $EUR_EUR = 1.0;

    private $USD_EUR = 0.85;

    private $GBP_EUR = 1.1;
    
    private $EUR_USD = 1.17;

    private $USD_USD = 1.0;

    private $GBP_USD = 1.3;
    
    private $EUR_GBP = 0.9;

    private $USD_GBP = 0.77;

    private $GBP_GBP = 1.0;

    private function getConvertCurrency(string $currencyValue, string $toCurrency) : ?float
    {
        if(preg_match('/€|\$|£/', $currencyValue, $matches)){            
            switch ($matches[0]) {
                case '€':                    
                    $currency = \sprintf('%s_%s', 'EUR', $toCurrency);
                break;
                case '$':
                    $currency = \sprintf('%s_%s', 'USD', $toCurrency);
                break;
                case '£':
                    $currency = \sprintf('%s_%s', 'GBP', $toCurrency);
                break;                        
            }

            return $this->{$currency};
        }              
    }

    /**
     * @param string $currency     
     * @return float
     */
    public function convert(string $currency, string $toCurrency) : float
    {
        $unitCurrencyConvert = $this->getConvertCurrency($currency, $toCurrency);        
        if (is_null($unitCurrencyConvert)) {
            throw new \Exception("Currency not found in exchange");            
        }

        $clearCurrency = (float) preg_replace('/[^\w+|,|\.]/', '', $currency);

        $result = $clearCurrency / $unitCurrencyConvert;

        return number_format($result, 2);
    }
}