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
  `jsonFIleName` VARCHAR(255) NOT NULL,
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
  `timestampMs` VARCHAR(255) NOT NULL,
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
  `userMapData_timestampMs` VARCHAR(255) NOT NULL,
  `activity_timestamp` VARCHAR(255) NOT NULL,
  `eco` INT(1) NULL DEFAULT 0,
  `IN_VEHICLE` INT(11) NULL DEFAULT NULL,
  `ON_BICYCLE` INT(11) NULL DEFAULT NULL,
  `ON_FOOT` INT(11) NULL DEFAULT NULL,
  `RUNNING` INT(11) NULL DEFAULT NULL,
  `STILL` INT(11) NULL DEFAULT NULL,
  `TILTING` INT(11) NULL DEFAULT NULL,
  `UNKNOWN` INT(11) NULL DEFAULT NULL,
  `WALKING` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`userMapData_userId`, `userMapData_timestampMs`, `activity_timestamp`),
  CONSTRAINT `fk_useractivity_userMapData1`
    FOREIGN KEY (`userMapData_userId` , `userMapData_timestampMs`)
    REFERENCES `userMapData` (`userId` , `timestampMs`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

DELIMITER $
CREATE TRIGGER eco_check
BEFORE INSERT ON user_activity
FOR EACH ROW
BEGIN
	DECLARE eco_score INT(4);
	SET @eco_score=0;

	IF NEW.ON_BICYCLE > 0 THEN
		SET @eco_score=@eco_score+NEW.ON_BICYCLE;
  END IF;
  IF NEW.ON_FOOT > 0 THEN
    SET @eco_score=@eco_score+NEW.ON_FOOT;
  END IF;
	IF NEW.RUNNING > 0 THEN
		SET @eco_score=@eco_score+NEW.RUNNING;
  END IF;
	IF NEW.STILL > 0 THEN
		SET @eco_score=@eco_score+NEW.STILL;
  END IF;
	IF NEW.TILTING > 0 THEN
		SET @eco_score=@eco_score+NEW.TILTING;
  END IF;
	IF NEW.WALKING > 0 THEN
		SET @eco_score=@eco_score+NEW.WALKING;
  END IF;
	IF NEW.UNKNOWN > 0 THEN
		SET @eco_score=@eco_score+(NEW.UNKNOWN DIV 2);
  END IF;

	IF @eco_score>50 THEN
		SET NEW.eco=1;
  END IF;
END$
DELIMITER ;
