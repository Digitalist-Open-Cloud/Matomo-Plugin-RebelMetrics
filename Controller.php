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

use Piwik\Plugins\RebelMetrics\Rebel;
use Piwik\Plugins\RebelMetrics\SystemSettings;

class Controller extends \Piwik\Plugin\Controller
{
    public function index()
    {
        $settings = new SystemSettings();
        $check = new Rebel($settings);
        $checks = [
            'exportWrite' => $this->getStatusIcon($check->isExportWriteable()),
            'gzipExists' => $this->getStatusIcon($check->isGzipAvailable()),
            's3LibExists' => $this->getStatusIcon($check->isS3ClassAvailable()),
            'storageValid' => $this->getStatusIcon($check->isStorageValid()),
            'isGzipable' => $this->getStatusIcon($check->isGzipable()),
            'isQueryPresent' => $this->getStatusIcon($check->isQueryPresent()),
        ];

        return $this->renderTemplate('index', $checks);
    }

    private function getStatusIcon($condition)
    {
        return $condition ? '<span class="icon-ok" title="Test passed"></span>' : '<span class="icon-error" title="Test failed"></span>';
    }
}
