-- PHP Exercises database (Outputs #3, #4 and #5)
CREATE DATABASE IF NOT EXISTS php_exercises CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE php_exercises;

DROP TABLE IF EXISTS registered_persons;
CREATE TABLE registered_persons (
  id             INT UNSIGNED NOT NULL AUTO_INCREMENT,
  first_name     VARCHAR(50)  NOT NULL,
  last_name      VARCHAR(50)  NOT NULL,
  age            TINYINT UNSIGNED NOT NULL,
  gender         ENUM('Male','Female','Other') NOT NULL,
  email          VARCHAR(100) NOT NULL,
  address        VARCHAR(255) NOT NULL,
  contact_number VARCHAR(20)  NOT NULL,
  created_at     TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_person_email (email)
) ENGINE=InnoDB;

DROP TABLE IF EXISTS faculty;
CREATE TABLE faculty (
  id          INT UNSIGNED NOT NULL AUTO_INCREMENT,
  first_name  VARCHAR(50)  NOT NULL,
  middle_name VARCHAR(50)  DEFAULT NULL,
  last_name   VARCHAR(50)  NOT NULL,
  age         TINYINT UNSIGNED NOT NULL,
  gender      ENUM('Male','Female','Other') NOT NULL,
  address     VARCHAR(255) NOT NULL,
  position    VARCHAR(100) NOT NULL,
  salary      DECIMAL(12,2) NOT NULL,
  created_at  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
) ENGINE=InnoDB;

INSERT INTO faculty (first_name, middle_name, last_name, age, gender, address, position, salary) VALUES
('Maria','Santos','Reyes',34,'Female','Nasipit, Agusan del Norte','Instructor I',28500.00),
('Jose','Protacio','Rizal',41,'Male','Butuan City','Assistant Professor',42000.00);
