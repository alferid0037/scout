<?php
require_once 'includes/functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>⚽ Ethio Online Scouting System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200..1000&family=Rubik:wght@300..900&family=Bebas+Neue&family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <style>
        :root {
  --primary:#3562A6; /* Ethiopian yellow */
  --secondary: #0E1EB5; /* Ethiopian red */
  --THERD:#0B0B0B;
  --FOURTH:#6594C0;
  --dark: #0C1E2E;
  --light: #F5F5F5;
  --accent: #078930; /* Ethiopian green */
  --text: #333333;
}

body {
  margin: 0;
  font-family: 'Montserrat', sans-serif;
  background-color: var(--light);
  color: var(--text);
  line-height: 1.6;
}

/* Header with Ethiopian flag colors */
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
  border-radius: 50%;
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

/* Search and settings */
.search-container, .dropdown {
  position: relative;
  display: flex;
  align-items: center;
}

#search-icon, #settings-icon {
  color: white;
  font-size: 1.2rem;
  cursor: pointer;
  transition: all 0.3s ease;
  padding: 8px;
  border-radius: 50%;
}

#search-icon:hover, #settings-icon:hover {
  background-color: rgba(255, 255, 255, 0.1);
  transform: rotate(15deg);
  color: var(--primary);
}

#search-input {
  position: absolute;
  right: 40px;
  width: 0;
  padding: 0;
  border: none;
  border-radius: 20px;
  background: rgba(255, 255, 255, 0.9);
  color: var(--dark);
  font-size: 0.9rem;
  transition: all 0.3s ease;
  opacity: 0;
  visibility: hidden;
}

#search-input.active {
  width: 200px;
  padding: 8px 15px;
  opacity: 1;
  visibility: visible;
}

.dark-mode {
  --primary: #FFCC00;
  --secondary: #DA1212;
  --dark: #121212;
  --light: #1E1E1E;
  --accent: #078930;
  --text: #E0E0E0;
  background-color: #121212;
  color: #E0E0E0;
}

.dark-mode nav {
  background: linear-gradient(135deg, #000000 0%, #1E1E1E 100%);
  border-bottom: 4px solid var(--secondary);
}

.dark-mode .item {
  background-color: #2D2D2D;
  color: #E0E0E0;
}

.dark-mode .item .occupation {
  color: #B0B0B0;
}

.dark-mode .video-item {
  background-color: #2D2D2D;
}

.dark-mode footer {
  background-color: #000000;
}

.dark-mode #player {
  background-color: #1E1E1E;
}

.dark-mode .about-text {
  color: rgba(255, 255, 255, 0.8);
}

/* Theme Toggle Button */
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
  transition: all 0.3s ease;
}

.dark-mode #theme-icon {
  color: var(--primary);
}



/* Profile Dropdown Styles */
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
    position: re;
    right: 0;
    background-color: white;
    min-width: 220px;
    box-shadow: 0 8px 16px rgba(0,0,0,0.2);
    z-index: 1000;
    border-radius: 8px;
    overflow: hidden;
}

