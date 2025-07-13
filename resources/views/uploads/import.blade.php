<x-layout>
	<h1>Upload CSV file</h1>

    <table class="table">
        <thead>
            <tr>
                <th>Result of operation</th>
            </tr>
        </thead>
        <tbody>
            <tr>
            	@if($result == "busy")
                    <td style="color:green">
                        <span>The CSV file is busy being processed!</span>
                        <ul>
                            <li>You may need to wait a few minutes for large files to complete processing; and</li>
                            <li>Remember to check the log files afterwards for details of rows that were not imported.</li>
                        </ul>
                    </td>
                @endif
            </tr>
        </tbody>
    </table>

</x-layout>

