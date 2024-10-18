<?php
session_start();
require_once 'vendor/autoload.php'; // Ensure you have the Google API Client Library installed
include('config/database.php');

$client = new Google_Client();
$client->setClientId('YOUR_CLIENT_ID'); // Replace with your Client ID
$client->setClientSecret('YOUR_CLIENT_SECRET'); // Replace with your Client Secret
$client->setRedirectUri('http://localhost/recruitment_portal/google_login.php');
$client->addScope('email');
$client->addScope('profile');

if (!isset($_GET['code'])) {
    // Generate a URL to request access from Google's OAuth 2.0 server
    $auth_url = $client->createAuthUrl();
    header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
    exit();
} else {
    // Exchange authorization code for an access token
    $client->authenticate($_GET['code']);
    $token = $client->getAccessToken();
    $client->setAccessToken($token);

    // Get user info
    $oauth = new Google_Service_Oauth2($client);
    $userInfo = $oauth->userinfo->get();

    // Check if user exists in the database
    $email = mysqli_real_escape_string($conn, $userInfo->email);

    $sql = "SELECT id, name, role FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        // User exists, log them in
        $user = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['role'] = $user['role'];
    } else {
        // New user, insert into database
        $name = mysqli_real_escape_string($conn, $userInfo->name);
        $google_id = $userInfo->id;
        // Default role can be set to 'job_seeker' or prompt user to choose
        $role = 'job_seeker';

        $sql = "INSERT INTO users (name, email, google_id, role) VALUES ('$name', '$email', '$google_id', '$role')";
        mysqli_query($conn, $sql);
        $_SESSION['user_id'] = mysqli_insert_id($conn);
        $_SESSION['name'] = $name;
        $_SESSION['role'] = $role;
    }

    header("Location: dashboard.php");
    exit();
}
?>
