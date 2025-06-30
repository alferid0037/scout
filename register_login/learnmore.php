<?php
require_once 'includes/functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🌟 Ethio-Scout  learn-more</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Rubik:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        /* Cosmic General Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Montserrat', sans-serif;
        }
        
        body {
            background: radial-gradient(circle at center, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            color: #e6f7ff;
            text-align: center;
            overflow-x: hidden;
            background-attachment: fixed;
        }
        
        /* Stellar Header */
        .header {
            background: linear-gradient(135deg, #4e54c8 0%, #8f94fb 100%);
            color: #f9d423;
            padding: 20px;
            font-size: 28px;
            font-weight: bold;
            letter-spacing: 2px;
            text-transform: uppercase;
            position: relative;
            box-shadow: 0 0 25px rgba(143, 148, 251, 0.6);
            border-bottom: 2px solid #f9d423;
        }
        
        .header::after {
            content: "";
            position: absolute;
            bottom: -10px;
            left: 0;
            right: 0;
            height: 10px;
            background: repeating-linear-gradient(
                45deg,
                transparent,
                transparent 10px,
                #f9d423 10px,
                #f9d423 20px
            );
        }
        
        /* Nebula Hero Section */
        .hero {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('https://images.unsplash.com/photo-1574629810360-7efbbe195018?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1920&q=80') no-repeat center center/cover;

            height: 90vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: #f9d423;
            text-shadow: 0 0 10px rgba(249, 212, 35, 0.8), 0 0 20px rgba(78, 84, 200, 0.8);
            padding: 20px;
            position: relative;
            overflow: hidden;
        }
        
        .hero::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)' opacity='0.1'/%3E%3C/svg%3E");
            pointer-events: none;
        }
        
        .hero h1 {
            font-size: 3.5em;
            margin-bottom: 20px;
            letter-spacing: 3px;
            position: relative;
            animation: glow 2s infinite alternate;
        }
        
        @keyframes glow {
            from {
                text-shadow: 0 0 10px #f9d423, 0 0 20px rgba(249, 212, 35, 0.5);
            }
            to {
                text-shadow: 0 0 15px #f9d423, 0 0 30px rgba(249, 212, 35, 0.8), 0 0 40px rgba(78, 84, 200, 0.6);
            }
        }
        
        .hero p {
            font-size: 1.5em;
            max-width: 700px;
            line-height: 1.6;
            margin-bottom: 40px;
            background: rgba(22, 33, 62, 0.7);
            padding: 20px;
            border-radius: 15px;
            border: 1px solid rgba(249, 212, 35, 0.3);
            backdrop-filter: blur(5px);
        }
        
        /* Cosmic Button */
        .button {
            padding: 18px 36px;
            font-size: 20px;
            font-weight: bold;
            outline: none;
            border: none;
            border-radius: 50px;
            transition: all 0.5s ease;
            background: linear-gradient(45deg, #f9d423, #f83600);
            cursor: pointer;
            color: #1a1a2e;
            box-shadow: 0 5px 15px rgba(249, 212, 35, 0.4),
                        inset 0 0 10px rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
            letter-spacing: 1px;
            text-transform: uppercase;
            z-index: 1;
        }
        
        .button::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, #f83600, #f9d423);
            z-index: -1;
            opacity: 0;
            transition: opacity 0.5s ease;
        }
        
        .button:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(249, 212, 35, 0.6),
                        inset 0 0 15px rgba(255, 255, 255, 0.3);
            animation: pulse 1.5s infinite;
        }
        
        .button:hover::before {
            opacity: 1;
        }
        
        @keyframes pulse {
            0% {
                transform: translateY(-5px) scale(1);
            }
            50% {
                transform: translateY(-5px) scale(1.05);
            }
            100% {
                transform: translateY(-5px) scale(1);
            }
        }
        
        /* Constellation Features Section */
        .features {
            padding: 80px 20px;
            background: linear-gradient(to bottom, #0f3460, #1a1a2e);
            position: relative;
        }
        
        .features::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 20px;
            background: linear-gradient(to bottom, rgba(249, 212, 35, 0.3), transparent);
        }
        
        .features h2 {
            font-size: 2.5em;
            margin-bottom: 40px;
            color: #f9d423;
            text-shadow: 0 0 10px rgba(249, 212, 35, 0.5);
            position: relative;
            display: inline-block;
        }
        
        .features h2::after {
            content: "";
            position: absolute;
            bottom: -10px;
            left: 25%;
            right: 25%;
            height: 3px;
            background: linear-gradient(to right, transparent, #f9d423, transparent);
        }
        
        .features-container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .feature-box {
            background: rgba(31, 42, 72, 0.7);
            padding: 30px;
            border-radius: 15px;
            width: 350px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3),
                        inset 0 0 10px rgba(78, 84, 200, 0.3);
            text-align: center;
            transition: transform 0.5s ease, box-shadow 0.5s ease;
            backdrop-filter: blur(5px);
            border: 1px solid rgba(78, 84, 200, 0.2);
            position: relative;
            overflow: hidden;
        }
        
        .feature-box:hover {
            transform: translateY(-10px) scale(1.03);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4),
                        inset 0 0 15px rgba(78, 84, 200, 0.5);
        }
        
        .feature-box::before {
            content: "";
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(249, 212, 35, 0.1) 0%, transparent 70%);
            transform: rotate(45deg);
            transition: all 0.5s ease;
            opacity: 0;
        }
        
        .feature-box:hover::before {
            opacity: 1;
            animation: shine 1.5s infinite;
        }
        
        @keyframes shine {
            0% {
                transform: rotate(45deg) translate(-10%, -10%);
            }
            100% {
                transform: rotate(45deg) translate(10%, 10%);
            }
        }
        
        .feature-box h3 {
            margin-bottom: 20px;
            color: #f9d423;
            font-size: 1.5em;
            position: relative;
        }
        
        .feature-box h3::after {
            content: "";
            position: absolute;
            bottom: -8px;
            left: 30%;
            right: 30%;
            height: 2px;
            background: linear-gradient(to right, transparent, #8f94fb, transparent);
        }
        
        .feature-box p {
            line-height: 1.8;
            color: #e6f7ff;
        }
        
        /* Galactic Footer */
        .footer {
            background: linear-gradient(to right, #0f3460, #1a1a2e, #0f3460);
            color: #8f94fb;
            padding: 25px;
            position: relative;
            letter-spacing: 1px;
        }
        
        .footer::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(to right, transparent, #f9d423, #8f94fb, #f9d423, transparent);
        }
        
        /* Shooting Stars */
        .shooting-star {
            position: absolute;
            width: 4px;
            height: 4px;
            background: white;
            border-radius: 50%;
            box-shadow: 0 0 10px 2px white;
            animation: shooting 3s infinite;
            opacity: 0;
        }
        
        @keyframes shooting {
            0% {
                transform: translate(0, 0);
                opacity: 1;
            }
            70% {
                opacity: 1;
            }
            100% {
                transform: translate(300px, 150px);
                opacity: 0;
            }
        }
        
        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.5em;
            }
            
            .hero p {
                font-size: 1.2em;
            }
            
            .features-container {
                flex-direction: column;
                align-items: center;
            }
            
            .feature-box {
                width: 90%;
            }
        }
    </style>
