CREATE DATABASE voting_system;

USE voting_system;

CREATE TABLE users (
 id INT AUTO_INCREMENT PRIMARY KEY,
 full_name VARCHAR(100),
 email VARCHAR(100) UNIQUE,
 password VARCHAR(255),
 phone VARCHAR(15),
 aadhaar VARCHAR(12) UNIQUE,
 voter_id VARCHAR(20) UNIQUE,
 photo VARCHAR(255),
 role ENUM('user') DEFAULT 'user',
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE admins (
 id INT AUTO_INCREMENT PRIMARY KEY,
 email VARCHAR(100),
 password VARCHAR(255)
);

CREATE TABLE election_commission (
 id INT AUTO_INCREMENT PRIMARY KEY,
 email VARCHAR(100),
 password VARCHAR(255)
);

CREATE TABLE elections (
 id INT AUTO_INCREMENT PRIMARY KEY,
 title VARCHAR(255),
 start_time DATETIME,
 end_time DATETIME
);

CREATE TABLE candidates (
 id INT AUTO_INCREMENT PRIMARY KEY,
 election_id INT,
 name VARCHAR(100),
 party VARCHAR(100),
 FOREIGN KEY (election_id) REFERENCES elections(id)
);

CREATE TABLE votes (
 id INT AUTO_INCREMENT PRIMARY KEY,
 user_id INT,
 election_id INT,
 candidate_id INT,
 UNIQUE(user_id,election_id),
 FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE otp_verifications (
 id INT AUTO_INCREMENT PRIMARY KEY,
 phone VARCHAR(15),
 otp VARCHAR(6),
 expiry DATETIME
);

CREATE TABLE biometric_data (
 id INT AUTO_INCREMENT PRIMARY KEY,
 user_id INT,
 fingerprint_hash VARCHAR(255),
 face_hash VARCHAR(255)
);