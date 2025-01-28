<?php
session_start();

if (isset($_SESSION['LAST_ACTIVITY'])) {
    // Calculate the remaining time
    $maxLifetime = ini_get('session.gc_maxlifetime');
    $startTime = $_SESSION['LAST_ACTIVITY'];
    $currentTime = time();
    $timeElapsed = $currentTime - $startTime;
    $remainingTime = $maxLifetime - $timeElapsed;

    if ($remainingTime > 0) {
        $remainingHours = floor($remainingTime / 3600); // Calculate remaining hours
        $remainingMinutes = floor(($remainingTime % 3600) / 60); // Calculate remaining minutes
        $remainingSeconds = $remainingTime % 60; // Calculate remaining seconds

        $remainingTimeString = "";
        if ($remainingHours > 0) {
            $remainingTimeString .= "$remainingHours hours";
            if ($remainingMinutes > 0) {
                $remainingTimeString .= ", $remainingMinutes minutes";
            }
        } elseif ($remainingMinutes > 0) {
            $remainingTimeString .= "$remainingMinutes minutes";
        }

        $remainingTimeString .= ", $remainingSeconds seconds";

        // Output the remaining time
        echo '<b style="color:white;">' . $remainingTimeString . ' left to auto Logout </b>';
    } else {
        echo "Session has expired.";
        unset($_SESSION['user_id']);
        unset($_SESSION['mac_address']);
        unset($_SESSION['user_email']);
        session_destroy();
        // reload();
        // header("refresh:0");
        // You can redirect to login page if needed
        header('Location: login');
        exit();
    }
} else {
    echo "Session not started.";
    echo '<script>window.location.reload();</script>';

}
?>
