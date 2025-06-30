<?php
require_once 'config/database.php';
require_once 'includes/functions.php';

if (!is_logged_in()) {
    redirect('login.php');
}

$database = new Database();
$db = $database->getConnection();

// Get user information
$user_query = "SELECT * FROM users WHERE id = ?";
$user_stmt = $db->prepare($user_query);
$user_stmt->execute([$_SESSION['user_id']]);
$user = $user_stmt->fetch(PDO::FETCH_ASSOC);

// Check if user has player registration
$player_query = "SELECT * FROM player_registrations WHERE user_id = ?";
$player_stmt = $db->prepare($player_query);
$player_stmt->execute([$_SESSION['user_id']]);
$player_registration = $player_stmt->fetch(PDO::FETCH_ASSOC);

// Get featured players for the carousel
$featured_query = "SELECT pr.*, u.email FROM player_registrations pr 
                   JOIN users u ON pr.user_id = u.id 
                   WHERE pr.registration_status = 'approved' 
                   ORDER BY pr.created_at DESC LIMIT 6";
$featured_stmt = $db->prepare($featured_query);
$featured_stmt->execute();
$featured_players = $featured_stmt->fetchAll(PDO::FETCH_ASSOC);

// Get notifications for the user
$notification_query = "SELECT * FROM notifications WHERE user_id = ? ORDER BY created_at DESC LIMIT 5";
$notification_stmt = $db->prepare($notification_query);
$notifications = $notification_stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>⚽ Player Dashboard - Ethio Scout</title>

  <!-- Fonts and Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200..1000&family=Rubik:wght@300..900&family=Bebas+Neue&family=Montserrat:wght@400;700&display=swap" rel="stylesheet">

  <style>
    :root {
      --primary:#3562A6;
      --secondary: #0E1EB5;
      --THERD:#0B0B0B;
      --FOURTH:#6594C0;
      --dark: #0C1E2E;
      --light: #F5F5F5;
      --accent: #078930;
      --text: #333333;
    }

    body {
      margin: 0;
      font-family: 'Montserrat', sans-serif;
      background-color: var(--light);
      color: var(--text);
      line-height: 1.6;
    }

    nav {
      background: linear-gradient(135deg, var(--dark) 0%, #000 100%);
      color: white;
      padding: 15px 5%;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      position: sticky;
      top: 0;
      z-index: 1000;
      border-bottom: 4px solid var(--primary);
    }

    .logo-container {
      display: flex;
      align-items: center;
    }

    .logo-container img {
      height: 50px;
      border-radius: 100%;
      margin-right: 15px;
      filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));
    }

    .logo-container::after {
      content: "ETHIO SCOUT";
      font-family: 'Bebas Neue', sans-serif;
      font-size: 1.8rem;
      color: var(--primary);
      letter-spacing: 1px;
      text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
    }

    .nav-links {
      display: flex;
      align-items: center;
      gap: 25px;
    }

    .nav-links a {
      text-decoration: none;
      color: white;
      font-weight: 600;
      font-size: 1rem;
      padding: 8px 12px;
      border-radius: 4px;
      transition: all 0.3s ease;
      position: relative;
    }

    .nav-links a:hover {
      color: var(--primary);
      transform: translateY(-2px);
    }

    .nav-links a::after {
      content: '';
      position: absolute;
      width: 0;
      height: 2px;
      bottom: 0;
      left: 0;
      background-color: var(--primary);
      transition: width 0.3s ease;
    }

    .nav-links a:hover::after {
      width: 100%;
    }

    .theme-toggle {
      cursor: pointer;
      padding: 8px;
      border-radius: 50%;
      transition: all 0.3s ease;
    }

    .theme-toggle:hover {
      background-color: rgba(255, 255, 255, 0.1);
      transform: rotate(15deg);
    }

    #theme-icon {
      font-size: 1.2rem;
      color: var(--primary);
    }

    .profile-dropdown {
      position: relative;
      display: flex;
      margin-left: 15px;
    }

    .profile-icon {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background-color: rgba(255, 255, 255, 0.1);
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .profile-icon i {
      font-size: 1.5rem;
      color: white;
    }

    .profile-icon:hover {
      background-color: var(--primary);
      transform: scale(1.1);
    }

    .profile-content {
      display: none;
      position: absolute;
      top: 50px;
      right: 0;
      background-color: white;
      min-width: 220px;
      box-shadow: 0 8px 16px rgba(0,0,0,0.2);
      z-index: 1000;
      border-radius: 8px;
      overflow: hidden;
      transition: all 0.3s ease;
    }

    .profile-content.active {
      display: block;
    }

    .profile-header {
      padding: 15px;
      background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
      color: white;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .profile-pic {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid white;
    }

    .profile-name {
      font-weight: 600;
      font-size: 0.9rem;
    }

    .profile-content a {
      color: var(--text);
      padding: 12px 16px;
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: 10px;
      font-size: 0.9rem;
      transition: all 0.2s ease;
    }

    .profile-content a:hover {
      background-color: #f5f5f5;
      color: var(--primary);
      padding-left: 20px;
    }

    .profile-content a:not(:last-child) {
      border-bottom: 1px solid #eee;
    }

    /* Dark Mode */
    .dark-mode {
      --primary: #FFCC00;
      --secondary: #DA1212;
      --dark: #121212;
      --light: #1E1E1E;
      --accent: #078930;
      --text: #E0E0E0;
      background-color: var(--light);
      color: var(--text);
    }

    .dark-mode nav {
      background: linear-gradient(135deg, #000000 0%, #1E1E1E 100%);
      border-bottom: 4px solid var(--secondary);
    }

    .dark-mode .profile-content {
      background-color: #2D2D2D;
      border: 1px solid #444;
    }

    .dark-mode .profile-content a {
      color: #E0E0E0;
    }

    .dark-mode .profile-content a:hover {
      background-color: #3D3D3D;
      color: var(--primary);
    }

    .dark-mode .profile-content a:not(:last-child) {
      border-bottom: 1px solid #444;
    }

    /* Hero Section */
    #container {
      background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('https://images.unsplash.com/photo-1574629810360-7efbbe195018?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1920&q=80') no-repeat center center/cover;
      height: 90vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      color: white;
      position: relative;
      overflow: hidden;
    }

    .sliding-header {
      font-family: 'Bebas Neue', sans-serif;
      font-size: 4.5rem;
      letter-spacing: 3px;
      margin-bottom: 20px;
      color: var(--primary);
      text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
      position: relative;
      overflow: hidden;
    }

    .sliding-header span {
      animation: slideIn 1.5s ease-out forwards;
      opacity: 0;
      transform: translateY(50px);
    }

    @keyframes slideIn {
      to {
          opacity: 1;
          transform: translateY(0);
      }
    }

    .container p {
      font-size: 1.3rem;
      max-width: 800px;
      margin: 0 auto 40px;
      line-height: 1.6;
      text-shadow: 1px 1px 2px rgba(0,0,0,0.8);
    }

    .container button {
      background-color: var(--primary);
      color: var(--dark);
      border: none;
      padding: 15px 40px;
      font-size: 1.1rem;
      font-weight: 700;
      border-radius: 50px;
      cursor: pointer;
      transition: all 0.3s ease;
      box-shadow: 0 4px 15px rgba(218, 18, 18, 0.4);
      text-transform: uppercase;
      letter-spacing: 1px;
      position: relative;
      overflow: hidden;
    }

    .container button:hover {
      background-color: var(--secondary);
      color: white;
      transform: translateY(-3px);
      box-shadow: 0 6px 20px rgba(218, 18, 18, 0.6);
    }

    /* Dashboard Styles */
    .dashboard-container {
      display: none;
      padding: 30px 5%;
      max-width: 1200px;
      margin: 0 auto;
    }

    .dashboard-container.active {
      display: block;
    }

    .dashboard-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 30px;
      padding-bottom: 15px;
      border-bottom: 2px solid var(--primary);
    }

    .dashboard-title {
      font-family: 'Bebas Neue', sans-serif;
      font-size: 2.5rem;
      color: var(--primary);
      margin: 0;
    }

    .dashboard-content {
      background-color: white;
      border-radius: 8px;
      padding: 20px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .dark-mode .dashboard-content {
      background-color: #2D2D2D;
    }

    /* Profile Dashboard */
    .profile-info {
      display: flex;
      gap: 30px;
      margin-bottom: 30px;
    }

    .profile-avatar {
      width: 150px;
      height: 150px;
      border-radius: 50%;
      object-fit: cover;
      border: 5px solid var(--primary);
    }

    .profile-details {
      flex: 1;
    }

    .profile-name-large {
      font-size: 1.8rem;
      margin: 0 0 10px 0;
      color: var(--primary);
    }

    .profile-stats {
      display: flex;
      gap: 20px;
      margin-bottom: 20px;
    }

    .stat-item {
      text-align: center;
      padding: 10px 20px;
      background-color: #f5f5f5;
      border-radius: 8px;
    }

    .dark-mode .stat-item {
      background-color: #3D3D3D;
    }

    .stat-value {
      font-size: 1.5rem;
      font-weight: bold;
      color: var(--primary);
    }

    .stat-label {
      font-size: 0.9rem;
      color: var(--text);
    }

    /* Players Section */
    #player {
      padding: 80px 5%;
      background-color: #f9f9f9;
      position: relative;
    }

    #player::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 20px;
      background: linear-gradient(90deg, var(--secondary), var(--primary), var(--accent));
    }

    .player h1 {
      font-family: 'Bebas Neue', sans-serif;
      font-size: 3rem;
      color: var(--dark);
      text-align: center;
      margin-bottom: 50px;
      letter-spacing: 2px;
      position: relative;
    }

    .player h1::after {
      content: '';
      position: absolute;
      bottom: -10px;
      left: 50%;
      transform: translateX(-50%);
      width: 100px;
      height: 4px;
      background-color: var(--primary);
    }

    .input {
      max-width: 1200px;
      margin: 0 auto;
      position: relative;
    }

    #carousel {
      display: flex;
      gap: 30px;
      padding: 20px;
      overflow-x: auto;
      scroll-snap-type: x mandatory;
      scroll-behavior: smooth;
      -webkit-overflow-scrolling: touch;
      margin-bottom: 30px;
    }

    #carousel::-webkit-scrollbar {
      height: 8px;
    }

    #carousel::-webkit-scrollbar-track {
      background: #f1f1f1;
      border-radius: 10px;
    }

    #carousel::-webkit-scrollbar-thumb {
      background: var(--primary);
      border-radius: 10px;
    }

    #carousel::-webkit-scrollbar-thumb:hover {
      background: var(--secondary);
    }

    .item {
      scroll-snap-align: start;
      flex: 0 0 280px;
      background-color: white;
      border-radius: 15px;
      padding: 25px;
      box-shadow: 0 10px 20px rgba(0,0,0,0.1);
      text-align: center;
      transition: all 0.3s ease;
      border-top: 5px solid var(--primary);
    }

    .item:hover {
      transform: translateY(-10px);
      box-shadow: 0 15px 30px rgba(0,0,0,0.15);
    }

    .item img {
      width: 120px;
      height: 120px;
      border-radius: 50%;
      object-fit: cover;
      border: 5px solid var(--light);
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
      margin-bottom: 20px;
    }

    .name {
      font-size: 1.3rem;
      font-weight: 700;
      color: var(--dark);
      margin-bottom: 5px;
    }

    .occupation {
      font-size: 0.9rem;
      color: #666;
      margin-bottom: 10px;
    }

    .occupation b {
      color: var(--secondary);
    }

    .occupations {
      color: var(--primary);
      font-size: 1.2rem;
      margin-top: 15px;
    }

    .nav-btn {
      background-color: var(--primary);
      color: white;
      border: none;
      width: 50px;
      height: 50px;
      border-radius: 50%;
      font-size: 1.2rem;
      cursor: pointer;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      z-index: 2;
    }

    .nav-btn:hover {
      background-color: var(--secondary);
      transform: translateY(-50%) scale(1.1);
    }

    #prevBtn {
      left: -25px;
    }

    #nextBtn {
      right: -25px;
    }

    /* Form Styles */
    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      display: block;
      margin-bottom: 8px;
      font-weight: 600;
    }

    .form-control {
      width: 100%;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 4px;
      font-family: inherit;
      box-sizing: border-box;
    }

    .dark-mode .form-control {
      background-color: #3D3D3D;
      border-color: #555;
      color: white;
    }

    .save-button {
      background-color: var(--primary);
      color: white;
      border: none;
      padding: 12px 25px;
      border-radius: 4px;
      cursor: pointer;
      font-weight: bold;
    }

    .save-button:hover {
      background-color: var(--secondary);
    }

    /* Status badges */
    .status-badge {
      padding: 5px 10px;
      border-radius: 15px;
      font-size: 0.9em;
      font-weight: bold;
    }

    .status-pending {
      background-color: #fff3cd;
      color: #856404;
    }

    .status-approved {
      background-color: #d4edda;
      color: #155724;
    }

    .status-rejected {
      background-color: #f8d7da;
      color: #721c24;
    }

    /* Video Post Section */
    .video-form {
      margin-top: 20px;
    }

    .video-preview {
      width: 100%;
      max-height: 400px;
      background-color: #f0f0f0;
      margin-bottom: 20px;
      display: none;
    }

    .video-thumbnail {
      width: 100%;
      height: auto;
      border-radius: 8px;
    }

    /* Video Chat Section */
    .video-chat-container {
      display: flex;
      flex-direction: column;
      gap: 20px;
    }

    .video-container {
      display: flex;
      gap: 20px;
    }

    .video-box {
      flex: 1;
      border: 2px solid var(--primary);
      border-radius: 8px;
      padding: 10px;
      background-color: #f5f5f5;
    }

    .video-box video {
      width: 100%;
      border-radius: 4px;
    }

    .chat-controls {
      display: flex;
      gap: 10px;
      justify-content: center;
    }

    .chat-button {
      padding: 10px 20px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-weight: bold;
    }

    .start-call {
      background-color: var(--primary);
      color: white;
    }

    .end-call {
      background-color: var(--secondary);
      color: white;
    }
   /* Video Chat Section zoom */
   #zoom-meeting-container {
  width: 100%;
  height: 400px;
  background-color: #f0f0f0;
  border-radius: 8px;
  margin-bottom: 20px;
}

