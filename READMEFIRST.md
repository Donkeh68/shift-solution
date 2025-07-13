##	Notes
+	CSV processing output appears in \app\storage\logs\csvimport.log
	+	This includes details of all exluded rows
+	Temporary CSV file data appears in \app\storage\app\public\csv
+	Remember to set the following values in your php.ini:
	+	upload_max_filesize (32M)
	+	post_max_size (32M)
	+	max_execution_time (1200)
	+	max_input_time (600)
+	Uploading of > 200 rows does take time on the dev environment
+	Pagination and filter values do not persist across shift and employee sub-pages


##	Decisions Made
+	Using SqlLite for the database
+	Implemented a single table structure for shifts
	+	If this were a production system, part of a bigger  solution, I would implement separate relational tables for Shifts, Employees and Employers
+	Implemented custom logging for the CSV import process
+	Implemented Jobs and Queues to run in the background, supporting larger uploads
	+	It operates slowly on the dev environment, but would be quicker if configured for - and running on - a production environment


##	Issues Encountered Occasionally
+	If Laravel routes to the 419 expired page
	+	Simply redo the action
	+	This only appears to happen sometimes, on the first user action at the very beginning of a session
+	If nothing happens after uploading a CSV file
	+	Simply press control+c in the main terminal hosting the session, enter Y and then restart the Laravel server (e.g. via composer run dev)
		+	The job should commence processing automatically after that
	+	This only appears to happen at the very beginning of a session
		+	Laravel may throw a timeout error

