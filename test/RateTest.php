<?php
require('./Rate.php');

use PHPUnit\Framework\TestCase;

final class RateTest extends TestCase
{
    /**
     * @dataProvider rateProvider
     */
    public function testChangerate($source, $target, $amount, $ret){
        $param = ['source' => $source, 'target' => $target, 'amount' => $amount];
        
        $api = new Rate();
        
        $content = $api->Changerate($param);
       
        $this->assertEquals($ret, $content['success']['ret']);
    }

    /**
     * @dataProvider rateProviderError
     */
    public function testChangerateError($source, $target, $amount, $ret){
        $param = ['source' => $source, 'target' => $target, 'amount' => $amount];

        $this->expectExceptionMessage($ret);

        $api = new Rate();

        $api->Changerate($param);
    }
   
    public function rateProvider()
    {
        return [
            ['USD', 'TWD', 1, '30.44'],
            ['USD', 'TWD', 1.1, '33.48'],
            ['USD', 'TWD', 100, '3,044.40'],
            ['USD', 'JPY', 1, '111.80'],
            ['USD', 'JPY', 100, '11,180.10'],
            ['TWD', 'USD', 1, '0.03'],
            ['TWD', 'USD', 100, '3.28'],
            ['TWD', 'JPY', 1, '3.66'],
            ['TWD', 'JPY', 1.1, '4.03'],
            ['TWD', 'JPY', 100, '366.90'],
            ['JPY', 'TWD', 1, '0.26'],
            ['JPY', 'TWD', 100, '26.95'],
            ['JPY', 'USD', 1, '0'],
            ['JPY', 'USD', 100, '0.88'],
        ];
    } 

    public function rateProviderError()
    {
        return [
            ['USD', 'TWDs', 1, 'param error: target not support'],
            ['USDs', 'TWD', 1.1, 'param error: source not support'],
            ['USD', 'TWD', 'a000100', 'param error: amount error'],
            ['#@WS!=user', 'TWD', 10, 'param error: source not support'],  
            ['usd', 'TWD', 10, 'param error: source not support'],  
            ['USD', 'twd', 10, 'param error: target not support'],  
        ];
    }
}