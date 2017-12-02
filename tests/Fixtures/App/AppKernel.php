<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2017 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Symfony\Bundle\MonologBundle\MonologBundle;
use Symfony\Cmf\Bundle\ApiPlatformBundle\CmfApiPlatformBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;
use ApiPlatform\Core\Bridge\Symfony\Bundle\ApiPlatformBundle;
use ApiPlatform\Core\Tests\Fixtures\TestBundle\TestBundle;
use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Doctrine\Bundle\PHPCRBundle\DoctrinePHPCRBundle;
use FOS\UserBundle\FOSUserBundle;
use Nelmio\ApiDocBundle\NelmioApiDocBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\SecurityBundle\SecurityBundle;
use Symfony\Bundle\TwigBundle\TwigBundle;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        return [
            new CmfApiPlatformBundle(),
            new FrameworkBundle(),
            new TwigBundle(),
            new DoctrineBundle(),
            new ApiPlatformBundle(),
            new SecurityBundle(),
            new FOSUserBundle(),
            new NelmioApiDocBundle(),
            new TestBundle(),
            new MonologBundle(),
            new DoctrinePHPCRBundle(),
        ];

    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__ . '/config/config.php');
    }
}
