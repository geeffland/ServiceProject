-- com_serviceproject install SQL file
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

-- Create Proposed Projects Table

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

INSERT INTO `#__serviceproject_project_categories` (`title`, `ordering`) VALUES
	('Serve', 1),
	('Fix-It', 2),
	('Clean-It', 3),
	('Build-It', 4),
	('Donate', 5),
	('Sort', 6),
	('Kindness', 7),
	('Arts//Crafts', 8),
	('Outside', 9),
	('Inside', 10),
	('Other', 11);

-- Create Project Skills Required Table
CREATE TABLE IF NOT EXISTS `#__serviceproject_project_skills` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`title` varchar(255) NOT NULL DEFAULT '',
	`published` tinyint(3) NOT NULL DEFAULT '1',
	`ordering` int(11) NOT NULL DEFAULT '0' COMMENT 'Shift Sort Order',
	PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

INSERT INTO `#__serviceproject_project_skills` (`title`, `ordering`) VALUES
	('Painting', 1),
	('Cleaning', 2),
	('Yardwork', 3),
	('Light Construction', 4),
	('Crafts', 5),
	('Visiting', 6),
	('Food Prep', 7),
	('Delivery', 8);

-- Create Project Age Ranges Table
CREATE TABLE IF NOT EXISTS `#__serviceproject_project_ageranges` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`title` varchar(255) NOT NULL DEFAULT '',
	`published` tinyint(3) NOT NULL DEFAULT '1',
	`ordering` int(11) NOT NULL DEFAULT '0' COMMENT 'Shift Sort Order',
	PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

INSERT INTO `#__serviceproject_project_ageranges` (`title`, `ordering`) VALUES
	('Under 5 Years of Age', 1),
	('Ages 5 - 11', 2),
	('Ages 12 - 15', 3),
	('Ages 16+', 4),
	('Other', 5);

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

-- Fill in default Update Reasons
INSERT INTO `#__serviceproject_updatereasons` (`updatereason_id`, `updatereason`, `updatetype`, `ordering`, `published`, `systemid`) VALUES
	(100, 'COM_SERVICEPROJECT_UR_NEWPROFILE', 'profile', 1, 1, -1),
	(110, 'COM_SERVICEPROJECT_UR_EDITNAME', 'profile', 2, 1, -1),
	(111, 'COM_SERVICEPROJECT_UR_EDITADDRESS', 'profile', 3, 1, -1),
	(112, 'COM_SERVICEPROJECT_UR_EDITEMAIL', 'profile', 4, 1, -1),
	(113, 'COM_SERVICEPROJECT_UR_EDITPHONE', 'profile', 5, 1, -1),
	(114, 'COM_SERVICEPROJECT_UR_EDITBIRTHDATE', 'profile', 6, 1, -1),
	(115, 'COM_SERVICEPROJECT_UR_SPLITADDRESS', 'profile', 7, 1, 1001),
	(116, 'COM_SERVICEPROJECT_UR_MERGEADDRESS', 'profile', 8, 1, 1002),
	(117, 'COM_SERVICEPROJECT_UR_STATECHANGEPROFILE', 'profile', 9, 1, 1003),
	(118, 'COM_SERVICEPROJECT_UR_MERGEPROFILE', 'profile', 10, 1, 1004),
	(119, 'COM_SERVICEPROJECT_UR_COPYPROFILE', 'profile', 11, 1, 1005),
	(120, 'COM_SERVICEPROJECT_UR_DELETEPROFILE', 'profile', 12, 1, 1006),
	(200, 'COM_SERVICEPROJECT_UR_NEWADDRESS', 'address', 1, 1, -1),
	(201, 'COM_SERVICEPROJECT_UR_ADDGEOCODES', 'address', 2, 1, -1),
	(210, 'COM_SERVICEPROJECT_UR_EDITADDRESS', 'address', 3, 1, -1),
	(211, 'COM_SERVICEPROJECT_UR_EDITGEOCODES', 'address', 4, 1, -1),
	(212, 'COM_SERVICEPROJECT_UR_SPLITADDRESS', 'address', 5, 1, 2001),
	(213, 'COM_SERVICEPROJECT_UR_MERGEADDRESS', 'address', 6, 1, 2002),
	(214, 'COM_SERVICEPROJECT_UR_COPYADDRESS', 'address', 7, 1, 2003),
	(215, 'COM_SERVICEPROJECT_UR_DELETEADDRESS', 'address', 8, 1, 2004),
	(216, 'COM_SERVICEPROJECT_UR_STATECHANGEADDRESS', 'address', 9, 1, 2005),
	(300, 'COM_SERVICEPROJECT_UR_NEWEVENTGROUP', 'eventgroup', 1, 1, -1),
	(301, 'COM_SERVICEPROJECT_UR_EDITEVENTGROUPDESCRIPTION', 'eventgroup', 2, 1, -1),
	(302, 'COM_SERVICEPROJECT_UR_EDITEVENTGROUPSTARTEND', 'eventgroup', 3, 1, -1),
	(303, 'COM_SERVICEPROJECT_UR_EDITEVENTGROUPREGISTRATION', 'eventgroup', 4, 1, -1),
	(304, 'COM_SERVICEPROJECT_UR_EDITEVENTGROUPPUBLISHDATES', 'eventgroup', 5, 1, -1),
	(400, 'COM_SERVICEPROJECT_UR_NEWEVENTGROUPSHIFT', 'eventgroupshift', 1, 1, -1),
	(401, 'COM_SERVICEPROJECT_UR_EDITEVENTGROUPSHIFT', 'eventgroupshift', 2, 1, -1),
	(402, 'COM_SERVICEPROJECT_UR_EDITEVENTGROUPSHIFTSTARTEND', 'eventgroupshift', 3, 1, -1),
	(403, 'COM_SERVICEPROJECT_UR_EDITEVENTGROUPSHIFTPUBLISHED', 'eventgroupshift', 4, 1, -1),
	(404, 'COM_SERVICEPROJECT_UR_COPYEVENTGROUPSHIFT', 'eventgroupshift', 5, 1, 3001);

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

