DROP TABLE IF EXISTS `#__serviceproject`;

CREATE TABLE `#__serviceproject` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`greeting` VARCHAR(25) NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

INSERT INTO `#__serviceproject` (`greeting`) VALUES
	(`Hello World!`),
	(`Good bye World!`);