/* For the meeting iframe */
#zoom-meeting-container iframe {
  width: 100%;
  height: 100%;
  border: none;
  border-radius: 8px;
}
    /* Notification Section */
    .notification-list {
      list-style-type: none;
      padding: 0;
    }

    .notification-item {
      padding: 15px;
      border-bottom: 1px solid #eee;
      transition: all 0.3s ease;
    }

    .notification-item:hover {
      background-color: #f9f9f9;
    }

    .notification-time {
      font-size: 0.8rem;
      color: #777;
      margin-top: 5px;
    }

    .unread-notification {
      background-color: #e6f7ff;
      border-left: 3px solid var(--primary);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      nav {
        flex-direction: column;
        padding: 15px;
      }
      
      .logo-container {
        margin-bottom: 15px;
      }
      
      .nav-links {
        width: 100%;
        justify-content: space-between;
        gap: 10px;
      }
      
      .sliding-header {
        font-size: 2.5rem;
      }
      
      .profile-info {
        flex-direction: column;
        text-align: center;
      }
      
      .profile-stats {
        justify-content: center;
      }

      .video-container {
        flex-direction: column;
      }
    }
  </style>
</head>

<body>
  <!-- Navigation -->
  <nav>
    <div class="logo-container">
      <img src="images/Football Award Vector.jpg" alt="Ethio Scout Logo">
    </div>
    <div class="nav-links">
      <a href="#container">Home</a>
      <a href="#player">Players</a>
      <a href="home.php">Main Site</a>

      <div class="theme-toggle">
        <i class="fas fa-moon" id="theme-icon"></i>
      </div>

      <div class="profile-dropdown">
        <div class="profile-icon">
          <i class="fas fa-user-circle"></i>
        </div>
        <div class="profile-content">
          <div class="profile-header">
            <img src="<?php echo $player_registration['photo_path'] ? 'uploads/' . $player_registration['photo_path'] : '/placeholder.svg?height=40&width=40'; ?>" alt="Profile Picture" class="profile-pic">
            <span class="profile-name"><?php echo htmlspecialchars($user['email']); ?></span>
          </div>
          <a href="#" class="dashboard-link" data-dashboard="profile"><i class="fas fa-user"></i> View Profile</a>
          <?php if (!$player_registration): ?>
            <a href="player-registration.php"><i class="fas fa-user-plus"></i> Complete Registration</a>
          <?php endif; ?>
          <a href="#" class="dashboard-link" data-dashboard="video"><i class="fas fa-video"></i> Post Video</a>
          <a href="#" class="dashboard-link" data-dashboard="video-chat"><i class="fas fa-video"></i> Start Video Chat</a>
          <a href="#" class="dashboard-link" data-dashboard="notification"><i class="fas fa-bell"></i> Notifications</a>
          <a href="#" class="dashboard-link" data-dashboard="settings"><i class="fas fa-cog"></i> Settings</a>
          <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
      </div>
    </div>
  </nav>

  <!-- Main Content Area -->
  <main id="main-content">
    <!-- Hero Section -->
    <div id="container">
        <div class="container">
            <div class="sliding-header">
                <span>ETHIO ONLINE SCOUTING SYSTEM</span>
            </div>
            <p>"Empower youth through Ethiopia's Online Scouting System! Build skills, foster leadership, and unite for a brighter, impactful future together!"</p>
        </div>
    </div>

    <!-- Profile Dashboard -->
    <div class="dashboard-container" id="profile-dashboard">
      <div class="dashboard-header">
        <h2 class="dashboard-title">My Profile</h2>
      </div>
      <div class="dashboard-content">
        <?php if ($player_registration): ?>
          <div class="profile-info">
            <img src="<?php echo $player_registration['photo_path'] ? 'uploads/' . $player_registration['photo_path'] : '/placeholder.svg?height=150&width=150'; ?>" alt="Profile Picture" class="profile-avatar">
            <div class="profile-details">
              <h3 class="profile-name-large"><?php echo htmlspecialchars($player_registration['first_name'] . ' ' . $player_registration['last_name']); ?></h3>
              <p>Football Player | <?php echo htmlspecialchars($player_registration['city'] . ', ' . $player_registration['country']); ?></p>
              <p>Registration Status: 
                <span class="status-badge status-<?php echo $player_registration['registration_status']; ?>">
                  <?php echo ucfirst($player_registration['registration_status']); ?>
                </span>
              </p>
              <div class="profile-stats">
                <div class="stat-item">
                  <div class="stat-value"><?php echo calculate_age($player_registration['birth_day'], $player_registration['birth_month'], $player_registration['birth_year']); ?></div>
                  <div class="stat-label">Age</div>
                </div>
                <div class="stat-item">
                  <div class="stat-value"><?php echo $player_registration['weight']; ?>kg</div>
                  <div class="stat-label">Weight</div>
                </div>
                <div class="stat-item">
                  <div class="stat-value"><?php echo ucfirst($player_registration['gender']); ?></div>
                  <div class="stat-label">Gender</div>
                </div>
              </div>
            </div>
          </div>
          <div class="profile-bio">
            <h4>Registration Details</h4>
            <p><strong>Date of Birth:</strong> <?php echo $player_registration['birth_day'] . '/' . $player_registration['birth_month'] . '/' . $player_registration['birth_year']; ?></p>
            <p><strong>Phone:</strong> <?php echo htmlspecialchars($player_registration['phone']); ?></p>
            <p><strong>Registered:</strong> <?php echo date('F j, Y', strtotime($player_registration['created_at'])); ?></p>
            <?php if ($player_registration['passport_number']): ?>
              <p><strong>Passport:</strong> <?php echo htmlspecialchars($player_registration['passport_number']); ?></p>
            <?php endif; ?>
          </div>
        <?php else: ?>
          <div class="profile-info">
            <img src="/placeholder.svg?height=150&width=150" alt="Profile Picture" class="profile-avatar">
            <div class="profile-details">
              <h3 class="profile-name-large">Welcome!</h3>
              <p>Complete your player registration to get started</p>
              <a href="player-registration.php" class="save-button">Complete Registration</a>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>

    <!-- Video Post Dashboard -->
    <div class="dashboard-container" id="video-dashboard">
      <div class="dashboard-header">
        <h2 class="dashboard-title">Post Your Video</h2>
      </div>
      <div class="dashboard-content">
        <form class="video-form" method="POST" action="upload-video.php" enctype="multipart/form-data">
          <div class="form-group">
            <label for="video-title">Video Title</label>
            <input type="text" id="video-title" name="video_title" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="video-description">Description</label>
            <textarea id="video-description" name="video_description" class="form-control" rows="4"></textarea>
          </div>
          <div class="form-group">
            <label for="video-file">Select Video File</label>
            <input type="file" id="video-file" name="video_file" class="form-control" accept="video/*" required>
          </div>
          <div class="video-preview" id="video-preview">
            <video controls class="video-thumbnail" id="video-thumbnail"></video>
          </div>
          <button type="submit" class="save-button">Upload Video</button>
        </form>
      </div>
    </div>

    <!-- Video Chat Dashboard -->
 
