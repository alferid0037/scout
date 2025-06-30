<?php
require_once 'config/database.php';
require_once 'includes/functions.php';

if (!is_logged_in()) {
    redirect('login.php');
}

$message = '';
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    
    if (!empty($new_password)) {
        if ($new_password !== $confirm_password) {
            $error_message = 'Passwords do not match.';
        } elseif (strlen($new_password) < 8) {
            $error_message = 'Password must be at least 8 characters long.';
        } else {
            $database = new Database();
            $db = $database->getConnection();
            
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $update_query = "UPDATE users SET password = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?";
            $update_stmt = $db->prepare($update_query);
            
            if ($update_stmt->execute([$hashed_password, $_SESSION['user_id']])) {
                $message = 'Password updated successfully!';
            } else {
                $error_message = 'Failed to update password. Please try again.';
            }
        }
    } else {
        $message = 'No changes were made.';
    }
}

// Redirect back to dashboard with message
$_SESSION['profile_message'] = $message;
$_SESSION['profile_error'] = $error_message;
redirect('dashboard.php');
?>
