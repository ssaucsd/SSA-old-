<?php
// TODO: FIX PRINTING URL ERROR

$calendar="https://calendar.google.com/calendar/embed?src=gg5p3rbo7tuhpgr77rvol6gkj4%40group.calendar.google.com&ctz=America%2FLos_Angeles";
$url = parse_url($calendar);
$google_domain = $url['scheme'].'://'.$url['host'];


// Load and parse Google's raw calendar
$dom = new DOMDocument;
$dom->loadHTMLfile($calendar);


// Change Google's JS file to use absolute URL
$scripts = $dom->getElementsByTagName('script')->item(2);
$js_src = $scripts->getAttribute('src');
$scripts->setAttribute('src', $google_domain . $js_src);

// Create a link to a new CSS file called custom_calendar.css

$element = $dom->createElement('style');
$element->setAttribute('type', 'text/css');
$element->setAttribute('src', 'calendar.css');

// Append this link at the end of the element
$head = $dom->getElementsByTagName('head')->item(0);
$head->appendChild($element);

// Export the HTML
echo $dom->saveHTML();
?>