INSERT INTO `#__serviceproject_projectroles` ( `role_id`, `role_level`, `role`, `description`, `canmodifyproject`, `canmodifyvolunteers`, `canviewcontactinfo`, `rolelevelscanassign`, `published`, `ordering`, `systemid`) VALUES
	( 0, 0, 'COM_SERVICEPROJECT_ROLE_SUBMITTER', 'COM_SERVICEPROJECT_ROLE_DESCRIPTION_SUBMITTER', 0, 0, 0, '', 1, 1, 1000),
	( 100, 1, 'COM_SERVICEPROJECT_ROLE_PROJECTMANAGER', 'COM_SERVICEPROJECT_ROLE_DESCRIPTION_PROJECTMANAGER', 1, 1, 1, '2, 3, 4', 1, 2, 1001),
	( 200, 2, 'COM_SERVICEPROJECT_ROLE_PROJECTFOREMAN', 'COM_SERVICEPROJECT_ROLE_DESCRIPTION_PROJECTFOREMAN', 1, 1, 1, '3, 4', 1, 3, 2001),
	( 300, 3, 'COM_SERVICEPROJECT_ROLE_PROJECTCOFOREMAN', 'COM_SERVICEPROJECT_ROLE_DESCRIPTION_PROJECTCOFOREMAN', 1, 1, 1, '4', 1, 4, 3001),
	( 400, 4, 'COM_SERVICEPROJECT_ROLE_VOLUNTEERCOORDINATOR', 'COM_SERVICEPROJECT_ROLE_DESCRIPTION_VOLUNTEERCOORDINATOR', 1, 1, 1, '', 1, 5, 4001),
	( 500, 5, 'COM_SERVICEPROJECT_ROLE_ATTENDEE', 'COM_SERVICEPROJECT_ROLE_DESCRIPTION_ATTENDEE', 0, 0, 0, '', 1, 6, 5001);

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

