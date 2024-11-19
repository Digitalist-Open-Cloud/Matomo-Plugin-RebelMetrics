<?php

/**
 * The RebelMetrics plugin for Matomo.
 *
 * Copyright (C) 2024 Digitalist Open Cloud <cloud@digitalist.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

namespace Piwik\Plugins\RebelMetrics;

use Piwik\Plugins\RebelMetrics\Checks;

/**
 * A controller lets you for example create a page that can be added to a menu. For more information read our guide
 * http://developer.piwik.org/guides/mvc-in-piwik or have a look at the our API references for controller and view:
 * http://developer.piwik.org/api-reference/Piwik/Plugin/Controller and
 * http://developer.piwik.org/api-reference/Piwik/View
 */
class Controller extends \Piwik\Plugin\Controller
{
    public function index()
    {
        $check = new Checks();
        $exportWrite = $check->isExportWriteable();
        if ($exportWrite) {
            $exportWrite = 'Yes';
        } else {
            $exportWrite = 'No';
        }
        return $this->renderTemplate('index', [
            'exportWrite' => $exportWrite
        ]);
    }
}
