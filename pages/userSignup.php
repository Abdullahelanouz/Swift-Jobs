<?php
session_start();
require 'db_connection.php'; // الاتصال بقاعدة البيانات

// معالجة التسجيل
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $error_message = "كلمتا المرور غير متطابقتين.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users (name, email, password, role, specialization) VALUES (?, ?, ?, 'employee', NULL)");
        $stmt->bind_param("sss", $name, $email, $hashed_password);

        if ($stmt->execute()) {
            $success_message = "تم تسجيل الحساب بنجاح. يمكنك الآن تسجيل الدخول.";
        } else {
            $error_message = "حدث خطأ أثناء التسجيل. حاول مرة أخرى.";
        }
    }
}
?>

<?php include "./navBar.php" ?>

<div class="reg-wrapper">
    <div class="reg-form">
        <h1 class="reg-heading">سجل كفرد</h1>
        <?php if (isset($success_message)): ?>
            <div class="alert alert-success"> <?= $success_message; ?> </div>
        <?php endif; ?>

        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger"> <?= $error_message; ?> </div>
        <?php endif; ?>

        <form method="POST">
            <div class="input-box">
                <input type="text" name="name" class="reg-input" placeholder="الاسم الكامل" required>
            </div>
            <div class="input-box">
                <input type="tel" name="phone" class="reg-input" placeholder="رقم الجوال" required>
            </div>
            <div class="input-box">
                <input type="email" name="email" class="reg-input" placeholder="البريد الالكتروني" required>
            </div>
            <div class="input-box">
                <input type="password" name="password" class="reg-input" placeholder="كلمة المرور" required>
            </div>
            <div class="input-box">
                <input type="password" name="confirm_password" class="reg-input" placeholder="تأكيد كلمة المرور" required>
            </div>
            <button type="submit" class="reg-submit">التالي</button>
            <div class="existing-account">
                <a href="login_page.php">لديك حساب بالفعل؟</a>
            </div>
        </form>
    </div>
    <div class="reg-image">
        <img src="../page-form-thumb.webp" alt="Registration illustration">
    </div>
</div>

<?php include "./footer.php" ?>
