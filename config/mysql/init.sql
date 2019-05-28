Create database file_uploader;

USE file_uploader;

CREATE TABLE IF NOT EXISTS 
    `file_uploader`.`files` ( 
        `id` INT NOT NULL AUTO_INCREMENT , 
        `name` VARCHAR(512) NOT NULL , 
        `size` INT NOT NULL , 
        `type` VARCHAR(512) NOT NULL , 
        `ext` VARCHAR(512) NOT NULL , 
        `path` VARCHAR(512) NOT NULL , 
        PRIMARY KEY (`id`)
    ) 
ENGINE = InnoDB;