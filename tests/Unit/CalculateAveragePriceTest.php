<?php

namespace Tests\Unit;

use App\Services\CalculateAveragePriceService;
use PHPUnit\Framework\TestCase;

class CalculateAveragePriceTest extends TestCase
{
    public function testCalculateAveragePrice()
    {
        $service = new CalculateAveragePriceService();

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
            'A' => [
                'C' => 33.33,
                'B' => 33.33
            ],
        ], $result);
    }
}
