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

use Piwik\Settings\Setting;
use Piwik\Settings\FieldConfig;
use Piwik\Validators\NotEmpty;
use Piwik\Settings\Plugin\SystemSettings as MatomoSettings;

/**
 * Defines settings for RebelMetrics.
 */
class SystemSettings extends MatomoSettings
{
    /** @var Setting */
    public $exportDir;

    /** @var Setting */
    public $storage;

    /** @var Setting */
    public $storageKey;

    /** @var Setting */
    public $storageSecret;

    /** @var Setting */
    public $project;

    protected function init()
    {
        $this->project = $this->createStorageProject();
        $this->storage = $this->createStorageSetting();
        $this->storageKey = $this->createStorageKeySetting();
        $this->storageSecret = $this->createStorageSecretSetting();
        $this->exportDir = $this->createExportDirSetting();
    }


    private function createStorageProject()
    {
        return $this->makeSetting('project', null, FieldConfig::TYPE_STRING, function (FieldConfig $field) {
            $field->title = 'Project name';
            $field->uiControl = FieldConfig::UI_CONTROL_TEXT;
            $field->description = 'This information you should have gotten when subscribing to the service.';
            $field->validators[] = new NotEmpty();
        });
    }
    private function createStorageSetting()
    {
        $default = "https://nbg1.your-objectstorage.com";

        return $this->makeSetting('storage', $default, FieldConfig::TYPE_STRING, function (FieldConfig $field) {
            $field->title = 'Storage for your RebelMetrics.';
            $field->uiControl = FieldConfig::UI_CONTROL_TEXT;
            $field->description = 'This information you should have gotten when subscribing to the service.';
            $field->validators[] = new NotEmpty();
        });
    }

    private function createExportDirSetting()
    {
        $default = "/tmp";

        return $this->makeSetting('exportDir', $default, FieldConfig::TYPE_STRING, function (FieldConfig $field) {
            $field->title = 'Export directory path.';
            $field->uiControl = FieldConfig::UI_CONTROL_TEXT;
            $field->description = 'Path for exports from Matomo. This needs to be writeable by Matomo.';
            $field->validators[] = new NotEmpty();
        });
    }

    private function createStorageKeySetting()
    {
        return $this->makeSetting('storageKey', $default = null, FieldConfig::TYPE_STRING, function (FieldConfig $field) {
            $field->title = 'Storage key for RebelMetrics';
            $field->uiControl = FieldConfig::UI_CONTROL_TEXT;
            $field->description = 'This needs the Storage key you would have gotten when subscribing to RebelMetrics';
        });
    }
    private function createStorageSecretSetting()
    {
        return $this->makeSetting('storageSecret', $default = null, FieldConfig::TYPE_STRING, function (FieldConfig $field) {
            $field->title = 'Storage secret for RebelMetrics';
            $field->uiControl = FieldConfig::UI_CONTROL_PASSWORD;
            $field->description = 'This needs the storage secret you would have gotten when subscribing to RebelMetrics';
        });
    }
}
