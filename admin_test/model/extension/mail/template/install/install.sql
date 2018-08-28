DROP TABLE IF EXISTS `oc_emailtemplate`;
CREATE TABLE `oc_emailtemplate`(
  `emailtemplate_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `emailtemplate_key` varchar(64) NOT NULL,
  `emailtemplate_label` varchar(255) NOT NULL,
  `emailtemplate_type` enum('','customer','affiliate','order','admin') NOT NULL,
  `emailtemplate_template` varchar(255) NULL DEFAULT NULL,
  `emailtemplate_mail_to` varchar(255) NULL DEFAULT NULL,
  `emailtemplate_mail_cc` varchar(255) NULL DEFAULT NULL,
  `emailtemplate_mail_bcc` varchar(255) NULL DEFAULT NULL,
  `emailtemplate_mail_from` varchar(255) NULL DEFAULT NULL,
  `emailtemplate_mail_html` tinyint(1) NOT NULL DEFAULT '1',
  `emailtemplate_mail_plain_text` tinyint(1) NOT NULL DEFAULT '0',
  `emailtemplate_mail_sender` varchar(255) NULL DEFAULT NULL,
  `emailtemplate_mail_replyto` varchar(255) NULL DEFAULT NULL,
  `emailtemplate_mail_replyto_name` varchar(255) NULL DEFAULT NULL,
  `emailtemplate_mail_attachment` varchar(255) NULL DEFAULT NULL,
  `emailtemplate_attach_invoice` tinyint(1) NOT NULL DEFAULT '0',
  `emailtemplate_language_files` varchar(255) NULL DEFAULT NULL,
  `emailtemplate_wrapper_tpl` varchar(255) NULL DEFAULT NULL,
  `emailtemplate_status` tinyint(1) NOT NULL DEFAULT '1',
  `emailtemplate_default` tinyint(1) NOT NULL DEFAULT '1',
  `emailtemplate_shortcodes` tinyint(1) NOT NULL DEFAULT '0',
  `emailtemplate_showcase` tinyint(1) NOT NULL DEFAULT '1',
  `emailtemplate_condition` TEXT NULL DEFAULT NULL,
  `emailtemplate_modified` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `emailtemplate_log` tinyint(1) NULL DEFAULT NULL,
  `emailtemplate_view_browser` tinyint(1) NULL DEFAULT NULL,
  `emailtemplate_mail_queue` tinyint(1) NULL DEFAULT NULL,
  `emailtemplate_config_id` int(11) unsigned NULL DEFAULT NULL,
  `store_id` int(11) NULL DEFAULT NULL,
  `customer_group_id` int(11) NULL DEFAULT NULL,
  `order_status_id` int(11) NULL DEFAULT NULL,
  `event_id` int(11) NULL DEFAULT NULL,
  PRIMARY KEY(`emailtemplate_id`),
  INDEX `KEY`(`emailtemplate_key`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO `oc_emailtemplate` (`emailtemplate_id`, `emailtemplate_key`, `emailtemplate_label`, `emailtemplate_type`, `emailtemplate_template`, `emailtemplate_mail_to`, `emailtemplate_mail_cc`, `emailtemplate_mail_bcc`, `emailtemplate_mail_from`, `emailtemplate_mail_html`, `emailtemplate_mail_plain_text`, `emailtemplate_mail_sender`, `emailtemplate_mail_replyto`, `emailtemplate_mail_replyto_name`, `emailtemplate_mail_attachment`, `emailtemplate_attach_invoice`, `emailtemplate_language_files`, `emailtemplate_wrapper_tpl`, `emailtemplate_status`, `emailtemplate_default`, `emailtemplate_shortcodes`, `emailtemplate_showcase`, `emailtemplate_condition`, `emailtemplate_modified`, `emailtemplate_config_id`, `store_id`, `customer_group_id`, `order_status_id`) VALUES
(1, 'main', 'Default', '', '', '', '', '', '', 1, 0, '', '', '', '', 0, '', '', 1, 1, 1, 1, '', NOW(), 0, NULL, 0, 0);

DROP TABLE IF EXISTS `oc_emailtemplate_description`;
CREATE TABLE `oc_emailtemplate_description`(
  `emailtemplate_id` int(11) unsigned NOT NULL,
  `language_id` int(11) unsigned NOT NULL,
  `emailtemplate_description_subject` varchar(120) NULL DEFAULT NULL,
  `emailtemplate_description_preview` varchar(255) NULL DEFAULT NULL,
  `emailtemplate_description_content1` longtext NULL DEFAULT NULL,
  `emailtemplate_description_content2` longtext NULL DEFAULT NULL,
  `emailtemplate_description_content3` longtext NULL DEFAULT NULL,
  `emailtemplate_description_comment` longtext NULL DEFAULT NULL,
  `emailtemplate_description_unsubscribe_text` varchar(255) NULL DEFAULT NULL,
  PRIMARY KEY(`emailtemplate_id`, `language_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO `oc_emailtemplate_description` (`emailtemplate_id`, `language_id`, `emailtemplate_description_subject`, `emailtemplate_description_preview`, `emailtemplate_description_content1`, `emailtemplate_description_content2`, `emailtemplate_description_content3`, `emailtemplate_description_comment`, `emailtemplate_description_unsubscribe_text`) VALUES
(1, 0, '', '', '', '', '', '', '');

DROP TABLE IF EXISTS `oc_emailtemplate_shortcode`;
CREATE TABLE `oc_emailtemplate_shortcode`(
  `emailtemplate_shortcode_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `emailtemplate_shortcode_code` varchar(255) NOT NULL,
  `emailtemplate_shortcode_type` enum('language', 'auto', 'auto_serialize') NOT NULL DEFAULT 'language',
  `emailtemplate_shortcode_example` TEXT NOT NULL,
  `emailtemplate_id` int(11) unsigned NOT NULL,
  PRIMARY KEY(`emailtemplate_shortcode_id`),
  KEY `emailtemplate_id` (`emailtemplate_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

DROP TABLE IF EXISTS `oc_emailtemplate_logs`;
CREATE TABLE `oc_emailtemplate_logs` (
  `emailtemplate_log_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `emailtemplate_log_added` datetime NULL DEFAULT NULL,
  `emailtemplate_log_sent` datetime NULL DEFAULT NULL,
  `emailtemplate_log_read` datetime NULL DEFAULT NULL,
  `emailtemplate_log_read_last` datetime NULL DEFAULT NULL,
  `emailtemplate_log_type` enum('','SYSTEM','CONTACT') COLLATE utf8_general_ci NULL DEFAULT NULL,
  `emailtemplate_log_protocol` ENUM('mail','smtp') NULL DEFAULT NULL,
  `emailtemplate_log_parameter` VARCHAR(255) NOT NULL,
  `emailtemplate_log_smtp` TEXT NOT NULL,
  `emailtemplate_log_to` varchar(255) COLLATE utf8_general_ci NOT NULL,
  `emailtemplate_log_from` varchar(255) COLLATE utf8_general_ci NOT NULL,
  `emailtemplate_log_cc` VARCHAR(255) NOT NULL,
  `emailtemplate_log_bcc` VARCHAR(255) NOT NULL,
  `emailtemplate_log_attachment` VARCHAR(255) NOT NULL,
  `emailtemplate_log_sender` varchar(255) COLLATE utf8_general_ci NULL DEFAULT NULL,
  `emailtemplate_log_subject` varchar(255) COLLATE utf8_general_ci NULL DEFAULT NULL,
  `emailtemplate_log_text` longtext COLLATE utf8_general_ci NULL DEFAULT NULL,
  `emailtemplate_log_content` longtext COLLATE utf8_general_ci NULL DEFAULT NULL,
  `emailtemplate_log_enc` varchar(255) COLLATE utf8_general_ci NULL DEFAULT NULL,
  `emailtemplate_log_status` tinyint(1) NOT NULL,
  `emailtemplate_log_is_sent` tinyint(1) NULL DEFAULT NULL,
  `emailtemplate_id` int(11) unsigned NOT NULL,
  `emailtemplate_config_id` int(11) unsigned NULL DEFAULT NULL,
  `customer_id` int(11) unsigned NULL DEFAULT NULL,
  `order_id` int(11) unsigned NULL DEFAULT NULL,
  `store_id` int(11) unsigned NOT NULL,
  `language_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`emailtemplate_log_id`),
  INDEX(`emailtemplate_log_is_sent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

DROP TABLE IF EXISTS `oc_emailtemplate_showcase_log`;
CREATE TABLE `oc_emailtemplate_showcase_log` (
  `customer_id` int(11) unsigned NOT NULL,
  `product_id` int(11) unsigned NOT NULL,
  `emailtemplate_showcase_log_count` smallint(6) NOT NULL,
  `emailtemplate_showcase_log_modified` datetime NOT NULL,
  PRIMARY KEY (`customer_id`, `product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;