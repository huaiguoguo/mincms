-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2012 年 05 月 31 日 10:46
-- 服务器版本: 5.5.8
-- PHP 版本: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `fuel_cms`
--

-- --------------------------------------------------------

--
-- 表的结构 `configs`
--

CREATE TABLE IF NOT EXISTS `configs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `val` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- 转存表中的数据 `configs`
--

INSERT INTO `configs` (`id`, `name`, `val`) VALUES
(1, 'open', '1'),
(2, 'close_info', ''),
(3, 'title', 'MinCMS home page'),
(4, 'seo', 'mincms,fuelphp,cms,web,企业建站,b2c'),
(5, 'stat', '<script type="text/javascript">\r\n\r\n\r\n\r\n  var _gaq = _gaq || [];\r\n\r\n  _gaq.push([''_setAccount'', ''UA-24460748-2'']);\r\n\r\n  _gaq.push([''_trackPageview'']);\r\n\r\n\r\n\r\n  (function() {\r\n\r\n    var ga = document.createElement(''script''); ga.type = ''text/javascript''; ga.async = true;\r\n\r\n    ga.src = (''https:'' == document.location.protocol ? ''https://ssl'' : ''http://www'') + ''.google-analytics.com/ga.js'';\r\n\r\n    var s = document.getElementsByTagName(''script'')[0]; s.parentNode.insertBefore(ga, s);\r\n\r\n  })();\r\n\r\n\r\n\r\n</script>'),
(6, 'footer', ''),
(7, 'seo_author', 'mincms'),
(8, 'seo_copyright', 'mincms'),
(9, 'admin_title', 'MinCMS'),
(10, 'url_suffix', ''),
(11, 'profiling', '2'),
(14, 'caching', '2'),
(12, 'admin_url_suffix', ''),
(13, 'admin_profiling', '2'),
(15, 'cache_lifetime', ''),
(16, 'cache_dir', '');

-- --------------------------------------------------------

--
-- 表的结构 `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `sort` int(11) DEFAULT NULL,
  `val` varchar(20) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `groups`
--

INSERT INTO `groups` (`id`, `name`, `sort`, `val`, `active`) VALUES
(1, '超级管理员', NULL, 'admin', 1),
(2, '管理员', NULL, 'admin_user', 1);

-- --------------------------------------------------------

--
-- 表的结构 `language`
--

CREATE TABLE IF NOT EXISTS `language` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `code` varchar(50) NOT NULL,
  `sort` int(11) DEFAULT '0',
  `display` tinyint(1) NOT NULL DEFAULT '1',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `default` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `language`
--

INSERT INTO `language` (`id`, `name`, `code`, `sort`, `display`, `active`, `default`) VALUES
(1, '简体中文', 'zh', 0, 1, 1, 1),
(2, 'English', 'en', 0, 1, 1, 0);

-- --------------------------------------------------------

--
-- 表的结构 `language_file`
--

