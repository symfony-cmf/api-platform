<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2017 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

if (!defined('CMF_TEST_ROOT_DIR')) {
    define('CMF_TEST_ROOT_DIR', realpath(__DIR__.'/../../../../vendor/symfony-cmf/testing'));
}
if (!defined('CMF_TEST_CONFIG_DIR')) {
    define('CMF_TEST_CONFIG_DIR', CMF_TEST_ROOT_DIR.'/resources/config');
}
$container->setParameter('cmf_testing.bundle_fqn', 'Symfony\Cmf\Bundle\CoreBundle');
$loader->import(CMF_TEST_CONFIG_DIR.'/default.php');
$loader->import(CMF_TEST_CONFIG_DIR.'/phpcr_odm.php');
$loader->import(__DIR__ . '/cmf_api_platform.yml');

$container->loadFromExtension('framework', [
    'csrf_protection' => true,
]);
