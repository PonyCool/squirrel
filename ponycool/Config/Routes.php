<?php
/**
 * Created by PhpStorm
 * User: Pony
 * Date: 2021/5/24
 * Time: 3:25 下午
 */

use Config\Services;

$routes = Services::routes(true);

/**
 * 自定义路由
 */
$uri = Services::uri();
$segments = $uri->getSegments();

$routes->setDefaultNamespace('PonyCool\Controllers\\');

// 获取当前服务器系统
$isWin = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
$separator = DIRECTORY_SEPARATOR;
if ($isWin) {
    $separator = '/';
}

$ns = $routes->getDefaultNamespace();
$controller = str_replace('\\', '/', ROOTPATH . lcfirst($ns));

if (!empty($segments)) {
    $from = '';
    $to = '';
    $method = 'Index';
    foreach ($segments as $k => $v) {
        $from .= $v;
        $to .= ucfirst($v);
        $controller .= $v;
        if (!is_dir($controller)) {
            if (array_key_exists($k + 1, $segments)) {
                $method = ucfirst($segments[$k + 1]);
            }
            break;
        }
        $from .= $separator;
        $to .= $separator;
        $controller .= $separator;
    }
    $to = str_replace('-', '_', $to);
    $routes->add($from, sprintf('%s::%s', $to, $method));
    $routes->add(sprintf('%s/(:any)', $from), sprintf('%s::%s', $to, $method));
}
