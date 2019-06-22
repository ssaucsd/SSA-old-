# SSA
## Overview
This is the website for the Symphonic Student Association, a student organization at UC San Diego. It was created using HTML5, CSS3, JavaScript, and PHP.

## Usage
### Get Code
Clone the repository by entering the following command: 

`git clone https://github.com/TritonSE/SSA.git`

### Dependencies
This website uses the Google Calendar API. To install the Google Client Library, follow [these instructions](https://getcomposer.org/download/) to download Composer and then enter the following command in the top level of the SSA directory:

`composer require google/apiclient:^2.0`

Full instructions on the Google API and PHP can be found [here](https://developers.google.com/calendar/quickstart/php).

### Credentials
Credentials for SSA's Google Calendar are required. A file with these credentials should be created in the `calendar` directory and should be called `credentials.php`. 

The credentials.php file should have the following format:

`<?php
$credentials = 'API_CREDENTIALS';
?>`

`API_CREDENTIALS` should be replaces with the text in the JSON file created when generating the Google Calendar API key. Steps on how to generate the JSON file with Google Calendar API credentials can be found in step 1 of the [PHP Google API Quickstart page](https://developers.google.com/calendar/quickstart/php).
