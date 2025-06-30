<?php
require_once 'config/database.php';
require_once 'includes/functions.php';


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Featured player</title>
    <meta name="description" content="<?php echo $meta_description; ?>">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@400;600;700;900&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Favicon -->
    <link rel="icon" href="https://footballtalentscout.net/home/wp-content/uploads/2024/01/cropped-JJJJJJJJJ-1-32x32.jpg" sizes="32x32">
    
    <style>
        /* Base Styles */
        :root {
            --primary-color: #ff1800;
            --primary-dark: #d41400;
            --primary-light: rgba(255, 24, 0, 0.1);
            --secondary-color: #0056b3;
            --dark-color: #171a22;
            --light-color: #f6f7f7;
            --text-color: #282828;
            --white: #ffffff;
            --border-radius: 8px;
            --box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            --transition: all 0.3s ease;
            --gradient: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        }
        
        body {
            font-family: 'Montserrat', sans-serif;
            color: var(--text-color);
            margin: 0;
            padding: 0;
            line-height: 1.6;
            background-color: #f9f9f9;
        }
        
        .logo-container {
            display: flex;
            align-items: center;
            padding: 10px 0;
        }

        .logo-container img {
            height: 60px;
            border-radius: 50%;
            margin-right: 15px;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));
            border: 3px solid var(--primary-color);
        }

        .logo-container::after {
            content: "ETHIO SCOUT";
            font-family: 'Bebas Neue', sans-serif;
            font-size: 2.2rem;
            color: var(--primary-color);
            letter-spacing: 2px;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.2);
        }
        
        a {
            color: var(--primary-color);
            text-decoration: none;
            transition: var(--transition);
        }
        
        a:hover {
            color: var(--primary-dark);
        }
        
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }
        
        /* Header */
        header {
            background-color: var(--white);
            padding: 10px 0;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .nav-links {
            display: flex;
            gap: 15px;
        }
        
        .nav-links a {
            font-weight: 600;
            padding: 8px 15px;
            border-radius: var(--border-radius);
            color: var(--dark-color);
            position: relative;
        }
        
        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 15px;
            width: 0;
            height: 2px;
            background: var(--primary-color);
            transition: var(--transition);
        }
        
        .nav-links a:hover::after {
            width: calc(100% - 30px);
        }
        
        .nav-links a.active {
            color: var(--primary-color);
        }
        
        /* Main Content */
        .page-header {
            padding: 80px 0;
            text-align: center;
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), 
                        url('https://images.unsplash.com/photo-1579952363873-27f3bade9f55?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1920&q=80') center/cover no-repeat;
            color: white;
            position: relative;
        }
        
        .page-title {
            font-family: 'Bebas Neue', sans-serif;
            font-weight: 400;
            font-size: 4rem;
            color: var(--white);
            margin-bottom: 20px;
            position: relative;
            letter-spacing: 2px;
        }
        
        .page-title::after {
            content: '';
            display: block;
            width: 100px;
            height: 4px;
            background: var(--primary-color);
            margin: 20px auto;
        }
        
        .page-header p {
            font-size: 1.2rem;
            max-width: 700px;
            margin: 0 auto;
            position: relative;
            opacity: 0.9;
        }
        
        /* Filter Section */
        .player-filters {
            background: var(--white);
            padding: 20px;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            margin: -40px auto 40px;
            max-width: 1200px;
            position: relative;
            z-index: 2;
        }
        
        .filter-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }
        
        .filter-group {
            margin-bottom: 0;
        }
        
        .filter-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--dark-color);
        }
        
        .filter-group select, .filter-group input {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: var(--border-radius);
            font-family: inherit;
            transition: var(--transition);
        }
        
        .filter-group select:focus, .filter-group input:focus {
            border-color: var(--primary-color);
            outline: none;
            box-shadow: 0 0 0 3px var(--primary-light);
        }
        
        .filter-button {
            background: var(--gradient);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: var(--border-radius);
            cursor: pointer;
            font-weight: 600;
            font-size: 1rem;
            transition: var(--transition);
            align-self: flex-end;
        }
        
        .filter-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 24, 0, 0.3);
        }
        
        /* Player Grid */
        .players-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 30px;
            padding: 40px 0;
        }
        
        .player-card {
            background: var(--white);
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--box-shadow);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
        }
        
        .player-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.15);
        }
        
        .player-image-container {
            position: relative;
            overflow: hidden;
            height: 320px;
        }
        
        .player-image {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        .player-card:hover .player-image {
            transform: scale(1.05);
        }
        
        .player-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: var(--gradient);
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        
        .player-info {
            padding: 20px;
            position: relative;
        }
        
        .player-name {
            font-family: 'Inter', sans-serif;
            font-weight: 700;
            font-size: 1.4rem;
            margin: 0 0 5px;
            color: var(--dark-color);
        }
        
        .player-club {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .player-club i {
            color: var(--primary-color);
        }
        
        .player-stats {
            display: flex;
            gap: 15px;
            margin: 15px 0;
        }
        
        .stat-item {
            text-align: center;
        }
        
        .stat-value {
            font-weight: 700;
            font-size: 1.2rem;
            color: var(--primary-color);
        }
        
        .stat-label {
            font-size: 0.7rem;
            text-transform: uppercase;
            color: #777;
            letter-spacing: 0.5px;
        }
        
        .player-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid rgba(0,0,0,0.1);
        }
        
        .player-category {
            display: inline-block;
            background: var(--primary-light);
            color: var(--primary-color);
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .action-buttons {
            display: flex;
            gap: 10px;
        }
        
        .like-btn, .dislike-btn {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1.1rem;
            padding: 5px 10px;
            border-radius: var(--border-radius);
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .like-btn {
            color: #4CAF50;
        }
        
        .dislike-btn {
            color: #F44336;
        }
        
        .like-btn:hover {
            background-color: rgba(76, 175, 80, 0.1);
        }
        
        .dislike-btn:hover {
            background-color: rgba(244, 67, 54, 0.1);
        }
        
        .like-btn.active {
            color: white;
            background-color: #4CAF50;
        }
        
        .dislike-btn.active {
            color: white;
            background-color: #F44336;
        }
        
        .likes-count, .dislikes-count {
            font-size: 0.9rem;
            font-weight: 500;
        }
        
        .view-profile {
            display: inline-block;
            background: var(--gradient);
            color: white;
            padding: 8px 20px;
            border-radius: var(--border-radius);
            font-weight: 600;
            font-size: 0.9rem;
            transition: var(--transition);
            margin-top: 10px;
            width: 100%;
            text-align: center;
        }
        
        .view-profile:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 24, 0, 0.3);
        }
        
        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin: 40px 0;
        }
        
        .pagination a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            font-weight: 600;
            transition: var(--transition);
            color: var(--dark-color);
            border: 1px solid #ddd;
        }
        
        .pagination a:hover {
            background-color: var(--primary-light);
            border-color: var(--primary-color);
        }
        
        .pagination a.active {
            background: var(--gradient);
            color: white;
            border-color: var(--primary-color);
        }
        
        .pagination a.arrow {
            font-size: 0.9rem;
            width: auto;
            padding: 0 15px;
            border-radius: 20px;
        }
        
        /* Footer */
        footer {
            background-color: var(--dark-color);
            color: var(--white);
            padding: 80px 0 30px;
            position: relative;
            clip-path: polygon(0 5%, 100% 0, 100% 100%, 0% 100%);
        }
        
        footer::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: var(--gradient);
        }
        
        .footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            margin-bottom: 40px;
        }
        
        .footer-col {
            position: relative;
        }
        
        .footer-logo {
            max-width: 250px;
            margin-bottom: 20px;
            filter: brightness(0) invert(1);
        }
        
        .footer-title {
            font-family: 'Inter', sans-serif;
            font-weight: 700;
            font-size: 1.3rem;
            margin-bottom: 20px;
            color: var(--white);
            position: relative;
            padding-bottom: 10px;
        }
        
        .footer-title::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background: var(--primary-color);
        }
        
        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .footer-links li {
            margin-bottom: 12px;
        }
        
        .footer-links a {
            color: rgba(255,255,255,0.8);
            transition: var(--transition);
            display: block;
            padding: 5px 0;
        }
        
        .footer-links a:hover {
            color: var(--white);
            transform: translateX(5px);
        }
        
        .social-links {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }
        
        .social-links a {
            color: var(--white);
            font-size: 1.3rem;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255,255,255,0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
        }
        
        .social-links a:hover {
            background: var(--gradient);
            transform: translateY(-3px);
        }
        
        .newsletter {
            margin-top: 20px;
        }
        
        .newsletter input {
            width: 100%;
            padding: 12px 15px;
            border: none;
            border-radius: var(--border-radius);
            margin-bottom: 10px;
            font-family: inherit;
        }
        
        .newsletter button {
            background: var(--gradient);
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: var(--border-radius);
            cursor: pointer;
            font-weight: 600;
            width: 100%;
            transition: var(--transition);
        }
        
        .newsletter button:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }
        
        .copyright {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid rgba(255,255,255,0.1);
            color: rgba(255,255,255,0.7);
            font-size: 0.9rem;
        }
        
        /* Responsive */
        @media (max-width: 992px) {
            .page-title {
                font-size: 3rem;
            }
            
            .players-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            }
        }
        
        @media (max-width: 768px) {
            .header-container {
                flex-direction: column;
                gap: 15px;
            }
            
            .nav-links {
                flex-wrap: wrap;
                justify-content: center;
            }
            
            .page-title {
                font-size: 2.5rem;
            }
            
            .page-header {
                padding: 60px 0;
            }
            
            .player-filters {
                margin-top: -30px;
            }
            
            .filter-grid {
                grid-template-columns: 1fr;
            }
            
            .players-grid {
                grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
                gap: 20px;
            }
        }
        
        @media (max-width: 576px) {
            .page-title {
                font-size: 2rem;
            }
            
            .pagination {
                flex-wrap: wrap;
            }
            
            .pagination a.arrow {
                display: none;
            }
            
            .footer-grid {
                grid-template-columns: 1fr;
            }
            
            footer {
                clip-path: polygon(0 3%, 100% 0, 100% 100%, 0% 100%);
                padding-top: 60px;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="container header-container">
            <div class="logo-container">
                <img src="images/Football Award Vector.jpg" alt="ETHIO SCOUT Logo">
            </div>
            <div class="nav-links">
                <a href="home.php">Home</a>
                <a href="featured.php" class="active">Featured Players</a>
                <?php if (is_logged_in()): ?>
                    <a href="dashboard.php">Dashboard</a>
                <?php else: ?>
                    <a href="register.php">Register</a>
                <?php endif; ?>
            </div>
        </div>
    </header>
    
    <!-- Main Content -->
    <main>
        <section class="page-header">
            <div class="container">
                <h1 class="page-title">Featured Player</h1>
                <p>Discover the most promising football talents in Ethiopia</p>
            </div>
        </section>
        
        <!-- Player Filters -->
        <div class="container">
            <div class="player-filters">
                <div class="filter-grid">
                    <div class="filter-group">
                        <label for="position">Position</label>
                        <select id="position">
                            <option value="">All Positions</option>
                            <option value="striker">Striker</option>
                            <option value="midfielder">Midfielder</option>
                            <option value="defender">Defender</option>
                            <option value="goalkeeper">Goalkeeper</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label for="age">Age Range</label>
                        <select id="age">
                            <option value="">All Ages</option>
                            <option value="5-10">5-10</option>
                            <option value="11-15">11-15</option>
                            <option value="16-18">16-18</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label for="region">Region</label>
                        <select id="region">
                            <option value="">All Regions</option>
                            <option value="addis-ababa">Addis Ababa</option>
                            <option value="oromia">Oromia</option>
                            <option value="amhara">Amhara</option>
                            <option value="snnpr">SNNPR</option>
                            <option value="tigray">Tigray</option>
                        </select>
                    </div>
                    <button class="filter-button">Filter Players</button>
                </div>
            </div>
        </div>
        
        <section class="container">
            <div class="players-grid">
                <?php foreach ($featured_players as $player): ?>
                <article class="player-card">
                    <div class="player-image-container">
                        <img src="<?php echo !empty($player['photo_path']) ? 'uploads/' . htmlspecialchars($player['photo_path']) : 'images/default-player.jpg'; ?>" 
                             alt="<?php echo htmlspecialchars($player['first_name'] . ' ' . $player['last_name']); ?>" class="player-image">
                        <?php if ($player['is_featured']): ?>
                            <span class="player-badge">Featured</span>
                        <?php endif; ?>
                    </div>
                    <div class="player-info">
                        <h3 class="player-name"><?php echo htmlspecialchars($player['first_name'] . ' ' . $player['last_name']); ?></h3>
                        <div class="player-club">
                            <i class="fas fa-map-marker-alt"></i>
                            <span><?php echo htmlspecialchars($player['city'] . ', Ethiopia'); ?></span>
                        </div>
                        <div class="player-stats">
                            <div class="stat-item">
                                <div class="stat-value"><?php echo calculate_age($player['birth_day'], $player['birth_month'], $player['birth_year']); ?></div>
                                <div class="stat-label">Age</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-value"><?php echo htmlspecialchars($player['height']); ?>m</div>
                                <div class="stat-label">Height</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-value"><?php echo htmlspecialchars(ucfirst($player['preferred_foot'])); ?></div>
                                <div class="stat-label">Foot</div>
                            </div>
                        </div>
                        <span class="player-category"><?php echo htmlspecialchars(ucfirst($player['position'])); ?></span>
                        <a href="profile.php?id=<?php echo $player['id']; ?>" class="view-profile">View Profile</a>
                        <div class="player-meta">
                            <div class="action-buttons">
                                <button class="like-btn" onclick="toggleLike(this, 'like<?php echo $player['id']; ?>')">
                                    <i class="fas fa-thumbs-up"></i>
                                    <span class="likes-count"><?php echo $player['likes'] ?? 0; ?></span>
                                </button>
                                <button class="dislike-btn" onclick="toggleLike(this, 'dislike<?php echo $player['id']; ?>')">
                                    <i class="fas fa-thumbs-down"></i>
                                    <span class="dislikes-count"><?php echo $player['dislikes'] ?? 0; ?></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </article>
                <?php endforeach; ?>
                
                <?php if (empty($featured_players)): ?>
                    <p>No featured players found. Check back later!</p>
                <?php endif; ?>
            </div>
            
            <!-- Pagination -->
            <div class="pagination">
                <a href="#" class="active">1</a>
                <a href="#">2</a>
                <a href="#">3</a>
                <a href="#">4</a>
                <a href="#">5</a>
                <span>...</span>
                <a href="#">24</a>
                <a href="#" class="arrow">Next <i class="fas fa-chevron-right"></i></a>
            </div>
        </section>
    </main>
    
    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-grid">
                <!-- About Column -->
                <div class="footer-col">
                    <div class="logo-container">
                        <img src="images/Football Award Vector.jpg" alt="Ethio Scout Logo">
                    </div>
                    <p>ETHIO SCOUT is dedicated to discovering and promoting Ethiopian football talent to the world. We connect promising players with professional clubs and opportunities.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                
                <!-- Quick Links -->
                <div class="footer-col">
                    <h3 class="footer-title">Quick Links</h3>
                    <ul class="footer-links">
                        <li><a href="home.php">Home</a></li>
                        <li><a href="featured.php">Featured Players</a></li>
                    
                    </ul>
                </div>
                
                <!-- Contact Info -->
                <div class="footer-col">
                    <h3 class="footer-title">Contact Us</h3>
                    <ul class="footer-links">
                        <li><i class="fas fa-map-marker-alt"></i> Addis Ababa, Ethiopia</li>
                        <li><i class="fas fa-phone"></i> +251 123 456 789</li>
                        <li><i class="fas fa-envelope"></i> info@ethioscout.com</li>
                    </ul>
                </div>
                
                <!-- Newsletter -->
                
            
            <div class="copyright">
                <p>&copy; <?php echo date('Y'); ?> ETHIO SCOUT - All Rights Reserved | Developed with <i class="fas fa-heart" style="color: var(--primary-color);"></i> for Ethiopian Football</p>
            </div>
        </div>
    </footer>

    <script>
        // Like/Dislike functionality
        function toggleLike(button, id) {
            // Get the parent action-buttons div
            const actionButtons = button.closest('.action-buttons');
            
            // Check if this is a like or dislike button
            const isLikeButton = button.classList.contains('like-btn');
            
            // Get the count element
            const countElement = button.querySelector(isLikeButton ? '.likes-count' : '.dislikes-count');
            
            // Check if the button is already active
            const isActive = button.classList.contains('active');
            
            // If already active, remove the active state and decrease count
            if (isActive) {
                button.classList.remove('active');
                countElement.textContent = parseInt(countElement.textContent) - 1;
            } else {
                // If not active, make it active and increase count
                button.classList.add('active');
                countElement.textContent = parseInt(countElement.textContent) + 1;
                
                // If this is a like button, ensure dislike is not active (and vice versa)
                const oppositeButton = isLikeButton 
                    ? actionButtons.querySelector('.dislike-btn') 
                    : actionButtons.querySelector('.like-btn');
                
                if (oppositeButton.classList.contains('active')) {
                    oppositeButton.classList.remove('active');
                    const oppositeCount = oppositeButton.querySelector(isLikeButton ? '.dislikes-count' : '.likes-count');
                    oppositeCount.textContent = parseInt(oppositeCount.textContent) - 1;
                }
            }
            
            // Save to localStorage
            localStorage.setItem(id, button.classList.contains('active') ? 'active' : 'inactive');
            
            // Send AJAX request to update database
            const playerId = id.replace(/like|dislike/g, '');
            const action = isLikeButton ? 'like' : 'dislike';
            const state = isActive ? 'remove' : 'add';
            
            fetch('update_likes.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    playerId: playerId,
                    action: action,
                    state: state
                })
            })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    console.error('Error updating likes:', data.error);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
        
        // Initialize like/dislike buttons from localStorage
        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('.like-btn, .dislike-btn');
            
            buttons.forEach(button => {
                const id = button.getAttribute('onclick').split("'")[1];
                if (localStorage.getItem(id) === 'active') {
                    button.classList.add('active');
                }
            });
            
            // Add animation to player cards on scroll
            const observerOptions = {
                threshold: 0.1
            };
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = 1;
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);
            
            const playerCards = document.querySelectorAll('.player-card');
            playerCards.forEach((card, index) => {
                card.style.opacity = 0;
                card.style.transform = 'translateY(20px)';
                card.style.transition = `opacity 0.5s ease, transform 0.5s ease ${index * 0.1}s`;
                observer.observe(card);
            });
        });
        
        // Newsletter form submission
        const newsletterForm = document.querySelector('.newsletter');
        if (newsletterForm) {
            newsletterForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const email = this.querySelector('input').value;
                
                // Create success message
                const successMsg = document.createElement('div');
                successMsg.innerHTML = `
                    <div style="
                        position: fixed;
                        top: 20px;
                        right: 20px;
                        background: #4CAF50;
                        color: white;
                        padding: 15px 25px;
                        border-radius: 4px;
                        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                        z-index: 1000;
                        animation: slideIn 0.5s forwards;
                    ">
                        <i class="fas fa-check-circle"></i> Thank you for subscribing with ${email}!
                    </div>
                `;
                
                document.body.appendChild(successMsg);
                
                // Remove after 5 seconds
                setTimeout(() => {
                    successMsg.style.animation = 'slideOut 0.5s forwards';
                    setTimeout(() => successMsg.remove(), 500);
                }, 5000);
                
                this.querySelector('input').value = '';
            });
        }
        
        // Filter functionality
        document.querySelector('.filter-button').addEventListener('click', function() {
            const position = document.getElementById('position').value;
            const age = document.getElementById('age').value;
            const region = document.getElementById('region').value;
            
            // This would normally be an AJAX call to filter players
            // For demo purposes, we'll just show all players
            document.querySelectorAll('.player-card').forEach(card => {
                card.style.display = 'block';
            });
        });
        
        // Add CSS for animations
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideIn {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            @keyframes slideOut {
                from { transform: translateX(0); opacity: 1; }
                to { transform: translateX(100%); opacity: 0; }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>