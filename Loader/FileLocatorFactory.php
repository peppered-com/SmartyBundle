<?php
/**
 * This file is part of NoiseLabs-SmartyBundle
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
 *
 * Copyright (C) 2011-2018 Vítor Brandão
 *
 * @category    NoiseLabs
 * @package     SmartyBundle
 * @copyright   (C) 2011-2018 Vítor Brandão <vitor@noiselabs.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL-3
 * @link        https://www.noiselabs.io
 */

namespace NoiseLabs\Bundle\SmartyBundle\Loader;

use Symfony\Component\HttpKernel\Config\FileLocator;
use Symfony\Component\HttpKernel\KernelInterface;

class FileLocatorFactory
{
    /**
     * @param KernelInterface $kernel A KernelInterface instance
     * @param string|null $path The path the global resource directory
     * @param array $paths An array of paths where to look for resources
     * @param string|array $extraTemplatePaths
     *
     * @return FileLocator
     */
    public static function createFileLocator(KernelInterface $kernel, $path, array $paths, $extraTemplatePaths)
    {
        return new FileLocator($kernel, $path, array_merge($paths, (array) $extraTemplatePaths));
    }
}