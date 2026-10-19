CREATE DATABASE IF NOT EXISTS ict_helpdesk CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE ict_helpdesk;

CREATE TABLE IF NOT EXISTS users (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  full_name VARCHAR(120) NOT NULL,
  email VARCHAR(190) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('admin','technician','user') NOT NULL DEFAULT 'user',
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS categories (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(80) NOT NULL UNIQUE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS equipment (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  asset_tag VARCHAR(60) NOT NULL UNIQUE,
  name VARCHAR(120) NOT NULL,
  equipment_type VARCHAR(80) NOT NULL,
  serial_number VARCHAR(120) NULL,
  ip_address VARCHAR(45) NULL,
  mac_address VARCHAR(17) NULL,
  location VARCHAR(120) NOT NULL,
  status ENUM('Working','Needs Repair','Under Maintenance','Retired') NOT NULL DEFAULT 'Working',
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS tickets (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  ticket_code VARCHAR(24) NOT NULL UNIQUE,
  user_id INT UNSIGNED NOT NULL,
  category_id INT UNSIGNED NOT NULL,
  equipment_id INT UNSIGNED NULL,
  title VARCHAR(160) NOT NULL,
  description TEXT NOT NULL,
  location VARCHAR(160) NOT NULL,
  priority ENUM('Low','Medium','High','Critical') NOT NULL DEFAULT 'Medium',
  status ENUM('Pending','Assigned','In Progress','Resolved','Closed') NOT NULL DEFAULT 'Pending',
  technician_id INT UNSIGNED NULL,
  resolution_notes TEXT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_ticket_user FOREIGN KEY (user_id) REFERENCES users(id),
  CONSTRAINT fk_ticket_category FOREIGN KEY (category_id) REFERENCES categories(id),
  CONSTRAINT fk_ticket_equipment FOREIGN KEY (equipment_id) REFERENCES equipment(id) ON DELETE SET NULL,
  CONSTRAINT fk_ticket_technician FOREIGN KEY (technician_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS maintenance_logs (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  equipment_id INT UNSIGNED NOT NULL,
  technician_id INT UNSIGNED NULL,
  problem TEXT NOT NULL,
  solution TEXT NULL,
  maintenance_date DATE NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_maintenance_equipment FOREIGN KEY (equipment_id) REFERENCES equipment(id),
  CONSTRAINT fk_maintenance_technician FOREIGN KEY (technician_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;

INSERT IGNORE INTO categories (name) VALUES
('Computer / Hardware'), ('Network / Wi-Fi'), ('Printer'), ('Software'),
('Email / Account'), ('Other');
