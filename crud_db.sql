-- Create [crud_db] Database
	CREATE DATABASE IF NOT EXISTS `crud_db` CHARACTER SET = `utf8mb4` COLLATE `utf8mb4_general_ci`;

-- Create [user] Table
	CREATE TABLE IF NOT EXISTS `crud_db`.`user` (
			`user_id`	INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
			`user_name` VARCHAR(50) NOT NULL,
			`full_name`	VARCHAR(100) NULL,
			`password`	VARCHAR(255) NOT NULL,
			`email`		VARCHAR(100) NOT NULL,
			PRIMARY KEY (`user_id`) 
		);

-- Create [orders] Table
	CREATE TABLE IF NOT EXISTS `crud_db`.`orders` (
			`order_id`	INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
			`order_name` VARCHAR(100) NOT NULL,
			`order_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
			`user_id`	INT(11) UNSIGNED NOT NULL,
			FOREIGN KEY (`user_id`) REFERENCES `crud_db`.`user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
		); 
