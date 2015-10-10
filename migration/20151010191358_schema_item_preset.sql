ALTER TABLE `scheme_items` ADD `preset_id` INT NULL DEFAULT NULL;
ALTER TABLE `scheme_items` ADD CONSTRAINT `preset_fk` FOREIGN KEY (`preset_id`) REFERENCES `scheme_presets`(`scheme_preset_id`);
