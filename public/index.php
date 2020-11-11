<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;

require __DIR__.'/../vendor/autoload.php';

$request = Request::createFromGlobals();

$routes = require __DIR__.'/../src/routes.php';

$context = (new RequestContext())->fromRequest($request);

$matcher = new UrlMatcher($routes, $context);

$controllerResolver = new ControllerResolver();
$argumentResolver = new ArgumentResolver();

try {
    $result = $matcher->match($request->getPathInfo());
    $request->attributes->add($result);
    // $controller = getController($result);
    $controller = $controllerResolver->getController($request);
    $arguments = $argumentResolver->getArguments($request, $controller);

    $response = call_user_func_array($controller, $arguments);
    // extract($matcher->match($request->getPathInfo()));
    // ob_start();
    // include __DIR__.'/../src/pages/'.$_route.'.php';
    // $response = new Response(ob_get_clean(), 200);
} catch (ResourceNotFoundException $e) {
    $response = new Response('La page n\'existe pas', 404);
} catch (Exception $e) {
    $response = new Response('Une erreur s\'est produite', 500);
}

// $pathInfo = $request->getPathInfo();
// if (isset($map[$pathInfo])) {
    //     extract($request->query->all());
//     ob_start();
//     include __DIR__.'/../src/pages/'.$map[$pathInfo];
//     $response->setContent(ob_get_clean());
//     $response->setStatusCode(200);
// } else {
    //     $response->setContent();
    //     $response->setStatusCode(404);
// }

// header('Content : text/html; charset=utf-8');
$response->headers->set('Content-Type', 'text/html');
$response->send();

// function getController(array $result)
// {
//     $className = substr($result['_controller'], 0, strpos($result['_controller'], '@'));
//     $methodName = substr($result['_controller'], strpos($result['_controller'], '@') + 1);

//     return [new $className(), $methodName];
// }

function renderTemplate(?Request $request): Response
{
    if ($request) {
        extract($request->attributes->all(), EXTR_SKIP);
    }

    ob_start();

    include __DIR__."/../src/pages/$_route.php";

    return new Response(ob_get_clean(), 200);
}
