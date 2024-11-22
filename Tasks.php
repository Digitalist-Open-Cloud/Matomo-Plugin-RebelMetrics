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

use Piwik\Plugin\Tasks as Task;
use Psr\Log\LoggerInterface;
use Piwik\Container\StaticContainer;
use Exception;
use Piwik\Scheduler\RetryableException;
use Piwik\Plugins\RebelMetrics\Exporter;
use Piwik\Plugins\RebelMetrics\Rebel;
use Piwik\Plugins\RebelMetrics\SystemSettings;

class Tasks extends Task
{
    /** @var Setting */
    private $settings;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    public function __construct(LoggerInterface $logger = null)
    {
        $this->logger = $logger ?: StaticContainer::get(LoggerInterface::class);
        $this->settings = new SystemSettings();
    }

    public function schedule()
    {

            $this->daily('rebelExports', null, self::HIGH_PRIORITY);
            $this->daily('rebelCleanup', null, self::LOWEST_PRIORITY);
    }

    public function rebelExports()
    {

        $settings = new SystemSettings();
        $check = new Rebel($settings);
        if (
            $check->isExportWriteable() &&
            $check->isGzipAvailable() &&
            $check->isS3ClassAvailable() &&
            $check->isStorageValid() &&
            $check->isGzipable() &&
            $check->isQueryPresent() &&
            $check->isPluginsPresent()
        ) {
            $this->logger->info('Starting RebelMetrics export');
            $settings = new SystemSettings();
            try {
                $exporter = new Exporter($settings);
                $exporter->doExport();
                $this->logger->info('RebelMetrics export done');
            } catch (Exception $e) {
                $this->logger->error($e->getMessage());
            }
        } else {
            $this->logger->error('Checks did not pass');
        }
    }

    public function rebelCleanup()
    {
        $this->logger->info('Starting RebelMetrics cleanup');
        try {
            $this->logger->info('Cleanup of RebelMetrics done');
        } catch (Exception $e) {
            throw new RetryableException($e->getMessage());
        }
    }
}
