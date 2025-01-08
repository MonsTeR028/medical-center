<?php

namespace App\Tests\Controller\Medicine;

use App\Tests\Support\ControllerTester;

class ListCest
{
    public function responseIsOk(ControllerTester $I): void
    {
        $I->amOnRoute('app_medicine');
        $I->seeResponseCodeIsSuccessful();
        $I->seeInTitle('Liste des médicaments');
        $I->seeNumberOfElements('div.medicines div.medicine', 0);
    }

    public function search(ControllerTester $I): void
    {
        $I->amOnRoute('app_medicine');
        $I->seeResponseCodeIsSuccessful();
        $I->fillField('search', 'A');
        $I->click('input#submit-search[type=submit]');
        $I->seeResponseCodeIsSuccessful();
        $I->seeInCurrentUrl('?search=A');
    }
}
