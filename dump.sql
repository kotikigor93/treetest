CREATE TABLE `tree` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
    `parent` INT(11) NULL DEFAULT '0',
    PRIMARY KEY (`id`) USING BTREE
)
    COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=110
;
