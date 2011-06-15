-- com_serviceproject install SQL file.  This file creates the tables
-- version 1.0.0
-- http://cbconnector.com

-- Create Configuration Table
CREATE TABLE IF NOT EXISTS `#__serviceproject_config` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`config_name` varchar(100) NOT NULL DEFAULT '',
	`config_subname` varchar(100) NOT NULL DEFAULT '',
	`config_value` varchar(255) NOT NULL DEFAULT '',
	PRIMARY KEY (`id`)
	-- UNIQUE KEY `idx_user_var_name` (`user_id`,`cfg_name`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

-- Create Projects Table
CREATE TABLE IF NOT EXISTS `#__serviceproject_projects` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`project_id` INT(11) NOT NULL,
	`eventgroup_id` INT(11) NOT NULL,
	`title` VARCHAR(100) NOT NULL DEFAULT '',
	`project_type` INT(11) NOT NULL COMMENT '0 = Organization, 1 = Individual',
	`shortdescription` VARCHAR(255) NOT NULL DEFAULT '',
	`longdescription` MEDIUMTEXT NOT NULL DEFAULT '',
	`address_id` INT(11) NOT NULL,
	`checkin_location` VARCHAR(255) NOT NULL DEFAULT '',
	`age_comments` VARCHAR(255) NOT NULL DEFAULT '',
	`shift_information` VARCHAR(255) NOT NULL DEFAULT '',
	`volunteer_information` VARCHAR(255) NOT NULL DEFAULT '',
	`volunteer_requirements` VARCHAR(255) NOT NULL DEFAULT '',
	`organization` VARCHAR(255) NOT NULL DEFAULT '',
	`contact_id` INT(11) NOT NULL COMMENT 'This is either the organization or individual contact ID',
	`meal_information` VARCHAR(255) NOT NULL DEFAULT '',
	`badweather_plan` VARCHAR(255) NOT NULL DEFAULT '',
	`earlycompletion_plan` VARCHAR(255) NOT NULL DEFAULT '',
	`specialcomments` VARCHAR(255) NOT NULL DEFAULT '',
	`categories` VARCHAR(255) NOT NULL DEFAULT '',
	`skills` VARCHAR(255) NOT NULL DEFAULT '',
	`ageranges` VARCHAR(255) NOT NULL DEFAULT '',
	`registration_startdate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Start date to register for an event in the event group.  Note: This datetime is in GMT',
	`registration_enddate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'End date to register for an event in the event group.  Note: This datetime is in GMT',
	`published` tinyint(3) NOT NULL DEFAULT '1',
	`publish_startdate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Start date to publish the event group.  Note: This datetime is in GMT',
	`publish_enddate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'End date to publish the event group.  Note: This datetime is in GMT',
	`ordering` int(11) NOT NULL DEFAULT '0',
	`updatereason_id` INT(11) NULL COMMENT 'Reason for this Update',
	`updatecomments` VARCHAR(100) NOT NULL COMMENT 'Comments for this Update',
	`last_updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Note: This datetime is in GMT',
	`last_updated_by` INT(11) NULL COMMENT 'Joomla User ID of person who made last update',
	PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

-- Create Project Shifts Table
CREATE TABLE IF NOT EXISTS `#__serviceproject_project_shifts` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`shift_id` INT(11) NOT NULL DEFAULT '0' COMMENT 'This is the shift_id of a predefined shift.  Use -1 for custom shift.',
	`eventgroup_id` INT(11) NOT NULL,
	`project_id` INT(11) NOT NULL,
	`title` varchar(255) DEFAULT '' NOT NULL COMMENT 'Title of Shift',
	`startdate` datetime DEFAULT '0000-00-00 00:00:00' COMMENT 'Date and time that shift starts.  Leave all 0 or blank if predefined shift.',
	`enddate` datetime DEFAULT '0000-00-00 00:00:00' COMMENT 'Date and time that shift ends. May be NULL if no defined end date/time.  Leave all 0 or blank if predefined shift.',
	`ordering` int(11) NOT NULL DEFAULT '0' COMMENT 'Shift Sort Order',
	`updatereason_id` INT(11) NULL COMMENT 'Reason for this Update',
	`updatecomments` VARCHAR(100) NOT NULL COMMENT 'Comments for this Update',
	`last_updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Note: This datetime is in GMT',
	`last_updated_by` INT(11) NULL COMMENT 'Joomla User ID of person who made last update',
	PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

-- Create Project Categories Table
CREATE TABLE IF NOT EXISTS `#__serviceproject_project_categories` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`title` varchar(255) NOT NULL DEFAULT '',
	`published` tinyint(3) NOT NULL DEFAULT '1',
	`ordering` int(11) NOT NULL DEFAULT '0' COMMENT 'Shift Sort Order',
	PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

-- Create Project Skills Required Table
CREATE TABLE IF NOT EXISTS `#__serviceproject_project_skills` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`title` varchar(255) NOT NULL DEFAULT '',
	`published` tinyint(3) NOT NULL DEFAULT '1',
	`ordering` int(11) NOT NULL DEFAULT '0' COMMENT 'Shift Sort Order',
	PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

-- Create Project Age Ranges Table
CREATE TABLE IF NOT EXISTS `#__serviceproject_project_ageranges` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`title` varchar(255) NOT NULL DEFAULT '',
	`published` tinyint(3) NOT NULL DEFAULT '1',
	`ordering` int(11) NOT NULL DEFAULT '0' COMMENT 'Shift Sort Order',
	PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

-- Create Shifts Table
CREATE TABLE IF NOT EXISTS `#__serviceproject_eventgroupshifts` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`shift_id` INT(11) NOT NULL,
	`eventgroup_id` INT(11) NOT NULL,
	`title` varchar(255) DEFAULT '' NOT NULL COMMENT 'Title of Shift',
	`startdate` datetime DEFAULT NULL COMMENT 'Date and time that shift starts.',
	`enddate` datetime DEFAULT NULL COMMENT 'Date and time that shift ends. May be NULL if no defined end date/time',
	`published` tinyint(3) NOT NULL DEFAULT '1',
	`ordering` int(11) NOT NULL DEFAULT '0' COMMENT 'Shift Sort Order',
	`updatereason_id` INT(11) NULL COMMENT 'Reason for this Update',
	`updatecomments` VARCHAR(100) NOT NULL COMMENT 'Comments for this Update',
	`last_updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Note: This datetime is in GMT',
	`last_updated_by` INT(11) NULL COMMENT 'Joomla User ID of person who made last update',
	PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

-- Create EventGroups Table
CREATE TABLE IF NOT EXISTS `#__serviceproject_eventgroups` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`eventgroup_id` INT(11) NOT NULL,
	`title` VARCHAR(100) NOT NULL DEFAULT '',
	`description` VARCHAR(255) NOT NULL DEFAULT '',
	`longdescription` MEDIUMTEXT NOT NULL,
	`startdate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'General start date of event group.  Note: This datetime is in GMT',
	`enddate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'General end date of event group.  Note: This datetime is in GMT',
	`registration_startdate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Start date to register for an event in the event group.  Note: This datetime is in GMT',
	`registration_enddate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'End date to register for an event in the event group.  Note: This datetime is in GMT',
	`published` tinyint(3) NOT NULL DEFAULT '1',
	`publish_startdate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Start date to publish the event group.  Note: This datetime is in GMT',
	`publish_enddate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'End date to publish the event group.  Note: This datetime is in GMT',
	`ordering` int(11) NOT NULL DEFAULT '0',
	`updatereason_id` INT(11) NULL COMMENT 'Reason for this Update',
	`updatecomments` VARCHAR(100) NOT NULL COMMENT 'Comments for this Update',
	`last_updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Note: This datetime is in GMT',
	`last_updated_by` INT(11) NULL COMMENT 'Joomla User ID of person who made last update',
	PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

-- Create Profiles Table
CREATE TABLE IF NOT EXISTS `#__serviceproject_profiles` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`profile_id` INT(11) NOT NULL,
	`firstname` VARCHAR(100) NOT NULL,
	`middlename` VARCHAR(100) NOT NULL,
	`lastname` VARCHAR(100) NOT NULL,
	`suffix` VARCHAR(10) NOT NULL,
	`nickname` VARCHAR(100) NOT NULL,
	`address_id` INT(11) NULL,
	`emailhome` VARCHAR(100) NOT NULL,
	`emailwork` VARCHAR(100) NOT NULL,
	`emailother` VARCHAR(100) NOT NULL,
	`emailpreferred` INT(11) NULL DEFAULT '0' COMMENT 'Preferred e-mail for contact: 0=not set, 1=home, 2=work, 3=other',
	`phonehome` VARCHAR(100) NOT NULL,
	`phonework` VARCHAR(100) NOT NULL,
	`phonecell` VARCHAR(100) NOT NULL,
	`phonepreferred` INT(11) NULL DEFAULT '0' COMMENT 'Preferred phone for contact: 0=not set, 1=home, 2=work, 3=cell',
	`birthdate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
	`remotekey` varchar(100) NOT NULL DEFAULT '' COMMENT 'This key is used to remotely modify the profile',
	`published` tinyint(3) NOT NULL DEFAULT '1',
	`updatereason_id` INT(11) NULL COMMENT 'Reason for this Update',
	`updatecomments` VARCHAR(100) NOT NULL COMMENT 'Comments for this Update',
	`last_updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Note: This datetime is in GMT',
	`last_updated_by` INT(11) NULL COMMENT 'Joomla User ID of person who made last update',
	PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

-- Create Adress Table
CREATE TABLE IF NOT EXISTS `#__serviceproject_addresses` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`address_id` INT(11) NOT NULL,
	`addressname` VARCHAR(100) NOT NULL,
	`streetaddress1` VARCHAR(100) NOT NULL,
	`streetaddress2` VARCHAR(100) NOT NULL,
	`city` VARCHAR(100) NOT NULL,
	`state` VARCHAR(100) NOT NULL,
	`zipcode` VARCHAR(12) NOT NULL,
	`latitude` DOUBLE DEFAULT NULL COMMENT 'Latitude',
	`longitude` DOUBLE DEFAULT NULL COMMENT 'Longitude',
	`gm_zoomlevel` DOUBLE DEFAULT NULL COMMENT 'Default Zoom Level for Google Maps',
	`center_latitude` DOUBLE DEFAULT NULL COMMENT 'Latitude of Map Center',
	`center_longitude` DOUBLE DEFAULT NULL COMMENT 'Longitude of Map Center',
	`published` tinyint(3) NOT NULL DEFAULT '0',
	`ordering` int(11) NOT NULL DEFAULT '0',
	`updatereason_id` INT(11) NULL COMMENT 'Reason for this Update',
	`updatecomments` VARCHAR(100) NOT NULL COMMENT 'Comments for this Update',
	`last_updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Note: This datetime is in GMT',
	`last_updated_by` INT(11) NULL COMMENT 'Joomla User ID of person who made last update',
	PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

-- Create Update Reasons Table
CREATE TABLE IF NOT EXISTS `#__serviceproject_updatereasons` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`updatereason_id` INT(11) NOT NULL,
	`updatereason` VARCHAR(100) NOT NULL,
	`updatetype` VARCHAR(100) NOT NULL,
	`published` tinyint(3) NOT NULL DEFAULT '0',
	`ordering` int(11) NOT NULL DEFAULT '0',
	`systemid` int(11) NOT NULL DEFAULT '-1',
	PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

-- Create Linked Profiles Table
CREATE TABLE IF NOT EXISTS `#__serviceproject_linked_profiles` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,	
	`user_id` INT(11) NULL COMMENT 'Joomla User ID',
	`profile_id` INT(11) NULL COMMENT 'ServiceProject Personal Profile ID',
	`link_method` INT(11) NULL COMMENT 'This is the method used to link the profiles. 1=admin side, 2=registration, 3=profile, 4=remote',
	`canregister` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0=ask, 1=allow, 2=deny',
	`canmodify` tinyint(4) NOT NULL DEFAULT '2' COMMENT '0=ask, 1=allow, 2=deny',
	`canaccess` tinyint(4) NOT NULL DEFAULT '2' COMMENT 'Has permission to access protected areas as profile: 0=ask, 1=allow, 2=deny',
	`remotekey` varchar(100) NOT NULL DEFAULT '' COMMENT 'This key is used to remotely activate the profile link',
	`updatereason_id` INT(11) NULL COMMENT 'Reason for this Update',
	`updatecomments` VARCHAR(100) NOT NULL COMMENT 'Comments for this Update',
	`last_updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Note: This datetime is in GMT',
	`last_updated_by` INT(11) NULL COMMENT 'Joomla User ID of person who made last update',
	PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

-- Create Project Role Table
CREATE TABLE IF NOT EXISTS `#__serviceproject_projectroles` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`role_id` INT(11) NOT NULL,
	`role_level` INT(11) NOT NULL COMMENT '1 is highest level',
	`role` VARCHAR(100) NOT NULL,
	`description` VARCHAR(255) NOT NULL DEFAULT '',
	`canmodifyproject` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0=ask, 1=allow, 2=deny',
	`canmodifyvolunteers` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0=ask, 1=allow, 2=deny',
	`canviewcontactinfo` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0=ask, 1=allow, 2=deny',
	`rolelevelscanassign` VARCHAR(100) NOT NULL DEFAULT '',
	`published` tinyint(3) NOT NULL DEFAULT '0',
	`ordering` int(11) NOT NULL DEFAULT '0',
	`systemid` int(11) NOT NULL DEFAULT '-1',
	PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

-- Create Registration Status Table
CREATE TABLE IF NOT EXISTS `#__serviceproject_registrationstatus` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`status_id` INT(11) NOT NULL,
	`status` VARCHAR(100) NOT NULL,
	`description` VARCHAR(255) NOT NULL DEFAULT '',
	`counted` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0=no, 1=yes',
	`published` tinyint(3) NOT NULL DEFAULT '0',
	`ordering` int(11) NOT NULL DEFAULT '0',
	`systemid` int(11) NOT NULL DEFAULT '-1',
	PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

-- Create Subscriptions Table
-- Enables subscription (e-mail notice) on project change or registration

-- Create Archive Projects Table
CREATE TABLE IF NOT EXISTS `#__serviceproject_archive_projects` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`project_id` INT(11) NOT NULL,
	`eventgroup_id` INT(11) NOT NULL,
	`title` VARCHAR(100) NOT NULL DEFAULT '',
	`project_type` INT(11) NOT NULL COMMENT '0 = Organization, 1 = Individual',
	`shortdescription` VARCHAR(255) NOT NULL DEFAULT '',
	`longdescription` MEDIUMTEXT NOT NULL DEFAULT '',
	`address_id` INT(11) NOT NULL,
	`checkin_location` VARCHAR(255) NOT NULL DEFAULT '',
	`age_comments` VARCHAR(255) NOT NULL DEFAULT '',
	`shift_information` VARCHAR(255) NOT NULL DEFAULT '',
	`volunteer_information` VARCHAR(255) NOT NULL DEFAULT '',
	`volunteer_requirements` VARCHAR(255) NOT NULL DEFAULT '',
	`organization` VARCHAR(255) NOT NULL DEFAULT '',
	`contact_id` INT(11) NOT NULL COMMENT 'This is either the organization or individual contact ID',
	`meal_information` VARCHAR(255) NOT NULL DEFAULT '',
	`badweather_plan` VARCHAR(255) NOT NULL DEFAULT '',
	`earlycompletion_plan` VARCHAR(255) NOT NULL DEFAULT '',
	`specialcomments` VARCHAR(255) NOT NULL DEFAULT '',
	`categories` VARCHAR(255) NOT NULL DEFAULT '',
	`skills` VARCHAR(255) NOT NULL DEFAULT '',
	`ageranges` VARCHAR(255) NOT NULL DEFAULT '',
	`registration_startdate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Start date to register for an event in the event group.  Note: This datetime is in GMT',
	`registration_enddate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'End date to register for an event in the event group.  Note: This datetime is in GMT',
	`published` tinyint(3) NOT NULL DEFAULT '1',
	`publish_startdate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Start date to publish the event group.  Note: This datetime is in GMT',
	`publish_enddate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'End date to publish the event group.  Note: This datetime is in GMT',
	`ordering` int(11) NOT NULL DEFAULT '0',
	`updatereason_id` INT(11) NULL COMMENT 'Reason for this Update',
	`updatecomments` VARCHAR(100) NOT NULL COMMENT 'Comments for this Update',
	`last_updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Note: This datetime is in GMT',
	`last_updated_by` INT(11) NULL COMMENT 'Joomla User ID of person who made last update',
	PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

-- Create Archive Project Shifts Table
CREATE TABLE IF NOT EXISTS `#__serviceproject_archive_project_shifts` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`shift_id` INT(11) NOT NULL DEFAULT '0' COMMENT 'This is the shift_id of a predefined shift.  Use -1 for custom shift.',
	`eventgroup_id` INT(11) NOT NULL,
	`project_id` INT(11) NOT NULL,
	`title` varchar(255) DEFAULT '' NOT NULL COMMENT 'Title of Shift',
	`startdate` datetime DEFAULT '0000-00-00 00:00:00' COMMENT 'Date and time that shift starts.  Leave all 0 or blank if predefined shift.',
	`enddate` datetime DEFAULT '0000-00-00 00:00:00' COMMENT 'Date and time that shift ends. May be NULL if no defined end date/time.  Leave all 0 or blank if predefined shift.',
	`ordering` int(11) NOT NULL DEFAULT '0' COMMENT 'Shift Sort Order',
	`updatereason_id` INT(11) NULL COMMENT 'Reason for this Update',
	`updatecomments` VARCHAR(100) NOT NULL COMMENT 'Comments for this Update',
	`last_updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Note: This datetime is in GMT',
	`last_updated_by` INT(11) NULL COMMENT 'Joomla User ID of person who made last update',
	PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

-- Create Archive Shifts Table
CREATE TABLE IF NOT EXISTS `#__serviceproject_archive_eventgroupshifts` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`shift_id` INT(11) NOT NULL,
	`eventgroup_id` INT(11) NOT NULL,
	`title` varchar(255) DEFAULT '' NOT NULL COMMENT 'Title of Shift',
	`startdate` datetime DEFAULT NULL COMMENT 'Date and time that shift starts.',
	`enddate` datetime DEFAULT NULL COMMENT 'Date and time that shift ends. May be NULL if no defined end date/time',
	`published` tinyint(3) NOT NULL DEFAULT '1',
	`ordering` int(11) NOT NULL DEFAULT '0' COMMENT 'Shift Sort Order',
	`updatereason_id` INT(11) NULL COMMENT 'Reason for this Update',
	`updatecomments` VARCHAR(100) NOT NULL COMMENT 'Comments for this Update',
	`last_updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Note: This datetime is in GMT',
	`last_updated_by` INT(11) NULL COMMENT 'Joomla User ID of person who made last update',
	PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

-- Create Archive EventGroups Table
CREATE TABLE IF NOT EXISTS `#__serviceproject_archive_eventgroups` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`eventgroup_id` INT(11) NOT NULL,
	`title` varchar(100) NOT NULL DEFAULT '',
	`description` VARCHAR(255) NOT NULL DEFAULT '',
	`longdescription` MEDIUMTEXT NOT NULL,
	`startdate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'General start date of event group.  Note: This datetime is in GMT',
	`enddate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'General end date of event group.  Note: This datetime is in GMT',
	`registration_startdate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Start date to register for an event in the event group.  Note: This datetime is in GMT',
	`registration_enddate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'End date to register for an event in the event group.  Note: This datetime is in GMT',
	`published` tinyint(3) NOT NULL DEFAULT '1',
	`publish_startdate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Start date to publish the event group.  Note: This datetime is in GMT',
	`publish_enddate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'End date to publish the event group.  Note: This datetime is in GMT',
	`ordering` int(11) NOT NULL DEFAULT '0',
	`updatereason_id` INT(11) NULL COMMENT 'Reason for this Update',
	`updatecomments` VARCHAR(100) NOT NULL COMMENT 'Comments for this Update',
	`last_updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Note: This datetime is in GMT',
	`last_updated_by` INT(11) NULL COMMENT 'Joomla User ID of person who made last update',
	PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

-- Create Archive Profiles Table
CREATE TABLE IF NOT EXISTS `#__serviceproject_archive_profiles` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`profile_id` INT(11) NOT NULL,
	`firstname` VARCHAR(100) NOT NULL,
	`middlename` VARCHAR(100) NOT NULL,
	`lastname` VARCHAR(100) NOT NULL,
	`suffix` VARCHAR(10) NOT NULL,
	`nickname` VARCHAR(100) NOT NULL,
	`address_id` INT(11) NULL,
	`emailhome` VARCHAR(100) NOT NULL,
	`emailwork` VARCHAR(100) NOT NULL,
	`emailother` VARCHAR(100) NOT NULL,
	`emailpreferred` INT(11) NULL DEFAULT '0' COMMENT 'Preferred e-mail for contact: 0=not set, 1=home, 2=work, 3=other',
	`phonehome` VARCHAR(100) NOT NULL,
	`phonework` VARCHAR(100) NOT NULL,
	`phonecell` VARCHAR(100) NOT NULL,
	`phonepreferred` INT(11) NULL DEFAULT '0' COMMENT 'Preferred phone for contact: 0=not set, 1=home, 2=work, 3=cell',
	`birthdate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
	`remotekey` varchar(100) NOT NULL DEFAULT '' COMMENT 'This key is used to remotely modify the profile',
	`published` tinyint(3) NOT NULL DEFAULT '1',
	`updatereason_id` INT(11) NULL COMMENT 'Reason for this Update',
	`updatecomments` VARCHAR(100) NOT NULL COMMENT 'Comments for this Update',
	`last_updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Note: This datetime is in GMT',
	`last_updated_by` INT(11) NULL COMMENT 'Joomla User ID of person who made last update',
	PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

-- Create Archive Address Table
CREATE TABLE IF NOT EXISTS `#__serviceproject_archive_addresses` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`address_id` INT(11) NOT NULL,
	`addressname` VARCHAR(100) NOT NULL,
	`streetaddress1` VARCHAR(100) NOT NULL,
	`streetaddress2` VARCHAR(100) NOT NULL,
	`city` VARCHAR(100) NOT NULL,
	`state` VARCHAR(100) NOT NULL,
	`zipcode` VARCHAR(12) NOT NULL,
	`latitude` DOUBLE DEFAULT NULL COMMENT 'Latitude',
	`longitude` DOUBLE DEFAULT NULL COMMENT 'Longitude',
	`gm_zoomlevel` DOUBLE DEFAULT NULL COMMENT 'Default Zoom Level for Google Maps',
	`center_latitude` DOUBLE DEFAULT NULL COMMENT 'Latitude of Map Center',
	`center_longitude` DOUBLE DEFAULT NULL COMMENT 'Longitude of Map Center',
	`published` tinyint(3) NOT NULL DEFAULT '0',
	`ordering` int(11) NOT NULL DEFAULT '0',
	`updatereason_id` INT(11) NULL COMMENT 'Reason for this Update',
	`updatecomments` VARCHAR(100) NOT NULL COMMENT 'Comments for this Update',
	`last_updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Note: This datetime is in GMT',
	`last_updated_by` INT(11) NULL COMMENT 'Joomla User ID of person who made last update',
	PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

-- Create Archive Linked Profiles Table
CREATE TABLE IF NOT EXISTS `#__serviceproject_archive_linked_profiles` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,	
	`user_id` INT(11) NULL COMMENT 'Joomla User ID',
	`profile_id` INT(11) NULL COMMENT 'ServiceProject Personal Profile ID',
	`link_method` INT(11) NULL COMMENT 'This is the method used to link the profiles. 1=admin side, 2=registration, 3=profile, 4=remote',
	`canregister` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0=ask, 1=allow, 2=deny',
	`canmodify` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0=ask, 1=allow, 2=deny',
	`canaccess` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Has permission to access protected areas as profile: 0=ask, 1=allow, 2=deny',
	`remotekey` varchar(100) NOT NULL DEFAULT '' COMMENT 'This key is used to remotely activate the profile link',
	`updatereason_id` INT(11) NULL COMMENT 'Reason for this Update',
	`updatecomments` VARCHAR(100) NOT NULL COMMENT 'Comments for this Update',
	`last_updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Note: This datetime is in GMT',
	`last_updated_by` INT(11) NULL COMMENT 'Joomla User ID of person who made last update',
	PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
