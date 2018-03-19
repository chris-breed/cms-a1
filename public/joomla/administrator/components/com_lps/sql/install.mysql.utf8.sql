CREATE TABLE IF NOT EXISTS `#__lps_landing_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `modifiedby` int(11) NOT NULL,
  `published` int(11) NOT NULL,
  `template_id` int(11) NOT NULL,
  `form_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `#__lps_templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `modifiedby` int(11) NOT NULL,
  `published` int(11) NOT NULL,
  `content` text NOT NULL,
  `layout` varchar(255) NOT NULL,
  `show_form_title` int(11) NOT NULL,
  `form_container` varchar(255) NOT NULL,
  `field_width` varchar(255) NOT NULL,
  `field_size` varchar(255) NOT NULL,
  `field_labeling` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `#__lps_forms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `published` int(11) NOT NULL,
  `return_url` varchar(255) NOT NULL,
  `show_thank_you` int(11) NOT NULL,
  `thank_you_message` text NOT NULL,
  `user_email_text` text NOT NULL,
  `user_email_to` varchar(255) NOT NULL,
  `user_email_cc` varchar(255) NOT NULL,
  `user_email_bcc` varchar(255) NOT NULL,
  `user_email_from` varchar(255) NOT NULL,
  `user_email_reply_to` varchar(255) NOT NULL,
  `user_email_from_name` varchar(255) NOT NULL,
  `user_email_subject` varchar(255) NOT NULL,
  `user_email_mode` int(11) NOT NULL,
  `admin_email_text` text NOT NULL,
  `admin_email_to` varchar(255) NOT NULL,
  `admin_email_cc` varchar(255) NOT NULL,
  `admin_email_bcc` varchar(255) NOT NULL,
  `admin_email_from` varchar(255) NOT NULL,
  `admin_email_reply_to` varchar(255) NOT NULL,
  `admin_email_from_name` varchar(255) NOT NULL,
  `admin_email_subject` varchar(255) NOT NULL,
  `admin_email_mode` int(11) NOT NULL,
  `meta_title` text NOT NULL,
  `meta_desc` text NOT NULL,
  `meta_keywords` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `#__lps_fields` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `form_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `order` int(11) NOT NULL,
  `published` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `#__lps_field_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

INSERT INTO `#__lps_field_types` (`id`, `name`) VALUES
(1, 'text_box'),
(2, 'text_area'),
(3, 'select_list'),
(4, 'checkbox_group'),
(5, 'radio_group'),
(6, 'calendar'),
(10, 'free_text'),
(11, 'submit_button');

CREATE TABLE IF NOT EXISTS `#__lps_field_properties` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `field_id` int(11) NOT NULL,
  `property_name` varchar(255) NOT NULL,
  `property_value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `#__lps_submissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lp_id` int(11) NOT NULL,
  `form_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `user_ip` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `published` int(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `#__lps_submission_values` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `submission_id` int(11) NOT NULL,
  `field_id` int(11) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `#__lps_leads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `submission_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `email` varchar(255) NOT NULL,
  `published` int(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;










