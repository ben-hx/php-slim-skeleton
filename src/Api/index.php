<?php

require "../../vendor/autoload.php";

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

$factory = new Factory();
$factory->inizializeContainerDI($app->getContainer());



$app->add(new \Slim\Middleware\JwtAuthentication([
    "path" => ["/"],
    "secret" => "supersecretkeyyoushouldnotcommittogithub",
    "passthrough" => ["/register", "/temp"]
]));


$app->put('/me', 'AuthenticationController:updateMe');
$app->post('/register', 'AuthenticationController:register');
$app->get('/login', 'AuthenticationController:login');
$app->get('/logout', 'AuthenticationController:logout');


// Add route callbacks
$app->get('/temp', function ($request, $response, $next) {
    //return $response->withStatus(200)->write("ups".$request->getUri()->getBasePath());
    //$request->getUri()->getBasePath();
    print_r ($next);
});

// Run application
$app->run();
