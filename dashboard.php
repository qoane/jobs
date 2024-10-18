<?php
session_start();
include('config/database.php');
include('includes/functions.php');

if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];

if ($role == 'job_poster') {
    // Fetch jobs posted by the user
    $sql = "SELECT * FROM jobs WHERE user_id = '$user_id'";
    $result = mysqli_query($conn, $sql);
}
?>

<?php include('includes/header.php'); ?>
<?php include('includes/navbar.php'); ?>

<div class="container mt-5">
    <h2>Dashboard</h2>
    <?php if ($role == 'job_poster'): ?>
        <a href="post_job.php" class="btn btn-success mb-3">Post a New Job</a>
        <h3>Your Job Postings</h3>
        <!-- Display job postings -->
        <?php while ($job = mysqli_fetch_assoc($result)): ?>
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $job['title']; ?></h5>
                    <p class="card-text"><?php echo $job['description']; ?></p>
                    <a href="edit_job.php?id=<?php echo $job['id']; ?>" class="btn btn-primary">Edit</a>
                    <a href="delete_job.php?id=<?php echo $job['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                    <a href="view_applications.php?job_id=<?php echo $job['id']; ?>" class="btn btn-info">View Applications</a>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <!-- Job seeker dashboard -->
        <p>Welcome, <?php echo $_SESSION['name']; ?>! Start searching for jobs <a href="jobs.php">here</a>.</p>
        <a href="profile.php" class="btn btn-primary">Edit Profile</a>
    <?php endif; ?>
</div>

<?php include('includes/footer.php'); ?>
