CREATE DATABASE examen;
USE examen;
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    password VARCHAR(100)
);
INSERT INTO users (name, password) VALUES ('user1', 'pass1'), ('user2', 'pass2');