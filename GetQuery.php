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

use Aws\S3\S3Client;
use Piwik\Config;

class GetQuery
{
    private $settings;
    private $region;

    public function __construct($settings, $region = 'us-east-1')
    {
        $this->settings = $settings;
        $this->region = $region;
    }

    public function fetchAndProcessQuery($objectKey, $exportDir)
    {
        $storage = $this->settings->storage->getValue();
        $key = $this->settings->storageKey->getValue();
        $secret = $this->settings->storageSecret->getValue();
        $bucket = $this->settings->project->getValue();
        $localFile = "$exportDir/QUERY";

        $client = new S3Client([
            'version' => 'latest',
            'region' => $this->region,
            'endpoint' => $storage,
            'credentials' => [
                'key'    => $key,
                'secret' => $secret,
            ],
        ]);

        $client->getObject([
            'Bucket' => $bucket,
            'Key'    => $objectKey,
            'SaveAs' => $localFile,
        ]);

        $query = file_get_contents($localFile);
        $cleaned = base64_decode($query);

        $prefix = Config::getInstance()->database['tables_prefix'];
        $cleanedQuery = str_replace('{prefix}', $prefix, $cleaned);
        // debug
        //$this->saveToFile($exportDir, 'Q', $cleaned);
        $this->removeFile($exportDir, 'QUERY');
        return $cleanedQuery;
    }

    private function saveToFile($directory, $filename, $content)
    {
        $filePath = rtrim($directory, '/') . '/' . $filename;
        $file = fopen($filePath, "w");

        if ($file === false) {
            throw new \RuntimeException("Unable to open file: $filePath");
        }

        fwrite($file, $content);
        fclose($file);
    }

    private function removeFile($directory, $filename)
    {
        $filePath = rtrim($directory, '/') . '/' . $filename;
        unlink($filePath);
    }
}
