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

require_once(PIWIK_INCLUDE_PATH . '/plugins/RebelMetrics/vendor/autoload.php');
use Aws\S3\S3Client;
use Piwik\Plugins\RebelMetrics\GetQuery;
use Piwik\Db;


class Exporter
{
    /**
     * @var SystemSettings
     */
    private $settings;

    public function __construct($settings)
    {
        $this->settings = $settings;
    }
    public function doExport($day = null)
    {
        $settings = new SystemSettings();
        $exportDir = $this->settings->exportDir->getValue();
        $queryProcessor = new GetQuery($settings);

        try {
            $query = $queryProcessor->fetchAndProcessQuery('QUERY', $exportDir);
        } catch (\Exception $e) {
            echo "An error occurred: " . $e->getMessage();
        }
        if ($day === null) {
            $day = date('Y-m-d', strtotime('yesterday'));
        }

        try {
            $results = Db::fetchAll($query, [$day]);
        } catch (\Exception $e) {

            echo "An error occurred: " . $e->getMessage();
        }

        $filePath = "$exportDir/$day.csv";
        $file = fopen($filePath, 'w');

        if ($file === false) {
            die('Error opening the file for writing.');
        }

        try {
            // If $results is not empty, write the headers
            if (!empty($results)) {
                // Write the header row (column names) to the CSV file
                fputcsv($file, array_keys($results[0]));

                // Write each row of data
                foreach ($results as $row) {
                    fputcsv($file, $row);
                }
            }
        } catch (\Exception $e) {
            echo "An error occurred while writing to the file: " . $e->getMessage();
        } finally {
            // Close the file after writing
            fclose($file);
        }

        $gzip = file_get_contents("$filePath");
        $gzData = gzencode($gzip, 9);
        file_put_contents("$filePath.gz", $gzData);
        unlink("$filePath");

        $storage = $this->settings->storage->getValue();
        $key = $this->settings->storageKey->getValue();
        $secret = $this->settings->storageSecret->getValue();
        $bucket = $this->settings->project->getValue();
        $region = 'us-east-1';
        $client = new S3Client([
          'version' => 'latest',
          'region' => $region,
          'endpoint' => $storage,
          'credentials' => [
            'key'    => $key,
            'secret' => $secret,
          ],
        ]);
        $upload = $client->putObject([
          'Bucket' => $bucket,
          'Key'    => "$day.csv.gz",
          'SourceFile' => "$filePath.gz",
        ]);
        unlink("$filePath.gz");
    }
}
