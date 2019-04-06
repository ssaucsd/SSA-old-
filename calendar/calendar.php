<?php
$calendar_id = "ucsd.edu_43odjj6hkidg977ksrlio92v30@group.calendar.google.com";
$calendar = "https://calendar.google.com/calendar/embed?src=".$calendar_id."&ctz=America%2FLos_Angeles";
$url = parse_url($calendar);
$google_domain = $url['scheme'].'://'.$url['host'];


// Load and parse Google's raw calendar
$dom = new DOMDocument;
$dom->loadHTMLfile($calendar);


// Change Google's JS file to use absolute URL
$scripts = $dom->getElementsByTagName('script')->item(2);
$js_src = $scripts->getAttribute('src');
$scripts->setAttribute('src', $google_domain . $js_src);

// Create a link to a new CSS file called calendar.css
$css = $dom->createElement('link');
$css->setAttribute('type', 'text/css');
$css->setAttribute('rel', 'stylesheet');
$css->setAttribute('href', 'calendar.css');

// Create a link to a new JS file called calendar.js
$js = $dom->createElement('script');
$js->setAttribute('type', 'text/javascript');
$js->setAttribute('src', 'calendar.js');

// Append CSS and JS links at the end of the head element
$head = $dom->getElementsByTagName('head')->item(0);
$head->appendChild($css);
$head->appendChild($js);

// Remove "SSA" text at top of page
$title = $dom->getElementById('calendarTitle');
$title->parentNode->removeChild($title);

// Export the HTML
echo $dom->saveHTML();
?>