<div class="dashboard-container" id="video-chat-dashboard">
  <div class="dashboard-header">
    <h2 class="dashboard-title">Zoom Video Chat</h2>
  </div>
  <div class="dashboard-content">
    <div class="video-chat-container">
      <div class="form-group">
        <label for="meeting-number">Meeting ID</label>
        <input type="text" id="meeting-number" class="form-control" placeholder="Enter Meeting ID">
      </div>
      <div class="form-group">
        <label for="meeting-password">Meeting Password (if required)</label>
        <input type="text" id="meeting-password" class="form-control" placeholder="Enter Password">
      </div>
      <div class="form-group">
        <label for="display-name">Your Name</label>
       <input type="text" id="display-name" class="form-control" value="<?php echo $player_registration ? htmlspecialchars($player_registration['first_name'] . ' ' . htmlspecialchars($player_registration['last_name'])) : htmlspecialchars($user['email']); ?>" placeholder="Your Name">      </div>
      
      <div class="video-container">
        <div class="video-box">
          <h3>Your Video</h3>
          <div id="zoom-meeting-container"></div>
        </div>
      </div>
      
      <div class="chat-controls">
        <button class="chat-button start-call" id="join-meeting">Join Meeting</button>
        <button class="chat-button end-call" id="leave-meeting" disabled>Leave Meeting</button>
      </div>
    </div>
  </div>