INSERT INTO `#__serviceproject_registrationstatus` (`status_id`, `status`, `description`, `counted`, `published`, `ordering`, `systemid` ) VALUES
	(100, 'COM_SERVICEPROJECT_REGISTRATION_STATUS_REGISTERED', 'COM_SERVICEPROJECT_REGISTRATION_STATUS_DESCRIPTION_REGISTERED', 1, 1, 1, 1001),
	(101, 'COM_SERVICEPROJECT_REGISTRATION_STATUS_REGISTERED_NOTCOUNTED', 'COM_SERVICEPROJECT_REGISTRATION_STATUS_DESCRIPTION_REGISTERED_NOTCOUNTED', 0, 1, 2, 1002),
	(102, 'COM_SERVICEPROJECT_REGISTRATION_STATUS_ONWAITLIST', 'COM_SERVICEPROJECT_REGISTRATION_STATUS_DESCRIPTION_ONWAITLIST', 0, 1, 3, 1003),
	(103, 'COM_SERVICEPROJECT_REGISTRATION_STATUS_AWAITINGAPPROVAL', 'COM_SERVICEPROJECT_REGISTRATION_STATUS_DESCRIPTION_AWAITINGAPPROVAL', 0, 1, 4, 1004),
	(104, 'COM_SERVICEPROJECT_REGISTRATION_STATUS_AWAITINGPROFILESAPPROVAL', 'COM_SERVICEPROJECT_REGISTRATION_STATUS_DESCRIPTION_AWAITINGPROFILESAPPROVAL', 0, 1, 5, 1005),
	(105, 'COM_SERVICEPROJECT_REGISTRATION_STATUS_ASSIGNED', 'COM_SERVICEPROJECT_REGISTRATION_STATUS_DESCRIPTION_ASSIGNED', 1, 1, 6, 1006),
	(106, 'COM_SERVICEPROJECT_REGISTRATION_STATUS_ASSIGNED_NOTCOUNTED', 'COM_SERVICEPROJECT_REGISTRATION_STATUS_DESCRIPTION_ASSIGNED_NOTCOUNTED', 0, 1, 7, 1007),
	(200, 'COM_SERVICEPROJECT_REGISTRATION_STATUS_ATTENDED', 'COM_SERVICEPROJECT_REGISTRATION_STATUS_DESCRIPTION_ATTENDED', 1, 1, 8, 2001),
	(201, 'COM_SERVICEPROJECT_REGISTRATION_STATUS_ATTENDED_NOTCOUNTED', 'COM_SERVICEPROJECT_REGISTRATION_STATUS_DESCRIPTION_ATTENDED_NOTCOUNTED', 0, 1, 9, 2002),
	(300, 'COM_SERVICEPROJECT_REGISTRATION_STATUS_NOSHOW', 'COM_SERVICEPROJECT_REGISTRATION_STATUS_DESCRIPTION_NOSHOW', 0, 1, 10, 3001),
	(301, 'COM_SERVICEPROJECT_REGISTRATION_STATUS_REJECTED', 'COM_SERVICEPROJECT_REGISTRATION_STATUS_DESCRIPTION_REJECTED', 0, 1, 11, 3002),
	(400, 'COM_SERVICEPROJECT_REGISTRATION_STATUS_CANCELLED', 'COM_SERVICEPROJECT_REGISTRATION_STATUS_DESCRIPTION_CANCELLED', 0, 1, 12, 4001),
	(401, 'COM_SERVICEPROJECT_REGISTRATION_STATUS_EXPIRED', 'COM_SERVICEPROJECT_REGISTRATION_STATUS_DESCRIPTION_EXPIRED', 0, 1, 13, 4002);

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

-- Fill in default testing data
INSERT INTO `#__serviceproject_addresses` (`address_id`, `addressname`, `streetaddress1`, `streetaddress2`, `city`, `state`, `zipcode`, `ordering`, `updatereason_id`, `updatecomments`, `last_updated`, `last_updated_by`, `published`) VALUES
	(1, 'LSUMC', '114 SE Douglas', '', 'Lee\'s Summit', 'Missouri', '64063', 1, 200, 'New Address was added', '2010-08-27 11:44:00', -1, 1),
	(2, 'Butler', '1540 Genessee St.', '', 'Kansas City', 'Missouri', '64102', 2, 200, 'New Address was added', '2010-08-27 11:44:00', -1, 1),
	(3, 'Butler R&D', '13500 Botts Road', '', 'Grandview', 'Missouri', '64030-2897', 3, 200, 'New Address was added', '2010-08-27 11:44:00', -1, 1),
	(4, '', '1123 Main St', '', 'Lee\'s Summit', 'Missouri', '64082', 4, 200, 'New Address was added', '2010-08-27 11:44:00', -1, 1);

