<?php
session_start();
include('config/database.php');
include('includes/functions.php');

if (!isJobPoster()) {
    header("Location: access_denied.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $job_type = mysqli_real_escape_string($conn, $_POST['job_type']);
    $employment_type = mysqli_real_escape_string($conn, $_POST['employment_type']);
    $required_documents = isset($_POST['required_documents']) ? implode(',', $_POST['required_documents']) : '';

    // Insert into database
    $user_id = $_SESSION['user_id'];
    $sql = "INSERT INTO jobs (user_id, title, description, location, job_type, employment_type, required_documents) 
            VALUES ('$user_id', '$title', '$description', '$location', '$job_type', '$employment_type', '$required_documents')";

    if (mysqli_query($conn, $sql)) {
        $success = "Job posted successfully.";
    } else {
        $error = "Error: " . mysqli_error($conn);
    }
}
?>

<?php include('includes/header.php'); ?>
<?php include('includes/navbar.php'); ?>

<!-- Job Posting Form -->
<div class="container mt-5">
    <h2>Post a Job</h2>
    <?php if (isset($success)) echo "<div class='alert alert-success'>$success</div>"; ?>
    <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
    <form action="post_job.php" method="POST">
        <!-- Title -->
        <div class="form-group">
            <label for="title">Job Title</label>
            <input type="text" class="form-control" name="title" required>
        </div>
        <!-- Description -->
        <div class="form-group">
            <label for="description">Job Description</label>
            <textarea class="form-control" name="description" rows="5" required></textarea>
        </div>
        <!-- Location -->
        <div class="form-group">
            <label for="location">Location</label>
            <input type="text" class="form-control" name="location">
        </div>
        <!-- Job Type (On-site or Remote) -->
        <div class="form-group">
            <label for="job_type">Job Type</label>
            <select class="form-control" name="job_type" required>
                <option value="On-site">On-site</option>
                <option value="Remote">Remote</option>
            </select>
        </div>
        <!-- Employment Type (Full-time, Part-time, Contract, Freelance) -->
        <div class="form-group">
            <label for="employment_type">Employment Type</label>
            <select class="form-control" name="employment_type" required>
                <option value="Full-time">Full-time</option>
                <option value="Part-time">Part-time</option>
                <option value="Contract">Contract</option>
                <option value="Freelance">Freelance</option>
            </select>
        </div>
        <!-- Required Documents -->
        <div class="form-group">
            <label for="required_documents">Required Documents</label><br>
            <input type="checkbox" name="required_documents[]" value="CV"> CV<br>
            <input type="checkbox" name="required_documents[]" value="Transcript"> Transcript<br>
            <!-- Add more options as needed -->
        </div>
        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Post Job</button>
    </form>
</div>

<?php include('includes/footer.php'); ?>
