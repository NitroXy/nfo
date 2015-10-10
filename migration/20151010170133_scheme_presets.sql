CREATE TABLE `scheme_presets` (
	`scheme_preset_id` INT PRIMARY KEY AUTO_INCREMENT,
	`name` VARCHAR(64) UNIQUE NOT NULL,
	`color` CHAR(7) NOT NULL,
	`icon` BINARY NULL DEFAULT NULL
);
