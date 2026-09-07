CREATE DATABASE IF NOT EXISTS vishal_portfolio
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE vishal_portfolio;

CREATE TABLE IF NOT EXISTS admins (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(190) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS site_settings (
    id TINYINT UNSIGNED PRIMARY KEY,
    site_name VARCHAR(150) NOT NULL,
    tagline VARCHAR(255) DEFAULT '',
    hero_title VARCHAR(255) DEFAULT '',
    hero_text TEXT,
    profile_image VARCHAR(255) DEFAULT 'assets/profile.jpg',
    resume_file VARCHAR(255) DEFAULT 'assets/resume.pdf',
    email VARCHAR(190) DEFAULT '',
    phone VARCHAR(50) DEFAULT '',
    location VARCHAR(150) DEFAULT '',
    github VARCHAR(255) DEFAULT '',
    linkedin VARCHAR(255) DEFAULT '',
    instagram VARCHAR(255) DEFAULT '',
    form_endpoint VARCHAR(255) DEFAULT '',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS portfolio_items (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    section ENUM('skills','projects','experience','education','certificates','services','socials') NOT NULL,
    title VARCHAR(180) NOT NULL,
    subtitle VARCHAR(255) DEFAULT '',
    description TEXT,
    image VARCHAR(255) DEFAULT '',
    url VARCHAR(500) DEFAULT '',
    meta VARCHAR(255) DEFAULT '',
    sort_order INT NOT NULL DEFAULT 0,
    is_visible TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX(section, sort_order, is_visible)
);

CREATE TABLE IF NOT EXISTS contact_messages (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(120) NOT NULL,
    email VARCHAR(190) NOT NULL,
    message TEXT NOT NULL,
    is_read TINYINT(1) NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO site_settings (id, site_name, tagline, hero_title, hero_text, profile_image, resume_file)
VALUES (1, 'Vishal Pethkar', 'Data Analyst • Python Developer', 'Vishal Pethkar',
        'I build clean dashboards, useful data products and practical Python/SQL solutions.',
        'assets/profile.jpg', 'assets/resume.pdf')
ON DUPLICATE KEY UPDATE id=id;

-- Demo/admin account:
-- Email: admin@vishalpethkar.dev
-- Password: ChangeMe123!
-- The setup page creates a secure password hash for you.

-- Default admin account requested for this installation.
-- Change the password after first login if you deploy this publicly.
INSERT INTO admins (name, email, password_hash)
VALUES (
    'Vishal Pethkar',
    'riteshpethkar1001@gmail.com',
    '$2y$12$OInQPieSi573QHp9WcSQCukLGopfymu3osgpEOsgz1a4JOT5DPyw6'
)
ON DUPLICATE KEY UPDATE
    name = VALUES(name),
    password_hash = VALUES(password_hash);

