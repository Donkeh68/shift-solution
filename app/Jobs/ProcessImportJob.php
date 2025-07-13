<?php

namespace App\Jobs;

use App\Jobs\ShiftsImport\ProcessShiftImportJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Log;

class ProcessImportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    // Set timeout (1200 = 20 minutes, 60000 = 1000 min or 16.67 hours)
    public $timeout = 60000;

    /**
     * Create a new job instance.
     */
    public function __construct(private string $filePath)
    {
        // 
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        // Map the data fields
        $mapping = [
            'date' => 0, 'employee' => 1, 'employer' => 2, 
            'hours' => 3, 'rate_per_hour' => 4, 'taxable' => 5, 
            'status' => 6, 'shift_type' => 7, 'paid_at' => 8, 
        ];

        // Log the start
        $timestamp = date('Y-m-d H:i:s', time());
        Log::channel('csvimport')->info("CSV upload commenced: {$timestamp}");

        // Open the filestream
        $fileStream = fopen($this->filePath, 'r');

        // Dispatch the rows to the job queue, ignoring the top line
        $skipHeader = true;
        while ($row = fgetcsv($fileStream)) {
            if ($skipHeader) {
                $skipHeader = false;
                continue;
            }
            dispatch(new ProcessShiftImportJob($row, $mapping));
        }

        // Close the filestream
        fclose($fileStream);

        // Delete the file
        unlink($this->filePath);

        // Log the end
        $timestamp = date('Y-m-d H:i:s', time());
        Log::channel('csvimport')->info("CSV upload completed: {$timestamp}");
        Log::channel('csvimport')->info("Now waiting on the jobs to finish processing the queue...");
    }
}
