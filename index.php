<?php

require "vendor/autoload.php";

use BenHx\Api\Factory\Factory;

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
$factory = new Factory($app);
$factory->inizializeContainerDI();
$factory->inizializeMiddleware();


$app->put('/me', 'AuthenticationController:updateMe');
$app->get('/me', 'AuthenticationController:getMe');
$app->post('/register', 'AuthenticationController:register');
$app->post('/token', 'AuthenticationController:token');

// Run application
$app->run();
