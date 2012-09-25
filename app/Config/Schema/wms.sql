--
-- Database: `wms`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

DROP TABLE IF EXISTS `activity_logs`;
CREATE TABLE IF NOT EXISTS `activity_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `editor_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `model` varchar(100) NOT NULL,
  `record_id` int(10) NOT NULL,
  `flag_status` tinyint(1) NOT NULL DEFAULT '0',
  `flag_id` int(11) DEFAULT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `assets_tasks`
--

DROP TABLE IF EXISTS `assets_tasks`;
CREATE TABLE IF NOT EXISTS `assets_tasks` (
  `id` char(36) COLLATE utf8_general_ci NOT NULL,
  `tasks_workorder_id` char(36) COLLATE utf8_general_ci NOT NULL,
  `asset_id` char(36) COLLATE utf8_general_ci NOT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`tasks_workorder_id`,`asset_id`),
  KEY `fk_assets` (`asset_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assets_workorders`
--

DROP TABLE IF EXISTS `assets_workorders`;
CREATE TABLE IF NOT EXISTS `assets_workorders` (
  `id` char(36) COLLATE utf8_general_ci NOT NULL,
  `workorder_id` char(36) COLLATE utf8_general_ci NOT NULL,
  `asset_id` char(36) COLLATE utf8_general_ci NOT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`workorder_id`,`asset_id`),
  KEY `fk_assets` (`asset_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `editors`
--

DROP TABLE IF EXISTS `editors`;
CREATE TABLE IF NOT EXISTS `editors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(250) NOT NULL,
  `role` enum('manager','operator') NOT NULL DEFAULT 'operator',
  `work_week` char(7) NOT NULL COMMENT 'each position of the string represents from monday to sunday, ie, works all days: 1111111, works monday to friday: 1111100, works weekends: 0000011, works only tuesdays and sundays: 0100001',
  `workday_hours` int(2) NOT NULL COMMENT 'hours per day they are scheduled to work',
  `editor_tasksworkorders_count` int(11) NOT NULL,
  `editor_assetstasks_count` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

DROP TABLE IF EXISTS `skills`;
CREATE TABLE IF NOT EXISTS `skills` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `editor_id` int(11) NOT NULL,
  `rate_1_day` int(11) NOT NULL,
  `rate_7_day` int(11) NOT NULL,
  `rate_30_dat` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

DROP TABLE IF EXISTS `tasks`;
CREATE TABLE IF NOT EXISTS `tasks` (
  `id` char(36) COLLATE utf8_general_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_general_ci NOT NULL,
  `description` varchar(1000) COLLATE utf8_general_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `target_work_rate` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tasks_workorders`
--

DROP TABLE IF EXISTS `tasks_workorders`;
CREATE TABLE IF NOT EXISTS `tasks_workorders` (
  `id` char(36) COLLATE utf8_general_ci NOT NULL,
  `workorder_id` char(36) COLLATE utf8_general_ci NOT NULL,
  `task_id` char(36) COLLATE utf8_general_ci NOT NULL,
  `task_sort` smallint(5) unsigned DEFAULT '0',
  `operator_id` char(36) COLLATE utf8_general_ci DEFAULT NULL COMMENT 'assignment',
  `status` enum('new','working','paused','flagged','done') COLLATE utf8_general_ci DEFAULT 'new',
  `assets_task_count` int(11) DEFAULT '0',
  `started` datetime DEFAULT NULL,
  `finished` datetime DEFAULT NULL,
  `elapsed` time DEFAULT '00:00:00',
  `paused_at` datetime DEFAULT NULL,
  `paused` time DEFAULT '00:00:00',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_operator_id` (`operator_id`),
  KEY `fk_workorder_id` (`workorder_id`,`task_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `workorders`
--

DROP TABLE IF EXISTS `workorders`;
CREATE TABLE IF NOT EXISTS `workorders` (
  `id` char(36) COLLATE utf8_general_ci NOT NULL,
  `client_id` char(36) COLLATE utf8_general_ci NOT NULL COMMENT 'customer satisfaction target',
  `source_id` char(36) COLLATE utf8_general_ci NOT NULL,
  `source_model` enum('User','Group') COLLATE utf8_general_ci DEFAULT 'User',
  `manager_id` char(36) COLLATE utf8_general_ci DEFAULT NULL COMMENT 'assignment',
  `name` varchar(255) COLLATE utf8_general_ci NOT NULL,
  `description` varchar(1000) COLLATE utf8_general_ci DEFAULT NULL,
  `harvest` tinyint(1) NOT NULL DEFAULT '0',
  `status` enum('new','ready','working','flagged','done') COLLATE utf8_general_ci DEFAULT 'new',
  `assets_workorder_count` int(11) DEFAULT '0',
  `submitted` datetime DEFAULT NULL,
  `due` datetime DEFAULT NULL,
  `started` datetime DEFAULT NULL,
  `finished` datetime DEFAULT NULL,
  `elapsed` time DEFAULT '00:00:00',
  `special_instructions` varchar(1000) COLLATE utf8_general_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_client_id` (`client_id`),
  KEY `fk_source_id` (`source_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

