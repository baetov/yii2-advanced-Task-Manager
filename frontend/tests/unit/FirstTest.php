<?php namespace frontend\tests;

use common\models\LoginForm;
use frontend\models\ContactForm;

class FirstTest extends \Codeception\Test\Unit
{
    /**
     * @var \frontend\tests\UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testSomeFeature()
    {
        $a = 123;
        $this->assertTrue(true);
        $this->assertNotEmpty($a);
        $this->assertEquals(123, $a);
        $this->assertLessThan(154,$a);

        expect('wait true', $a)->equals(123);

        $obj = new ContactForm();
        $obj->name = 'max';
        $this->assertAttributeEquals('max','name',$obj);

        $this->assertArrayHasKey('max',['max' => 'name']);
    }
}