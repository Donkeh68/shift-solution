<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Aaron's Shift Solutions</title>

        <link rel="icon" type="image/svg+xml" href="/media/shiftsol-offwhite.svg" />

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

        <link href="/css/layout.css" rel="stylesheet">
	</head>
	<body class="d-flex flex-column min-vh-100 min-vw-100">
		<header>
            <div class="ps-4 pe-4 pt-1 pb-1">
				<a href="/" class="text-decoration-none text-white">
					<img src="/media/shiftsol-offwhite.svg" alt="Shiftsol logo" width="64" height="51" class="d-inline-block">
					<span class="fs-2 fw-medium align-middle d-inline-block ps-4 mt-1">Aaron's Shift Solutions</span>
				</a>
			</div>
            <nav class="pe-4">
                <ul>
                    <li><a href="/" class="text-decoration-none">Uploads</a></li>
                    <li><a href="/employees" class="text-decoration-none">Employees</a></li>
                    <li>
                        <form action="/shifts" method="post">
                            @csrf
                            <input type="hidden" name="filter" value="" />
                            <button>Shifts</button>
                        </form>
                    </li>
                </ul>
            </nav>
        </header>
		<main>
            {{ $slot }}
        </main>
		<footer>
            <div class="text-center pt-2">&copy; 2025 Tim Storey</div>
        </footer>
	</body>
</html>
