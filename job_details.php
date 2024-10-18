<?php
session_start();
include('config/database.php');
include('includes/functions.php');

$job_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$sql = "SELECT jobs.*, users.name AS poster_name, users.email AS poster_email FROM jobs INNER JOIN users ON jobs.user_id = users.id WHERE jobs.id = '$job_id'";
$result = mysqli_query($conn, $sql);
$job = mysqli_fetch_assoc($result);

// Handle application submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isJobSeeker()) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $surname = mysqli_real_escape_string($conn, $_POST['surname']);
    $highest_qualification = mysqli_real_escape_string($conn, $_POST['highest_qualification']);
    $institution_name = mysqli_real_escape_string($conn, $_POST['institution_name']);
    $field_of_study = mysqli_real_escape_string($conn, $_POST['field_of_study']);
    $additional_certifications = mysqli_real_escape_string($conn, $_POST['additional_certifications']);
    // Check if work_experience is set and is an array
if (isset($_POST['work_experience']) && is_array($_POST['work_experience'])) {
    // Convert the array of checked checkboxes into a comma-separated string
    $work_experience = implode(', ', $_POST['work_experience']);
} else {
    $work_experience = ''; // Handle as empty if the user hasn't checked any
}

    $portfolio_link = isset($_POST['portfolio_link']) ? mysqli_real_escape_string($conn, $_POST['portfolio_link']) : NULL;
    $linkedin_link = isset($_POST['linkedin_link']) ? mysqli_real_escape_string($conn, $_POST['linkedin_link']) : NULL;

    $cover_letter = mysqli_real_escape_string($conn, $_POST['cover_letter']);
    $user_id = $_SESSION['user_id'];
    $cv = '';
    $transcript = '';

   // Check if work_experience is set and is an array
if (isset($_POST['work_experience']) && is_array($_POST['work_experience'])) {
    // Convert the array of checked checkboxes into a comma-separated string
    $work_experience = implode(', ', $_POST['work_experience']);
} else {
    $work_experience = ''; // Or handle as NULL if the user hasn't checked any
}

    // File upload handling
    if (isset($_FILES['cv']) && $_FILES['cv']['error'] == 0) {
        $cv = time() . '_' . $_FILES['cv']['name'];
        move_uploaded_file($_FILES['cv']['tmp_name'], 'uploads/cvs/' . $cv);
    }

    if (isset($_FILES['transcript']) && $_FILES['transcript']['error'] == 0) {
        $transcript = time() . '_' . $_FILES['transcript']['name'];
        move_uploaded_file($_FILES['transcript']['tmp_name'], 'uploads/transcripts/' . $transcript);
    }


    // Check if already applied
    $check_sql = "SELECT * FROM applications WHERE job_id = '$job_id' AND user_id = '$user_id'";
    $check_result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_result) == 0) {
        // Insert into applications table with new fields
        $sql = "INSERT INTO applications (job_id, user_id, name, surname, highest_qualification, institution_name, field_of_study, additional_certifications, work_experience, portfolio_link, linkedin_link, cover_letter, cv, transcript) 
                VALUES ('$job_id', '$user_id', '$name', '$surname', '$highest_qualification', '$institution_name', '$field_of_study', '$additional_certifications', '$work_experience', '$portfolio_link', '$linkedin_link', '$cover_letter', '$cv', '$transcript')";
        
        if (mysqli_query($conn, $sql)) {
            $success = "Application submitted successfully.";
        } else {
            $error = "Error: " . mysqli_error($conn);
        }
    } else {
        $error = "You have already applied for this job.";
    }
}

?>

<?php include('includes/header.php'); ?>
<?php include('includes/navbar.php'); ?>

