<?php

namespace App\Jobs\ShiftsImport;

use App\Models\Shifts;
use Carbon\Carbon;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Validation\ValidationException;
use Log;

class ProcessShiftImportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private array $rowData, private array $mapping)
    {
        //
    }

    private function SanitiseInput($value) {
        return trim(htmlspecialchars($value));
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        try {
            // Sanitise each and throw errors if they fail validation
            $date = $this->SanitiseInput(Carbon::createFromFormat('d m Y', $this->rowData[$this->mapping['date']])->format('Y-m-d'));
            $employee = $this->SanitiseInput($this->rowData[$this->mapping['employee']]);
            if ($employee == "") {
                $error = ValidationException::withMessages([
                   'employee' => ['Employee may not be blank'],
                ]);
                throw $error;
            }
            $employer = $this->SanitiseInput($this->rowData[$this->mapping['employer']]);
            if ($employer == "") {
                $error = ValidationException::withMessages([
                   'employer' => ['Employer may not be blank'],
                ]);
                throw $error;
            }
            $hours = $this->SanitiseInput(preg_replace("/[^0-9]/", "", $this->rowData[$this->mapping['hours']]));
            if ($hours == "") {
                $error = ValidationException::withMessages([
                   'hours' => ['Hours must be an integer value greater than 0'],
                ]);
                throw $error;
            }
            $rateperhour = $this->SanitiseInput(preg_replace("/[^0-9.]/", "", $this->rowData[$this->mapping['rate_per_hour']]));
            if ($rateperhour == "") {
                $error = ValidationException::withMessages([
                   'rate_per_hour' => ['Rate per Hour must be a numeric value greater than 0.00'],
                ]);
                throw $error;
            }
            $taxable = $this->SanitiseInput($this->rowData[$this->mapping['taxable']]);
            if ($taxable != "Yes" && $taxable != "No") {
                $error = ValidationException::withMessages([
                   'taxable' => ['Taxable must be either Yes or No'],
                ]);
                throw $error;
            }
            $status = $this->SanitiseInput($this->rowData[$this->mapping['status']]);
            if ($status != "Complete" && $status != "Failed" && $status != "Pending" && $status != "Processing") {
                $error = ValidationException::withMessages([
                   'status' => ['Status must be either Complete, Failed, Pending or Processing'],
                ]);
                throw $error;
            }
            $shifttype = $this->SanitiseInput($this->rowData[$this->mapping['shift_type']]);
            if ($shifttype != "Day" && $shifttype != "Holiday" && $shifttype != "Night") {
                $error = ValidationException::withMessages([
                   'shift_type' => ['Shift Type must be either Day, Holiday or Night'],
                ]);
                throw $error;
            }
            $paidat = $this->SanitiseInput($this->rowData[$this->mapping['paid_at']]) == "" ? null : $this->SanitiseInput(Carbon::createFromFormat("Y-m-d H:i:s", $this->rowData[$this->mapping['paid_at']])->format("Y-m-d H:i:s"));

            Shifts::create(
                [
                    'date' => $date,
                    'employee' => $employee,
                    'employer' => $employer,
                    'hours' => $hours,
                    'rate_per_hour' => $rateperhour,
                    'taxable' => $taxable,
                    'status' => $status,
                    'shift_type' => $shifttype,
                    'paid_at' => $paidat,
                ]
            );
        } catch (\Exception $e) {
            Log::channel('csvimport')->error($e->getMessage());
            Log::channel('csvimport')->info(json_encode($this->rowData));
        }
    }
}
