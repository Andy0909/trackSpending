<?php

namespace Tests\Unit;

use App\Services\CalculateAveragePrice;
use PHPUnit\Framework\TestCase;

class CalculateAveragePriceTest extends TestCase
{
    public function testCalculateAveragePrice()
    {
        $service = new CalculateAveragePrice();

        // 假設有三個人分攤費用
        $spendList = [
            [
                'payer' => 'A',
                'price' => 100,
                'shareMember' => ['A', 'B', 'C']
            ]
        ];

        $result = $service->calculateAveragePrice($spendList);

        // 驗證結果是否正確
        $this->assertEquals([
            'B' => ['A' => -33.33],
            'A' => ['C' => 33.33]
        ], $result);
    }
}
