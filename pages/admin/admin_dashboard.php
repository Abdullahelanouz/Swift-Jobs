<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

require '../db_connection.php';

// جلب عدد الوظائف
$stmt = $conn->prepare("SELECT COUNT(*) AS job_count FROM jobs");
$stmt->execute();
$job_count = $stmt->get_result()->fetch_assoc()['job_count'];

// جلب عدد الشركات
$stmt = $conn->prepare("SELECT COUNT(*) AS company_count FROM users WHERE role = 'Employer'");
$stmt->execute();
$company_count = $stmt->get_result()->fetch_assoc()['company_count'];

// جلب عدد الباحثين عن العمل
$stmt = $conn->prepare("SELECT COUNT(*) AS job_seeker_count FROM users WHERE role = 'Applicant'");
$stmt->execute();
$job_seeker_count = $stmt->get_result()->fetch_assoc()['job_seeker_count'];

// جلب عدد المستخدمين الإداريين
$stmt = $conn->prepare("SELECT COUNT(*) AS admin_count FROM users WHERE role = 'admin'");
$stmt->execute();
$admin_count = $stmt->get_result()->fetch_assoc()['admin_count'];
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم الأدمن</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <style>
        .dashboard-container { display: flex; min-height: 100vh; }
        .sidebar { width: 250px; background: #343a40; color: white; padding: 20px; }
        .sidebar a { color: white; text-decoration: none; display: block; padding: 10px; border-radius: 5px; }
        .sidebar a:hover { background: #495057; }
        .content { flex-grow: 1; padding: 20px; }
        .stat-card { background: white; padding: 20px; border-radius: 10px; text-align: center; box-shadow: 0px 4px 6px rgba(0,0,0,0.1); }
        .stat-card i { font-size: 30px; margin-bottom: 10px; }
    </style>
</head>
<body>

<div class="dashboard-container">
    <!-- الشريط الجانبي -->
    <div class="sidebar">
        <h4 class="text-center">لوحة التحكم</h4>
        <hr>
        <a href="admin_dashboard.php"><i class="fas fa-th-large"></i> الرئيسية</a>
        <a href="all_jobs.php"><i class="fas fa-briefcase"></i> جميع الوظائف <span class="badge bg-primary"><?= $job_count; ?></span></a>
        <a href="all_companies.php"><i class="fas fa-building"></i> جميع الشركات <span class="badge bg-primary"><?= $company_count; ?></span></a>
        <a href="all_job_seekers.php"><i class="fas fa-users"></i> جميع الباحثين عن العمل <span class="badge bg-primary"><?= $job_seeker_count; ?></span></a>
        <a href="all_admins.php"><i class="fas fa-user-shield"></i> المستخدمون الإداريون <span class="badge bg-danger"><?= $admin_count; ?></span></a>
        <a href="edit_profile.php"><i class="fas fa-user-edit"></i> تعديل الحساب</a>
        <a href="../logout.php" class="text-danger"><i class="fas fa-sign-out-alt"></i> تسجيل الخروج</a>
    </div>

    <!-- المحتوى الرئيسي -->
    <div class="content">
        <h2 class="mb-4">مرحبًا بك في لوحة تحكم الأدمن</h2>

        <div class="row">
            <div class="col-md-3">
                <div class="stat-card">
                    <i class="fas fa-briefcase text-primary"></i>
                    <h3><?= $job_count; ?></h3>
                    <p>الوظائف</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <i class="fas fa-building text-info"></i>
                    <h3><?= $company_count; ?></h3>
                    <p>الشركات</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <i class="fas fa-users text-success"></i>
                    <h3><?= $job_seeker_count; ?></h3>
                    <p>الباحثين عن عمل</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <i class="fas fa-user-shield text-danger"></i>
                    <h3><?= $admin_count; ?></h3>
                    <p>الإداريين</p>
                </div>
            </div>
        </div>

    </div>
</div>

</body>
</html>
