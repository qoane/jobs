<?php
session_start();
include('config/database.php');
include('includes/functions.php');

// Initialize search variables
$search = '';
$location = '';
$job_type = '';
$employment_type = '';  // New variable for full-time, part-time, contract, freelance

$search_query = "WHERE 1=1";

if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    $search_query .= " AND (jobs.title LIKE '%$search%' OR jobs.description LIKE '%$search%')";
}

if (isset($_GET['location']) && $_GET['location'] != '') {
    $location = mysqli_real_escape_string($conn, $_GET['location']);
    $search_query .= " AND jobs.location LIKE '%$location%'";
}

// Filtering by remote/on-site
if (isset($_GET['job_type']) && $_GET['job_type'] != '') {
    $job_type = mysqli_real_escape_string($conn, $_GET['job_type']);
    $search_query .= " AND jobs.job_type = '$job_type'";
}

// Filtering by full-time/part-time/contract/freelance
if (isset($_GET['employment_type']) && $_GET['employment_type'] != '') {
    $employment_type = mysqli_real_escape_string($conn, $_GET['employment_type']);
    $search_query .= " AND jobs.employment_type = '$employment_type'";
}

$sql = "SELECT jobs.*, users.name AS poster_name FROM jobs INNER JOIN users ON jobs.user_id = users.id $search_query ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
?>

<?php include('includes/header.php'); ?>
<?php include('includes/navbar.php'); ?>

<div class="container mt-5">
    <h2>Job Listings</h2>
    <!-- Search Form -->
    <form class="form-inline mb-3" method="GET" action="jobs.php">
        <input class="form-control mr-sm-2" type="search" placeholder="Search jobs" name="search" value="<?php echo htmlspecialchars($search); ?>">
        <input class="form-control mr-sm-2" type="text" placeholder="Location" name="location" value="<?php echo htmlspecialchars($location); ?>">
        
        <!-- Job Type Dropdown (Remote/On-site) -->
        <select class="form-control mr-sm-2" name="job_type">
            <option value="">Any Type</option>
            <option value="On-site" <?php if ($job_type == 'On-site') echo 'selected'; ?>>On-site</option>
            <option value="Remote" <?php if ($job_type == 'Remote') echo 'selected'; ?>>Remote</option>
        </select>
        
        <!-- New Employment Type Dropdown (Full-time, Part-time, Contract, Freelance) -->
        <select class="form-control mr-sm-2" name="employment_type">
            <option value="">Employment Type</option>
            <option value="Full-time" <?php if ($employment_type == 'Full-time') echo 'selected'; ?>>Full-time</option>
            <option value="Part-time" <?php if ($employment_type == 'Part-time') echo 'selected'; ?>>Part-time</option>
            <option value="Contract" <?php if ($employment_type == 'Contract') echo 'selected'; ?>>Contract</option>
            <option value="Freelance" <?php if ($employment_type == 'Freelance') echo 'selected'; ?>>Freelance</option>
        </select>

        <button class="btn btn-outline-success btn-lg" type="submit">Search</button>
    </form>
    <!-- Display Jobs -->
    <?php while ($job = mysqli_fetch_assoc($result)): ?>
        <div class="card mb-3 animate__animated animate__fadeInUp">
            <div class="card-body">
                <h5 class="card-title"><?php echo $job['title']; ?> <span class="badge badge-info"><?php echo $job['job_type']; ?></span></h5>
                <p class="card-text"><?php echo substr($job['description'], 0, 150); ?>...</p>
                <p class="card-text"><small class="text-muted">Location: <?php echo $job['location']; ?> | Posted by <?php echo $job['poster_name']; ?> on <?php echo date('F j, Y', strtotime($job['created_at'])); ?></small></p>
                <p class="card-text"><small class="text-muted">Employment Type: <?php echo $job['employment_type']; ?></small></p>
                <a href="job_details.php?id=<?php echo $job['id']; ?>" class="btn btn-primary">View Details</a>
            </div>
        </div>
    <?php endwhile; ?>
</div>

<?php include('includes/footer.php'); ?>