CREATE TABLE IF NOT EXISTS `language_file` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `out` varchar(200) NOT NULL,
  `language_id` int(11) NOT NULL,
  `display` tinyint(1) NOT NULL DEFAULT '1',
  `create_at` int(11) NOT NULL,
  `update_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=142 ;

--
-- 转存表中的数据 `language_file`
--

INSERT INTO `language_file` (`id`, `name`, `out`, `language_id`, `display`, `create_at`, `update_at`) VALUES
(1, 'hello', '您好', 1, 1, 1337857001, NULL),
(2, 'logout', '退出', 1, 1, 1337857038, NULL),
(3, 'admin', '管理', 1, 1, 1337857047, NULL),
(4, 'add', '添加', 1, 1, 1337857056, NULL),
(5, 'home', '首页', 1, 1, 1337857076, NULL),
(6, 'update', '更新', 1, 1, 1337857082, NULL),
(7, 'name', '名称', 1, 1, 1337868455, NULL),
(8, 'display', '显示', 1, 1, 1337868462, NULL),
(9, 'language', '语言', 1, 1, 1337868467, NULL),
(10, 'translation', '语言翻译', 1, 1, 1337868494, 1337868680),
(11, 'translation add', '新建翻译', 1, 1, 1337868507, 1337868568),
(12, 'language add', '新建语言', 1, 1, 1337868550, NULL),
(13, 'create_time', '创建时间', 1, 1, 1337868855, NULL),
(14, 'action', '操作', 1, 1, 1337868865, NULL),
(15, 'save success', '操作已成功', 1, 1, 1337868878, NULL),
(16, 'edit', '编辑', 1, 1, 1337869040, NULL),
(17, 'language_key', '语言包名称', 1, 1, 1337869329, NULL),
(18, 'content', '内容', 1, 1, 1337870213, NULL),
(19, 'user', '用户', 1, 1, 1337870220, NULL),
(20, 'pages', '页面', 1, 1, 1337870252, NULL),
(21, 'user add', '创建用户', 1, 1, 1337919030, NULL),
(22, 'tel', '手机号码', 1, 1, 1337919407, NULL),
(23, 'email', '邮件地址', 1, 1, 1337919531, NULL),
(24, 'password', '密码', 1, 1, 1337919592, NULL),
(25, 'you can login tel or email', '登录支持手机号或邮件', 1, 1, 1337919776, NULL),
(26, 'pls confirm you are admin language is very importent', '请谨慎操作多语言,设置将改变全站语言信息', 1, 1, 1337920459, NULL),
(27, 'application admin', '应用后台管理', 1, 1, 1337920759, NULL),
(28, 'the field :label should be tel', '字段 :label 请输入正确的手机号', 1, 1, 1337921098, NULL),
(29, 'The field :label must be unique, but :value has already been used', '字段 :label 必须唯一, 但 :value 已存在', 1, 1, 1337921559, NULL),
(30, 'user group', '用户组', 1, 1, 1337921814, NULL),
(31, 'user group add', '创建用户组', 1, 1, 1337921825, NULL),
(32, 'acl', '权限设置', 1, 1, 1337921831, NULL),
(33, 'config', '设置', 1, 1, 1337921898, NULL),
(34, 'seo', 'SEO优化', 1, 1, 1337922008, NULL),
(35, 'tools', '工具', 1, 1, 1337922427, NULL),
(36, 'database backup', '数据备份', 1, 1, 1337923005, NULL),
(37, 'generate sitemap', '生成网站地图', 1, 1, 1337923016, NULL),
(38, 'enable website', '开启网站', 1, 1, 1337932043, NULL),
(39, 'setting name', '设置名称', 1, 1, 1337932056, NULL),
(40, 'setting value', '设置值', 1, 1, 1337932064, NULL),
(41, 'yes', '是', 1, 1, 1337932082, NULL),
(42, 'no', '否', 1, 1, 1337932086, NULL),
(43, 'close website display', '关闭网站时显示', 1, 1, 1337932309, NULL),
(44, 'save', '保存', 1, 1, 1337932428, NULL),
(45, 'reset', '重置', 1, 1, 1337932442, NULL),
(46, 'website title', '网站标题', 1, 1, 1337932455, NULL),
(47, 'website footer', '网站页脚', 1, 1, 1337932468, NULL),
(48, 'seo key', 'SEO关键词', 1, 1, 1337932565, NULL),
(49, 'statistics', '流量统计代码', 1, 1, 1337932582, NULL),
(50, 'our website now is close,any problem pls connect us', '我们的网站因故将关闭,如有疑问请联系管理员', 1, 1, 1337935118, NULL),
(51, 'page not find', '您把请求的页面不存在', 1, 1, 1337935321, NULL),
(52, 'complete progress', '完成进度', 1, 1, 1337936444, NULL),
(53, 'code', '代码', 1, 1, 1337936463, NULL),
(54, 'active', '启用', 1, 1, 1337937010, NULL),
(55, 'default language', '默认语言', 1, 1, 1337937048, NULL),
(56, 'cover to language', '快速翻译语言包', 1, 1, 1337954905, NULL),
(57, 'hello', 'hello', 2, 1, 1337959296, NULL),
(58, 'logout', 'logout', 2, 1, 1337959296, NULL),
(59, 'admin', 'admin', 2, 1, 1337959296, NULL),
(60, 'add', 'add', 2, 1, 1337959296, NULL),
(61, 'home', 'home', 2, 1, 1337959296, NULL),
(62, 'update', 'update', 2, 1, 1337959296, NULL),
(63, 'name', 'name', 2, 1, 1337959296, NULL),
(64, 'display', 'display', 2, 1, 1337959296, NULL),
(65, 'language', 'language', 2, 1, 1337959296, NULL),
(66, 'translation', 'translation', 2, 1, 1337959296, NULL),
(67, 'translation add', 'translation add', 2, 1, 1337959296, NULL),
(68, 'language add', 'language add', 2, 1, 1337959296, NULL),
(69, 'create_time', 'create_time', 2, 1, 1337959296, NULL),
(70, 'action', 'action', 2, 1, 1337959296, NULL),
(71, 'save success', 'save success', 2, 1, 1337959296, NULL),
(72, 'edit', 'edit', 2, 1, 1337959296, NULL),
(73, 'language_key', 'language_key', 2, 1, 1337959296, NULL),
(74, 'content', 'content', 2, 1, 1337959296, NULL),
(75, 'user', 'user', 2, 1, 1337959296, NULL),
(76, 'pages', 'pages', 2, 1, 1337959296, NULL),
(77, 'user add', 'user add', 2, 1, 1337959296, NULL),
(78, 'tel', 'tel', 2, 1, 1337959296, NULL),
(79, 'email', 'email', 2, 1, 1337959296, NULL),
(80, 'password', 'password', 2, 1, 1337959296, NULL),
(81, 'you can login tel or email', 'you can login tel or email', 2, 1, 1337959296, NULL),
(82, 'pls confirm you are admin language is very importent', 'pls confirm you are admin language is very importent', 2, 1, 1337959296, NULL),
(83, 'application admin', 'application admin', 2, 1, 1337959296, NULL),
(84, 'the field :label should be tel', 'the field :label should be tel', 2, 1, 1337959296, NULL),
(85, 'The field :label must be unique, but :value has already been used', 'The field :label must be unique, but :value has already been used', 2, 1, 1337959296, NULL),
(86, 'user group', 'user group', 2, 1, 1337959296, NULL),
(87, 'user group add', 'user group add', 2, 1, 1337959296, NULL),
(88, 'acl', 'acl', 2, 1, 1337959296, NULL),
(89, 'config', 'config', 2, 1, 1337959296, NULL),
(90, 'seo', 'seo', 2, 1, 1337959296, NULL),
(91, 'tools', 'tools', 2, 1, 1337959296, NULL),
(92, 'database backup', 'database backup', 2, 1, 1337959296, NULL),
(93, 'generate sitemap', 'generate sitemap', 2, 1, 1337959296, NULL),
(94, 'enable website', 'enable website', 2, 1, 1337959296, NULL),
(95, 'setting name', 'setting name', 2, 1, 1337959296, NULL),
(96, 'setting value', 'setting value', 2, 1, 1337959296, NULL),
(97, 'yes', 'yes', 2, 1, 1337959296, NULL),
(98, 'no', 'no', 2, 1, 1337959296, NULL),
(99, 'close website display', 'close website display', 2, 1, 1337959296, NULL),
(100, 'save', 'save', 2, 1, 1337959296, NULL),
(101, 'reset', 'reset', 2, 1, 1337959296, NULL),
(102, 'website title', 'website title', 2, 1, 1337959296, NULL),
(103, 'website footer', 'website footer', 2, 1, 1337959296, NULL),
(104, 'seo key', 'seo key', 2, 1, 1337959296, NULL),
(105, 'statistics', 'statistics', 2, 1, 1337959296, NULL),
(106, 'our website now is close,any problem pls connect us', 'our website now is close,any problem pls connect us', 2, 1, 1337959296, NULL),
(107, 'page not find', 'page not find', 2, 1, 1337959296, NULL),
(108, 'complete progress', 'complete progress', 2, 1, 1337959296, NULL),
(109, 'code', 'code', 2, 1, 1337959296, NULL),
(110, 'active', 'active', 2, 1, 1337959296, NULL),
(111, 'default language', 'default language', 2, 1, 1337959296, NULL),
(112, 'cover to language', 'cover to language', 2, 1, 1337959296, NULL),
(113, 'cover language :a to :b', 'cover language :a to :b', 1, 1, 1337959518, NULL),
(114, 'import to database', '恢复数据库,请谨慎操作', 1, 1, 1338030837, NULL),
(115, 'confirm delete', '操作不可恢复,确认删除吗', 1, 1, 1338031065, NULL),
(116, 'backup database', '备份数据库', 1, 1, 1338031183, NULL),
(117, 'import database', '恢复数据库', 1, 1, 1338031195, NULL),
(118, 'confirm open import tag', '确认打开导入链接吗', 1, 1, 1338038958, NULL),
(119, 'file_size', '文件大小', 1, 1, 1338039305, NULL),
(120, 'sort', '排序', 1, 1, 1338182056, NULL),
(121, 'im', '联系方式', 1, 1, 1338182074, NULL),
(122, 'author', '作者', 1, 1, 1338182079, NULL),
(123, 'admin title', '后台标题', 1, 1, 1338196449, NULL),
(124, 'will logout', '确认退出系统', 1, 1, 1338196756, NULL),
(125, 'url_suffix', 'URL后缀,必须.开始', 1, 1, 1338199406, NULL),
(126, 'profiling', '调试', 1, 1, 1338199418, NULL),
(127, 'caching', '缓存', 1, 1, 1338199423, NULL),
(128, 'cache lifetime', '缓存过期时间', 1, 1, 1338199431, NULL),
(129, 'cache dir', '缓存目录', 1, 1, 1338199438, NULL),
(130, 'seo author', 'seo 作者', 1, 1, 1338199449, NULL),
(131, 'seo copyright', 'seo 版权信息', 1, 1, 1338199462, NULL),
(132, 'the cache lifetime in seconds', '缓存过期时间以秒为单位', 1, 1, 1338199479, NULL),
(133, 'relative app path,default is app/cache/', '路径相对于app目录,默认为app/cache/', 1, 1, 1338199508, NULL),
(134, 'front settings', '前台设置', 1, 1, 1338199534, NULL),
(135, 'admin settings', '后台设置', 1, 1, 1338199542, NULL),
(136, 'login', '登录', 1, 1, 1338202545, NULL),
(137, 'set it in app/config/config php file key is profiling', '请在文件 app/config/config.php 中设置 profiling属性', 1, 1, 1338202757, NULL),
(138, 'backup language', '备份当前语言', 1, 1, 1338203501, NULL),
(139, 'import language', '恢复语言', 1, 1, 1338203517, NULL),
(140, 'upload language', '上传语言', 1, 1, 1338203623, NULL),
(141, 'just for devloper', '请确认您是开发者', 1, 1, 1338258701, 1338281765);

-- --------------------------------------------------------

--
-- 表的结构 `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_title` varchar(100) NOT NULL,
  `post_content` text NOT NULL,
  `author_name` varchar(65) NOT NULL,
  `author_email` varchar(80) NOT NULL,
  `author_website` varchar(60) DEFAULT NULL,
  `post_status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `posts`
