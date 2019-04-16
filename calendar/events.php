<?php
require '../vendor/autoload.php';

define("MAX_UPCOMING_EVENTS", 4);
define("CALENDAR_ID",
	"ucsd.edu_43odjj6hkidg977ksrlio92v30@group.calendar.google.com");

function getClient()
{
    require 'credentials.php';
    
    $client = new Google_Client();
    
    // true flag in json_decode allows for array methods to be used
    $credentials_json = json_decode($credentials, true);

    $client->setApplicationName('SSA Calendar');
    $client->setScopes(Google_Service_Calendar::CALENDAR_READONLY);
    $client->setAuthConfig($credentials_json);
    $client->setAccessType('offline');
    $client->setPrompt('select_account consent');

    return $client;
}

// Get the API client and construct the service object.
$client = getClient();
$service = new Google_Service_Calendar($client);

$optParams = array(
  'maxResults' => MAX_UPCOMING_EVENTS,
  'orderBy' => 'startTime',
  'singleEvents' => true,
  'timeMin' => date('c'),
);

$results = $service->events->listEvents(CALENDAR_ID, $optParams);
$events = $results->getItems();
?>
<!DOCTYPE html>
<html>
    <head>
		<title>SSA: Calendar</title>
		<link rel="stylesheet"
			href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
			integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
			crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="./events.css">
		<link href="https://fonts.googleapis.com/css?family=Archivo+Black" rel="stylesheet">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	</head>

    <body>
		<!-- Navigation -->
		<div id="navbar">
			<nav class="navbar fixed-top navbar-expand-sm navbar-light" id="navbar">
				<button class="navbar-toggler custom-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation" id="menu-button">
				<span class="navbar-toggler-icon">
					<i class="fa fa-navicon"></i>
				</span>
				</button>


				<div class="collapse navbar-collapse" id="navbarTogglerDemo03">

					<ul class="navbar-nav container-fluid d-flex flex-row justify-content-center text-center" id="nav-list">
						<li class="nav-item flex-fill">
							<a class="nav-link" id="links" href="../index.html">
							Home
							</a>
						</li>
						<li class="nav-item flex-fill">
							<a class="nav-link" id="links" href="../about/index.html">
							About
							</a>
						</li>
						<li class="nav-item flex-fill">
							<a class="nav-link" id="links" href="#">
							Calendar
							</a>
						</li>
						<li class="nav-item flex-fill">
							<a class="nav-link" id="links" href="../collaborations/index.html">
							Collabs
							</a>
						</li>
						<li class="nav-item flex-fill">
							<a class="nav-link" id="links" href="../support/index.html">
							Support
							</a>
						</li>
					</ul>

					<ul id="phone-list">
					<li><a id="mobile-nav" href="../index.html">Home</a></li>
						<li id="underline-div"><div></div></li>
						<li><a id="mobile-nav" href="../about/index.html">About</a></li>
						<li id="underline-div"><div></div></li>
						<li><a id="mobile-nav" href="../calendar/events.php">Calendar</a></li>
						<li id="underline-div"><div></div></li>
						<li><a id="mobile-nav" href="../collaborations/index.html">Collabs</a></li>
						<li id="underline-div"><div></div></li>
						<li><a id="mobile-nav" href="../support/index.html">Support</a></li>
					</ul>
				</div>
			</nav>
		</div>

		<div class='main'>
			<div class="background-img"></div>
			<div class='content-center'>
					<div class="title">EVENTS |</div>
					<div class="events">
						<div style="font-size: 60px; text-align: center; font-weight: 600">
							09
							<p id="month">SEP</p>
						</div>
						<div style="padding-top: 25px; text-align: right">
							<div>Annual Fall Concert</div>
							<div>Music Center 8:30pm</div>
						</div>
						<?php
						if (empty($events)) {
							echo '<p style="text-align: center;">No upcoming events.</p>';
						} else {
							$i = 1;

							foreach ($events as $event) {
								$title = $event->getSummary();
								$start = $event->start->dateTime;
								$location = $event->getLocation();

								if (empty($start)) {
									$start = $event->start->date;
								}

								$startarr = date_parse($start);
								$month = $startarr["month"];
								$monthobj = DateTime::createFromFormat("!m", $month);
								$month = $monthobj->format("F");
								$day = $startarr["day"];
								$day = str_pad($day, 2, 0, STR_PAD_LEFT);
								$hour = $startarr["hour"];
								$hour = str_pad($hour, 2, 0, STR_PAD_LEFT);
								$minute = $startarr["minute"];
								$time = strval($hour) . ":" . strval($minute);
								$time = date('g:i a', strtotime($time));

								echo "<div class=\"event-display\" id=\"event" . $i . "\">
												<div style=\"display: flex; flex-direction: row; justify-content: space-between; align-items: flex-end\">
													<div style=\"display: inline-block; font-size: 30px\">" . $month . "</div>
													<div style=\"display: inline-block; margin-right: 0; font-size: 40px; font-weight: 600\">" . $day . "</div>
												</div>
												<div>" . $title . "</div>
												<div>" . $time . " at " . $location . "</div>
											</div>";

								$i++;
							}
						}
						?>
					</div>
					<iframe id="calendar" src="./calendar.php" frameBorder="0"></iframe>
			</div>
		</div>

		<!-- jQuery -->
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
		integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
		crossorigin="anonymous">
		</script>

		<!-- Popper.js -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
		integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
		crossorigin="anonymous">
		</script>

		<!-- Bootstrap JS -->
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
		integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
		crossorigin="anonymous">
		</script>
    </body>
</html>
