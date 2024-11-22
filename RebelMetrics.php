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

use Piwik\Common;
use Piwik\Db;
use Exception;

class RebelMetrics extends \Piwik\Plugin
{
    public const PLUGIN_NAME = "RebelMetrics";
    public static $statusTable = 'rebelmetrics_status';

    /**
     * Runs when the RebelMetrics is installed, adds table.
     */
    public function install()
    {
        try {
            $sql = "CREATE TABLE " . Common::prefixTable(self::$statusTable) . " (
                        id INT NOT NULL AUTO_INCREMENT
                        , date datetime NOT NULL
                        , status TINYINT(1) NOT NULL
                        , size VARCHAR(256) NOT NULL
                        , done datetime
                        , PRIMARY KEY (id)
                    ) DEFAULT CHARSET=utf8mb4";
            // phpcs:disable
            Db::exec($sql);
            // phpcs:enable
        } catch (Exception $e) {
            // ignore error if table already exists (1050 code is for 'table already exists')
            if (!Db::get()->isErrNo($e, '1050')) {
                throw $e;
            }
        }
    }

    /**
     * Runs when the RebelMetrics is uninstalled, removing the table.
     */
    public function uninstall()
    {
        Db::dropTables(Common::prefixTable(self::$statusTable));
    }
}
