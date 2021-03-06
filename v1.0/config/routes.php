<?php
/**
 * 统一管理路由规则
 * User: Edvard
 * Date: 2016/1/3
 * Time: 16:34
 */

use Phalcon\Mvc\Micro\Collection as MicroCollection;

router($app, 'Public', array(
    array(
        'method' => 'post',
        'path' => '/token',
        'action' => 'login'
    ),
    array(
        'method' => 'delete',
        'path' => '/token',
        'action' => 'logout'
    ),
    array(
        'method' => 'post',
        'path' => '/user',
        'action' => 'register'
    )
), false);

router($app, 'User', array(
    array(
        'method' => 'get',
        'path' => '/user',
        'action' => 'getUser'
    ),
    array(
        'method' => 'put',
        'path' => '/user',
        'action' => 'updateUser'
    )
), false);

router($app, 'Admin', array(
    array(
        'method' => 'get',
        'path' => '/admin/user',
        'action' => 'getUsers'
    ),
    array(
        'method' => 'get',
        'path' => '/admin/user/{id:[0-9]+}',
        'action' => 'getUser'
    ),
    array(
        'method' => 'delete',
        'path' => '/admin/user/{id:[0-9]+}',
        'action' => 'deleteUser'
    )
), false);

function router($app, $controllerName, $requests, $lazyLoad = true)
{
    $class_name = $controllerName . 'Controller';
    $handler = new $class_name;
    $collections = new MicroCollection();
    $collections->setHandler($handler, $lazyLoad);
    foreach ($requests as $action) {
        switch ($action['method']) {
            case 'get':
                $collections->get($action['path'], $action['action']);
                break;
            case 'post':
                $collections->post($action['path'], $action['action']);
                break;
            case 'delete':
                $collections->delete($action['path'], $action['action']);
                break;
            case 'put':
                $collections->put($action['path'], $action['action']);
                break;
        }
    }
    $app->mount($collections);
}
