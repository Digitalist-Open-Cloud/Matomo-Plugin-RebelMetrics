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

namespace Piwik\Plugins\RebelMetrics\Diagnostic;

use Piwik\Plugins\Diagnostics\Diagnostic\Diagnostic;
use Piwik\Plugins\Diagnostics\Diagnostic\DiagnosticResult;
use Piwik\Plugins\RebelMetrics\Rebel;
use Piwik\Plugins\RebelMetrics\SystemSettings;
use Piwik\Translation\Translator;

class StorageValid implements Diagnostic
{
   /**
     * @var Translator
     */
    private $translator;

    public function __construct(Translator $translator)
    {
        $this->translator = $translator;
    }
    public function execute()
    {
        $result = [];
        $settings = new SystemSettings();
        $label = $this->translator->translate('RebelMetrics_DiagnosticPrefix') .
          $this->translator->translate('RebelMetrics_StorageIsValid');
        $check = new Rebel($settings);
        $file = $check->isStorageValid();
        if ($file) {
            $status = DiagnosticResult::STATUS_OK;
            $comment = 'Can connect and upload file.';
        } else {
            $status = DiagnosticResult::STATUS_ERROR;
            $comment = 'Can not connect and upload file.';
        }

        $result[] = DiagnosticResult::singleResult($label, $status, $comment);

        return $result;
    }
}
