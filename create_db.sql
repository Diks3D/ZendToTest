DROP DATABASE IF EXISTS zend_to_test;
CREATE DATABASE zend_to_test;
USE zend_to_test;

CREATE TABLE z2t_admin (
  id INT(2) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  login VARCHAR(30) NOT NULL,
  email VARCHAR(50) NOT NULL,
  full_name VARCHAR(150) NOT NULL,
  pass_hash VARCHAR(40) NOT NULL,
  created DATETIME NOT NULL,
  last_login DATETIME NOT NULL,
  INDEX (login, email)
);

GRANT ALL PRIVILEGES ON zend_to_test.* TO 'admin'@'localhost' IDENTIFIED BY 'Abcd12345';
GRANT ALL PRIVILEGES ON zend_to_test.* TO 'doctrine'@'localhost' IDENTIFIED BY 'DoctrinePass';