<x-layout>
	<div>
		<h1 style="float:left;">Shifts</h1>
		<div><a href="/shifts/create" class="form-button" style="margin-top:-3px;">Create Shift</a></div>
	</div>

	<br />
	<br />
	<br />

	<div>
		<div style="float:left;">
			<form action="/shifts" method="post">
	            @csrf
				<label for="txtfilter">Only show shifts with Total Pay greater than </label>
	            <input type="text" id="txtfilter" name="filter" value="{{ $filter }}" class="text-end form-control" style="display:inline;width:100px;" />
				<button class="integrated-button">Filter View</button>
	        </form>
		</div>
		<label class="form-label" style="float:right;margin-top:16px;">Displaying {{ $start + 1 > $count ? $count : $start + 1 }} to {{ $start + 15 > $count ? $count : $start + 15 }} of {{ $count }} record{{ $count != 1 ? "s" : "" }}.</label>
	</div>
	<br />
	<br />
	<br />

	<table class="table">
		<thead>
			<tr>
				<th>Date</th>
				<th>Employee</th>
				<th>Employer</th>
				<th>Hours</th>
				<th>Rate per Hour</th>
				<th>Total Pay</th>
				<th>Taxable</th>
				<th>Status</th>
				<th>Shift Type</th>
				<th>Paid At</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
			</tr>
		</thead>
		<tbody>
			@if ($count === 0)
				<tr>
					<td colspan="12">No shift data found!</td>
				</tr>
			@else
				@foreach ($shifts as $shift)
					<tr>
						<td>{{ $shift->date }}</td>
						<td>{{ $shift->employee }}</td>
						<td>{{ $shift->employer }}</td>
						<td class="text-end">{{ $shift->hours }}</td>
						<td class="text-end">£ {{ number_format($shift->rate_per_hour, 2) }}</td>
						<td class="text-end">£ {{ number_format($shift->hours * $shift->rate_per_hour, 2) }}</td>
						<td>{{ $shift->taxable }}</td>
						<td>{{ $shift->status }}</td>
						<td>{{ $shift->shift_type }}</td>
						<td>{{ $shift->paid_at }}</td>
						<td><a href="/shifts/edit/{!! $shift->id !!}" class="icon-button">Edit</a></td>
						<td><a href="/shifts/delete/{!! $shift->id !!}" class="icon-button">Delete</a></td>
					</tr>
				@endforeach
			@endif
		</tbody>
	</table>

	@foreach ($pagination as $elem)
		@foreach ($elem as $key => $value)
			@if ($value == "...")
				<span class="pagination-divider">...</span>
			@else
				<form action="/shifts?start={{ $value }}" class="d-inline-block" method="post">
                    @csrf
                    <input type="hidden" name="filter" value="{{ $filter }}" />
                    <button class="paginate-button">{{ $key }}</button>
                </form>
			@endif
		@endforeach
	@endforeach

</x-layout>

