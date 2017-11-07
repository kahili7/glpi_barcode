DROP TABLE IF EXISTS `glpi_plugin_barcode_profiles`;
CREATE TABLE `glpi_plugin_barcode_profiles` (
	`ID` int(11) NOT NULL auto_increment,
	`name` varchar(255) default NULL,
	`interface` varchar(50) NOT NULL default 'barcode',
	`is_default` enum('0','1') NOT NULL default '0',
	`barcode` char(1) default NULL,
	PRIMARY KEY  (`ID`),
	KEY `interface` (`interface`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `glpi_plugin_barcode_configs`;
CREATE TABLE `glpi_plugin_barcode_configs` (
	`ID` int(11) NOT NULL auto_increment,
	`name` varchar(100) collate utf8_unicode_ci NOT NULL default '',
	`value` varchar(255) collate utf8_unicode_ci NOT NULL default '',
	PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `glpi_plugin_barcode_configs` ( `ID` , `name`, `value` ) VALUES ('1', 'version', '1.0.0');
INSERT INTO `glpi_plugin_barcode_configs` ( `ID` , `name`, `value` ) VALUES ('2', 'count_computers', '0');
INSERT INTO `glpi_plugin_barcode_configs` ( `ID` , `name`, `value` ) VALUES ('3', 'count_monitors', '0');
INSERT INTO `glpi_plugin_barcode_configs` ( `ID` , `name`, `value` ) VALUES ('4', 'count_printers', '0');
INSERT INTO `glpi_plugin_barcode_configs` ( `ID` , `name`, `value` ) VALUES ('5', 'count_phones', '0');
INSERT INTO `glpi_plugin_barcode_configs` ( `ID` , `name`, `value` ) VALUES ('6', 'count_networks', '0');
INSERT INTO `glpi_plugin_barcode_configs` ( `ID` , `name`, `value` ) VALUES ('7', 'count_devices', '0');

DROP TABLE IF EXISTS `glpi_plugin_barcode_computers`;
CREATE TABLE `glpi_plugin_barcode_computers` (
	`ID` int(11) NOT NULL auto_increment,
	`computer_id` int(11) NOT NULL default '0',
	`ean13` varchar(13) collate utf8_unicode_ci NOT NULL default '',
	PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `glpi_plugin_barcode_monitors`;
CREATE TABLE `glpi_plugin_barcode_monitors` (
	`ID` int(11) NOT NULL auto_increment,
	`monitor_id` int(11) NOT NULL default '0',
	`ean13` varchar(13) collate utf8_unicode_ci NOT NULL default '',
	PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `glpi_plugin_barcode_printers`;
CREATE TABLE `glpi_plugin_barcode_printers` (
	`ID` int(11) NOT NULL auto_increment,
	`printer_id` int(11) NOT NULL default '0',
	`ean13` varchar(13) collate utf8_unicode_ci NOT NULL default '',
	PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `glpi_plugin_barcode_phones`;
CREATE TABLE `glpi_plugin_barcode_phones` (
	`ID` int(11) NOT NULL auto_increment,
	`phone_id` int(11) NOT NULL default '0',
	`ean13` varchar(13) collate utf8_unicode_ci NOT NULL default '',
	PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `glpi_plugin_barcode_networks`;
CREATE TABLE `glpi_plugin_barcode_networks` (
	`ID` int(11) NOT NULL auto_increment,
	`network_id` int(11) NOT NULL default '0',
	`ean13` varchar(13) collate utf8_unicode_ci NOT NULL default '',
	PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `glpi_plugin_barcode_devices`;
CREATE TABLE `glpi_plugin_barcode_devices` (
	`ID` int(11) NOT NULL auto_increment,
	`device_id` int(11) NOT NULL default '0',
	`ean13` varchar(13) collate utf8_unicode_ci NOT NULL default '',
	PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;








