<?php
/**
 * requestDataConverter.
 *
 * @author Wumouse <wumouse@qq.com>
 * @version $Id$
 */

use Library\Parameter;
use Phalcon\CLI\Console;
use Phalcon\CLI\Dispatcher;
use Phalcon\DI\FactoryDefault\CLI;
use Phalcon\Loader;

/**
 * 应用目录
 */
const APP_PATH = 'app';

$loader = new Loader();
$loader->registerNamespaces([
    'Tasks' => APP_PATH . '/Tasks',
    'Library' => APP_PATH . '/Library',
    'Logic' => APP_PATH . '/Logic',
])->register();

$di = new CLI();

$di->set('dispatcher', function () {
    $dispatcher = new Dispatcher();
    $dispatcher->setDefaultNamespace('Tasks');
    return $dispatcher;
}, true);

try {
    $console = new Console($di);
    $di->set('console', $console);
    $di->set('parameter', function () use ($argv) {
        $parameter = new Parameter($argv);
        return $parameter;
    });

    /** @var Parameter $parameter */
    $parameter = $di->get('parameter');
    $return = $console->handle($parameter->getParameters());
} catch (Exception $e) {
    echo $e;
}
