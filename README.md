use this code in my sql to create a tabel to store the data
-- Create the database
CREATE DATABASE user_management;

-- Use the created database
USE user_management;

-- Create users table with necessary fields
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(15),
    password VARCHAR(255) NOT NULL,
    profile_image VARCHAR(255) DEFAULT NULL
);
