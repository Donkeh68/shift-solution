<?php

namespace App\Http\Controllers;

use App\Models\Shifts;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class EmployeeController extends Controller
{
    // List all employees
    public function index(): View
    {
        // Init and sanitise input
        $start = "0";
        if (isset($_GET["start"])) $start = preg_replace("/[^0-9]/", "", $_GET["start"]);
        $filter = "";
        if (isset($_GET["filter"])) $filter = trim(htmlspecialchars($_GET["filter"]));

        // Count records
        $employees = Shifts::groupBy("employee")
        ->pluck("employee");
        if ($filter != "") {
            $employees = Shifts::groupBy("employee")
            ->whereRaw("employee LIKE '%{$filter}%'")
            ->pluck("employee");
        }
        $count = count($employees);

        // Get paginated data
        $employees = Shifts::groupBy("employee")
        ->offset($start)
        ->limit(15)
        ->pluck("employee");
        if ($filter != "") {
            $employees = Shifts::groupBy("employee")
            ->whereRaw("employee LIKE '%{$filter}%'")
            ->offset($start)
            ->limit(15)
            ->pluck("employee");
        }

        // Determine paginations
        $pagination = CalculatePagination($count, $start);

        // Display view
        return view('employees.index')
        ->with("filter", $filter)
        ->with("count", $count)
        ->with("start", $start)
        ->with("employees", $employees)
        ->with("pagination", $pagination);
    }

    public function filter(Request $request): View
    {
        // Init and sanitise input
        $start = "0";
        if (isset($_GET["start"])) $start = preg_replace("/[^0-9]/", "", $_GET["start"]);
        $filter = trim(htmlspecialchars($request->input("filter")));

        $_GET["start"] = $start;
        $_GET["filter"] = $filter;

        return $this->index();
    }

    // Display selected employee summary
    public function summary(string $name): View | RedirectResponse
    {
        // Sanitise data
        $sanitisedName = trim(htmlspecialchars($name));

        // Validate input
        if ($sanitisedName == "") return redirect("/400");

        // Prepare headline data
        $employeeData = DB::table("Shifts")
        ->select("employee", 
        DB::raw("sum(rate_per_hour) as totalrate"), 
        DB::raw("sum(rate_per_hour * hours) as totalearned"), 
        DB::raw("count(*) as totalshifts"))
        ->where("employee", "=", $sanitisedName)
        ->groupBy("employee")
        ->get();

        // Validate
        if (count($employeeData) < 1) return redirect("/400");

        // Prepare shift summary data
        $lastCompletedShifts = DB::table("Shifts")
        ->where("employee", "=", $sanitisedName)
        ->where("status", "=", "Complete")
        ->orderBy("id", "desc")
        ->limit(5)
        ->get();

        // Display view
        return view('employees.summary')
        ->with("employeeData", $employeeData)
        ->with("lastCompletedShifts", $lastCompletedShifts);
    }
}
