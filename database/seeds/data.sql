-- --------------------------------------------------------
-- 主机:                           localhost
-- 服务器版本:                        5.7.19 - MySQL Community Server (GPL)
-- 服务器操作系统:                      Win64
-- HeidiSQL 版本:                  9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- 导出  表 yuqing.address 结构
CREATE TABLE IF NOT EXISTS `address` (
  `areacode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pcode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`areacode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 正在导出表  yuqing.address 的数据：~0 rows (大约)
/*!40000 ALTER TABLE `address` DISABLE KEYS */;
/*!40000 ALTER TABLE `address` ENABLE KEYS */;

-- 导出  表 yuqing.admins 结构
CREATE TABLE IF NOT EXISTS `admins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `realname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 正在导出表  yuqing.admins 的数据：~1 rows (大约)
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
REPLACE INTO `admins` (`id`, `username`, `realname`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'admin', '超级管理员', '$2y$10$66x80Mfjhj4dLCRtmvmSHOPDDtoXoSjJ5zo92nfFqmcPPX7Go/yoW', 'oSbnbYg8NunZivAnrATZMPLqI2VVOaD3bcKviToL5vu8UCySZeMMjWRWqzz2', '2018-02-05 16:22:23', '2018-02-05 16:22:23');
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;

-- 导出  表 yuqing.casetype 结构
CREATE TABLE IF NOT EXISTS `casetype` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 正在导出表  yuqing.casetype 的数据：~0 rows (大约)
/*!40000 ALTER TABLE `casetype` DISABLE KEYS */;
/*!40000 ALTER TABLE `casetype` ENABLE KEYS */;

-- 导出  表 yuqing.migrations 结构
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 正在导出表  yuqing.migrations 的数据：~10 rows (大约)
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
REPLACE INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(21, '2014_10_12_000000_create_users_table', 1),
	(22, '2014_10_12_100000_create_password_resets_table', 1),
	(23, '2018_01_12_084824_admin', 1),
	(24, '2018_01_15_080129_entrust_setup_tables', 1),
	(25, '2018_01_23_085212_subject', 1),
	(26, '2018_01_23_092202_reportform', 1),
	(27, '2018_01_24_023141_address', 1),
	(28, '2018_01_24_025931_casetype', 1),
	(29, '2018_01_24_040214_news', 1),
	(30, '2018_01_24_092301_useful_news', 1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

-- 导出  表 yuqing.news 结构
CREATE TABLE IF NOT EXISTS `news` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `orientation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `firstwebsite` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sitetype` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keywords` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transmit` int(11) NOT NULL DEFAULT '0',
  `starttime` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 正在导出表  yuqing.news 的数据：~0 rows (大约)
/*!40000 ALTER TABLE `news` DISABLE KEYS */;
/*!40000 ALTER TABLE `news` ENABLE KEYS */;

-- 导出  表 yuqing.password_resets 结构
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 正在导出表  yuqing.password_resets 的数据：~0 rows (大约)
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;

-- 导出  表 yuqing.permissions 结构
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '-1',
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 正在导出表  yuqing.permissions 的数据：~18 rows (大约)
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
REPLACE INTO `permissions` (`id`, `name`, `display_name`, `link`, `icon`, `pid`, `description`, `created_at`, `updated_at`) VALUES
	(1, '管理列表', '管理列表', 'role.lists', 'fa-users', '-1', NULL, NULL, NULL),
	(2, '用户管理', '用户管理', 'admin.lists', 'fa-sliders', '1', NULL, NULL, NULL),
	(3, '角色管理', '角色管理', 'role.lists', 'fa-sliders', '1', NULL, NULL, NULL),
	(4, '栏目管理', '栏目管理', 'permission.lists', 'fa-sliders', '1', NULL, NULL, NULL),
	(5, '新闻管理', '新闻管理', '', 'fa-users', '-1', NULL, NULL, NULL),
	(6, '新闻列表', '新闻列表', 'news.lists', 'fa-sliders', '5', NULL, NULL, NULL),
	(7, '我的新闻', '我的新闻', 'person.lists', 'fa-sliders', '5', NULL, NULL, NULL),
	(8, '审核通过的新闻', '审核通过的新闻', 'passed.lists', 'fa-sliders', '5', NULL, NULL, NULL),
	(9, '审核新闻', '审核新闻', 'verify.lists', 'fa-sliders', '5', NULL, NULL, NULL),
	(10, '报表管理', '报表管理', '', 'fa-users', '-1', NULL, NULL, NULL),
	(11, '日报表', '日报表', 'report.day', 'fa-sliders', '10', NULL, NULL, NULL),
	(12, '专题管理', '专题管理', '', NULL, '-1', NULL, NULL, NULL),
	(13, '案件类型管理', '案件类型管理', NULL, NULL, '-1', NULL, NULL, NULL),
	(14, '类型管理', '类型管理', 'casetype.lists', NULL, '13', NULL, NULL, NULL),
	(15, '统计', '统计', NULL, NULL, '-1', NULL, NULL, NULL),
	(16, '新闻统计', '新闻统计', 'tongji.lists', NULL, '15', NULL, NULL, NULL),
	(17, '个人统计', '个人统计', 'tongji.person', NULL, '15', NULL, NULL, NULL),
	(18, '专题列表', '专题列表', 'subject.lists', NULL, '12', NULL, NULL, NULL);
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;

-- 导出  表 yuqing.permission_role 结构
CREATE TABLE IF NOT EXISTS `permission_role` (
  `permissions_id` int(10) unsigned NOT NULL,
  `roles_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`permissions_id`,`roles_id`),
  KEY `permission_role_roles_id_foreign` (`roles_id`),
  CONSTRAINT `permission_role_permissions_id_foreign` FOREIGN KEY (`permissions_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `permission_role_roles_id_foreign` FOREIGN KEY (`roles_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 正在导出表  yuqing.permission_role 的数据：~18 rows (大约)
/*!40000 ALTER TABLE `permission_role` DISABLE KEYS */;
REPLACE INTO `permission_role` (`permissions_id`, `roles_id`) VALUES
	(1, 1),
	(2, 1),
	(3, 1),
	(4, 1),
	(5, 1),
	(6, 1),
	(7, 1),
	(8, 1),
	(9, 1),
	(10, 1),
	(11, 1),
	(12, 1),
	(13, 1),
	(14, 1),
	(15, 1),
	(16, 1),
	(17, 1),
	(18, 1);
/*!40000 ALTER TABLE `permission_role` ENABLE KEYS */;

-- 导出  表 yuqing.reportform 结构
CREATE TABLE IF NOT EXISTS `reportform` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `admin_id` int(10) unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reportform_admin_id_foreign` (`admin_id`),
  CONSTRAINT `reportform_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 正在导出表  yuqing.reportform 的数据：~0 rows (大约)
/*!40000 ALTER TABLE `reportform` DISABLE KEYS */;
/*!40000 ALTER TABLE `reportform` ENABLE KEYS */;

-- 导出  表 yuqing.roles 结构
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 正在导出表  yuqing.roles 的数据：~1 rows (大约)
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
REPLACE INTO `roles` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES
	(1, 'administror', 'administror', 'administror', '2018-02-05 16:22:23', '2018-02-05 16:22:23');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;

-- 导出  表 yuqing.role_user 结构
CREATE TABLE IF NOT EXISTS `role_user` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `role_user_role_id_foreign` (`role_id`),
  CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 正在导出表  yuqing.role_user 的数据：~1 rows (大约)
/*!40000 ALTER TABLE `role_user` DISABLE KEYS */;
REPLACE INTO `role_user` (`user_id`, `role_id`) VALUES
	(1, 1);
/*!40000 ALTER TABLE `role_user` ENABLE KEYS */;

-- 导出  表 yuqing.subject 结构
CREATE TABLE IF NOT EXISTS `subject` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 正在导出表  yuqing.subject 的数据：~0 rows (大约)
/*!40000 ALTER TABLE `subject` DISABLE KEYS */;
/*!40000 ALTER TABLE `subject` ENABLE KEYS */;

-- 导出  表 yuqing.useful_news 结构
CREATE TABLE IF NOT EXISTS `useful_news` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `news_id` int(10) unsigned DEFAULT NULL,
  `admin_id` int(10) unsigned DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `firstwebsite` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sitetype` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keywords` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transmit` int(11) NOT NULL DEFAULT '0',
  `tag` int(11) NOT NULL DEFAULT '0',
  `verify_option` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `court` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `abstract` text COLLATE utf8mb4_unicode_ci,
  `starttime` datetime DEFAULT NULL,
  `visitnum` int(11) NOT NULL DEFAULT '0',
  `replynum` int(11) NOT NULL DEFAULT '0',
  `orientation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ispush` int(11) NOT NULL DEFAULT '1',
  `yuqinginfo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `screen` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `md5` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `oldsubject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `areacode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject_id` int(10) unsigned DEFAULT NULL,
  `reportform_id` int(10) unsigned DEFAULT NULL,
  `casetype_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `useful_news_news_id_foreign` (`news_id`),
  KEY `useful_news_admin_id_foreign` (`admin_id`),
  KEY `useful_news_areacode_foreign` (`areacode`),
  KEY `useful_news_subject_id_foreign` (`subject_id`),
  KEY `useful_news_reportform_id_foreign` (`reportform_id`),
  KEY `useful_news_casetype_id_foreign` (`casetype_id`),
  CONSTRAINT `useful_news_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `useful_news_areacode_foreign` FOREIGN KEY (`areacode`) REFERENCES `address` (`areacode`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `useful_news_casetype_id_foreign` FOREIGN KEY (`casetype_id`) REFERENCES `casetype` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `useful_news_news_id_foreign` FOREIGN KEY (`news_id`) REFERENCES `news` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `useful_news_reportform_id_foreign` FOREIGN KEY (`reportform_id`) REFERENCES `reportform` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `useful_news_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 正在导出表  yuqing.useful_news 的数据：~0 rows (大约)
/*!40000 ALTER TABLE `useful_news` DISABLE KEYS */;
/*!40000 ALTER TABLE `useful_news` ENABLE KEYS */;

-- 导出  表 yuqing.users 结构
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 正在导出表  yuqing.users 的数据：~0 rows (大约)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
