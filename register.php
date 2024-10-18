<?php
session_start();
include('config/database.php');
include('includes/functions.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect and sanitize form data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role'];
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $skills = $experience = '';

    if ($role == 'job_seeker') {
        $skills = mysqli_real_escape_string($conn, $_POST['skills']);
        $experience = mysqli_real_escape_string($conn, $_POST['experience']);
    }

    // Validate passwords
    if ($password != $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        // Check if email already exists
        $email_check = "SELECT * FROM users WHERE email = '$email'";
        $email_result = mysqli_query($conn, $email_check);
        if (mysqli_num_rows($email_result) > 0) {
            $error = "An account with this email already exists.";
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            // Insert into database
            $sql = "INSERT INTO users (name, email, password, role, phone, address, skills, experience) VALUES ('$name', '$email', '$hashed_password', '$role', '$phone', '$address', '$skills', '$experience')";

            if (mysqli_query($conn, $sql)) {
                $_SESSION['user_id'] = mysqli_insert_id($conn);
                $_SESSION['name'] = $name;
                $_SESSION['role'] = $role;
                header("Location: dashboard.php");
                exit();
            } else {
                $error = "Error: " . mysqli_error($conn);
            }
        }
    }
}
?>

<?php include('includes/header.php'); ?>
<?php include('includes/navbar.php'); ?>

<!-- Registration Form -->
<div class="container mt-5">
    <h2>Register</h2>
    <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
    <form action="register.php" method="POST">
        <!-- Name -->
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" name="name" required>
        </div>
        <!-- Email -->
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" name="email" required>
        </div>
        <!-- Password -->
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" name="password" required>
        </div>
        <!-- Confirm Password -->
        <div class="form-group">
            <label for="confirm_password">Confirm Password</label>
            <input type="password" class="form-control" name="confirm_password" required>
        </div>
        <!-- Phone -->
        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" class="form-control" name="phone" required>
        </div>
        <!-- Address -->
        <div class="form-group">
            <label for="address">Address</label>
            <textarea class="form-control" name="address" required></textarea>
        </div>
        <!-- Role Selection -->
        <div class="form-group">
            <label for="role">I am a:</label>
            <select class="form-control" name="role" required onchange="toggleJobSeekerFields(this.value)">
                <option value="job_seeker">Job Seeker</option>
                <option value="job_poster">Job Poster</option>
            </select>
        </div>
        <!-- Skills and Experience (Job Seeker Only) -->
        <div id="job_seeker_fields">
            <!-- Skills -->
            <div class="form-group">
                <label for="skills">Skills</label>
                <textarea class="form-control" name="skills"></textarea>
            </div>
            <!-- Experience -->
            <div class="form-group">
                <label for="experience">Experience</label>
                <textarea class="form-control" name="experience"></textarea>
            </div>
        </div>
        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Register</button>
    </form>
</div>

<script>
function toggleJobSeekerFields(role) {
    var fields = document.getElementById('job_seeker_fields');
    if (role === 'job_seeker') {
        fields.style.display = 'block';
    } else {
        fields.style.display = 'none';
    }
}
document.addEventListener('DOMContentLoaded', function() {
    var roleSelect = document.querySelector('select[name="role"]');
    toggleJobSeekerFields(roleSelect.value);
});
</script>

<?php include('includes/footer.php'); ?>
