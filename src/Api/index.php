<?php

require "../../vendor/autoload.php";

use BenHx\Api\Controllers\User\UserController;

/**
 * @SWG\Swagger(
 *     schemes={"http"},
 *     host="letssee",
 *     basePath="/v2",
 *     @SWG\Info(
 *         version="1.0.0",
 *         title="BenHx Api",
 *         description="API",
 *         @SWG\Contact(
 *             email="ben-hx@web.de"
 *         ),
 *         @SWG\License(
 *             name="Apache 2.0",
 *             url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *         )
 *     ),
 *     @SWG\ExternalDocumentation(
 *         description="Find out more about Swagger",
 *         url="http://swagger.io"
 *     )
 * )
 */

$config = [
    'settings' => [
        'displayErrorDetails' => true
    ],
];

$app = new \Slim\App($config);


$app->put('/me', 'BenHx\Api\Controllers\User\UserController:updateMe');
$app->get('/register', 'BenHx\Api\Controllers\User\UserController:register');
$app->get('/login', 'BenHx\Api\Controllers\User\UserController:login');
$app->get('/logout', 'BenHx\Api\Controllers\User\UserController:logout');


// Add route callbacks
$app->get('/', function ($request, $response, $args) {
    return $response->withStatus(200)->write('Hello World!');
});

// Run application
$app->run();
