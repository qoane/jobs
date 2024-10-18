<?php
session_start();
include('config/database.php');
include('includes/functions.php');

if (!isJobPoster()) {
    header("Location: access_denied.php");
    exit();
}

$job_id = isset($_GET['job_id']) ? intval($_GET['job_id']) : 0;
$user_id = $_SESSION['user_id'];

// Verify that the job belongs to the logged-in user
$job_sql = "SELECT * FROM jobs WHERE id = '$job_id' AND user_id = '$user_id'";
$job_result = mysqli_query($conn, $job_sql);

if (mysqli_num_rows($job_result) == 0) {
    echo "Invalid job ID or you do not have permission to view applications for this job.";
    exit();
}

// Fetch applications for the job
$sql = "SELECT applications.*, users.name AS applicant_name, jobs.title AS job_title FROM applications 
        INNER JOIN users ON applications.user_id = users.id 
        INNER JOIN jobs ON applications.job_id = jobs.id
        WHERE applications.job_id = '$job_id'";
$result = mysqli_query($conn, $sql);
?>

<?php include('includes/header.php'); ?>
<?php include('includes/navbar.php'); ?>

<div class="container mt-5">
    <h2>Applications for Job: <?php echo isset($job['title']) ? $job['title'] : 'Unknown'; ?></h2>
    
    <?php if (mysqli_num_rows($result) > 0): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Applicant Name</th>
                    <th>Surname</th>
                    <th>Highest Qualification</th>
                    <th>Institution Name</th>
                    <th>Field of Study</th>
                    <th>Additional Certifications</th>
                    <th>Work Experience</th>
                    <th>Portfolio Link</th>
                    <th>LinkedIn Profile</th>
                    <th>Cover Letter</th>
                    <th>CV</th>
                    <th>Transcript</th>
                    <th>Date Applied</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($application = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($application['name']); ?></td>
                        <td><?php echo htmlspecialchars($application['surname']); ?></td>
                        <td><?php echo htmlspecialchars($application['highest_qualification']); ?></td>
                        <td><?php echo htmlspecialchars($application['institution_name']); ?></td>
                        <td><?php echo htmlspecialchars($application['field_of_study']); ?></td>
                        <td><?php echo htmlspecialchars($application['additional_certifications']); ?></td>
                        <td><?php echo htmlspecialchars($application['work_experience']); ?></td>
                        <td>
                            <?php if (!empty($application['portfolio_link'])): ?>
                                <a href="<?php echo htmlspecialchars($application['portfolio_link']); ?>" target="_blank">View Portfolio</a>
                            <?php else: ?>
                                N/A
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (!empty($application['linkedin_link'])): ?>
                                <a href="<?php echo htmlspecialchars($application['linkedin_link']); ?>" target="_blank">View LinkedIn</a>
                            <?php else: ?>
                                N/A
                            <?php endif; ?>
                        </td>
                        <td><?php echo nl2br(htmlspecialchars($application['cover_letter'])); ?></td>
                        <td>
                            <?php if (!empty($application['cv'])): ?>
                                <a href="uploads/cvs/<?php echo htmlspecialchars($application['cv']); ?>" target="_blank">Download CV</a>
                            <?php else: ?>
                                N/A
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (!empty($application['transcript'])): ?>
                                <a href="uploads/transcripts/<?php echo htmlspecialchars($application['transcript']); ?>" target="_blank">Download Transcript</a>
                            <?php else: ?>
                                N/A
                            <?php endif; ?>
                        </td>
                        <td><?php echo date('Y-m-d', strtotime($application['applied_at'])); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-info">No applications found for this job.</div>
    <?php endif; ?>
</div>

<?php include('includes/footer.php'); ?>