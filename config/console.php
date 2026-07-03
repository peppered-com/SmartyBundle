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

        ->set('smarty.command.compile', \NoiseLabs\Bundle\SmartyBundle\Command\CompileCommand::class)
            ->args([
                service('templating.engine.smarty'),
                service('smarty.templating.finder'),
            ])
            ->tag('console.command', ['command' => 'smarty:compile'])

        ->set('smarty.command.templates', \NoiseLabs\Bundle\SmartyBundle\Command\TemplatesCommand::class)
            ->args([
                service('smarty.templating.finder'),
            ])
            ->tag('console.command', ['command' => 'smarty:templates'])
    ;
};