<div class="container mt-5">
    <h2><?php echo $job['title']; ?></h2>
    <p><strong>Location:</strong> <?php echo $job['location']; ?></p>
    <p><strong>Job Type:</strong> <?php echo $job['job_type']; ?></p>
    <p><strong>Posted by:</strong> <?php echo $job['poster_name']; ?></p>
    <p><strong>Contact Email:</strong> <?php echo $job['poster_email']; ?></p>
    <p><strong>Required Documents:</strong> <?php echo $job['required_documents'] ? $job['required_documents'] : 'None'; ?></p>
    <p><?php echo nl2br($job['description']); ?></p>

    <?php if (isJobSeeker()): ?>
        <!-- Application Form -->
        <h3>Apply for this Job</h3>
        <?php if (isset($success)) echo "<div class='alert alert-success'>$success</div>"; ?>
        <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
        <form action="job_details.php?id=<?php echo $job_id; ?>" method="POST" enctype="multipart/form-data">
            <!-- Name -->
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <!-- Surname -->
            <div class="form-group">
                <label for="surname">Surname</label>
                <input type="text" class="form-control" id="surname" name="surname" required>
            </div>

            <!-- Highest Qualification -->
            <div class="form-group">
                <label for="highest_qualification">Highest Qualification</label>
                <select class="form-control" id="highest_qualification" name="highest_qualification" required>
                    <option value="">Select Qualification</option>
                    <option value="High School Diploma">High School Diploma</option>
                    <option value="Certificate">Certificate</option>
                    <option value="Diploma">Diploma</option>
                    <option value="Bachelor’s Degree">Bachelor’s Degree</option>
                    <option value="Master’s Degree">Master’s Degree</option>
                    <option value="PhD">PhD</option>
                    <option value="Other">Other</option>
                </select>
            </div>

            <!-- Institution Name -->
            <div class="form-group">
                <label for="institution_name">Institution Name</label>
                <input type="text" class="form-control" id="institution_name" name="institution_name" required>
            </div>

            <!-- Field of Study -->
            <div class="form-group">
                <label for="field_of_study">Field of Study</label>
                <input type="text" class="form-control" id="field_of_study" name="field_of_study" required>
            </div>

            <!-- Additional Certifications or Courses -->
            <div class="form-group">
                <label for="additional_certifications">Additional Certifications or Courses (Optional)</label>
                <textarea class="form-control" id="additional_certifications" name="additional_certifications"></textarea>
            </div>

            <!-- Work Experience -->
            <div class="form-group">
                <label>Work Experience</label><br>
                <input type="checkbox" name="work_experience[]" value="0-2 years"> 0-2 years<br>
                <input type="checkbox" name="work_experience[]" value="3-5 years"> 3-5 years<br>
                <input type="checkbox" name="work_experience[]" value="6-9 years"> 6-9 years<br>
                <input type="checkbox" name="work_experience[]" value="10+ years"> 10+ years<br>
            </div>

            <!-- Portfolio Link -->
            <div class="form-group">
                <label for="portfolio_link">Portfolio Link (Optional)</label>
                <input type="url" class="form-control" id="portfolio_link" name="portfolio_link">
            </div>

            <!-- LinkedIn Profile Link -->
            <div class="form-group">
                <label for="linkedin_link">LinkedIn Profile Link (Optional)</label>
                <input type="url" class="form-control" id="linkedin_link" name="linkedin_link">
            </div>

            <!-- Cover Letter -->
            <div class="form-group">
                <label for="cover_letter">Cover Letter</label>
                <textarea class="form-control" name="cover_letter" rows="5" required></textarea>
            </div>

            <!-- CV Upload -->
            <?php if (strpos($job['required_documents'], 'CV') !== false): ?>
            <div class="form-group">
                <label for="cv">Upload CV</label>
                <input type="file" class="form-control-file" name="cv" accept=".pdf,.doc,.docx" required>
            </div>
            <?php endif; ?>

            <!-- Transcript Upload -->
            <?php if (strpos($job['required_documents'], 'Transcript') !== false): ?>
            <div class="form-group">
                <label for="transcript">Upload Transcript</label>
                <input type="file" class="form-control-file" name="transcript" accept=".pdf,.jpg,.png" required>
            </div>
            <?php endif; ?>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary">Submit Application</button>
        </form>
    <?php else: ?>
        <p><a href="login.php">Login as a Job Seeker</a> to apply for this job.</p>
    <?php endif; ?>
</div>

<?php include('includes/footer.php'); ?>
