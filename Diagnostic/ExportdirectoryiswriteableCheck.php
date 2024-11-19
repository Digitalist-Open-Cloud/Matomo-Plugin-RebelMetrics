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

class ExportdirectoryiswriteableCheck implements Diagnostic
{
    public function execute()
    {
        $result = [];

        $label = 'Export directory is writeable';
        $status = DiagnosticResult::STATUS_OK; // can be ok, error, warning or informational
        $comment = 'A comment for this check';
        $result[] = DiagnosticResult::singleResult($label, $status, $comment);

        $label = 'Example Information';
        $comment = 'The PHP version is ' . PHP_VERSION;
        $result[] = DiagnosticResult::informationalResult($label, $status, $comment);

        return $result;
    }
}
