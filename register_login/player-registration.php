<?php
require_once 'config/database.php';
require_once 'includes/functions.php';

if (!is_logged_in()) {
    redirect('login.php');
}

$error_message = '';
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Process form data without CAPTCHA verification
    $first_name = sanitize_input($_POST['firstName']);
    $last_name = sanitize_input($_POST['lastName']);
    $birth_day = (int)$_POST['day'];
    $birth_month = (int)$_POST['month'];
    $birth_year = (int)$_POST['year'];
    $gender = sanitize_input($_POST['gender']);
    $phone = sanitize_input($_POST['phone']);
    $passport_number = sanitize_input($_POST['passport']);
    $weight = (float)$_POST['weight'];
    $country = sanitize_input($_POST['country']);
    $city = sanitize_input($_POST['city']);
    
    // File uploads
    $upload_dir = 'uploads/';
    
    // Ensure upload directory exists
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }
    
    // Upload files with strict validation
    $photo_path = upload_file($_FILES['photo'], $upload_dir, ['jpg', 'jpeg', 'png'], 'photo_');
    $birth_cert_path = upload_file($_FILES['birthCertificate'], $upload_dir, ['pdf', 'jpg', 'jpeg', 'png'], 'birthcert_');
    $passport_photo_path = !empty($_FILES['passportPhoto']['name']) ? 
        upload_file($_FILES['passportPhoto'], $upload_dir, ['jpg', 'jpeg', 'png'], 'passport_') : '';
    $education_cert_path = upload_file($_FILES['education'], $upload_dir, ['pdf'], 'education_');
    
    if ($photo_path && $birth_cert_path && $education_cert_path) {
        $database = new Database();
        $db = $database->getConnection();
        
        $query = "INSERT INTO player_registrations 
                 (user_id, first_name, last_name, birth_day, birth_month, birth_year, 
                  gender, phone, photo_path, birth_certificate_path, passport_number, 
                  passport_photo_path, weight, education_certificate_path, country, city) 
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $db->prepare($query);
        $result = $stmt->execute([
            $_SESSION['user_id'], $first_name, $last_name, $birth_day, $birth_month, $birth_year,
            $gender, $phone, $photo_path, $birth_cert_path, $passport_number,
            $passport_photo_path, $weight, $education_cert_path, $country, $city
        ]);
        
        if ($result) {
            $success_message = 'Registration submitted successfully! You will be contacted soon.';
        } else {
            $error_message = 'Registration failed. Please try again.';
            // Clean up uploaded files if DB insert failed
            @unlink($photo_path);
            @unlink($birth_cert_path);
            if ($passport_photo_path) @unlink($passport_photo_path);
            @unlink($education_cert_path);
        }
    } else {
        $error_message = 'File upload error: ';
        
        if (!$photo_path) {
            $error_message .= 'Profile photo must be JPG/JPEG/PNG. ';
        }
        if (!$birth_cert_path) {
            $error_message .= 'Birth certificate must be PDF/JPG/JPEG/PNG. ';
        }
        if (!$education_cert_path) {
            $error_message .= 'Education certificate must be PDF only. ';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Player Registration Form</title>
    <style>
        :root {
            --primary-color: #6a5acd;
            --secondary-color: #9370db;
            --accent-color: #ff7e5f;
            --light-color: #f8f9fa;
            --dark-color: #343a40;
            --success-color: #28a745;
            --error-color: #dc3545;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #1f074b;
            background-image: 
                radial-gradient(circle at 20% 30%, rgba(255, 42, 109, 0.15) 0%, transparent 25%),
                radial-gradient(circle at 80% 70%, rgba(5, 217, 232, 0.15) 0%, transparent 25%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
            color: var(--dark-color);
        }

        .container {
            background-color: #0d0221;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 700px;
            transition: all 0.3s ease;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: var(--primary-color);
            font-size: 2rem;
            position: relative;
            padding-bottom: 15px;
        }

        h2::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: linear-gradient(to right, var(--primary-color), var(--accent-color));
            border-radius: 3px;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
            color: #f6f2f2;
        }
        
        .form-group img {
            width: 100px;
            height: 100px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: white;
        }

        label.required::after {
            content: " *";
            color: var(--error-color);
        }

        input, select, textarea {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e1e5ee;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s;
            background-color: var(--light-color);
        }

        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(106, 90, 205, 0.2);
        }

        .dob-fields {
            display: flex;
            gap: 10px;
        }

        .dob-fields select {
            flex: 1;
        }

        input[type="file"] {
            padding: 10px;
            background-color: white;
        }

        .file-requirements {
            font-size: 0.85rem;
            color: #aaa;
            margin-top: 5px;
        }

        .file-preview {
            max-width: 200px;
            max-height: 200px;
            margin: 10px 0;
            display: none;
        }

        .upload-notes {
            background-color: rgba(106, 90, 205, 0.1);
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid var(--primary-color);
        }

        .upload-notes h4 {
            color: var(--primary-color);
            margin-bottom: 10px;
        }

        .upload-notes ul {
            padding-left: 20px;
            color: #ddd;
            font-size: 0.9rem;
        }

        .upload-notes li {
            margin-bottom: 5px;
        }

        .button-group {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }

        button {
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s;
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .back-btn {
            background-color: #6c757d;
            color: white;
        }

        .register-btn {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            color: white;
        }

        .error-message {
            color: var(--error-color);
            margin-bottom: 15px;
            text-align: center;
            padding: 10px;
            background-color: rgba(220, 53, 69, 0.1);
            border-radius: 5px;
        }

        .success-message {
            color: var(--success-color);
            margin-bottom: 15px;
            text-align: center;
            padding: 10px;
            background-color: rgba(40, 167, 69, 0.1);
            border-radius: 5px;
        }

        @media (max-width: 768px) {
            .dob-fields {
                flex-direction: column;
            }
            
            .button-group {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Player Registration Form</h2>
        <?php if ($error_message): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <?php if ($success_message): ?>
            <div class="success-message"><?php echo $success_message; ?></div>
        <?php endif; ?>
        
        <form id="registrationForm" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="firstName" class="required">First Name</label>
                <input type="text" id="firstName" name="firstName" required placeholder="Enter your first name">
            </div>

            <div class="form-group">
                <label for="lastName" class="required">Last Name</label>
                <input type="text" id="lastName" name="lastName" required placeholder="Enter your last name">
            </div>

            <div class="form-group">
                <label class="required">Date of Birth</label>
                <div class="dob-fields">
                    <select id="day" name="day" required>
                        <option value="">Day</option>
                        <?php for($i = 1; $i <= 31; $i++): ?>
                            <option value="<?php echo $i; ?>"><?php echo sprintf('%02d', $i); ?></option>
                        <?php endfor; ?>
                    </select>
                    <select id="month" name="month" required>
                        <option value="">Month</option>
                        <?php 
                        $months = ['January', 'February', 'March', 'April', 'May', 'June',
                                  'July', 'August', 'September', 'October', 'November', 'December'];
                        foreach($months as $index => $month): ?>
                            <option value="<?php echo $index + 1; ?>"><?php echo $month; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <select id="year" name="year" required>
                        <option value="">Year</option>
                        <?php for($i = date('Y'); $i >= 1900; $i--): ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="gender" class="required">Gender</label>
                <select id="gender" name="gender" required>
                    <option value="">Select your gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </div>

            <div class="form-group">
                <label for="phone" class="required">Phone Number</label>
                <input type="tel" id="phone" name="phone" required 
                    placeholder="Enter phone number (e.g., +251912345678)"
                    pattern="^\+2519\d{8}$" title="Phone number must start with +2519 followed by 8 digits">
            </div>

            <div class="form-group">
                <label for="country" class="required">Country</label>
                <select id="country" name="country" required>
                    <option value="">Select your country</option>
                    <option value="Ethiopia">Ethiopia</option>
                    <!-- Add more countries as needed -->
                </select>
            </div>

            <div class="form-group">
                <label for="city" class="required">City</label>
                <select id="city" name="city" required>
                    <option value="">Select your city</option>
                    <option value="Addis Ababa">Addis Ababa</option>
                    <option value="Dire Dawa">Dire Dawa</option>
                    <option value="Mekelle">Mekelle</option>
                    <option value="Adama">Adama (Nazret)</option>
                    <option value="Bahir Dar">Bahir Dar</option>
                    <option value="Hawassa">Hawassa</option>
                    <option value="Jimma">Jimma</option>
                    <option value="Gondar">Gondar</option>
                    <option value="Dessie">Dessie</option>
                    <option value="Shashemene">Shashemene</option>
                    <option value="Wolaita Sodo">Wolaita Sodo</option>
                    <option value="Debre Birhan">Debre Birhan</option>
                    <option value="Jijiga">Jijiga</option>
                    <option value="Harar">Harar</option>
                    <option value="Nekemte">Nekemte</option>
                    <option value="Arba Minch">Arba Minch</option>
                    <option value="Dilla">Dilla</option>
                    <option value="Assosa">Assosa</option>
                    <option value="Gambela">Gambela</option>
                    <option value="Woldia">Woldia</option>
                </select>
            </div>

            <div class="upload-notes">
                <h4>Important Upload Requirements:</h4>
                <ul>
                    <li>Profile photo must be a clear headshot (JPG/PNG only, max 2MB)</li>
                    <li>Birth certificate can be scanned document (PDF) or clear photo (JPG/PNG, max 5MB)</li>
                    <li>Education certificate must be PDF format only (max 5MB)</li>
                    <li>Passport photo (if provided) must be JPG/PNG (max 2MB)</li>
                    <li>All documents must be clear and readable</li>
                </ul>
            </div>

            <div class="form-group">
                <label for="photo" class="required">Upload Photo</label>
                <input type="file" id="photo" name="photo" accept="image/jpeg,image/png" required>
                <div class="file-requirements">Accepted formats: JPG, JPEG, PNG only. Max size: 2MB</div>
                <img src="https://st3.depositphotos.com/3332767/19338/i/1600/depositphotos_193386670-stock-photo-full-length-portrait-soccer-player.jpg" alt="Sample Photo">
            </div>

            <div class="form-group">
                <label for="birthCertificate" class="required">Birth Certificate</label>
                <input type="file" id="birthCertificate" name="birthCertificate" accept=".pdf,.jpg,.jpeg,.png" required>
                <div class="file-requirements">Accepted formats: PDF, JPG, JPEG, PNG. Max size: 5MB</div>
            </div>

            <div class="form-group">
                <label for="passport">Passport Number (Optional)</label>
                <input type="text" id="passport" name="passport" placeholder="Enter passport number if available">
            </div>

            <div class="form-group">
                <label for="passportPhoto">Upload Passport Photo (Optional)</label>
                <input type="file" id="passportPhoto" name="passportPhoto" accept="image/jpeg,image/png">
                <div class="file-requirements">Accepted formats: JPG, JPEG, PNG only. Max size: 2MB</div>
                <img id="passportPhotoPreview" class="file-preview" src="#" alt="Passport photo preview">
            </div>

            <div class="form-group">
                <label for="weight" class="required">Weight (kg)</label>
                <input type="number" id="weight" name="weight" step="0.1" min="30" max="200" required placeholder="Enter your weight in kg">
            </div>

            <div class="form-group">
                <label for="education" class="required">Educational Certificate</label>
                <input type="file" id="education" name="education" accept=".pdf,application/pdf" required>
                <div class="file-requirements">Accepted format: PDF only. Max size: 5MB</div>
            </div>

            <div class="button-group">
                <button type="button" class="back-btn" onclick="window.location.href='dashboard.php'">← Back</button>
                <button type="submit" class="register-btn">REGISTER</button>
            </div>
        </form>
    </div>

    <script>
        // File preview functionality
        document.getElementById('photo').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    const preview = document.getElementById('photoPreview');
                    preview.src = event.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });

        document.getElementById('passportPhoto').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    const preview = document.getElementById('passportPhotoPreview');
                    preview.src = event.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });

        // Form validation
        document.getElementById('registrationForm').addEventListener('submit', function(e) {
            const maxPhotoSize = 2 * 1024 * 1024; // 2MB
            const maxDocSize = 5 * 1024 * 1024; // 5MB

            const photo = document.getElementById('photo').files[0];
            if (photo) {
                const validImageTypes = ['image/jpeg', 'image/png'];
                if (!validImageTypes.includes(photo.type)) {
                    e.preventDefault();
                    alert('Profile photo must be JPG or PNG format');
                    return false;
                }
                if (photo.size > maxPhotoSize) {
                    e.preventDefault();
                    alert('Profile photo size must be less than 2MB');
                    return false;
                }
            }

            const birthCert = document.getElementById('birthCertificate').files[0];
            if (birthCert) {
                const validTypes = ['application/pdf', 'image/jpeg', 'image/png'];
                if (!validTypes.includes(birthCert.type)) {
                    e.preventDefault();
                    alert('Birth certificate must be PDF, JPG, or PNG format');
                    return false;
                }
                if (birthCert.size > maxDocSize) {
                    e.preventDefault();
                    alert('Birth certificate size must be less than 5MB');
                    return false;
                }
            }

            const educationCert = document.getElementById('education').files[0];
            if (educationCert) {
                if (educationCert.type !== 'application/pdf') {
                    e.preventDefault();
                    alert('Education certificate must be PDF format');
                    return false;
                }
                if (educationCert.size > maxDocSize) {
                    e.preventDefault();
                    alert('Education certificate size must be less than 5MB');
                    return false;
                }
            }

            const passportPhoto = document.getElementById('passportPhoto').files[0];
            if (passportPhoto) {
                const validImageTypes = ['image/jpeg', 'image/png'];
                if (!validImageTypes.includes(passportPhoto.type)) {
                    e.preventDefault();
                    alert('Passport photo must be JPG or PNG format');
                    return false;
                }
                if (passportPhoto.size > maxPhotoSize) {
                    e.preventDefault();
                    alert('Passport photo size must be less than 2MB');
                    return false;
                }
            }

            return true;
        });
    </script>
</body>
</html>