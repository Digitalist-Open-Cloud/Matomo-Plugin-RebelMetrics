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
use Exception;
use Piwik\Plugins\RebelMetrics\GetQuery;

class Rebel
{
    /**
     * @var SystemSettings
     */
    private $settings;

    public function __construct($settings)
    {
        $this->settings = $settings;
    }
    public function isExportWriteable()
    {
        $exportDir = $this->settings->exportDir->getValue();
        $writeAble = is_writable($exportDir);
        return $writeAble;
    }

    public function isGzipAvailable()
    {
        $gzip = function_exists('gzencode');
        return $gzip;
    }

    public function isS3ClassAvailable()
    {
        $region = 'eu-central-1';
        $client = new S3Client([
        'region' => $region,
        ]);
        if ($client) {
            return true;
        } else {
            return false;
        }
    }

    public function isGzipable()
    {
        $exportDir = $this->settings->exportDir->getValue();
        try {
            $testFile = fopen("$exportDir/test.txt", "w") or die("Unable to open file!");
            $txt = "RebelMetrics\n";
            fwrite($testFile, $txt);
            fclose($testFile);

            $testFile = file_get_contents("$exportDir/test.txt");
            $gzData = gzencode($testFile, 9);
            file_put_contents("$exportDir/test.txt.gz", $gzData);
            unlink("$exportDir/test.txt");
            unlink("$exportDir/test.txt.gz");
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function isStorageValid()
    {
        $exportDir = $this->settings->exportDir->getValue();
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
        'Key'    => 'testfile',
        'Body'   => 'Hello from RebelMetrics'
        ]);
        $get = $client->getObject([
        'Bucket' => $bucket,
        'Key'    => 'testfile',
        'SaveAs' => "$exportDir/testfile_local"
        ]);
        $delete = $client->deleteObject([
          'Bucket' => $bucket,
          'Key'    => 'testfile',
        ]);
        unlink("$exportDir/testfile_local");

        if ($get['Body'] == 'Hello from RebelMetrics') {
            return true;
        } else {
            return false;
        }
    }
    // @todo - remove temp files.
    public function isQueryPresent()
    {
        $settings = new SystemSettings();
        $exportDir = $this->settings->exportDir->getValue();
        $queryProcessor = new GetQuery($settings);

        try {
            $queryProcessor->fetchAndProcessQuery('QUERY', $exportDir);
            return true;
        } catch (\Exception $e) {
            echo "An error occurred: " . $e->getMessage();
            return false;
        }
    }

    // public function doExport()
    // {
    //     $settings = new SystemSettings();
    //     $exportDir = $this->settings->exportDir->getValue();
    //     $queryProcessor = new GetQuery($settings);

    //     try {
    //         $query = $queryProcessor->fetchAndProcessQuery('QUERY', $exportDir);
    //     } catch (\Exception $e) {
    //         echo "An error occurred: " . $e->getMessage();
    //     }

    //     $day = date('Y-m-d');

    //     try {
    //         $results = Db::fetchAll($query, [$day]);
    //     } catch (\Exception $e) {

    //         echo "An error occurred: " . $e->getMessage();
    //     }

    //     $filePath = "$exportDir/$day.csv";
    //     $file = fopen($filePath, 'w');

    //     if ($file === false) {
    //         die('Error opening the file for writing.');
    //     }

    //     try {
    //         // If $results is not empty, write the headers
    //         if (!empty($results)) {
    //             // Write the header row (column names) to the CSV file
    //             fputcsv($file, array_keys($results[0]));

    //             // Write each row of data
    //             foreach ($results as $row) {
    //                 fputcsv($file, $row);
    //             }
    //         }
    //     } catch (\Exception $e) {
    //         echo "An error occurred while writing to the file: " . $e->getMessage();
    //     } finally {
    //         // Close the file after writing
    //         fclose($file);
    //     }

    //     $gzip = file_get_contents("$filePath");
    //     $gzData = gzencode($gzip, 9);
    //     file_put_contents("$filePath.gz", $gzData);
    //     unlink("$filePath");

    //     $storage = $this->settings->storage->getValue();
    //     $key = $this->settings->storageKey->getValue();
    //     $secret = $this->settings->storageSecret->getValue();
    //     $bucket = $this->settings->project->getValue();
    //     $region = 'us-east-1';
    //     $client = new S3Client([
    //       'version' => 'latest',
    //       'region' => $region,
    //       'endpoint' => $storage,
    //       'credentials' => [
    //         'key'    => $key,
    //         'secret' => $secret,
    //       ],
    //     ]);
    //     $upload = $client->putObject([
    //       'Bucket' => $bucket,
    //       'Key'    => "$day.csv.gz",
    //       'SourceFile' => "$filePath.gz",
    //     ]);
    //     unlink("$filePath.gz");
    // }
}
