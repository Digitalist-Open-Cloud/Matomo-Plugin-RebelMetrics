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
        $this->daily('export', null, self::HIGH_PRIORITY);
        $this->daily('cleanup', null, self::LOWEST_PRIORITY);
    }

    public function export()
    {
        $this->logger->info('Starting RebelMetrics export');
        try {
            // do something
            $this->logger->info('RebelMetrics export done');
        } catch (Exception $e) {
            throw new RetryableException($e->getMessage());
        }
    }

    public function cleanup()
    {
        $this->logger->info('Starting RebelMetrics cleanup');
        try {
            // do something
            $this->logger->info('Cleanup of RebelMetrics done');
        } catch (Exception $e) {
            throw new RetryableException($e->getMessage());
        }
    }
}
