DROP DATABASE IF EXISTS dashboard ;
CREATE DATABASE dashboard ;
USE dashboard ;

CREATE TABLE users (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  login VARCHAR(30) NOT NULL,
  pass VARCHAR(41) NOT NULL,
  nick VARCHAR(30) NOT NULL,
  email	VARCHAR(50) NOT NULL,
  level TINYINT(1) UNSIGNED NOT NULL,
  reg_date DATETIME,
  last_login TIMESTAMP,
  INDEX (login, nick, email, reg_date, last_login)
);

CREATE TABLE user_info (
  user_id INT UNSIGNED NOT NULL,
  full_name VARCHAR(100) NOT NULL,
  avatar TINYBLOB,
  photo BLOB,
  icq INT(10) UNSIGNED, 
  skype VARCHAR(50) NOT NULL,
  tel VARCHAR(15),
  options VARCHAR(30),
  signature VARCHAR(150),
  FOREIGN KEY (user_id) REFERENCES users(`id`)
);

CREATE TABLE topic (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(150) NOT NULL,
  task VARCHAR(255),
  user_id INT UNSIGNED NOT NULL,
  add_date DATETIME NOT NULL,
  last_date TIMESTAMP,
  min_level INT(1) UNSIGNED NOT NULL,
  status ENUM ('new','hot','none','closed') NOT NULL DEFAULT 'new',
  INDEX (user_id, title),
  FOREIGN KEY (user_id) REFERENCES users(`id`)
);

CREATE TABLE messages (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNSIGNED NOT NULL,
  topic_id INT UNSIGNED NOT NULL,
  mess TEXT NOT NULL,
  add_date DATETIME NOT NULL,
  last_date TIMESTAMP,
  INDEX (user_id, topic_id, last_date),
  FOREIGN KEY (user_id) REFERENCES users(`id`),
  FOREIGN KEY (topic_id) REFERENCES topic(`id`)
);

CREATE TABLE gallery (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNSIGNED NOT NULL,
  img_title VARCHAR(100) NOT NULL,
  img_body BLOB NOT NULL,
  add_date DATETIME NOT NULL,
  last_date TIMESTAMP,
  rating INT(1) UNSIGNED NOT NULL DEFAULT 0,
  INDEX (user_id, add_date, last_date, rating),
  FOREIGN KEY (user_id) REFERENCES users(`id`)
);