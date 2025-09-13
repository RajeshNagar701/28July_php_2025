<?php
$date1 = new DateTime("1990-11-17"); // Start date
$date2 = new DateTime("2025-09-13"); // End date (today or any date)

$interval = $date1->diff($date2);

// Output years and remaining days

echo "Years: " . $interval->y . "<br>";
echo "Months: " . $interval->m . "<br>";
echo "Days (in current month): " . $interval->d . "<br>";
echo "Total days: " . $interval->days . " days";

?>