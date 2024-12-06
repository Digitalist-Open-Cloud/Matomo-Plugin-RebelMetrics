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

namespace Piwik\Plugins\RebelMetrics\tests\System;

use Piwik\Tests\Framework\TestCase\SystemTestCase;
use Piwik\Piwik;
use Piwik\Plugins\RebelMetrics\Controller;
use Piwik\Plugins\RebelMetrics\Rebel;
use Piwik\Plugins\RebelMetrics\SystemSettings;
use Piwik\Tests\Fixtures\SomePageGoalVisitsWithConversions;

class ControllerTest extends SystemTestCase
{
    /**
     * @var SomePageGoalVisitsWithConversions
     */
    private $controller;
    public static $fixture;


    public function setUp(): void
    {
        parent::setUp();
        ControllerTest::$fixture = new SomePageGoalVisitsWithConversions();
        $this->controller = new Controller();
    }

    public function testIndexRendersCorrectTemplate()
    {
        // Mock the SystemSettings and Rebel class
        $mockSettings = $this->createMock(SystemSettings::class);
        $mockRebel = $this->createMock(Rebel::class);

        // Mock Rebel methods
        $mockRebel->method('isExportWriteable')->willReturn(true);
        $mockRebel->method('isGzipAvailable')->willReturn(false);
        $mockRebel->method('isS3ClassAvailable')->willReturn(true);
        $mockRebel->method('isStorageValid')->willReturn(false);
        $mockRebel->method('isGzipable')->willReturn(true);
        $mockRebel->method('isQueryPresent')->willReturn(false);
        $mockRebel->method('isPluginsPresent')->willReturn(true);
        $mockRebel->method('isSetup')->willReturn(false);

        // Mock index() method behavior
        $checks = [
            'exportWrite' => $this->controller->index(),
            'gzipExists' => $this->controller->testIndexRendersCorrectTemplate()
        ];
    }
}