INSERT INTO `#__serviceproject_profiles` (`profile_id`, `firstname`, `middlename`, `lastname`, `suffix`, `nickname`, `address_id`, `emailhome`, `emailwork`, `emailother`, `emailpreferred`, `phonehome`, `phonework`, `phonecell`, `phonepreferred`, `birthdate`, `updatereason_id`, `updatecomments`, `last_updated`, `last_updated_by`, `published`) VALUES
	(1, 'Joe', 'Middle1', 'Bloek', '', 'Joe', 1, 'JoeBloek-home@test.effland.org', 'JoeBloek-work@test.effland.org', 'JoeBloek-other@test.effland.org', 1, '(816) 555-1111', '(816) 555-1112', '(816) 555-1113', 1, '2010-01-27 11:44:00', 100, 'New Profile', '2010-08-27 11:44:00', -1, 1),
	(2, 'Fred', '', 'Williams', 'III', 'Fred', 2, 'FredW-home@test.effland.org', 'FredW-work@test.effland.org', 'FredW-other@test.effland.org', 2, '(816) 555-2221', '(816) 555-2222', '(816) 555-2223', 2, '2010-02-27 11:44:00', 100, 'New Profile', '2010-08-27 11:44:00', -1, 1),
	(3, 'Bob', 'Middle3', 'Jones', 'Sr.', 'Bob', 3, 'BobJ-home@test.effland.org', 'BobJ-work@test.effland.org', 'BobJ-other@test.effland.org', 3, '(816) 555-3331', '(816) 555-3332', '(816) 555-3333', 3, '2010-03-27 11:44:00', 100, 'New Profile', '2010-08-27 11:44:00', -1, 1),
	(4, 'Sam', '', 'Jones', 'Jr.', 'Sam', 3, 'SamJ-home@test.effland.org', 'SamJ-work@test.effland.org', 'SamJ-other@test.effland.org', 0, '(816) 555-4441', '(816) 555-4442', '(816) 555-4443', 0, '2010-04-27 11:44:00', 100, 'New Profile', '2010-08-27 11:44:00', -1, 1),
	(5, 'Bob', 'Middle5', 'Smith', 'Sr.', 'Bob', 4, 'BobS-home@test.effland.org', 'BobS-work@test.effland.org', 'BobS-other@test.effland.org', 1, '(816) 555-5551', '(816) 555-5552', '(816) 555-5553', 2, '2010-05-27 11:44:00', 100, 'New Profile', '2010-08-27 11:44:00', -1, 1);

INSERT INTO `#__serviceproject_config` (`config_name`, `config_subname`, `config_value`) VALUES
	('next_address_id', '', '5'),
	('next_profile_id', '', '6'),
	('next_eventgroup_id', '', '2'),
	('next_eventgroupshift_id', '', '1'),
	('next_project_id', '', '1'),
	('next_updatereason_id', '', '1000'),
	('next_projectrole_id', '', '1'),
	('next_registrationstatus_id', '', '1001'),
	('email_new_projectassignee', '', '0'),
	('email_new_registrations', '', '0'),
	('email_delete_registrations', '', '0');

INSERT INTO `#__serviceproject_projectroles` ( `role_id`, `role_level`, `role`, `description`, `canmodifyproject`, `canmodifyvolunteers`, `canviewcontactinfo`, `rolelevelscanassign`, `published`, `ordering`, `systemid`) VALUES
	( 1000, 5, 'Test', 'Test', 0, 0, 0, '', 1, 6, -1);

INSERT INTO `#__serviceproject_registrationstatus` (`status_id`, `status`, `description`, `counted`, `published`, `ordering`, `systemid` ) VALUES
	(1000, 'Test Status', 'Not sure what this status is for', 1, 1, 13, -1);

