<?php
require __DIR__ . '/vendor/autoload.php';

define("MAX_UPCOMING_EVENTS", 4);
define("CALENDAR_ID", 
	"ucsd.edu_43odjj6hkidg977ksrlio92v30@group.calendar.google.com");

function getClient()
{
    $client = new Google_Client();
    $credentials = '{
       	"type": "service_account",
	"project_id": "ssa-website-233021",
	"private_key_id": "b38d35d30437b62857c3c8a6610439eb9920a984",
	"private_key": "-----BEGIN PRIVATE KEY-----\nMIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQCdz9F+x/2w4NQt\nHgk8NWncikma4xmMnkEJR3IqHBY2a32cj+IiCNAm1oPb4+Hn2NSUYWhJ8APKt7Vo\nKdmmaSuggLOukDWxdXDaFmjl/Vt8SQpjrZxR4WUTU1+tZCaz5E68nF4ibvYYH/NF\nciOQ4o6cWhRNagt6jopQPpqb8nkeWXFtAbiJxGCeUos7lDF0daUwfwbzk0R9DYeq\nOzZsI0g/aZ3znJuVDoXdv8ZJm3mtnOLPCj0g6Y7NIM0U0Sl58DSp1Xi854l+r+NU\ndTSxxaS+Q56d7Vm1VFsuX8hB3/O/O27R+FY21msK9yBAS3hZp3/mfMX2HzbvOyTE\nDrfZz885AgMBAAECggEAA3etgruiN2C5SMSAL3J9APuI4n5a8VwI0ctgFszHMCrs\nd6Qxs829xRyxiQNY019QTHJXeEhtzOZ8de11etKUwtIRIKTKiTurXx9e7q7Cc9in\nAcmuxZ3OOr56O7UXpJw/nqVQ7DDD94O8NKptXaGcwJK6H3lVBzxajajSfNq3DpOf\ns/SNDkNNO070Hn+VgJMP6cjD6q7sPgpEMLr+B2GnesPcaCIr7m7UpCWqw78cjn1o\nV3r9uvwGJqzXAKsywMU9ZzA0Oi1+xgNFnoNE2YmCEQgyjo1YvJPoALtygGv02quj\nRAZQaAXKL006A7aPgqfrLSQRY2L2N4gJb6FIgLXKgQKBgQDPuHFw34XOsTtFXTmy\nbI3tgx3cB2NH9WG9EvWz41dsYqU7KRl+uGahKcPZei4Sn7b5cfO9AxHYhRiNmgKt\nBZo9JVigwBH5RnJB3LJndOPU9GEIvGfad0NmAU0zQUHbY3GL2tb32CZZhhd2m9jX\nJPWXovEKHDxNz5aBmlSDyJkXYwKBgQDCfcNM2olTmG+NbsMHiToeo02qTzz6ObbF\nyp3ogyntkMuk7OXyFnnV85Lfwks3IAmswuU38XEcM5biDlORFQxWBOm/Yu2ScMQY\nngDIHeKX3tDheyN9emV6ClNt6iLYmkdottl4Q/x527vfhQ6AR0kMV5dfgO9s8nFD\n7u7NUBhHswKBgQCQBqJZkhKUQx0GtmIoDc7G7Y/JnTHAliqjz76fcTWPyEIq6A9u\nZut6OZw7cdT6QtW61cEbwEIib/6bSDssvuK4HOn749FSlv7oHd9xjoHeiWeyh/g2\naVVJKAPgUxIXzTbQsvc0uCG3FxuzuNG8Mzs6XddlnDhP92yzBlAtY+yKYwKBgE28\nGl0TU6P33042IPlYHcS1HIuflA2nF6hCbY7LLezn3J0UmmuCFDwxWFjavVlREszc\nMOWFOOI+tGWxuDDaqs2OtSZrkezf6WC1djaFy1VMF0yn/O1gCEMY8XOTC05ri3MM\n8iqhcb3610JlWgBnfYjTUYs4a3muBRtT2lpxUuMFAoGABPlL9m1VB5fNzc5jyGJS\neHnOK+ubppRtpgIGyNd+kIwAlje2uHhNROUINmlVFam2RBAAibt2cJOWGkVEbgFI\nmUj8JeA5N0Y2xWHO6qRfmyXqjKpH4PDQypWr1Ql1nVEWLKJDLxX75fDAgM9pt/9l\nrhBS7mYKbshFMeXRB7Db0iY=\n-----END PRIVATE KEY-----\n",
	"client_email": "ssa-website@ssa-website-233021.iam.gserviceaccount.com",
	"client_id": "105232639546069107433",
	"auth_uri": "https://accounts.google.com/o/oauth2/auth",
	"token_uri": "https://oauth2.googleapis.com/token",
	"auth_provider_x509_cert_url": "https://www.googleapis.com/oauth2/v1/certs",
	"client_x509_cert_url": "https://www.googleapis.com/robot/v1/metadata/x509/ssa-website%40ssa-website-233021.iam.gserviceaccount.com"
    }';

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
    </head>
    <body>
	<?php
	if (empty($events)) {
	    print "no upcoming events found.\n";
	} else {
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

		printf("%s %s (%s %s %s)<br>", $title, $location, $month, $day, $time);
	    }
	}
	?>
    </body>
</html>
