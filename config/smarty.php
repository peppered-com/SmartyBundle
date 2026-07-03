<?php
/*
 * This file is part of the NoiseLabs-SmartyBundle package.
 *
 * Copyright (c) 2011-2021 Vítor Brandão <vitor@noiselabs.io>
 *
 * NoiseLabs-SmartyBundle is free software; you can redistribute it
 * and/or modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 3 of the License, or (at your option) any later version.
 *
 * NoiseLabs-SmartyBundle is distributed in the hope that it will be
 * useful, but WITHOUT ANY WARRANTY; without even the implied warranty
 * of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with NoiseLabs-SmartyBundle; if not, see
 * <http://www.gnu.org/licenses/>.
 */

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return static function (ContainerConfigurator $container): void {
    $container->services()
        ->set('smarty', \Smarty::class)

        ->set('templating.engine.smarty', \NoiseLabs\Bundle\SmartyBundle\SmartyEngine::class)
            ->public()
            ->args([
                service('smarty'),
                service('smarty.templating.loader'),
                service('service_container'),
                '%smarty.options%',
                service('smarty.templating.globals')->nullOnInvalid(),
                service('logger')->nullOnInvalid(),
            ])
            ->tag('templating.engine')
            ->tag('monolog.logger', ['channel' => 'SmartyBundle'])

        ->set('smarty.file_locator', \Symfony\Component\HttpKernel\Config\FileLocator::class)
            ->factory([\NoiseLabs\Bundle\SmartyBundle\Loader\FileLocatorFactory::class, 'createFileLocator'])
            ->args([
                service('kernel'),
                '%kernel.project_dir%/Resources',
                ['%kernel.project_dir%'],
                '%smarty.options.templates_dir%',
            ])

        ->set('smarty.extension.core', \NoiseLabs\Bundle\SmartyBundle\Extension\CoreExtension::class)
            ->private()
            ->tag('smarty.extension')

        ->set('smarty.extension.actions', \NoiseLabs\Bundle\SmartyBundle\Extension\ActionsExtension::class)
            ->private()
            ->tag('smarty.extension')
            ->args([
                service('smarty.templating.helper.actions'),
            ])

        ->set('smarty.extension.assets', \NoiseLabs\Bundle\SmartyBundle\Extension\AssetsExtension::class)
            ->private()
            ->tag('smarty.extension')
            ->args([
                service('assets.packages')->ignoreOnInvalid(),
            ])

        ->set('smarty.extension.routing', \NoiseLabs\Bundle\SmartyBundle\Extension\RoutingExtension::class)
            ->private()
            ->tag('smarty.extension')
            ->args([
                service('router'),
            ])

        ->set('smarty.extension.trans', \NoiseLabs\Bundle\SmartyBundle\Extension\TranslationExtension::class)
            ->private()
            ->tag('smarty.extension')
            ->args([
                service('translator'),
            ])

        ->set('smarty.extension.security', \NoiseLabs\Bundle\SmartyBundle\Extension\SecurityExtension::class)
            ->private()
            ->tag('smarty.extension')
            ->args([
                service('security.authorization_checker')->nullOnInvalid(),
                service('security.csrf.token_manager')->nullOnInvalid(),
            ])

        ->set('smarty.extension.expression', \NoiseLabs\Bundle\SmartyBundle\Extension\ExpressionExtension::class)
            ->private()
            ->tag('smarty.extension')

        ->alias('smarty_engine', 'templating.engine.smarty')
    ;
};