.profile-dropdown:hover .profile-content {
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

.profile-content a i {
    width: 20px;
    text-align: center;
}

.profile-content a:hover {
    background-color: #f5f5f5;
    color: var(--primary);
    padding-left: 20px;
}

.profile-content a:not(:last-child) {
    border-bottom: 1px solid #eee;
}

/* Dark mode styles for profile dropdown */
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

.container button::before {
  content: '';
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
  transition: 0.5s;
}

.container button:hover::before {
  left: 100%;
}

/* About Section */
.about-us {
  display: flex;
  align-items: center;
  padding: 80px 10%;
  background: linear-gradient(to right, var(--dark) 50%, transparent 100%);
  position: relative;
}

.about-us::before {
  content: '';
  position: absolute;
  top: 0;
  right: 0;
  width: 50%;
  height: 100%;
  background: url('photo.jpg') no-repeat center center/cover;
  z-index: -1;
  border-radius: 10px 0 0 10px;
}

.text-content {
  flex: 1;
  padding-right: 40px;
  z-index: 1;
}

.section-title {
  font-size: 2.5rem;
  margin-bottom: 20px;
  color:white;
  position: relative;
  display: inline-block;
}

.section-title::after {
  content: '';
  position: absolute;
  bottom: -10px;
  left: 0;
  width: 60px;
  height: 4px;
  background: #FFCC00;
  border-radius: 2px;
}

.welcome-message {
  font-size: 1.5rem;
  color: white;
  margin-bottom: 15px;
  font-weight: 600;
}

.about-text {
  font-size: 1rem;
  line-height: 1.8;
  margin-bottom: 25px;
  color: rgba(255, 255, 255, 0.9);
}

.learn-more-button {
  background: transparent;
  color: white;
  border: 2px solid var(--neon-green);
  padding: 12px 25px;
  border-radius: 50px;
  font-size: 1rem;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
  display: flex;
  align-items: center;
  gap: 8px;
}

.learn-more-button:hover {
  background:#FFCC00;
  color: var(--dark);
  transform: translateY(-3px);
  box-shadow: 0 5px 15px rgba(57, 255, 20, 0.4);
}

.image-content {
  flex: 1;
  position: relative;
}

.about-image {
  max-width: 100%;
  height: auto;
  border-radius: 10px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
  transition: transform 0.3s ease;
}

.about-image:hover {
  transform: scale(1.02);
}

.image-overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: linear-gradient(to right, transparent 0%, rgba(41, 47, 54, 0.7) 100%);
  border-radius: 10px;
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
  color: white;
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
  color: white;
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

/* Video Gallery */
#Video Highlight {
  padding: 80px 5%;
  background-color: white;
}

.video-gallery h1 {
  font-family: 'Bebas Neue', sans-serif;
  font-size: 3rem;
  color: white;
  text-align: center;
  margin-bottom: 50px;
  letter-spacing: 2px;
  position: relative;
}

.video-gallery h1::after {
  content: '';
  position: absolute;
  bottom: -10px;
  left: 50%;
  transform: translateX(-50%);
  width: 100px;
  height: 4px;
  background-color: var(--primary);
}

.gallery-container {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 30px;
  max-width: 1200px;
  margin: 0 auto;
}

.video-item {
  background-color: #f9f9f9;
  border-radius: 10px;
  overflow: hidden;
  box-shadow: 0 5px 15px rgba(0,0,0,0.1);
  transition: all 0.3s ease;
  border-top: 5px solid var(--accent);
}

.video-item:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}

video {
  width: 100%;
  height: 200px;
  object-fit: cover;
  display: block;
}

.video-title {
  padding: 15px;
  font-weight: 600;
  color:white;
  text-align: center;
  margin: 0;
}

/* Footer */
footer {
  background-color: var(--dark);
  color: white;
  padding: 60px 5% 30px;
  position: relative;
}

footer::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 10px;
  background: linear-gradient(90deg, var(--primary), var(--secondary), var(--accent));
}

.footer-container {
  max-width: 1200px;
  margin: 0 auto;
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 40px;
}

.footer-section h3 {
  font-family: 'Bebas Neue', sans-serif;
  font-size: 1.8rem;
  color: var(--primary);
  margin-bottom: 20px;
  letter-spacing: 1px;
  position: relative;
}

.footer-section h3::after {
  content: '';
  position: absolute;
  bottom: -8px;
  left: 0;
  width: 50px;
  height: 3px;
  background-color: var(--secondary);
}

.footer-section p, .footer-section a {
  color: #ddd;
  margin-bottom: 10px;
  transition: all 0.3s ease;
}

.footer-section a:hover {
  color: var(--primary);
  padding-left: 5px;
}

.social-links {
  display: flex;
  gap: 15px;
  margin-top: 20px;
}

.social-links a {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 40px;
  height: 40px;
  background-color: rgba(255,255,255,0.1);
  border-radius: 50%;
  color: white;
  font-size: 1.2rem;
  transition: all 0.3s ease;
}

.social-links a:hover {
  background-color: var(--primary);
  color: var(--dark);
  transform: translateY(-3px);
}

