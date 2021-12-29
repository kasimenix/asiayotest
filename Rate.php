<?php


class Rate{
    function __construct()
    {
        
    }

    /**
    * @method GET
    * @param $string source
    * @param $string target
    * @param $number amount
    * @return array
    */
    public function Changerate($param) {
        try {
            if (empty($param)) {
                throw new Exception("param empty");
            }
        
            $amount = $param['amount'];
            $source = $param['source'];
            $target = $param['target'];
            $currency = ['JPY', 'TWD', 'USD'];
            $currencies =  [
                'TWD' => [ 
                    'TWD' => 1, 
                    'JPY' => 3.669, 
                    'USD' => 0.03281 
                ], 
                'JPY' => [ 
                    'TWD' => 0.26956, 
                    'JPY' => 1, 
                    'USD' => 0.00885 
                ], 
                'USD' => [
                    'TWD' => 30.444, 
                    'JPY' => 111.801, 
                    'USD' => 1 
                ]
            ]; 
            
            if (!is_numeric($amount)) {
                throw new Exception('param error: amount error');
            }
        
            if (!in_array($target, $currency)) {
                throw new Exception('param error: target not support');
            }
        
            if (!in_array($source, $currency)) {
                throw new Exception('param error: source not support');
            }
        
            $sourceRate = $currencies[$source];
            $targetRate = $sourceRate[$target];
            $transform = bcmul($amount, $targetRate, 2);

            $transform = $this->formatMoney($transform, 1);
            
            $success = ['success' => ['ret' => $transform, 'status' => 200]];

            return $success;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    private function formatMoney($number, $cents = 1) { 
        if (is_numeric($number)) { 
            if (!$number) { 
                $money = ($cents == 2 ? '0.00' : '0'); 
            } else { 
                if (floor($number) == $number) { 
                    $money = number_format($number, ($cents == 2 ? 2 : 0)); 
                } else {
                    $money = number_format(round($number, 2), ($cents == 0 ? 0 : 2)); 
                } 
            } 
            return $money;
        } 
    }
}



