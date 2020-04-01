<?php
namespace backend\tests;

use backend\tests\fixtures\GoodFixture;

class GoodTest extends \Codeception\Test\Unit
{
    /**
     * @var \backend\tests\UnitTester
     */
    protected $tester;

    public function _fixtures()
    {
        return [
            'goods' => GoodFixture::class,
        ];
    }

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testSomeFeature()
    {
        $good = $this->tester->grabFixture('goods', 'good1');
        expect($good->getImage())->equals('');
        sleep(20);
    }
}