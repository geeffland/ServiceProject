-- com_serviceproject uninstall SQL file
-- version 1.0.0
-- http://cbconnector.com

-- Drop existing tables for com_serviceproject
DROP TABLE IF EXISTS `#__serviceproject_config`;
DROP TABLE IF EXISTS `#__serviceproject_proposed_projects`;
DROP TABLE IF EXISTS `#__serviceproject_projects`;
DROP TABLE IF EXISTS `#__serviceproject_project_ageranges`;
DROP TABLE IF EXISTS `#__serviceproject_project_categories`;
DROP TABLE IF EXISTS `#__serviceproject_project_skills`;
DROP TABLE IF EXISTS `#__serviceproject_shifts`;
DROP TABLE IF EXISTS `#__serviceproject_eventgroups`;
DROP TABLE IF EXISTS `#__serviceproject_eventgroupshifts`;
DROP TABLE IF EXISTS `#__serviceproject_profiles`;					-- implemented
DROP TABLE IF EXISTS `#__serviceproject_addresses`;				-- implemented
DROP TABLE IF EXISTS `#__serviceproject_states`;					-- implemented
DROP TABLE IF EXISTS `#__serviceproject_updatereasons`;			-- implemented
DROP TABLE IF EXISTS `#__serviceproject_linked_profiles`;			-- implemented
DROP TABLE IF EXISTS `#__serviceproject_projectroles`;				-- implemented
DROP TABLE IF EXISTS `#__serviceproject_registrationstatus`;		-- implemented
DROP TABLE IF EXISTS `#__serviceproject_subscriptions`;

-- Drop existing archive tables for com_serviceproject
DROP TABLE IF EXISTS `#__serviceproject_archive_proposed_projects`;
DROP TABLE IF EXISTS `#__serviceproject_archive_projects`;
DROP TABLE IF EXISTS `#__serviceproject_archive_shifts`;
DROP TABLE IF EXISTS `#__serviceproject_archive_eventgroups`;
DROP TABLE IF EXISTS `#__serviceproject_archive_eventgroupshifts`;
DROP TABLE IF EXISTS `#__serviceproject_archive_profiles`;			-- implemented
DROP TABLE IF EXISTS `#__serviceproject_archive_addresses`;		-- implemented
DROP TABLE IF EXISTS `#__serviceproject_archive_linked_profiles`;
DROP TABLE IF EXISTS `#__serviceproject_archive_registrationstatus`;
DROP TABLE IF EXISTS `#__serviceproject_archive_subscriptions`;