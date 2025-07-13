<x-layout>
	<h1>Details for {!! $employeeData[0]->employee !!}</h1>

	<h3>Calculated averages</h3>
	<table class="table">
		<tbody>
			<tr>
				<th scope="row">Average pay per hour (all time)</th>
				<td class="text-end">£ {{ number_format($employeeData[0]->totalrate / $employeeData[0]->totalshifts, 2) }}</td>
			</tr>
			<tr>
				<th scope="row">Average total pay (all time)</th>
				<td class="text-end">£ {{ number_format($employeeData[0]->totalearned / $employeeData[0]->totalshifts, 2) }}</td>
			</tr>
		</tbody>
	</table>

	<h3>Last 5 complete shifts</h3>
	<table class="table">
		<thead>
			<tr>
				<th>Date</th>
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
			@if (count($lastCompletedShifts) == 0)
				<tr>
					<td colspan="8">No completed shifts found for employee!</td>
				</tr>
			@else
				@foreach ($lastCompletedShifts as $shift)
					<tr>
						<td>{{ $shift->date }}</td>
						<td>{{ $shift->employer }}</td>
						<td class="text-end">{{ $shift->hours }}</td>
						<td class="text-end">£ {{ number_format($shift->rate_per_hour, 2) }}</td>
						<td>{{ $shift->taxable }}</td>
						<td>{{ $shift->status }}</td>
						<td>{{ $shift->shift_type }}</td>
						<td>{{ $shift->paid_at }}</td>
					</tr>
				@endforeach
			@endif
		</tbody>
	</table>

	<a href="/employees" class="form-button">Back</a>

</x-layout>

