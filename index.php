<?php

header('Content-type: text/calendar; charset=utf-8');
header('Content-Disposition: attachment; filename=filename.ics');

require 'class.iCalReader.php';

$urls = json_decode(file_get_contents('./url.json', FILE_USE_INCLUDE_PATH));

$newCal = "BEGIN:VCALENDAR"
    . "\r\nVERSION:2.0"
    . "\r\nPRODID:v1.0//EN"
    . "\r\nCALSCALE:GREGORIAN";
foreach ($urls as $url) {
    $ical = new ICal($url);
    $events = $ical->events();

    foreach ($events as $event) {

        $newCal = $newCal
            . "\r\nBEGIN:VEVENT"
            . "\r\nDTEND:" . $event['DTEND']
            . "\r\nDTSTART:" . $event['DTSTART']
            . "\r\nUID:" . $event['UID']
            . "\r\nDESCRIPTION:" . $event['DESCRIPTION']
            . "\r\nSUMMARY:" . $event['SUMMARY']
            . "\r\nLOCATION:" . $event['LOCATION']
            . "\r\nDTSTAMP:" . $event['DTSTAMP']
            . "\r\nEND:VEVENT";
    }
    unset($ical);
    unset($events);
}
$newCal = $newCal . "\r\nEND:VCALENDAR";
echo $newCal;
?>