</div>

    
    <!-- Notification Dashboard -->
    <div class="dashboard-container" id="notification-dashboard">
      <div class="dashboard-header">
        <h2 class="dashboard-title">Notifications</h2>
      </div>
      <div class="dashboard-content">
        <?php if (!empty($notifications)): ?>
          <ul class="notification-list">
            <?php foreach ($notifications as $notification): ?>
              <li class="notification-item <?php echo $notification['is_read'] ? '' : 'unread-notification'; ?>">
                <div class="notification-message"><?php echo htmlspecialchars($notification['message']); ?></div>
                <div class="notification-time">
                  <?php echo date('M j, Y g:i a', strtotime($notification['created_at'])); ?>
                </div>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php else: ?>
          <p>No notifications to display.</p>
        <?php endif; ?>
      </div>
    </div>

    <!-- Settings Dashboard -->
    <div class="dashboard-container" id="settings-dashboard">
      <div class="dashboard-header">
        <h2 class="dashboard-title">Account Settings</h2>
      </div>
      <div class="dashboard-content">
        <form class="settings-form" method="POST" action="update-profile.php">
          <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" readonly>
          </div>
          <div class="form-group">
            <label for="new-password">New Password (leave blank to keep current)</label>
            <input type="password" id="new-password" name="new_password" class="form-control" placeholder="Enter new password">
          </div>
          <div class="form-group">
            <label for="confirm-password">Confirm New Password</label>
            <input type="password" id="confirm-password" name="confirm_password" class="form-control" placeholder="Confirm new password">
          </div>
          <button type="submit" class="save-button">Save Changes</button>
        </form>
      </div>
    </div>

    <!-- Featured Players Section -->
    <div id="player">
        <div class="player"><h1>Featured Players</h1></div>

        <div class="input">
            <button id="prevBtn" class="nav-btn"><i class="fas fa-chevron-left"></i></button>
            <button id="nextBtn" class="nav-btn"><i class="fas fa-chevron-right"></i></button>

            <main id="carousel">
                <?php foreach ($featured_players as $player): ?>
                <div class="item">
                    <img src="<?php echo $player['photo_path'] ? 'uploads/' . $player['photo_path'] : '/placeholder.svg?height=120&width=120'; ?>" alt="<?php echo htmlspecialchars($player['first_name']); ?>">
                    <h3 class="name"><?php echo htmlspecialchars($player['first_name'] . ' ' . $player['last_name']); ?></h3>
                    <p class="occupation"><b>Date Of Birth</b><br><?php echo $player['birth_day'] . '/' . $player['birth_month'] . '/' . $player['birth_year']; ?></p>
                    <p class="occupation"><b>Age</b><br><?php echo calculate_age($player['birth_day'], $player['birth_month'], $player['birth_year']); ?> years</p>
                    <p class="occupation"><b>Location</b><br><?php echo htmlspecialchars($player['city']); ?></p>
                    <p class="occupations">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </p>
                </div>
                <?php endforeach; ?>
                
                <?php if (empty($featured_players)): ?>
                <div class="item">
                    <img src="/placeholder.svg?height=120&width=120" alt="No players">
                    <h3 class="name">No Featured Players</h3>
                    <p class="occupation">Be the first to register!</p>
                </div>
                <?php endif; ?>
            </main>
        </div>
    </div>
  </main>

  <!-- JavaScript -->
  <script>
    // Dark mode toggle
    const themeIcon = document.getElementById('theme-icon');
    const body = document.body;

    const savedTheme = localStorage.getItem('theme');
    if (savedTheme) {
      body.classList.add(savedTheme);
      updateThemeIcon();
    } else if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
      body.classList.add('dark-mode');
      updateThemeIcon();
    }

    themeIcon.addEventListener('click', () => {
      const isDark = body.classList.contains('dark-mode');
      body.classList.toggle('dark-mode', !isDark);
      body.classList.toggle('light-mode', isDark);
      updateThemeIcon();
      localStorage.setItem('theme', !isDark ? 'dark-mode' : 'light-mode');
    });

    function updateThemeIcon() {
      if (body.classList.contains('dark-mode')) {
        themeIcon.classList.replace('fa-moon', 'fa-sun');
      } else {
        themeIcon.classList.replace('fa-sun', 'fa-moon');
      }
    }

    // Profile dropdown
    document.addEventListener('DOMContentLoaded', () => {
      const profileDropdown = document.querySelector('.profile-dropdown');
      const profileContent = profileDropdown.querySelector('.profile-content');

      profileDropdown.addEventListener('click', function (e) {
        e.stopPropagation();
        profileContent.classList.toggle('active');
      });

      document.addEventListener('click', function () {
        profileContent.classList.remove('active');
      });
    });

    // Dashboard navigation
    document.querySelectorAll('.dashboard-link').forEach(link => {
      link.addEventListener('click', function(e) {
        e.preventDefault();
        const dashboardId = this.getAttribute('data-dashboard');
        
        // Hide all dashboards
        document.querySelectorAll('.dashboard-container').forEach(dashboard => {
          dashboard.classList.remove('active');
        });
        
        // Show selected dashboard
        if (dashboardId) {
          document.getElementById(`${dashboardId}-dashboard`).classList.add('active');
        }
        
        // Close dropdown
        document.querySelector('.profile-content').classList.remove('active');
      });
    });

    // Carousel navigation
    const carousel = document.getElementById('carousel');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const items = document.querySelectorAll('.item');

    if (items.length > 0) {
      let currentIndex = 0;
      const itemWidth = items[0].offsetWidth + 30; // width + gap

      nextBtn.addEventListener('click', () => {
        if (currentIndex < items.length - 1) {
          currentIndex++;
          carousel.scrollLeft = currentIndex * itemWidth;
        }
      });

      prevBtn.addEventListener('click', () => {
        if (currentIndex > 0) {
          currentIndex--;
          carousel.scrollLeft = currentIndex * itemWidth;
        }
      });
    }

    // Animate sliding header letters
    const slidingHeader = document.querySelector('.sliding-header span');
    if (slidingHeader) {
      const letters = slidingHeader.textContent.split('');
      slidingHeader.textContent = '';
      
      letters.forEach((letter, i) => {
        const span = document.createElement('span');
        span.textContent = letter;
        span.style.animationDelay = `${i * 0.1}s`;
        slidingHeader.appendChild(span);
      });
    }

   // Zoom Meeting SDK variables
