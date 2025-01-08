<?php


namespace App\Tests\Controller\Admin;

use App\Factory\UserFactory;
use App\Tests\Support\ControllerTester;
use Codeception\Util\HttpCode;

class DashboardCest
{
    public function responseIsOk(ControllerTester $I): void
    {
        $user = UserFactory::createOne([
            'roles' => ['ROLE_ADMIN'],
        ]);
        $realUser = $user->_real();
        $I->amLoggedInAs($realUser);

        $I->amOnRoute('admin');
        $I->seeResponseCodeIsSuccessful();
    }

    public function accessIsRestrictedToAuthenticatedUsers(ControllerTester $I): void
    {
        $I->amOnRoute('admin');
        $I->seeCurrentRouteIs('app_login');
    }

    public function accessIsRestrictedToAdminUsers(ControllerTester $I): void
    {
        $user = UserFactory::createOne();
        $realUser = $user->_real();
        $I->amLoggedInAs($realUser);

        $I->amOnRoute('admin');
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
    }
}