.map-embed iframe {
  width: 100%;
  height: 200px;
  border: none;
  border-radius: 8px;
  box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.copyright {
  grid-column: 1 / -1;
  text-align: center;
  margin-top: 50px;
  padding-top: 20px;
  border-top: 1px solid rgba(255,255,255,0.1);
  color: #aaa;
  font-size: 0.9rem;
}

/* Responsive Design */
@media (max-width: 1024px) {
  .sliding-header {
      font-size: 3.5rem;
  }
  
  .container p {
      font-size: 1.1rem;
      max-width: 700px;
  }
}

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
  
  .container p {
      font-size: 1rem;
      padding: 0 20px;
  }
  
  .about-us {
      flex-direction: column;
  }
  
  .text-content, .image-content {
      width: 100%;
  }
  
  .image-content {
      margin-top: 40px;
  }
  
  #carousel {
      padding-bottom: 40px;
  }
  
  .nav-btn {
      width: 40px;
      height: 40px;
      font-size: 1rem;
  }
  
  #prevBtn {
      left: 10px;
  }
  
  #nextBtn {
      right: 10px;
  }
}

@media (max-width: 480px) {
  .sliding-header {
      font-size: 2rem;
  }
  
  .container button {
      padding: 12px 30px;
      font-size: 1rem;
  }
  
  .text-content h2, .player h1, .video-gallery h1 {
      font-size: 2.2rem;
  }
  
  .footer-container {
      grid-template-columns: 1fr;
  }
  
  .footer-section {
      text-align: center;
  }
  
  .footer-section h3::after {
      left: 50%;
      transform: translateX(-50%);
  }
  
  .social-links {
      justify-content: center;
  }
}
    </style>
</head>