--

INSERT INTO `posts` (`id`, `post_title`, `post_content`, `author_name`, `author_email`, `author_website`, `post_status`) VALUES
(1, '11111111112aa', 'aaaaaaaaaa', 'aa', 'aaa@msn.com', 'http://ab.com', 1),
(2, 'aasfasdfasdfa', 'asdfasdf', 'asdfa', 'jj@msn.com', 'http://w.com', 1),
(3, 'aadasfasdfasdfasdf', 'adfafasdf', 'aadsf', 'aaa@msn.com', 'http://ab.com', 2),
(4, 'adsfasdfasdfasd', 'sadfasdfasdfas', 'aaa', 'aaa@msn.com', 'http://ab.com', 1);

-- --------------------------------------------------------

--
-- 表的结构 `role_acl`
--

CREATE TABLE IF NOT EXISTS `role_acl` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `action_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=151 ;

--
-- 转存表中的数据 `role_acl`
--

INSERT INTO `role_acl` (`id`, `group_id`, `action_id`) VALUES
(146, 2, 6),
(145, 2, 5),
(144, 2, 4),
(143, 2, 8),
(142, 2, 14),
(141, 2, 13),
(140, 2, 12),
(139, 2, 11),
(138, 2, 10),
(137, 2, 9),
(136, 2, 17),
(135, 2, 16),
(134, 2, 15),
(133, 2, 20),
(132, 2, 19),
(131, 2, 18),
(130, 2, 24),
(129, 2, 23),
(128, 2, 22),
(127, 2, 21),
(147, 2, 7),
(148, 2, 3),
(149, 2, 1),
(150, 2, 2);

-- --------------------------------------------------------

--
-- 表的结构 `role_action`
--

CREATE TABLE IF NOT EXISTS `role_action` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `controller_id` int(11) NOT NULL,
  `val` varchar(50) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=34 ;

--
-- 转存表中的数据 `role_action`
--

INSERT INTO `role_action` (`id`, `controller_id`, `val`, `name`) VALUES
(1, 1, 'action_index', 'ACL权限首页'),
(2, 1, 'action_do', '加载所有控制器及动作至ACL'),
(3, 2, 'action_index', '系统配置'),
(4, 3, 'action_index', '用户组列表'),
(5, 3, 'action_add', '添加用户组'),
(6, 3, 'action_edit', '编辑用户组信息'),
(7, 3, 'action_bind', '组绑定权限'),
(8, 4, 'action_index', NULL),
(9, 5, 'action_index', '语言列表'),
(10, 5, 'action_add', '添加新语言'),
(11, 5, 'action_edit', NULL),
(12, 5, 'action_active', '激活对应的语言'),
(13, 5, 'action_enable', '设为默认语言'),
(14, 5, 'action_cover', '转换语言包'),
(15, 6, 'action_index', '工具列表'),
(16, 6, 'action_active', '启用或禁用工具'),
(17, 6, 'action_sort', '工具排序'),
(18, 7, 'action_index', NULL),
(19, 7, 'action_add', NULL),
(20, 7, 'action_edit', NULL),
(21, 8, 'action_index', '用户列表'),
(22, 8, 'action_active', '启用或禁用用户'),
(23, 8, 'action_add', '添加用户'),
(24, 8, 'action_edit', '修改用户信息'),
(25, 9, 'action_index', NULL),
(26, 10, 'action_info', NULL),
(27, 10, 'action_backup', NULL),
(28, 10, 'action_backup_do', NULL),
(29, 10, 'action_import', NULL),
(30, 10, 'action_remove', NULL),
(31, 11, 'action_info', NULL),
(32, 11, 'action_index', NULL),
(33, 11, 'action_do', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `role_controller`
--

CREATE TABLE IF NOT EXISTS `role_controller` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `val` varchar(50) NOT NULL,
  `sort` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- 转存表中的数据 `role_controller`
--

INSERT INTO `role_controller` (`id`, `name`, `val`, `sort`) VALUES
(1, 'Admin\\Controller_Acl', 'Admin\\Controller_Acl', NULL),
(2, 'Admin\\Controller_Config', 'Admin\\Controller_Config', NULL),
(3, 'Admin\\Controller_Group', 'Admin\\Controller_Group', NULL),
(4, 'Admin\\Controller_Home', 'Admin\\Controller_Home', NULL),
(5, 'Admin\\Controller_Language', 'Admin\\Controller_Language', NULL),
(6, 'Admin\\Controller_Tools', 'Admin\\Controller_Tools', NULL),
(7, 'Admin\\Controller_Translate', 'Admin\\Controller_Translate', NULL),
(8, 'Admin\\Controller_User', 'Admin\\Controller_User', NULL),
(9, 'Content\\Controller_Home', 'Content\\Controller_Home', NULL),
(10, 'Tools\\Controller_Database', 'Tools\\Controller_Database', NULL),
(11, 'Tools\\Controller_Sitemap', 'Tools\\Controller_Sitemap', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `tools`
--

CREATE TABLE IF NOT EXISTS `tools` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(50) NOT NULL,
  `url` varchar(200) NOT NULL,
  `author` varchar(20) NOT NULL,
  `web` varchar(200) DEFAULT NULL,
  `im` varchar(200) NOT NULL,
  `sort` int(11) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `tools`
--

INSERT INTO `tools` (`id`, `label`, `url`, `author`, `web`, `im`, `sort`, `active`) VALUES
(1, 'database backup', 'tools/database/backup', 'sun kang', NULL, '68103403@qq.com', 4, 1),
(2, 'sitemap', 'tools/sitemap/index', 'sun kang', NULL, '68103403@qq.com', 3, 0);

-- --------------------------------------------------------

--
-- 表的结构 `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `group` int(11) NOT NULL DEFAULT '1',
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `last_login` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `login_hash` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `profile_fields` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `created_at` int(11) unsigned NOT NULL,
  `update_at` int(11) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`,`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `group`, `email`, `last_login`, `login_hash`, `profile_fields`, `created_at`, `update_at`, `active`) VALUES
(1, 'admin', 'Lz2ctRARdGg8X8CUtXtW56YbCpKE847lr7GQdAg0AtE=', 1, '68103403@qq.com', '1338456994', '6c7a126a6075fe8b3303612cc64dabe16d76f719', '', 1338456989, 0, 1),
(2, 'test', 'MmfkdDe+jyL0JcScCX0otUdYwYLH61w1gfJFBigdgag=', 2, 'yiiphp@qq.com', '1338457290', '1401b721642327a996a0730ae409cb5bad5e7e86', NULL, 1338457038, NULL, 1);

-- --------------------------------------------------------

--
-- 表的结构 `user_group`
--

CREATE TABLE IF NOT EXISTS `user_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `user_group`
--

