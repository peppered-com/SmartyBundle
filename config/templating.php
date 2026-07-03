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
        ->defaults()
            ->private()

        ->set('smarty.templating.name_parser', \NoiseLabs\Bundle\SmartyBundle\Templating\TemplateNameParser::class)
            ->args([
                service('kernel'),
            ])

        ->set('smarty.templating.filename_parser', \NoiseLabs\Bundle\SmartyBundle\Templating\TemplateFilenameParser::class)

        ->set('smarty.templating.locator', \NoiseLabs\Bundle\SmartyBundle\Templating\Loader\TemplateLocator::class)
            ->args([
                service('smarty.file_locator'),
                '%kernel.cache_dir%',
            ])

        ->set('smarty.templating.finder', \NoiseLabs\Bundle\SmartyBundle\Loader\TemplateFinder::class)
            ->public()
            ->args([
                service('kernel'),
                service('smarty.templating.filename_parser'),
                '%kernel.project_dir%/Resources',
                '%smarty.options%',
            ])

        ->set('smarty.templating.loader.filesystem', \NoiseLabs\Bundle\SmartyBundle\Templating\Loader\FilesystemLoader::class)
            ->args([
                service('smarty.templating.locator'),
            ])

        ->set('smarty.templating.loader', \NoiseLabs\Bundle\SmartyBundle\Loader\TemplateLoader::class)
            ->args([
                service('smarty.templating.name_parser'),
                service('smarty.templating.loader.filesystem'),
            ])

        ->set('smarty.templating.globals', \NoiseLabs\Bundle\SmartyBundle\Templating\GlobalVariables::class)
            ->args([
                service('service_container'),
            ])

        ->set('smarty.templating.helper.actions', \NoiseLabs\Bundle\SmartyBundle\Templating\Helper\ActionsHelper::class)
            ->tag('templating.helper', ['alias' => 'actions'])
            ->args([
                service('fragment.handler'),
            ])
    ;
};
