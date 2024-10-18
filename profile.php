<?php
session_start();
include('config/database.php');
include('includes/functions.php');

if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $skills = mysqli_real_escape_string($conn, $_POST['skills']);
    $experience = mysqli_real_escape_string($conn, $_POST['experience']);

    $sql = "UPDATE users SET phone = '$phone', address = '$address', skills = '$skills', experience = '$experience' WHERE id = '$user_id'";
    if (mysqli_query($conn, $sql)) {
        $success = "Profile updated successfully.";
    } else {
        $error = "Error: " . mysqli_error($conn);
    }
}

// Fetch user data
$sql = "SELECT * FROM users WHERE id = '$user_id'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);
?>
<?php include('includes/header.php'); ?>
<?php include('includes/navbar.php'); ?>

<div class="container mt-5">
    <h2>Your Profile</h2>
    <?php if (isset($success)) echo "<div class='alert alert-success'>$success</div>"; ?>
    <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
    <form action="profile.php" method="POST">
        <!-- Phone -->
        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" class="form-control" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>">
        </div>
        <!-- Address -->
        <div class="form-group">
            <label for="address">Address</label>
            <textarea class="form-control" name="address"><?php echo htmlspecialchars($user['address']); ?></textarea>
        </div>
        <!-- Skills -->
        <div class="form-group">
            <label for="skills">Skills</label>
            <textarea class="form-control" name="skills"><?php echo htmlspecialchars($user['skills']); ?></textarea>
        </div>
        <!-- Experience -->
        <div class="form-group">
            <label for="experience">Experience</label>
            <textarea class="form-control" name="experience"><?php echo htmlspecialchars($user['experience']); ?></textarea>
        </div>
        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Update Profile</button>
    </form>
</div>

<?php include('includes/footer.php'); ?>
