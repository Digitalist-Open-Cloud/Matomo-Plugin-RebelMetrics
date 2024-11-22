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

use Piwik\Piwik;
use Piwik\Settings\Setting;
use Piwik\Settings\FieldConfig;
use Piwik\Settings\Plugin\SystemSettings as MatomoSettings;
use DateTime;
use Exception;

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

    /** @var Setting */
    public $exportHistoricalData;

    /** @var Setting */
    public $historicalDataDate;

    protected function init()
    {
        $this->project = $this->storageProject();
        $this->storage = $this->storageSetting();
        $this->storageKey = $this->storageKeySetting();
        $this->storageSecret = $this->storageSecretSetting();
        $this->exportDir = $this->exportDirSetting();
        $this->exportHistoricalData = $this->exportHistoricalData();
        $this->historicalDataDate = $this->historicalDataDate();
    }

    private function exportHistoricalData()
    {
        return $this->makeSetting(
            'exportHistoricalData',
            $default = false,
            FieldConfig::TYPE_BOOL,
            function (FieldConfig $field) {
                $field->title = Piwik::translate('RebelMetrics_ExportHistoricalData');
                $field->uiControl = FieldConfig::UI_CONTROL_CHECKBOX;
                $field->description = Piwik::translate('RebelMetrics_ExportHistoricalDataDescription');
            }
        );
    }
    private function historicalDataDate()
    {
        return $this->makeSetting('historicalDataDate', null, FieldConfig::TYPE_STRING, function (FieldConfig $field) {
            $field->title = Piwik::translate('RebelMetrics_ExportFrom');
            $field->uiControl = FieldConfig::UI_CONTROL_TEXT;
            $field->description = Piwik::translate('RebelMetrics_ExportFromDescription');
            $field->condition = 'exportHistoricalData';
            $field->validate = function ($value, $setting) {
                if (!empty($value) && !$this->isValidDate($value)) {
                    throw new Exception(Piwik::translate('RebelMetrics_ExportFromValidate'));
                }
            };
        });
    }

    private function storageProject()
    {
        return $this->makeSetting('project', null, FieldConfig::TYPE_STRING, function (FieldConfig $field) {
            $field->title = Piwik::translate('RebelMetrics_ProjectName');
            $field->uiControl = FieldConfig::UI_CONTROL_TEXT;
            $field->description = Piwik::translate('RebelMetrics_ProjectNameDescription');
        });
    }
    private function storageSetting()
    {
        return $this->makeSetting('storage', null, FieldConfig::TYPE_STRING, function (FieldConfig $field) {
            $field->title = Piwik::translate('RebelMetrics_Storage');
            $field->uiControl = FieldConfig::UI_CONTROL_TEXT;
            $field->description = Piwik::translate('RebelMetrics_StorageDescription');
        });
    }

    private function exportDirSetting()
    {
        $default = "/tmp";
        return $this->makeSetting('exportDir', $default, FieldConfig::TYPE_STRING, function (FieldConfig $field) {
            $field->title = Piwik::translate('RebelMetrics_ExportDirectory');
            $field->uiControl = FieldConfig::UI_CONTROL_TEXT;
            $field->description = Piwik::translate('RebelMetrics_ExportDirectoryDescription');
        });
    }

    private function storageKeySetting()
    {
        return $this->makeSetting(
            'storageKey',
            $default = null,
            FieldConfig::TYPE_STRING,
            function (FieldConfig $field) {
                $field->title = Piwik::translate('RebelMetrics_Key');
                $field->uiControl = FieldConfig::UI_CONTROL_TEXT;
                $field->description = Piwik::translate('RebelMetrics_KeyDescription');
            }
        );
    }
    private function storageSecretSetting()
    {
        return $this->makeSetting(
            'storageSecret',
            $default = null,
            FieldConfig::TYPE_STRING,
            function (FieldConfig $field) {
                $field->title = Piwik::translate('RebelMetrics_Secret');
                $field->uiControl = FieldConfig::UI_CONTROL_PASSWORD;
                $field->description = Piwik::translate('RebelMetrics_SecretDescription');
            }
        );
    }

    private function isValidDate($date)
    {
        $d = DateTime::createFromFormat('Y-m-d', $date);
        return $d && $d->format('Y-m-d') === $date;
    }
}
