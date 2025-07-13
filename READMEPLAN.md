##	Solution Overview/Analysis
+	Upload CSV
	+	Iterate through rows
		+	Validation
		+	Store in DB
	+	Display any errors
+	Display all employees
	+	*Table*
		+	View button per record
+	Employee summary
	+	Launched via view button
	+	Full name
	+	Ave pay per hour
	+	Ave total pay (ave pay per hour x hours)
	+	Last 5 **completed** payments in *table*
+	Display all shifts
	+	*Table*
		+	Column for Total Pay (rate per hour x hours)
		+	Filter Total Pay
			+	Shows shifts where **Total Pay > filter** amount
		+	Edit shift button
		+	Delete shift button
	+	Create button above table
+	Create shift
	+	Status and Shift Type fields are dropdown
+	Edit shift
	+	Status and Shift Type fields are dropdown
+	Delete shift
	+	Show details
	+	Confirm action


##	Database Structure
+	Single table: ShiftData
	+	id					primary int auto_increment
	+	date				date [should be YYYY-MM-DD]
	+	employee			varchar
	+	employer			varchar
	+	hours				int
	+	ratePerHour			float [currency symbol with error symbol]
	+	taxable				varchar [Yes|No]
	+	status				varchar [Complete|Failed|Pending|Processing]
	+	shiftType			varchar [Day|Holiday|Night]
	+	paidAt				date-time [YYYY-MM-DD H(H):M(M)]


##	Virtual Layout
+	Uploads (Home/landing page)				[GET					/]
	+	Process Upload						[POST ... csv file		/import]
+	Employees								[GET					/employees]
	+	View Employee Summary				[GET					/employees/{name}]
+	Shifts									[POST ... filter		/shifts]
	+	Create Shift Index					[GET ... shift ID		/shifts/create]
	+	Create Shift From Form Data			[POST ... form data		/shifts/create/new]
	+	Edit Shift Index					[GET					/shifts/edit/{id}]
	+	Update Shift From Form Data			[POST ... form data		/shifts/edit/{id}/update]
	+	Delete Shift Index					[GET					/shifts/delete/{id}]
	+	Delete Shift From Form Data			[POST ... form data		/shifts/delete/{id}/confirmed]
+	The layout suggests the following:
	+	3 controllers
		+	Uploads, Employees and Shifts
	+	Routes as above (excluding custom 404 & co.)
	+	Main menu across the site will have 3 elements:
		+	Uploads, Employees and Shifts
+	The table structure suggests the following:
	+	1 model, related to the table structure


##	Site Layout
+	Each page body will adopt the following UI (with FLEX):
	+	Header								[BG: cornflower blue, FG: off-white]
		+	Logo (staff-related SVG)
		+	Brand (Shift Solutions)
		+	Main menu (as above)
	+	Main (FLEX stretch)					[BG: off-white, FG: dark blue, H1: cornflower blue]
		+	Page content
	+	Footer								[BG: dark blue, FG: off-white]
		+	Copyright
		+	Link
	+	Colours as follows:
		+	Cornflower blue: #3676E8
		+	Dark blue: #1347A5
		+	Off-white: #EDF3FD

