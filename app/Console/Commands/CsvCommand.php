<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CsvCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'csv:get';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            // declaration
            $folderDownloaded = storage_path('blibli');
            $folderCsv = storage_path('blibli-csv');
            $name = 'feed';
            $data = [];
            $zipPassword = '';

            // download all zip
            $baseUrl = 'https://icubic.xyz/ic-download/blibli';
            $numDownload = 1;
            \File::makeDirectory($folderDownloaded, $mode = 0755, true, true);
            while (get_headers($baseUrl.'/'.$name.'-'.$numDownload.'.zip')[0] == 'HTTP/1.1 200 OK') {
                $filename = $name.'-'.$numDownload.'.zip';
                $file = $folderDownloaded.'/'.$filename;
                copy($baseUrl.'/'.$filename, $file);
                $numDownload++;
            }

            // extract all zip
            $allZip = \File::files($folderDownloaded);
            foreach ($allZip as $zip) {
                $zipInfo = pathinfo($zip);
                if (isset($zipInfo['extension']) && $zipInfo['extension'] == 'zip') {
                    $fileZip = $folderDownloaded.'/'.$zipInfo['basename'];
                    $extractTo = $this->extractZip($fileZip, $folderCsv, $zipPassword);
                }
            }

            // maping csv
            $allCsv = \File::files($folderCsv);
            foreach ($allCsv as $csv) {
                $csvInfo = pathinfo($csv);
                if (isset($csvInfo['extension']) && $csvInfo['extension'] == 'csv') {
                    $fileCsv = $folderCsv.'/'.$csvInfo['basename'];
                    $data = array_merge($data, $this->readCsv($fileCsv));
                }
            }

            dd($data);
        } catch (\Exception $e) {
            $this->info($e->getMessage());
        }
    }

    public function extractZip($zipLocation, $destination, $password = null){
        $zip = new \ZipArchive();
        if ($zip->open($zipLocation) === TRUE) {
            if ($password) {
                $zip->setPassword($password);
            }
            $zip->extractTo($destination);
            $zip->close();
            return true;
        } else {
            return false;
        }
    }

    public function readCsv($csv){
        $data = [];
        $handle = fopen($csv, 'r');
        $header = fgetcsv($handle);
        while (($line = fgetcsv($handle)) !== false) {
            $data[] = array_combine($header, $line);
        }
        fclose($handle);
        return $data;
    }
}
