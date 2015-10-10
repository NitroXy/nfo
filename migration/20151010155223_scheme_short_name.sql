ALTER TABLE `scheme_items` ADD `short_name` VARCHAR(10) NULL DEFAULT NULL;
UPDATE `scheme_items` SET `short_name` = `text`;
ALTER TABLE `scheme_items` CHANGE `short_name` `short_name` VARCHAR(10) NOT NULL;
