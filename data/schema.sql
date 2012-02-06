SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS `history_lifo`;
CREATE TABLE IF NOT EXISTS `history_lifo` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `proxy_model` int(11) unsigned NOT NULL,
  `proxy_pk` int(11) unsigned NOT NULL,
  `old_permalink` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL default '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `proxy_model` (`proxy_model`,`proxy_pk`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;


DROP TABLE IF EXISTS `history_log`;
CREATE TABLE IF NOT EXISTS `history_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(255) CHARACTER SET utf8 NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `message` text CHARACTER SET utf8 NOT NULL,
  `nb` int(10) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `url` (`url`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

SET FOREIGN_KEY_CHECKS=1;

