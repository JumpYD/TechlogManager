<?php

namespace Qihoo\UserBundle;

use Qihoo\UserBundle\DependencyInjection\Security\Factory\QihooUserFactory;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class QihooUserBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $extension = $container->getExtension('security');
        $extension->addSecurityListenerFactory(new QihooUserFactory());
    }
}
