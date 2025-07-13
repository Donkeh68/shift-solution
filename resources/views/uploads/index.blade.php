<x-layout>
	<h1>Upload CSV file</h1>
	<form action="/import" method="POST" enctype="multipart/form-data">
        @csrf
        <label class="form-label" for="filecsv">Select file to upload</label>
        <input type="file" name="csv" id="filecsv" class="form-control" accept=".csv" required />
        <button class="form-button" type="submit">Import</button>
    </form>
    <br />
    <br />
    <p class="mt-4">Before you start, please make sure your file is saved in CSV UTF-8 format.</p>
    <p class="mt-2">
        <span>Please ensure your columns are in the following order:</span>
        <ul>
            <li>Date</li>
            <li>Employee</li>
            <li>Employer</li>
            <li>Hours</li>
            <li>Rate per Hour</li>
            <li>Taxable</li>
            <li>Status</li>
            <li>Shift Type</li>
            <li>Paid At</li>
        </ul>
    </p>
</x-layout>
