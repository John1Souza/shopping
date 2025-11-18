-- Johnatas 16/11/25

create database shopping;
use shopping;

CREATE TABLE `user` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(150) NOT NULL UNIQUE,
  `password_hash` VARCHAR(255) NOT NULL,
  `auth_key` VARCHAR(255) null,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
);

CREATE TABLE `shopping_list` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `title` VARCHAR(150) NOT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `user`(`id`)
);

CREATE TABLE `shopping_item` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `list_id` INT NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `quantity` INT DEFAULT 1,
  `price` DECIMAL(10,2) DEFAULT NULL,
  `checked` TINYINT(1) DEFAULT 0,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`list_id`) REFERENCES `shopping_list`(`id`)
);

