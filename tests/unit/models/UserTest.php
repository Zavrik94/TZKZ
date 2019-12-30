<?php

namespace tests\unit\models;

use app\models\LoginUser;

class UserTest extends \Codeception\Test\Unit
{
    public function testFindUserById()
    {
        expect_that($user = LoginUser::findIdentity(100));
        expect($user->username)->equals('admin');

        expect_not(LoginUser::findIdentity(999));
    }

    public function testFindUserByAccessToken()
    {
        expect_that($user = LoginUser::findIdentityByAccessToken('100-token'));
        expect($user->username)->equals('admin');

        expect_not(LoginUser::findIdentityByAccessToken('non-existing'));
    }

    public function testFindUserByUsername()
    {
        expect_that($user = LoginUser::findByUsername('admin'));
        expect_not(LoginUser::findByUsername('not-admin'));
    }

    /**
     * @depends testFindUserByUsername
     */
    public function testValidateUser($user)
    {
        $user = LoginUser::findByUsername('admin');
        expect_that($user->validateAuthKey('test100key'));
        expect_not($user->validateAuthKey('test102key'));

        expect_that($user->validatePassword('admin'));
        expect_not($user->validatePassword('123456'));        
    }

}