INSERT INTO `#__serviceproject_eventgroups` (	`eventgroup_id`, `title`, `description`, `longdescription`, `startdate`, `enddate`, `registration_startdate`, `registration_enddate`, `published`, `publish_startdate`, `publish_enddate`, `updatereason_id`, `updatecomments`, `last_updated`, `last_updated_by`) VALUES
	(1, 'Event Group #1', 'This event group is for Group #1', '<p>This is a <strong>test </strong>of a long description.</p>\r\n<p><img src="images/joomla_logo_black.jpg" border="0" /></p>\r\n<p>It is with great pleasure and pride that the <strong>Joomla Production Leadership</strong> Team (PLT) announces the <a href="http://www.joomla.org/announcements/general-news/5348-joomlar-16-has-arrived.html">release of Joomla! 1.6</a>.   Our community has been anticipating this milestone for many months. As  we celebrate the arrival of the new version, we wish to recognize the  many people who have made this day possible.</p>\r\n<p>The PLT would like to thank everyone who contributed time, code and  patches to make 1.6 happen.  We covered the full spectrum of emotion  while taking the 1,000-plus day journey, but in the end, all the hard  work and commitment has paid off. With heartfelt appreciation, we would  like to thank the following people for their efforts:</p>\r\n<p>Adrian Louter, Adrian Victor III Onod, Airton Torres, Amy Stephen,  Andrea Tarr, Andrew Eddie, Andy Capiau, Angie Radtke, Anja Hage, Anthony  McLin, Antonio Escobar Tizon, Artyom Bisyarin, Benjamin Trenkle, Bill  Richardson, Birger Lehner, Boris Baddenoff, Brian Teeman, C. Tapuscrine,  Cherif Gouiaa, Chris Davenport, Christophe Demko, Christopher Garvis,  Cristina Solana, CY Lee, Dennis Hermacki, Elin Waring, Ercan Ozkaya,  Franklin Tse, Gergo Erdosi, Gobezu Sewu, Hannes Papenberg, Harry  Reinhardt, Ian MacLennan, Iszak Bryan, Jacob Waisner, Janich Rasmussen,  Jason Pettett, Jean-Marie Simonet, Jen Kramer, Jennifer Marriott, Jeremy  Wilken, Jonatas Braganca, Jonnathan S. Lima, Joseph LeBlanc, Kevin  Devine, Klas Berlic, Louis Landry, Loyd Headrick, Marijke Stuivenberg,  Marius van Rijnsoever, Mark Dexter, Martijn Maandag, Mathavan Jeyadev,  Matt Thomas, Michael Babker, Navid Zeraati, Nicholas Dionysopoulos,  Nikolai Plath, Ole Bang Ottosen, Omar Ramos, Peter Osipof, Phani  Kalluri, Phil Snell, Prasit Gebsaap, Radek Suski, Ramindu Deshapriya,  Rob Joyce, Rob Schley, Robert Deutz, Roland Dalmulder, Ron Severdia,  Ronald de Vries, Ronald Pijpers, Rouven Weßling, Rune Sjøen, Samuel  Moffatt, Sander Potjer, Selene Feigl, Sergio Iglesias, Stefania  Gaianigo, Steve Burge, Sudhi Seshachala, Thierry Bela, Tim Plummer, Tore  Krudtaa, Troy Hall, Tudor Mazilu, Viet Hoang Vu, Zachary Draper.</p>\r\n<p>It is impossible to name each contributor without whom 1.6 would not  exist. So many individuals have given freely and selflessly to an  amazing project for the benefit of its community of users,  administrators, developers and designers.</p>\r\n<p>Thanks also goes to those who contributed to the development of the  help screens for Joomla 1.6: Javier Ballester, Klas Berlic, Josh  [Coder4life], Scott Cooper, Miguel Costa, James Cutrone, Mark Dexter,  Noel Dixon, Anja Hage, Dave Harker, Gauurang Khanna, Ian MacLennan,  Denis Mouraux, Darcy Peal, Max Shinn, Rouven Weßling, Lica Wouters.</p>\r\n<p>We thank the hundreds of people who made changes or additions to the  documentation wiki during the 1.6 release cycle. The following deserve  special mention: Rene Serradeil, Alex Bachmann, and Lorna Scammell.</p>\r\n<p>Thank you to the people who worked through the weekend to prepare the  Joomla 1.6 landing page and supporting materials ready. A big thanks  goes to Kyle Ledbetter, who worked tirelessly on banners and the landing  page design, and to Steve Burge for organizing this effort. Thanks also  go to Alice Grevet, Allan Walker, Andrea Tarr, Andrew Eddie, Dianne  Henning, Jacques Rentzke, Jean-Marie (JM) Simonet, Jen Kramer, John  Coonen, Jonathan Neubauer, Kristoffer Sandven, Luis Méndez Alejo, Marco  Corrò, Marijke Stuivenberg, Mark Dexter, Matt Lipscomb, Milena Mitova,  Neil Malhar, Ole Bang Ottosen, Paul Orwig, Robert Deutz, Robert Vining,  Ryan Ozimek, Sandra Warren, Tess Neale, and TJ Baker.</p>\r\n<p>We’d also like to thank, in advance, all the people who will make  implementing 1.6 a success.  With the release of General Availability  (GA) comes the enormous effort of compiling new language packs. We  express our thanks and appreciation to the translation teams who will  put a staggering number of hours into producing the required files.   Thanks in advance to all the people that will assist with support on the  forums and other sites and we bestow on you a blessing of wisdom and  patience. We’d also like to honour all of the Joomla extension  developers who will be furiously upgrading their code for compatibility  with 1.6. We eagerly anticipate the amazing extensions and the  innovation in both form and function.</p>\r\n<p>Finally, we cannot pass up this opportunity to thank the Community  Leadership Team (CLT), responsible for the web sites that keep the  Joomla universe in orbit (the JED, JRD, JCM and more).  Likewise we’d  like to thank Open Source Matters for their continued support and  stewardship of the project and the 1.6 release.</p>\r\n<p>The hard work does not stop with this release.  The PLT will  continues the responsibility of overseeing the maintenance of both  Joomla 1.5 and 1.6, and also coordinating the efforts for the production  of the next version of Joomla, codenamed <a href="http://www.joomla.org/announcements/general-news/5321-rediscover-content-the-vision-for-next-years-release.html">Bowerbird</a>.</p>\r\n<p>If you would like to stay informed about Joomla 1.6 news, please subcribe to our <a href="http://www.joomla.org/mailing-lists.html">newsletter</a>.</p>\r\n<div id="comments">\r\n<h3 id="comments-num"><span class="numcomments">0</span> Comments</h3>\r\n</div>\r\n<div class="footer">\r\n<ul class="menu">\r\n<li class="item97"><a href="http://www.joomla.org/"><span>Home</span></a></li>\r\n<li class="item110"><a href="http://www.joomla.org/about-joomla.html"><span>About Joomla</span></a></li>\r\n<li class="item98"><a href="http://community.joomla.org/"><span>Community</span></a></li>\r\n<li class="item99"><a href="http://forum.joomla.org/"><span>Forum</span></a></li>\r\n<li class="item100"><a href="http://extensions.joomla.org/"><span>Extensions</span></a></li>\r\n<li class="item206"><a href="http://resources.joomla.org/"><span>Resources</span></a></li>\r\n<li class="item102"><a href="http://docs.joomla.org/"><span>Documentation</span></a></li>\r\n<li class="item101"><a href="http://developer.joomla.org/"><span>Developer</span></a></li>\r\n<li class="item103"><a href="http://shop.joomla.org/"><span>Shop</span></a></li>\r\n</ul>\r\n<div id="footerInfo">©2005-2011 <a href="http://www.opensourcematters.org/">Open Source Matters, Inc.</a> All rights reserved.              			<a href="http://www.rochenhost.com/joomla-hosting" target="_blank">Joomla Hosting</a> by Rochen Ltd.              			<a href="http://jxtended.com/" target="_blank">Empowered by JXtended</a> <a href="http://www.joomla.org/accessibility-statement.html">Accessibility Statement</a> <a href="http://www.joomla.org/privacy-policy.html">Privacy Policy</a> <a href="http://community.joomla.org/login.html">Log in</a></div>\r\n</div>\r\n<p><a class="support-joomla-left-corner" href="http://contribute.joomla.org/" title="Support Joomla! by making a financial contribution."> Support Joomla!</a></p>', '2011-01-01 11:44:00', '2011-01-03 11:44:00', '2010-12-01 11:44:00', '2011-01-03 11:44:00', 1, '2010-12-01 11:44:00', '2011-01-03 11:44:00', 300, 'New Event Group', '2010-12-13 11:36:00', -1);

INSERT INTO `#__serviceproject_linked_profiles` (`user_id`, `profile_id`, `link_method`, `canregister`, `canmodify`, `canaccess`) VALUES
	(42, 1, 1, 1, 1, 1),
	(42, 2, 1, 1, 0, 0),
	(42, 3, 1, 2, 2, 2);