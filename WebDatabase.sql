drop database if exists `web_db`;
create database `web_db`;
use `web_db`;


CREATE TABLE IF NOT EXISTS `user` (
  `userId` VARCHAR(255) NOT NULL ,
  `name` VARCHAR(25) NOT NULL,
  `surname` VARCHAR(30) NOT NULL,
  `username` VARCHAR(45) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `email` VARCHAR(60) NOT NULL,
  PRIMARY KEY (`userId`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


CREATE TABLE IF NOT EXISTS `uploaded_by_user` (
  `userId` VARCHAR(255) NOT NULL,
  `uploadTime` DATETIME NOT NULL,
  `jsonFIleName` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`userId`, `uploadTime`),
  CONSTRAINT `fk_uploaded_by_user_user`
    FOREIGN KEY (`userId`)
    REFERENCES `user` (`userId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `userMapData` (
  `userId` VARCHAR(255) NOT NULL,
  `timestampMs` INT(11) NOT NULL,
  `latitude` INT(11) NOT NULL,
  `longitude` INT(11) NOT NULL,
  `accuracy` INT(11) NOT NULL,
  `velocity` INT(11) NULL DEFAULT NULL,
  `heading` INT(11) NULL DEFAULT NULL,
  `altitude` INT(11) NULL DEFAULT NULL,
  `verticalAccuracy` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`userId`, `timestampMs`),
  CONSTRAINT `fk_userMapData_user1`
    FOREIGN KEY (`userId`)
    REFERENCES `user` (`userId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


CREATE TABLE IF NOT EXISTS `user_activity` (
  `userMapData_userId` VARCHAR(255) NOT NULL,
  `userMapData_timestampMs` INT(11) NOT NULL,
  `activity_timestamp` INT(11) NOT NULL,
  `inVehicle` INT(11) NULL DEFAULT NULL,
  `onBicycle` INT(11) NULL DEFAULT NULL,
  `onFoot` INT(11) NULL DEFAULT NULL,
  `running` INT(11) NULL DEFAULT NULL,
  `still` INT(11) NULL DEFAULT NULL,
  `tilting` INT(11) NULL DEFAULT NULL,
  `unknown` INT(11) NULL DEFAULT NULL,
  `walking` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`userMapData_userId`, `userMapData_timestampMs`, `activity_timestamp`),
  CONSTRAINT `fk_useractivity_userMapData1`
    FOREIGN KEY (`userMapData_userId` , `userMapData_timestampMs`)
    REFERENCES `userMapData` (`userId` , `timestampMs`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;
