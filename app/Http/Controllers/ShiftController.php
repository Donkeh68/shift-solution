<?php

namespace App\Http\Controllers;

use App\Models\Shifts;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShiftController extends Controller
{
    // List all shifts
    public function index(Request $request): View
    {
        // Init and sanitise input
        $start = "0";
        if (isset($_GET["start"])) $start = preg_replace("/[^0-9]/", "", $_GET["start"]);
        $filter = trim(htmlspecialchars($request->input("filter")));

        // Validate
        if (!is_numeric($filter)) $filter = "0";

        // Count records
        $shifts = Shifts::whereRaw("rate_per_hour * hours > {$filter}")
        ->orderBy('id', 'asc')
        ->get();
        $count = count($shifts);

        // Get paginated data
        $shifts = Shifts::whereRaw("rate_per_hour * hours > {$filter}")
        ->orderBy('id', 'asc')
        ->offset($start)
        ->limit(15)
        ->get();

        // Determine paginations
        $pagination = CalculatePagination($count, $start);

        // Display view
        return view('shifts.index')
        ->with("filter", $filter)
        ->with("count", $count)
        ->with("start", $start)
        ->with("shifts", $shifts)
        ->with("pagination", $pagination);
    }

    // Show the create shift details
    public function indexCreate(): View
    {
        // Display view
        return view('shifts.create');
    }

    // Create the new shift
    public function createShift(Request $request): View
    {
        // Sanitise input
        $date = trim(htmlspecialchars($request->input("date")));
        if ($date != "") $date = Carbon::parse($date)->format("Y-m-d");
        $employee = trim(htmlspecialchars($request->input("employee")));
        $employer = trim(htmlspecialchars($request->input("employer")));
        $hours = trim(htmlspecialchars($request->input("hours")));
        $rate_per_hour = number_format((float)preg_replace("/[^0-9.]/", "", $request->input("rate_per_hour")), 2, '.', '');
        $taxable = trim(htmlspecialchars($request->input("taxable")));
        $status = trim(htmlspecialchars($request->input("status")));
        $shift_type = trim(htmlspecialchars($request->input("shift_type")));
        $paid_at = trim(htmlspecialchars($request->input("paid_at"))) == "" ? null : trim(htmlspecialchars($request->input("paid_at")));
        if ($paid_at != null) $paid_at = Carbon::parse($paid_at)->format("Y-m-d H:i:s");

        // Validate input
        $errors = [];
        if ($date == "") array_push($errors, "Date may not be empty.");
        if ($employee == "") array_push($errors, "Employee may not be empty.");
        if ($employer == "") array_push($errors, "Employer may not be empty.");
        if ($hours == "" || $hours == "0") array_push($errors, "Hours may not be empty or zero.");
        else if (ctype_digit($hours) == false) array_push($errors, "Hours must be an integer value.");
        if ($rate_per_hour == "" || $rate_per_hour == "0.00") array_push($errors, "Rate per Hour may not be empty or zero.");
        else if (is_numeric($rate_per_hour) == false) array_push($errors, "Rate per Hour must be a mumeric value.");
        if ($taxable != "Yes" && $taxable != "No") array_push($errors, "Taxable must be a supported value.");
        if ($status != "Complete" && $status != "Failed" && $status != "Pending" && $status != "Processing") array_push($errors, "Status must be a supported value.");
        if ($shift_type != "Day" && $shift_type != "Holiday" && $shift_type != "Night") array_push($errors, "Shift Type must be a supported value.");

        // Response
        if (count($errors) < 1) {
            // Success

            // -- Create new shift
            $shift = new Shifts;
            $shift->date = $date;
            $shift->employee = $employee;
            $shift->employer = $employer;
            $shift->hours = $hours;
            $shift->rate_per_hour = $rate_per_hour;
            $shift->taxable = $taxable;
            $shift->status = $status;
            $shift->shift_type = $shift_type;
            $shift->paid_at = $paid_at;
            $shift->save();

            // -- Display view
            return view('shifts.create')
            ->with("response", "successful");
        } else {
            // Response: input error

            // -- Display view
            return view('shifts.create')
            ->with("response", "failed")
            ->with("errors", $errors)
            ->with("input", $request);
        }
    }

    // Show the selected shift for editing
    public function indexEdit(string $id): View | RedirectResponse
    {
        // Sanitise input
        $sanitisedId = trim(htmlspecialchars($id));

        // Validate input
        if ($sanitisedId == "") return redirect("/400");

        // Prepare data
        $shift = Shifts::find((int)$sanitisedId);

        // Validate
        if ($shift == null) return redirect("/400");

        // Display view
        return view('shifts.edit')
        ->with("shiftid", $sanitisedId)
        ->with("shift", $shift);
    }

    // Update the selected shift
    public function editShift(string $id, Request $request): View | RedirectResponse
    {
        // Sanitise input
        $sanitisedId = trim(htmlspecialchars($id));

        // Validate input
        if ($sanitisedId == "") return redirect("/400");

        // Sanitise input
        $date = trim(htmlspecialchars($request->input("date")));
        if ($date != "") $date = Carbon::parse($date)->format("Y-m-d");
        $employee = trim(htmlspecialchars($request->input("employee")));
        $employer = trim(htmlspecialchars($request->input("employer")));
        $hours = trim(htmlspecialchars($request->input("hours")));
        $rate_per_hour = number_format((float)preg_replace("/[^0-9.]/", "", $request->input("rate_per_hour")), 2, '.', '');
        $taxable = trim(htmlspecialchars($request->input("taxable")));
        $status = trim(htmlspecialchars($request->input("status")));
        $shift_type = trim(htmlspecialchars($request->input("shift_type")));
        $paid_at = trim(htmlspecialchars($request->input("paid_at"))) == "" ? null : trim(htmlspecialchars($request->input("paid_at")));
        if ($paid_at != null) $paid_at = Carbon::parse($paid_at)->format("Y-m-d H:i:s");

        // Validate input
        $errors = [];
        if ($date == "") array_push($errors, "Date may not be empty.");
        if ($employee == "") array_push($errors, "Employee may not be empty.");
        if ($employer == "") array_push($errors, "Employer may not be empty.");
        if ($hours == "" || $hours == "0") array_push($errors, "Hours may not be empty or zero.");
        else if (ctype_digit($hours) == false) array_push($errors, "Hours must be an integer value.");
        if ($rate_per_hour == "" || $rate_per_hour == "0.00") array_push($errors, "Rate per Hour may not be empty or zero.");
        else if (is_numeric($rate_per_hour) == false) array_push($errors, "Rate per Hour must be a mumeric value.");
        if ($taxable != "Yes" && $taxable != "No") array_push($errors, "Taxable must be a supported value.");
        if ($status != "Complete" && $status != "Failed" && $status != "Pending" && $status != "Processing") array_push($errors, "Status must be a supported value.");
        if ($shift_type != "Day" && $shift_type != "Holiday" && $shift_type != "Night") array_push($errors, "Shift Type must be a supported value.");

        // Response
        if (count($errors) < 1) {
            // Success

            // -- Get shift data
            $shift = Shifts::find((int)$sanitisedId);

            // -- Validate
            if ($shift == null) return redirect("/400");

            // -- Update shift data
            $shift->date = $date;
            $shift->employee = $employee;
            $shift->employer = $employer;
            $shift->hours = $hours;
            $shift->rate_per_hour = $rate_per_hour;
            $shift->taxable = $taxable;
            $shift->status = $status;
            $shift->shift_type = $shift_type;
            $shift->paid_at = $paid_at;
            $shift->save();

            // -- Display view
            return view('shifts.edit')
            ->with("response", "successful");
        } else {
            // Response: input error

            // -- Display view
            return view('shifts.edit')
            ->with("shiftid", $sanitisedId)
            ->with("response", "failed")
            ->with("errors", $errors)
            ->with("input", $request);
        }
    }

    // Confirm deletion of the selected shift
    public function indexDelete(string $id): View | RedirectResponse
    {
        // Sanitise input
        $sanitisedId = trim(htmlspecialchars($id));

        // Validate input
        if ($sanitisedId == "") return redirect("/400");

        // Prepare data
        $shift = Shifts::find((int)$sanitisedId);

        // Validate
        if ($shift == null) return redirect("/400");

        // Display view
        return view('shifts.delete')
        ->with("shiftid", $sanitisedId)
        ->with("shift", $shift);
    }

    // Delete the selected shift
    public function deleteShift(string $id, Request $request): View | RedirectResponse
    {
        // Sanitise input
        $sanitisedId = trim(htmlspecialchars($id));

        // Validate input
        if ($sanitisedId == "") return redirect("/400");

        // Get shift
        $shift = Shifts::find((int)$sanitisedId);

        // Validate
        if ($shift == null) return redirect("/400");

        // Delete shift
        $shift->delete();

        return view('shifts.delete')
        ->with("response", "successful");
    }
}
