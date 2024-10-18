<?php
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function isJobSeeker() {
    return isLoggedIn() && $_SESSION['role'] === 'job_seeker';
}

function isJobPoster() {
    return isLoggedIn() && $_SESSION['role'] === 'job_poster';
}
?>
