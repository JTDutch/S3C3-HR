<?php
function format_dutch_date($date) {
    // Set the locale for Dutch
    setlocale(LC_TIME, 'Dutch_Netherlands.1252');  // Ensure this is valid on Windows
    return strftime('%A %d %B %Y', strtotime($date));  // Format the date
}