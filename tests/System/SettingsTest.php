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
use Piwik\Plugins\RebelMetrics\SystemSettings;
use Piwik\Tests\Fixtures\OneVisitorTwoVisits;
use Piwik\Container\StaticContainer;

/**
 * @group RebelMetrics
 * @group RebelMetricsSystemSettings
 * @group Plugins
 */
class SettingsTest extends SystemTestCase
{
    public static $fixture = null;
    /**
     * @var SystemSettings
     */
    private $settings;

    protected function setUp(): void
    {
        parent::setUp();
        $systemSettings = $this->makePluginSettings();
        $systemSettings->project->setValue('rebelFoo');
        $systemSettings->storage->setValue('https://bar.foo');
        $systemSettings->exportHistoricalData->setValue('1');
        $systemSettings->historicalDataDate->setValue('2024-12-01');
        $systemSettings->storageKey->setValue('D204FE21-A74B-4406-A26F-2CE050674E19');
        $systemSettings->storageSecret->setValue('E595DDAE-F8FE-4D3B-8A1C-A9A3B3FFA3DD');




        $systemSettings->save();
        $this->settings = new SystemSettings();
    }
    public function testProjectSetting()
    {
        $this->assertSame('rebelFoo', $this->settings->project->getValue());
        $this->assertSame('https://bar.foo', $this->settings->storage->getValue());
        $this->assertSame(true, $this->settings->exportHistoricalData->getValue());
        $this->assertSame('2024-12-01', $this->settings->historicalDataDate->getValue());
        $this->assertSame('/tmp', $this->settings->exportDir->getValue());
        $this->assertSame('D204FE21-A74B-4406-A26F-2CE050674E19', $this->settings->storageKey->getValue());
        $this->assertSame('E595DDAE-F8FE-4D3B-8A1C-A9A3B3FFA3DD', $this->settings->storageSecret->getValue());
    }

    private function makePluginSettings()
    {
        $settings = new SystemSettings();

        StaticContainer::getContainer()->set('Piwik\Plugins\RebelMetrics\SystemSettings', $settings);
        return $settings;
    }
}
SettingsTest::$fixture = new OneVisitorTwoVisits();
