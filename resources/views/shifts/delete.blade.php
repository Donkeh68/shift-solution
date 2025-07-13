<x-layout>
   	<h1>Delete Shift</h1>

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
                </tr>
            </tbody>
        </table>
    @endif

	@if ((isset($response) && $response != "successful") || !isset($response))
		<table class="table">
			<thead>
				<tr>
					<th>Date</th>
					<th>Employee</th>
					<th>Employer</th>
					<th>Hours</th>
					<th>Rate per Hour</th>
					<th>Taxable</th>
					<th>Status</th>
					<th>Shift Type</th>
					<th>Paid At</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>{{ substr($shift->date, 0, 10) }}</td>
					<td>{{ $shift->employee }}</td>
					<td>{{ $shift->employer }}</td>
					<td class="text-end">{{ $shift->hours }}</td>
					<td class="text-end">£ {{ $shift->rate_per_hour }}</td>
					<td>{{ $shift->taxable }}</td>
					<td>{{ $shift->status }}</td>
					<td>{{ $shift->shift_type }}</td>
					<td>{{ $shift->paid_at }}</td>
				</tr>
			</tbody>
		</table>
        <form action="/shifts/delete/{{ $shiftid }}/confirmed" method="post">
            @csrf
			<button class="form-button">Confirm Delete</button>
        </form>
	@endif

    <form action="/shifts" method="post">
        @csrf
        <input type="hidden" name="filter" value="" />
        <button class="form-button me-3">Back</button>
    </form>

</x-layout>