let zoomClient, meeting;

// Initialize Zoom SDK
function initializeZoomSDK() {
  ZoomMtg.setZoomJSLib('https://source.zoom.us/2.16.0/lib', '/av');
  
  ZoomMtg.preLoadWasm();
  ZoomMtg.prepareWebSDK();
  
  // Set language to English
  ZoomMtg.i18n.load('en-US');
  ZoomMtg.i18n.reload('en-US');
}

// Join Zoom meeting function
async function joinMeeting(meetingNumber, passWord, displayName) {
  try {
    // Required fields for joining meeting
    const meetConfig = {
      sdkKey: 'YOUR_SDK_KEY', // Replace with your Zoom SDK Key
      meetingNumber: meetingNumber,
      passWord: passWord,
      userName: displayName,
      userEmail: '<?php echo htmlspecialchars($user["email"]); ?>',
      tk: '', // Leave empty if using SDK key
      zak: '', // Leave empty if using SDK key
      signature: '', // Leave empty if using SDK key
      leaveUrl: window.location.href,
      role: 0 // 1 for host, 0 for participant
    };

    // Initialize the client
    ZoomMtg.init({
      leaveUrl: meetConfig.leaveUrl,
      success: function() {
        // Join the meeting
        ZoomMtg.join({
          meetingNumber: meetConfig.meetingNumber,
          userName: meetConfig.userName,
          signature: meetConfig.signature,
          sdkKey: meetConfig.sdkKey,
          userEmail: meetConfig.userEmail,
          passWord: meetConfig.passWord,
          tk: meetConfig.tk,
          zak: meetConfig.zak,
          success: function(res) {
            console.log('Zoom meeting joined successfully');
            document.getElementById('join-meeting').disabled = true;
            document.getElementById('leave-meeting').disabled = false;
          },
          error: function(res) {
            console.error('Zoom meeting join error', res);
            alert('Failed to join meeting: ' + res.reason);
          }
        });
      },
      error: function(res) {
        console.error('Zoom SDK init error', res);
        alert('Failed to initialize Zoom: ' + res.reason);
      }
    });
  } catch (error) {
    console.error('Error joining meeting:', error);
    alert('Error joining meeting: ' + error.message);
  }
}

// Leave meeting function
function leaveMeeting() {
  if (meeting) {
    ZoomMtg.leaveMeeting({});
    document.getElementById('join-meeting').disabled = false;
    document.getElementById('leave-meeting').disabled = true;
  }
}

// Initialize Zoom when page loads
document.addEventListener('DOMContentLoaded', () => {
  initializeZoomSDK();
  
  // Set up join meeting button
  document.getElementById('join-meeting').addEventListener('click', () => {
    const meetingNumber = document.getElementById('meeting-number').value.trim();
    const passWord = document.getElementById('meeting-password').value.trim();
    const displayName = document.getElementById('display-name').value.trim();
    
    if (!meetingNumber) {
      alert('Please enter a meeting ID');
      return;
    }
    
    joinMeeting(meetingNumber, passWord, displayName);
  });
  
  // Set up leave meeting button
  document.getElementById('leave-meeting').addEventListener('click', leaveMeeting);
});
  </script>
</body>
</html>