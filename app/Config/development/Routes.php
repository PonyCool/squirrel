<?php
/**
 * Created by PhpStorm
 * User: Pony
 * Date: 2021/5/24
 * Time: 2:43 下午
 */

use Config\Services;

$routes = Services::routes(true);

/**
 * 自定义路由
 */
$url = current_url(true);
$segments = $url->getSegments();
$ns = [
    'api' => "PonyCool\Control\Api"
];
if (key_exists($segments[0], $ns)) {
    $routes->add($segments[0] . '/(:any)', $ns[$segments[0]] . '\\' . $segments[1] . '::' . $segments[2]);
}