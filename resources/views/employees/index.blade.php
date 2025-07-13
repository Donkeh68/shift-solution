<x-layout>
	<h1>Employees</h1>

	<div>
		<div style="float:left;">
			<form action="/employees" method="post">
	            @csrf
				<label for="txtfilter">Filter by name </label>
	            <input type="text" id="txtfilter" name="filter" value="{{ $filter }}" class="form-control" style="display:inline;width:150px;" />
				<button class="integrated-button">Search</button>
	        </form>
		</div>
		<label class="form-label ms-3" style="float:right;margin-top:16px;">Displaying {{ $start + 1 > $count ? $count : $start + 1 }} to {{ $start + 15 > $count ? $count : $start + 15 }} of {{ $count }} record{{ $count != 1 ? "s" : "" }}.</label>
	</div>
	<br />
	<br />
	<br />


	<table class="table">
		<tbody>
			@if ($count === 0)
				<tr>
					<td>No employees found!</td>
				</tr>
			@else
				@foreach ($employees as $employee)
					<tr>
						<td>{!! $employee !!}</td>
						<td><a href="/employees/{!! $employee !!}" class="icon-button">View</a></td>
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
				<a href="/employees?start={{ $value }}&filter={{ $filter }}" class="paginate-button">{{ $key }}</a>
			@endif
		@endforeach
	@endforeach

</x-layout>

