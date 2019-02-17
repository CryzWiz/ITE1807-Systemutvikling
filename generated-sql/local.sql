
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- user
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `UserName` VARCHAR(45) NOT NULL,
    `Password` VARCHAR(256) NOT NULL,
    `Email` VARCHAR(45) NOT NULL,
    `FirstName` VARCHAR(15) NOT NULL,
    `LastName` VARCHAR(15) NOT NULL,
    `Validated` TINYINT(1) DEFAULT 0 NOT NULL,
    `Active` TINYINT(1) DEFAULT 1 NOT NULL,
    `Role` TINYINT(1) DEFAULT 1 NOT NULL,
    `Permanent` TINYINT(1) DEFAULT 1 NOT NULL,
    `pass_expires_at` DATETIME NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `email_unique_idx` (`Email`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- timeregistration
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `timeregistration`;

CREATE TABLE `timeregistration`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `User_id` INTEGER NOT NULL,
    `Team_id` INTEGER NOT NULL,
    `Task_id` INTEGER NOT NULL,
    `Start` DATETIME,
    `Stop` DATETIME,
    `Place` VARCHAR(45),
    `PredefinedTask` VARCHAR(45),
    `Comment` VARCHAR(150),
    `Approved` TINYINT(1) DEFAULT 0,
    `Active` VARCHAR(10) DEFAULT 'false',
    PRIMARY KEY (`id`),
    UNIQUE INDEX `timeReg_unique_idx` (`User_id`, `Start`, `Stop`),
    INDEX `timeregistration_fi_031dc6` (`Task_id`),
    INDEX `timeregistration_fi_f0e437` (`Team_id`),
    CONSTRAINT `timeregistration_fk_29554a`
        FOREIGN KEY (`User_id`)
        REFERENCES `user` (`id`),
    CONSTRAINT `timeregistration_fk_031dc6`
        FOREIGN KEY (`Task_id`)
        REFERENCES `task` (`id`),
    CONSTRAINT `timeregistration_fk_f0e437`
        FOREIGN KEY (`Team_id`)
        REFERENCES `team` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- userinfo
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `userinfo`;

CREATE TABLE `userinfo`
(
    `User_id` INTEGER NOT NULL,
    `Work_Phone` VARCHAR(45) DEFAULT '',
    `Mobile_Phone` VARCHAR(45) DEFAULT '',
    `Civil_Registration_Number` BIGINT,
    `Bankaccount` BIGINT,
    `Address` VARCHAR(64),
    `PostCode` SMALLINT,
    PRIMARY KEY (`User_id`),
    UNIQUE INDEX `id_unique_idx` (`User_id`),
    INDEX `userinfo_fi_177a08` (`PostCode`),
    CONSTRAINT `userinfo_fk_29554a`
        FOREIGN KEY (`User_id`)
        REFERENCES `user` (`id`),
    CONSTRAINT `userinfo_fk_177a08`
        FOREIGN KEY (`PostCode`)
        REFERENCES `postal` (`PostCode`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- calendar
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `calendar`;

CREATE TABLE `calendar`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `Project_id` INTEGER NOT NULL,
    `User_id` INTEGER NOT NULL,
    `Name` VARCHAR(45) NOT NULL,
    `Regards` VARCHAR(45) NOT NULL,
    `Location` VARCHAR(45) NOT NULL,
    `start_date` DATE NOT NULL,
    `end_date` DATE NOT NULL,
    PRIMARY KEY (`id`,`Project_id`,`User_id`),
    INDEX `calendar_fi_601850` (`Project_id`),
    INDEX `calendar_fi_29554a` (`User_id`),
    CONSTRAINT `calendar_fk_601850`
        FOREIGN KEY (`Project_id`)
        REFERENCES `project` (`id`),
    CONSTRAINT `calendar_fk_29554a`
        FOREIGN KEY (`User_id`)
        REFERENCES `user` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- team
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `team`;

CREATE TABLE `team`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `Name` VARCHAR(45) NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `name_unique_idx` (`Name`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- user_team
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `user_team`;

CREATE TABLE `user_team`
(
    `User_id` INTEGER NOT NULL,
    `Team_id` INTEGER NOT NULL,
    `isTeamleader` TINYINT(1) DEFAULT 0 NOT NULL,
    PRIMARY KEY (`User_id`,`Team_id`),
    UNIQUE INDEX `user_team_unique_idx` (`User_id`, `Team_id`),
    INDEX `user_team_fi_f0e437` (`Team_id`),
    CONSTRAINT `user_team_fk_29554a`
        FOREIGN KEY (`User_id`)
        REFERENCES `user` (`id`),
    CONSTRAINT `user_team_fk_f0e437`
        FOREIGN KEY (`Team_id`)
        REFERENCES `team` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- team_project
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `team_project`;

CREATE TABLE `team_project`
(
    `Project_id` INTEGER NOT NULL,
    `Team_id` INTEGER NOT NULL,
    PRIMARY KEY (`Project_id`,`Team_id`),
    UNIQUE INDEX `project_team_unique_idx` (`Project_id`, `Team_id`),
    INDEX `team_project_fi_f0e437` (`Team_id`),
    CONSTRAINT `team_project_fk_601850`
        FOREIGN KEY (`Project_id`)
        REFERENCES `project` (`id`),
    CONSTRAINT `team_project_fk_f0e437`
        FOREIGN KEY (`Team_id`)
        REFERENCES `team` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- project
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `project`;

CREATE TABLE `project`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `Name` VARCHAR(45) NOT NULL,
    `Start` DATE NOT NULL,
    `End` DATE NOT NULL,
    `Status_id` CHAR(6) NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `name_unique_idx` (`Name`),
    INDEX `project_fi_be3d4f` (`Status_id`),
    CONSTRAINT `project_fk_be3d4f`
        FOREIGN KEY (`Status_id`)
        REFERENCES `work_status` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- projectinfo
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `projectinfo`;

CREATE TABLE `projectinfo`
(
    `Project_id` INTEGER NOT NULL,
    `CostumerName` VARCHAR(45) DEFAULT '',
    `Address` VARCHAR(70) DEFAULT '',
    `ContactPerson` VARCHAR(45),
    `Email` VARCHAR(64),
    PRIMARY KEY (`Project_id`),
    UNIQUE INDEX `projectid_unique_idx` (`Project_id`),
    CONSTRAINT `projectinfo_fk_601850`
        FOREIGN KEY (`Project_id`)
        REFERENCES `project` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- work_status
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `work_status`;

CREATE TABLE `work_status`
(
    `id` CHAR(6) NOT NULL,
    `Status` VARCHAR(25) NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `status_unique_idx` (`Status`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- task
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `task`;

CREATE TABLE `task`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `Project_id` INTEGER NOT NULL,
    `Team_id` INTEGER,
    `Name` VARCHAR(45) NOT NULL,
    `Start` DATE NOT NULL,
    `End` DATE NOT NULL,
    `PlannedHours` INTEGER DEFAULT 0 NOT NULL,
    `Dependent_id` INTEGER,
    `Status_id` CHAR(6) NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `name_unique_idx` (`Name`, `Project_id`),
    INDEX `task_fi_be3d4f` (`Status_id`),
    INDEX `task_fi_57bc89` (`Project_id`, `Team_id`),
    CONSTRAINT `task_fk_be3d4f`
        FOREIGN KEY (`Status_id`)
        REFERENCES `work_status` (`id`),
    CONSTRAINT `task_fk_57bc89`
        FOREIGN KEY (`Project_id`,`Team_id`)
        REFERENCES `team_project` (`Project_id`,`Team_id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- valid_link
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `valid_link`;

CREATE TABLE `valid_link`
(
    `id` INTEGER NOT NULL,
    `ValidLink` VARCHAR(32) NOT NULL,
    `updated_at` DATE NOT NULL,
    `created_at` DATETIME,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `valid_link_unique_idx` (`ValidLink`),
    CONSTRAINT `valid_link_fk_ffc53a`
        FOREIGN KEY (`id`)
        REFERENCES `user` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- postal
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `postal`;

CREATE TABLE `postal`
(
    `PostCode` SMALLINT NOT NULL,
    `City` VARCHAR(24) NOT NULL,
    PRIMARY KEY (`PostCode`),
    UNIQUE INDEX `postcode_unique_idx` (`PostCode`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
