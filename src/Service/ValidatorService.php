<?php

namespace App\Service;

use Webmozart\Assert\Assert;

class ValidatorService
{
    public function __construct()
    {
    }

    public static function validateCreateUserArray(array $userInformation)
    {
        Assert::keyExists($userInformation, "lastname", "Value lastname is missing");
        Assert::keyExists($userInformation, "firstname", "Value firstname is missing");
        Assert::keyExists($userInformation, "password", "Value password is missing");
        Assert::keyExists($userInformation, "email", "Value email is missing");

        Assert::stringNotEmpty($userInformation["lastname"], "Value lastname can't be blank");
        Assert::stringNotEmpty($userInformation["firstname"], "Value firstname can't be blank");
        Assert::stringNotEmpty($userInformation["password"], "Value password can't be blank");
        Assert::email($userInformation["email"], "Value email must be a valid email");
    }
}
