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
use Piwik\Version;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use Piwik\Plugins\TestRunner\Commands\CheckDirectDependencyUse;

/**
 * @group RebelMetrics
 * @group RebelMetricsDirectDependencyUse
 * @group Plugins
 */
class CheckDirectDependencyUseTest extends SystemTestCase
{
    public function testDirectDependencies()
    {
        if (
            version_compare(
                Version::VERSION,
                '5.0.3',
                '<='
            )
                && !file_exists(PIWIK_INCLUDE_PATH . '/plugins/TestRunner/Commands/CheckDirectDependencyUse.php')
        ) {
            $this->markTestSkipped('tests:check-direct-dependency-use is not available in this version');
        }
        $pluginName = 'RebelMetrics';
        $checkDirectDependencyUse = new CheckDirectDependencyUse();

        $console = new \Piwik\Console(self::$fixture->piwikEnvironment);
        $console->addCommands([$checkDirectDependencyUse]);
        $command = $console->find('tests:check-direct-dependency-use');
        $arguments = [
            'command'    => 'tests:check-direct-dependency-use',
            '--plugin' => $pluginName,
            '--grep-vendor',
        ];

        $inputObject = new ArrayInput($arguments);
        $command->run($inputObject, new NullOutput());

        $this->assertEquals([
            'Symfony\Component\Console' => [
                'RebelMetrics/tests/System/CheckDirectDependencyUseTest.php'
            ],
        ], $checkDirectDependencyUse->usesFoundList[$pluginName]);
    }
}
