<?php

namespace App\Tests\Controller\Home;

use App\Tests\Support\ControllerTester;

class IndexCest
{
    public function responseIsOk(ControllerTester $I): void
    {
        $I->amOnRoute('app_home');
        $I->seeResponseCodeIsSuccessful();
        $I->seeInTitle('MedicalCenter');
        $I->see('MedicalCenter', 'h1');
    }
}
