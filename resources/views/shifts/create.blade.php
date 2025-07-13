<x-layout>
   	<h1>Create Shift</h1>

    @if(isset($response))
        <table class="table">
            <thead>
                <tr>
                    <th>Result of operation</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                	@if(isset($response) && $response == "successful")
                        <td style="color:green">Operation completed successfully!</td>
                    @endif
                	@if(isset($response) && $response == "failed" && isset($errors) && count($errors) > 0)
                        <td style="color:red">The operation experienced the following errors:</td>
                    @endif
                </tr>
            </tbody>
        </table>
    @endif

    @if(isset($response) && $response == "failed" && isset($errors) && count($errors) > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                @foreach($errors as $error)
                    <tr>
                        <td>{{ $error }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    @if ((isset($response) && $response == "failed") || !isset($response))
        <form action="/shifts/create/new" method="post">
            @csrf
            <div class="mb-3">
                <label class="form-label" for="txtdate">Date</label>
                @if (isset($input->date) && $input->date != "")
                    <input type="date" class="form-control" name="date" id="txtdate" value="{{ $input->date }}" />
                @else
                    <input type="date" class="form-control" name="date" id="txtdate" value="" />
                @endif
            </div>
            <div class="mb-3">
                <div class="me-3 d-inline-block">
                    <label class="form-label" for="txtemployee">Employee</label>
                    @if (isset($input->employee) && $input->employee != "")
                        <input type="text" class="form-control" name="employee" id="txtemployee" value="{{ $input->employee }}" />
                    @else
                		<input type="text" class="form-control" name="employee" id="txtemployee" value="" />
                    @endif
                </div>
                <div class="d-inline-block">
                    <label class="form-label" for="txtemployer">Employer</label>
                    @if (isset($input->employer) && $input->employer != "")
                		<input type="text" class="form-control" name="employer" id="txtemployer" value="{{ $input->employer }}" />
                    @else
                		<input type="text" class="form-control" name="employer" id="txtemployer" value="" />
                    @endif
                </div>
            </div>
            <div class="mb-3">
                <div class="me-3 d-inline-block">
                    <label class="form-label" for="txthours">Hours</label>
                    @if (isset($input->hours) && $input->hours != "")
                        <input type="text" class="form-control" name="hours" id="txthours" value="{{ $input->hours }}" />
                    @else
                        <input type="text" class="form-control" name="hours" id="txthours" value="" />
                    @endif
                </div>
                <div class="d-inline-block">
                    <label class="form-label" for="txtrateperhour">Rate per Hour</label>
                    @if (isset($input->rate_per_hour) && $input->rate_per_hour != "")
                        <input type="text" class="form-control" name="rate_per_hour" id="txtrateperhour" value="{{ $input->rate_per_hour }}" />
                    @else
                        <input type="text" class="form-control" name="rate_per_hour" id="txtrateperhour" value="" />
                    @endif
                </div>
            </div>
            <div class="mb-3">
                <div class="me-3 d-inline-block">
                    <label class="form-label" for="seltaxable">Taxable</label>
                    <select class="form-select" name="taxable" id="seltaxable">
                        <option value="Yes" {{ isset($input->taxable) && $input->taxable == "Yes" ? "selected" : "" }}>Yes</option>
                        <option value="No" {{ isset($input->taxable) && $input->taxable == "No" ? "selected" : "" }}>No</option>
                    </select>
                </div>
                <div class="me-3 d-inline-block">
                    <label class="form-label" for="selstatus">Status</label>
                    <select class="form-select" name="status" id="selstatus">
                        <option value="Complete" {{ isset($input->status) && $input->status == "Complete" ? "selected" : "" }}>Complete</option>
                        <option value="Failed" {{ isset($input->status) && $input->status == "Failed" ? "selected" : "" }}>Failed</option>
                        <option value="Pending" {{ isset($input->status) && $input->status == "Pending" ? "selected" : "" }}>Pending</option>
                        <option value="Processing" {{ isset($input->status) && $input->status == "Processing" ? "selected" : "" }}>Processing</option>
                    </select>
                </div>
                <div class="d-inline-block">
                    <label class="form-label" for="selshifttype">Shift Type</label>
                    <select class="form-select" name="shift_type" id="selshifttype">
                        <option value="Day" {{ isset($input->shift_type) && $input->shift_type == "Day" ? "selected" : "" }}>Day</option>
                        <option value="Holiday" {{ isset($input->shift_type) && $input->shift_type == "Holiday" ? "selected" : "" }}>Holiday</option>
                        <option value="Night" {{ isset($input->shift_type) && $input->shift_type == "Night" ? "selected" : "" }}>Night</option>
                    </select>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label" for="txtpaidat">Paid At</label>
                @if (isset($input->paid_at) && $input->paid_at != "")
                    <input type="datetime-local" class="form-control" name="paid_at" id="txtpaidat" value="{{ $input->paid_at }}" />
                @else
                    <input type="datetime-local" class="form-control" name="paid_at" id="txtpaidat" value="" />
                @endif
            </div>
            <button class="form-button">Create</button>
        </form>
    @endif

    <form action="/shifts" method="post">
        @csrf
        <input type="hidden" name="filter" value="" />
        <button class="form-button me-3">Back</button>
    </form>

</x-layout>
