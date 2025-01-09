<?php

namespace App\Tests\Controller\Cart;

use App\Factory\UserFactory;
use App\Tests\Support\ControllerTester;

class CartIndexCest
{
    public function accessIsRestrictedToAuthenticatedUsers(ControllerTester $I): void
    {
        $I->amOnRoute('app_cart');
        $I->seeCurrentRouteIs('app_login');
    }

    public function responseIsOk(ControllerTester $I): void
    {
        $user = UserFactory::createOne();
        $realUser = $user->_real();
        $I->amLoggedInAs($realUser);

        $I->amOnRoute('app_cart');
        $I->seeResponseCodeIsSuccessful();
        $I->seeInTitle('Panier');
        $I->see('Votre Panier', 'h3');
        $I->see('Votre panier est vide !', 'p');
    }
}