<body>
  <!-- Header -->
  <nav>
      <div class="logo-container">
          <img src="images/Football Award Vector.jpg" alt="Ethio Scout Logo">
      </div>
      <div class="nav-links">
        <a href="#container"><i class="fas fa-home"></i> Home</a>
        <a href="#about-us"><i class="fas fa-info-circle"></i> About</a>
        <a href="#player"><i class="fas fa-users"></i> Players</a>
        <a href="#Video-Highlight"><i class="fas fa-video"></i> Highlights</a>
        <a href="#contact"><i class="fas fa-envelope"></i> Contact</a>
        
        <div class="search-container">
            <i class="fa-solid fa-magnifying-glass" id="search-icon"></i>
            <input type="text" id="search-input" placeholder="Search players...">
        </div>

        <div class="theme-toggle">
            <i class="fas fa-moon" id="theme-icon"></i>
        </div>

        <button onclick="window.location.href='index.php'" style="background: var(--primary); color: white; border: none; padding: 8px 16px; border-radius: 20px; font-weight: 600; cursor: pointer;">
            REGISTER
        </button>
      </div>
  </nav>

  <!-- Hero Section -->
  <div id="container">
      <div class="container">
          <div class="sliding-header">
              <span>ETHIO ONLINE SCOUTING SYSTEM</span>
          </div>
          <p>"Empower youth through Ethiopia's Online Scouting System! Build skills, foster leadership, and unite for a brighter, impactful future together!"</p>
          <button type="button" onclick="window.location.href='index.php'">REGISTER</button>
      </div>
  </div>

  <!-- About Section -->
  <div id="about-us">
    <section class="about-us">
        <div class="text-content">
            <h2 class="section-title">About Us</h2>
            <p class="welcome-message">Welcome to Our Platform</p>
            <p class="about-text">The Ethiopian Football Scouting System represents a comprehensive platform designed to revolutionize player assessment, match analysis, and talent identification processes within the Ethiopian football landscape. This system aims to address the evolving needs of players, scouts, coaches, medical staff, and external football clubs, providing them with powerful tools and insights to drive the development of football talent across the nation.</p>
            <button class="learn-more-button" onclick="window.location.href='learnmore.php'">
                Learn More <i class="fas fa-chevron-right"></i>
            </button>
        </div>
        <div class="image-content">
            <img src="images/photo.jpg" alt="Football Scouting" class="about-image">
            <div class="image-overlay"></div>
        </div>
    </section>
  </div>

  <!-- Players Section -->
  <div id="player">
      <div class="player" onclick="window.location.href='Featured player.php'"><h1>Featured Players</h1></div>

      <div class="input">
          <button id="prevBtn" class="nav-btn"><i class="fas fa-chevron-left"></i></button>
          <button id="nextBtn" class="nav-btn"><i class="fas fa-chevron-right"></i></button>

          <main id="carousel">
              <div class="item">
                  <img src="/placeholder.svg?height=120&width=120" alt="player 1">
                  <h3 class="name">Player 1</h3>
                  <p class="occupation"><b>Date Of Birth</b><br>12/02/2008</p>
                  <p class="occupation"><b>Height</b><br>1.75M</p>
                  <p class="occupation"><b>Position</b><br>Fullback</p>
                  <p class="occupations">
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                  </p>
              </div>
              <div class="item">
                  <img src="/placeholder.svg?height=120&width=120" alt="player 2">
                  <h3 class="name">Player 2</h3>
                  <p class="occupation"><b>Date Of Birth</b><br>05/11/2007</p>
                  <p class="occupation"><b>Height</b><br>1.82M</p>
                  <p class="occupation"><b>Position</b><br>Midfielder</p>
                  <p class="occupations">
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star-half-alt"></i>
                  </p>
              </div>
              <div class="item">
                  <img src="/placeholder.svg?height=120&width=120" alt="player 3">
                  <h3 class="name">Player 3</h3>
                  <p class="occupation"><b>Date Of Birth</b><br>22/09/2006</p>
                  <p class="occupation"><b>Height</b><br>1.68M</p>
                  <p class="occupation"><b>Position</b><br>Forward</p>
                  <p class="occupations">
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                  </p>
              </div>
              <div class="item">
                  <img src="/placeholder.svg?height=120&width=120" alt="player 4">
                  <h3 class="name">Player 4</h3>
                  <p class="occupation"><b>Date Of Birth</b><br>18/04/2007</p>
                  <p class="occupation"><b>Height</b><br>1.70M</p>
                  <p class="occupation"><b>Position</b><br>Winger</p>
                  <p class="occupations">
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                  </p>
              </div>
              <div class="item">
                  <img src="/placeholder.svg?height=120&width=120" alt="player 5">
                  <h3 class="name">Player 5</h3>
                  <p class="occupation"><b>Date Of Birth</b><br>30/07/2005</p>
                  <p class="occupation"><b>Height</b><br>1.88M</p>
                  <p class="occupation"><b>Position</b><br>Center Back</p>
                  <p class="occupations">
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star-half-alt"></i>
                  </p>
              </div>
              <div class="item">
                  <img src="/placeholder.svg?height=120&width=120" alt="player 6">
                  <h3 class="name">Player 6</h3>
                  <p class="occupation"><b>Date Of Birth</b><br>14/01/2008</p>
                  <p class="occupation"><b>Height</b><br>1.76M</p>
                  <p class="occupation"><b>Position</b><br>Goalkeeper</p>
                  <p class="occupations">
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                  </p>
              </div>
          </main>
      </div>
  </div>

  <!-- Video Highlights -->
  <div id="Video-Highlight">
      <div class="video-gallery">
          <h1>Video Highlights</h1>
          <div class="gallery-container">
              <div class="video-item">
                  <video controls poster="/placeholder.svg?height=200&width=300&text=VIDEO+1">
                      <source src="#" type="video/mp4">
                      Your browser does not support the video tag.
                  </video>
                  <p class="video-title">U17 Championship Highlights</p>
              </div>

              <div class="video-item">
                  <video controls poster="/placeholder.svg?height=200&width=300&text=VIDEO+2">
                      <source src="#" type="video/mp4">
                      Your browser does not support the video tag.
                  </video>
                  <p class="video-title">Player Development Sessions</p>
              </div>

              <div class="video-item">
                  <video controls poster="/placeholder.svg?height=200&width=300&text=VIDEO+3">
                      <source src="#" type="video/mp4">
                      Your browser does not support the video tag.
                  </video>
                  <p class="video-title">Training Session Drills</p>
              </div>

              <div class="video-item">
                  <video controls poster="/placeholder.svg?height=200&width=300&text=VIDEO+4">
                      <source src="#" type="video/mp4">
                      Your browser does not support the video tag.
                  </video>
                  <p class="video-title">Regional Tournament Finals</p>
              </div>
          </div>
      </div>
  </div>

  <!-- Footer -->
  <footer id="contact">
      <div class="footer-container">
          <div class="footer-section">
              <h3>Address</h3>
              <p>Addis Ababa Stadium - ADDIS ABEBA</p>
              <p>2Q89+5G7, Addis Ababa</p>
              <p><a href="#">View on Map</a></p>
          </div>
          <div class="footer-section">
              <h3>Contact</h3>
              <p>Phone: +251-11/515 6205</p>
              <p>Email: info@ethioscout.org</p>
              <p>Website: www.ethioscout.org</p>
          </div>
          <div class="footer-section">
              <h3>Social Media</h3>
              <div class="social-links">
                  <a href="#"><i class="fab fa-facebook-f"></i></a>
                  <a href="#"><i class="fab fa-instagram"></i></a>
                  <a href="#"><i class="fab fa-twitter"></i></a>
                  <a href="#"><i class="fab fa-telegram"></i></a>
                  <a href="#"><i class="fab fa-linkedin-in"></i></a>
                  <a href="#"><i class="fab fa-whatsapp"></i></a>
              </div>
          </div>
          <div class="footer-section">
              <h3>Map</h3>
              <div class="map-embed">
                  <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3940.869244261849!2d38.76331531536616!3d9.012722893547026!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x164b85f1a4d1f8b5%3A0x7fddde27ad21a9aa!2sEthiopian%20Football%20Federation!5e0!3m2!1sen!2set!4v1633081234567!5m2!1sen!2set" allowfullscreen="" loading="lazy"></iframe>
              </div>
          </div>
          <p class="copyright">&copy; 2024 Ethiopian Football Federation. All rights reserved.</p>
      </div>
  </footer>

  <script>
      // Search functionality
      document.getElementById('search-icon').addEventListener('click', function() {
          const searchInput = document.getElementById('search-input');
          searchInput.classList.toggle('active');
          if (searchInput.classList.contains('active')) {
              searchInput.focus();
          }
      });

      // Theme toggle functionality
      const themeIcon = document.getElementById('theme-icon');
      const body = document.body;
      
      const savedTheme = localStorage.getItem('theme');
      if (savedTheme) {
          body.classList.add(savedTheme);
          updateThemeIcon();
      } else if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
          body.classList.add('dark-mode');
          updateThemeIcon();
      }

      themeIcon.addEventListener('click', function() {
          body.classList.toggle('dark-mode');
          body.classList.toggle('light-mode');
          updateThemeIcon();
          
          const currentTheme = body.classList.contains('dark-mode') ? 'dark-mode' : 'light-mode';
          localStorage.setItem('theme', currentTheme);
      });

      function updateThemeIcon() {
          if (body.classList.contains('dark-mode')) {
              themeIcon.classList.remove('fa-moon');
              themeIcon.classList.add('fa-sun');
          } else {
              themeIcon.classList.remove('fa-sun');
              themeIcon.classList.add('fa-moon');
          }
      }

      // Carousel navigation
      const carousel = document.getElementById('carousel');
      const prevBtn = document.getElementById('prevBtn');
      const nextBtn = document.getElementById('nextBtn');
      const items = document.querySelectorAll('.item');

      if (items.length > 0) {
          let currentIndex = 0;
          const itemWidth = items[0].offsetWidth + 30;

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

      // Smooth scrolling for navigation links
      document.querySelectorAll('nav a[href^="#"]').forEach(anchor => {
          anchor.addEventListener('click', function(e) {
              e.preventDefault();
              const targetId = this.getAttribute('href');
              if (targetId === '#') return;
              
              const targetElement = document.querySelector(targetId);
              if (targetElement) {
                  window.scrollTo({
                      top: targetElement.offsetTop - 80,
                      behavior: 'smooth'
                  });
              }
          });
      });

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

      // Video hover effects
      const videoItems = document.querySelectorAll('.video-item');
      videoItems.forEach(item => {
          const video = item.querySelector('video');
          
          item.addEventListener('mouseenter', () => {
              if (video) {
                  video.play().catch(e => console.log('Autoplay prevented:', e));
              }
          });
          
          item.addEventListener('mouseleave', () => {
              if (video) {
                  video.pause();
                  video.currentTime = 0;
              }
          });
      });

      // Initialize
      document.addEventListener('DOMContentLoaded', function() {
          console.log('Ethio Online Scouting System loaded');
      });
  </script>
</body>
</html>
