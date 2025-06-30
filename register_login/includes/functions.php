<?php
session_start();

function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function generate_captcha() {
    $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789';
    $captcha = '';
    for ($i = 0; $i < 6; $i++) {
        $captcha .= $chars[rand(0, strlen($chars) - 1)];
    }
    $_SESSION['captcha'] = $captcha;
    return $captcha;
}

function verify_captcha($user_input) {
    return isset($_SESSION['captcha']) && $_SESSION['captcha'] === $user_input;
}

function upload_file($file, $target_dir, $allowed_types = ['jpg', 'jpeg', 'png', 'pdf']) {
    if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
        return false;
    }
    
    $file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($file_extension, $allowed_types)) {
        return false;
    }
    
    $unique_name = uniqid() . '.' . $file_extension;
    $target_path = $target_dir . $unique_name;
    
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }
    
    if (move_uploaded_file($file['tmp_name'], $target_path)) {
        return $unique_name;
    }
    
    return false;
}

function is_logged_in() {
    return isset($_SESSION['user_id']);
}

function redirect($url) {
    header("Location: $url");
    exit();
}

function calculate_age($birth_day, $birth_month, $birth_year) {
    $birth_date = new DateTime("$birth_year-$birth_month-$birth_day");
    $today = new DateTime();
    return $today->diff($birth_date)->y;
}
?>
