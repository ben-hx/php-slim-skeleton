<?php

declare (strict_types = 1);

namespace BenHx\Api\Helpers;

class ExampleDictionaries
{
    public static $minimalUser = [
        'username' => 'minimal',
        'password' => 'minimalPassword',
    ];

    public static $bobUser = [
        'username' => 'bob',
        'password' => 'bobPassword',
        'firstName' => 'bobFirstname',
        'lastName' => 'bobLastname',
        'email' => 'bob@mail.com'
    ];

    public static $aliceUser = [
        'username' => 'alice',
        'password' => 'alicePassword',
        'firstName' => 'aliceFirstname',
        'lastName' => 'aliceLastname',
        'email' => 'alice@mail.com'
    ];
}