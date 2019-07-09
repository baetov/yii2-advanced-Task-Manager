<?php namespace frontend\tests\functional;
use Codeception\Example;
use frontend\tests\FunctionalTester;


class FirstCest
{
    public function _before(FunctionalTester $I)
    {
    }

    /**
     * @dataProvider pageProvider
     */
    public function tryToTest(FunctionalTester $I, Example $data)
    {
        $I->amOnPage([$data['url']]);
        $I->see($data['h1'],'h1');

    }

    protected function pageProvider()
    {
        return [
            ['url' => '/', 'h1' => 'Congratulations!'],
            ['url' => 'site/about', 'h1' => 'About'],
            ['url' => 'site/contact', 'h1' => 'Contact'],
            ['url' => 'site/login', 'h1' => 'Login'],
        ];
    }
}
