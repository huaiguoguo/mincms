CREATE TABLE IF NOT EXISTS `content_field_form` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `val` varchar(20) NOT NULL,
  `sort` int(11) NOT NULL,
  `use` varchar(10) DEFAULT NULL,
  `options` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- 转存表中的数据 `content_field_form`
--

INSERT INTO `content_field_form` (`id`, `name`, `val`, `sort`, `use`, `options`) VALUES
(1, 'input', 'input', 9, '', ''),
(2, 'radio', 'radio', 4, '', ''),
(3, 'checkbox', 'checkbox', 6, '', ''),
(4, 'file', 'file', 7, '', ''),
(5, 'textarea', 'textarea', 8, '', ''),
(6, 'select', 'select', 5, '', ''),
(7, 'relation_belongs_to', 'belongs_to', 2, 'orm', ''),
(8, 'relation_has_one', 'has_one', 3, 'orm', ''),
(9, 'relation_has_many', 'has_many', 1, 'orm', ''),
(10, 'image', 'image', 10, 'file', '');