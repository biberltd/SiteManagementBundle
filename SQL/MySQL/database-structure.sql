/**
 * @author		Can Berkol
 *
 * @copyright   Biber Ltd. (http://www.biberltd.com) (C) 2015
 * @license     GPLv3
 *
 * @date        27.12.2015
 */
SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for domain_aliases
-- ----------------------------
DROP TABLE IF EXISTS `domain_aliases`;
CREATE TABLE `domain_aliases` (
  `domain` varchar(255) COLLATE utf8_turkish_ci NOT NULL COMMENT 'Alias of the primary domain.',
  `site` int(10) unsigned NOT NULL COMMENT 'Site that alias belongs to.',
  PRIMARY KEY (`site`,`domain`),
  UNIQUE KEY `idxUSiteDomain` (`domain`,`site`),
  CONSTRAINT `idxFSiteOfDomain` FOREIGN KEY (`site`) REFERENCES `site` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- ----------------------------
-- Table structure for site
-- ----------------------------
DROP TABLE IF EXISTS `site`;
CREATE TABLE `site` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'System given id.',
  `title` varchar(155) COLLATE utf8_turkish_ci NOT NULL COMMENT 'Title of the site.',
  `url_key` varchar(255) COLLATE utf8_turkish_ci NOT NULL COMMENT 'Url key of site.',
  `description` varchar(255) COLLATE utf8_turkish_ci DEFAULT NULL COMMENT 'Short description of site.',
  `default_language` int(5) unsigned DEFAULT NULL COMMENT 'Default language of the site.',
  `settings` text COLLATE utf8_turkish_ci COMMENT 'Base64 Encoded and serialized site settings information.',
  `date_added` datetime NOT NULL COMMENT 'Date when the site is added.',
  `date_updated` datetime NOT NULL COMMENT 'Date when the site''s details last updated.',
  `date_removed` datetime DEFAULT NULL COMMENT 'Date when the entry is marked as removed.',
  `domain` text COLLATE utf8_turkish_ci COMMENT 'Domain of the site.',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idxUSiteId` (`id`) USING BTREE,
  UNIQUE KEY `idxUSiteUrlKey` (`url_key`) USING BTREE,
  KEY `idxNSiteDateAdded` (`date_added`) USING BTREE,
  KEY `idxNSiteDateUpdated` (`date_updated`) USING BTREE,
  KEY `idxFDefaultLanguageOfSite` (`default_language`) USING BTREE,
  KEY `idxNSiteDateRemoved` (`date_removed`),
  CONSTRAINT `idxFDefaultLanguageOfSite` FOREIGN KEY (`default_language`) REFERENCES `language` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci ROW_FORMAT=COMPACT;