</head>
<body>

    <!-- Shooting Stars -->
    

    <div class="header">🚀 Ethio-Scout More Explorer 🌌</div>

    <section class="hero">
        <h1>Empower Youth Through Scouting</h1>
        <p>Embark on an interstellar journey of skill development and leadership. Our scouting program blends Ethiopian heritage with futuristic exploration to prepare youth for tomorrow's challenges.</p>
        <button class="button" type="button" onclick="window.location.href='index.php'">JOIN NOW</button>
    </section>

    <section class="features">
        <h2>WHY JOIN OUR COSMIC SCOUTING PROGRAM?</h2>
        <div class="features-container">
            <div class="feature-box">
                <h3>🛠️ Skill Development</h3>
                <p>Master essential life skills and cutting-edge technologies to become a leader of the future.</p>
            </div>
            <div class="feature-box">
                <h3>👥 Teamwork & Leadership</h3>
                <p>Collaborate with fellow scouts on mission-critical projects that make a real impact.</p>
            </div>
            <div class="feature-box">
                <h3>🌌 Adventure & Exploration</h3>
                <p>Experience cosmic adventures from Ethiopian highlands to simulated space missions.</p>
            </div>
        </div>
    </section>

    <div class="footer">
        © 2025 Ethio-Scout Galactic Explorer | Combining Ethiopian Heritage with Future Vision
    </div>

    <script>
        // Create more shooting stars dynamically
        document.addEventListener('DOMContentLoaded', function() {
            const body = document.querySelector('body');
            for (let i = 0; i < 5; i++) {
                const star = document.createElement('div');
                star.className = 'shooting-star';
                star.style.top = Math.random() * 80 + '%';
                star.style.left = Math.random() * 80 + '%';
                star.style.animationDelay = Math.random() * 5 + 's';
                body.appendChild(star);
            }
        });
    </script>

</body>
</html>