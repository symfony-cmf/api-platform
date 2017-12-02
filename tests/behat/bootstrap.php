<?php

use Doctrine\Common\Annotations\AnnotationRegistry;

date_default_timezone_set('UTC');

$loader = require __DIR__.'/../../vendor/autoload.php';

require __DIR__ . '/../Fixtures/App/AppKernel.php';

AnnotationRegistry::registerLoader([$loader, 'loadClass']);

return $loader;