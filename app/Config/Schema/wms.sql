--
-- Database: `wms`
--

-- CREATE DATABASE IF NOT EXISTS `snappi_wms` CHARSET=utf8 COLLATE=utf8_unicode_ci;
-- GRANT ALL PRIVILEGES ON `snappi_wms` . * TO 'snaphappi'@'localhost';
USE 'snappi_wms';


-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

DROP TABLE IF EXISTS `activity_logs`;
CREATE TABLE IF NOT EXISTS `activity_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `editor_id` int(11) NOT NULL,
  `comment` text CHARSET utf8 COLLATE utf8_general_ci NOT NULL ,
  `model` varchar(100) NOT NULL,
  `foreign_key` char(36) NOT NULL COMMENT 'either a UUID, or int primary key',
  `workorder_id` int(11) NOT NULL COMMENT 'for Activity Log group by workorder',
  `tasks_workorder_id` int(11) NOT NULL COMMENT 'for Activity Log group by tasks_workorder',
  `flag_status` tinyint(1) DEFAULT NULL COMMENT 'raised=1, cleared=0, no flag=NULL',
  `flag_id` int(11) DEFAULT NULL COMMENT 'self referencing field, references activity_logs.id',
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`), 
  KEY `fk_editor` (`editor_id`),
  KEY `fk_target` (`model`, `foreign_key`),
  KEY `fk_flag_id` (`flag_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `assets_tasks`
--

DROP TABLE IF EXISTS `assets_tasks`;
CREATE TABLE IF NOT EXISTS `assets_tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tasks_workorder_id` int(11)  NOT NULL,
  `asset_id` char(36) CHARSET utf8 COLLATE utf8_general_ci NOT NULL,
  `edit_count` int(4) NOT NULL DEFAULT '0' COMMENT 'for fast access to unedited Assets',
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `fk_habtm_join` (`tasks_workorder_id`,`asset_id`),
  KEY `fk_assets` (`asset_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci  AUTO_INCREMENT=1;

-- --------------------------------------------------------

--
-- Table structure for table `assets_workorders`
--

DROP TABLE IF EXISTS `assets_workorders`;
CREATE TABLE IF NOT EXISTS `assets_workorders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `workorder_id` int(11) NOT NULL,
  `asset_id` char(36) CHARSET utf8 COLLATE utf8_general_ci NOT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `fk_habtm_join` (`workorder_id`,`asset_id`),
  KEY `fk_assets` (`asset_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1;

-- --------------------------------------------------------

--
-- Table structure for table `editors`
--

DROP TABLE IF EXISTS `editors`;
CREATE TABLE IF NOT EXISTS `editors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` char(36) CHARSET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'foreign key to snappi.users table, Editor belongsTo User',
  `username` varchar(100) NOT NULL,
  `password` varchar(250) NOT NULL,
  `role` enum('manager','operator') NOT NULL DEFAULT 'operator',
  `work_week` char(7) NOT NULL COMMENT 'each position of the string represents from monday to sunday, ie, works all days: 1111111, works monday to friday: 1111100, works weekends: 0000011, works only tuesdays and sundays: 0100001',
  `workday_hours` decimal(4,2) NOT NULL COMMENT 'hours per day they are scheduled to work',
  `editor_tasksworkorders_count` int(11) NOT NULL DEFAULT 0,
  `editor_assetstasks_count` int(11) NOT NULL DEFAULT 0,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

DROP TABLE IF EXISTS `skills`;
CREATE TABLE IF NOT EXISTS `skills` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `editor_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `rate_1_day` DECIMAL(9,2) NOT NULL DEFAULT 0.0,
  `rate_7_day` DECIMAL(9,2) NOT NULL DEFAULT 0.0,
  `rate_30_day` DECIMAL(9,2) NOT NULL DEFAULT 0.0,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_habtm_join` (`editor_id`,`task_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 COMMENT 'habtm join table between Tasks and Editors' ;

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

DROP TABLE IF EXISTS `tasks`;
CREATE TABLE IF NOT EXISTS `tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(36) CHARSET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'legacy field for ETL, ignore',
  `name` varchar(255) COLLATE utf8_general_ci NOT NULL,
  `description` varchar(1000) COLLATE utf8_general_ci DEFAULT NULL,
  `target_work_rate` decimal(9,2) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci  AUTO_INCREMENT=1;

-- --------------------------------------------------------

--
-- Table structure for table `tasks_workorders`
--

DROP TABLE IF EXISTS `tasks_workorders`;
CREATE TABLE IF NOT EXISTS `tasks_workorders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(36) CHARSET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'legacy field for ETL, ignore',  
  `workorder_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `task_sort` smallint(5) unsigned DEFAULT '0',
  `operator_id` int(11) DEFAULT NULL COMMENT 'Operator assignment, references Editor.id',
  `status` enum('New','Working','Paused','Flagged','Done') COLLATE utf8_general_ci DEFAULT 'New',
  `assets_task_count` int(11) DEFAULT '0',
  `started` datetime DEFAULT NULL,
  `finished` datetime DEFAULT NULL,
  `elapsed` INT NULL DEFAULT NULL COMMENT 'total working time, in seconds
  `paused_at` datetime DEFAULT NULL,
  `paused` INT NULL DEFAULT NULL COMMENT 'time the task was paused, in seconds',  
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_operator_id` (`operator_id`),
  KEY `fk_habtm_join` (`workorder_id`,`task_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci  AUTO_INCREMENT=1;

-- --------------------------------------------------------

--
-- Table structure for table `workorders`
--

DROP TABLE IF EXISTS `workorders`;
CREATE TABLE IF NOT EXISTS `workorders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(36) CHARSET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'legacy field for ETL, ignore',  
  `client_id` char(36) CHARSET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'customer satisfaction target',
  `source_id` char(36) CHARSET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'User or Circle with ownership over the AssetsWorkorder',
  `source_model` enum('User','Group') NOT NULL COMMENT 'User or Group Model',
  `manager_id` int(11) DEFAULT NULL COMMENT 'Manager assignment, references Editor.id',
  `name` varchar(255) NOT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `harvest` tinyint(1) NOT NULL DEFAULT '0',
  `status` enum('New','Ready','Working','QA','Done') DEFAULT 'New',
  `assets_workorder_count` int(11) DEFAULT '0',
  `submitted` datetime DEFAULT NULL,
  `due` datetime DEFAULT NULL,
  `started` datetime DEFAULT NULL,
  `finished` datetime DEFAULT NULL,
  `elapsed` time DEFAULT '00:00:00',
  `special_instructions` varchar(1000) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_client_id` (`client_id`),
  KEY `fk_manager_id` (`manager_id`),
  KEY `fk_source_id` (`source_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci  AUTO_INCREMENT=1;

