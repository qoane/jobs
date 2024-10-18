<?php
session_start();
?>

<?php
include_once('config/database.php');
include_once('includes/functions.php');
include_once('includes/header.php');
include_once('includes/navbar.php');
?>
<!-- Main Content -->
<div class="container mt-5 animate__animated animate__fadeIn">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">   
    <div class="jumbotron text-center">
        <h1 class="display-4">Welcome to the Recruitment Portal</h1>
        <p class="lead">Connecting job seekers with job posters seamlessly.</p>
        <hr class="my-4">
        <p class="my-4">Find your dream job or the perfect candidate today.</p>
        <a class="btn btn-primary btn-lg" href="jobs.php" role="button">Browse Jobs</a>
        <?php if (isJobPoster()): ?>
            <a class="btn btn-success btn-lg" href="post_job.php" role="button">Post a Job</a>
        <?php elseif (!isLoggedIn()): ?>
            <a class="btn btn-success btn-lg" href="register.php" role="button">Sign Up</a>
        <?php endif; ?>
    </div>

    <!-- Motivational Section -->
    <div class="row mt-5">
        <div class="col-md-12">
            <h2 class="text-center">Empowering Lesotho's Workforce</h2>
            <p class="text-justify">
                Lesotho, a beautiful mountainous kingdom encircled by South Africa, faces significant economic challenges. High unemployment rates and limited access to job opportunities have impacted many Basotho citizens. Our recruitment portal aims to bridge this gap by connecting skilled job seekers with employers, fostering economic growth, and contributing to the nation's prosperity. By leveraging technology, we strive to make job search and recruitment more efficient and accessible for everyone in Lesotho.
            </p>
        </div>
    </div>

    <!-- Process Flow Section -->

    <div class="container mt-5">
    <h2 class="text-center">How It Works</h2>
    <div class="row mt-4 text-center">
        <div class="col-md-3">
            <i class="bi bi-person-plus fa-3x mb-2"></i> <!-- Bootstrap Icon for Sign Up -->
            <h5>1. Sign Up</h5>
            <p>Create an account as a job seeker or a job poster.</p>
        </div>
        <div class="col-md-3">
            <i class="bi bi-pencil-square fa-3x mb-2"></i> <!-- Bootstrap Icon for Complete Profile -->
            <h5>2. Complete Profile</h5>
            <p>Fill in your details to showcase your skills or company.</p>
        </div>
        <div class="col-md-3">
            <i class="bi bi-search fa-3x mb-2"></i> <!-- Bootstrap Icon for Browse & Apply -->
            <h5>3. Browse & Apply</h5>
            <p>Search for jobs and apply or post job openings.</p>
        </div>
        <div class="col-md-3">
            <i class="bi bi-person-check fa-3x mb-2"></i> <!-- Bootstrap Icon for Connect -->
            <h5>4. Connect</h5>
            <p>Job posters review applications and contact candidates.</p>
        </div>
    </div>
</div>


<?php include_once('includes/footer.php'); ?>
