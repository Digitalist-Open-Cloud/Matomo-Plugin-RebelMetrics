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

use Piwik\Archive;
use Piwik\DataTable;
use Piwik\Piwik;
use Piwik\Plugins\RebelMetrics\RecordBuilders\ExampleMetric;
use Piwik\Plugins\RebelMetrics\RecordBuilders\ExampleMetric2;
use Piwik\Segment;

/**
 * API for plugin RebelMetrics
 *
 * @method static \Piwik\Plugins\RebelMetrics\API getInstance()
 */
class API extends \Piwik\Plugin\API
{
    /**
     * Example method. Please remove if you do not need this API method.
     * You can call this API method like this:
     * /index.php?module=API&method=RebelMetrics.getAnswerToLife
     * /index.php?module=API&method=RebelMetrics.getAnswerToLife&truth=0
     *
     * @param  bool $truth
     *
     * @return int
     */
    public function getAnswerToLife(bool $truth = true): int
    {
        if ($truth) {
            return 42;
        }

        return 24;
    }

    /**
     * Another example method that returns a data table.
     * @param string $idSite  (might be a number, or the string all)
     * @param string $period
     * @param string $date
     * @param null|string $segment
     * @return DataTable
     */
    public function getExampleReport(string $idSite, string $period, string $date, ?string $segment = null): DataTable
    {
        Piwik::checkUserHasViewAccess($idSite);

        $table = DataTable::makeFromSimpleArray(array(
            array('label' => 'My Label 1', 'nb_visits' => '1'),
            array('label' => 'My Label 2', 'nb_visits' => '5'),
        ));

        return $table;
    }

    /**
     * Returns the example metric we archive in Archiver.php.
     * @param string $idSite (might be a number, or the string all)
     * @param string $period
     * @param string $date
     * @param null|string $segment
     * @return DataTable\DataTableInterface
     */
    public function getExampleArchivedMetric(string $idSite, string $period, string $date, ?string $segment = null): DataTable\DataTableInterface
    {
        Piwik::checkUserHasViewAccess($idSite);

        $archive = Archive::build($idSite, $period, $date, $segment);
        return $archive->getDataTableFromNumeric([ExampleMetric::EXAMPLEPLUGIN_METRIC_NAME, ExampleMetric2::EXAMPLEPLUGIN_CONST_METRIC_NAME]);
    }

    public function getSegmentHash(string $idSite, string $segment)
    {
        Piwik::checkUserHasViewAccess($idSite);

        $segment = new Segment($segment, [$idSite]);
        return $segment->getHash();
    }
}
