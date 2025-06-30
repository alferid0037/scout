-- Create database and tables for the football scouting system
CREATE DATABASE IF NOT EXISTS football_scouting;
USE football_scouting;

-- Users table for authentication
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Player registrations table
CREATE TABLE player_registrations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    birth_day INT NOT NULL,
    birth_month INT NOT NULL,
    birth_year INT NOT NULL,
    gender ENUM('male', 'female') NOT NULL,
    phone VARCHAR(20) NOT NULL,
    photo_path VARCHAR(255),
    birth_certificate_path VARCHAR(255),
    passport_number VARCHAR(50),
    passport_photo_path VARCHAR(255),
    weight DECIMAL(5,2),
    education_certificate_path VARCHAR(255),
    country VARCHAR(100) NOT NULL,
    city VARCHAR(100) NOT NULL,
    registration_status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Password reset tokens table
CREATE TABLE password_reset_tokens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    token VARCHAR(255) NOT NULL,
    expires_at TIMESTAMP NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Age categories table
CREATE TABLE age_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(10) NOT NULL,
    min_age INT NOT NULL,
    max_age INT NOT NULL,
    description TEXT
);

-- Training schedules table
CREATE TABLE training_schedules (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT,
    day_of_week VARCHAR(20) NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME,
    FOREIGN KEY (category_id) REFERENCES age_categories(id)
);
