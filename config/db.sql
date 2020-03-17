-- noinspection SqlNoDataSourceInspectionForFile

-- noinspection SqlDialectInspectionForFile 

-- Listage de la structure de la base pour blog_mvc
CREATE DATABASE IF NOT EXISTS `blog_mvc`;
USE `blog_mvc`;

-- Listage de la structure de la table blog_mvc. article
CREATE TABLE IF NOT EXISTS `article` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `lead` varchar(250) DEFAULT NULL,
  `content` text NOT NULL,
  `createdAt` datetime NOT NULL,
  `publish` tinyint(1) NOT NULL DEFAULT '0',
  `updatedAt` datetime NOT NULL,
  `user_id` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`,`user_id`),
  UNIQUE KEY `title` (`title`),
  KEY `fk_article_user1_idx` (`user_id`),
  CONSTRAINT `fk_article_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de la table blog_mvc. comment
CREATE TABLE IF NOT EXISTS `comment` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `createdAt` datetime NOT NULL,
  `updateAt` datetime NOT NULL,
  `content` text NOT NULL,
  `publish` tinyint(1) DEFAULT NULL,
  `article_id` smallint(6) NOT NULL,
  `user_id` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`,`article_id`,`user_id`),
  KEY `fk_comment_article1_idx` (`article_id`),
  KEY `fk_comment_user1_idx` (`user_id`),
  CONSTRAINT `fk_comment_article1` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_comment_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de la table blog_mvc. user
CREATE TABLE IF NOT EXISTS `user` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `login` varchar(45) NOT NULL,
  `password` varchar(88) NOT NULL,
  `first_name` varchar(75) DEFAULT NULL,
  `last_name` varchar(25) DEFAULT NULL,
  `email` varchar(85) NOT NULL,
  `role` varchar(15) DEFAULT 'user',
  PRIMARY KEY (`id`),
  UNIQUE KEY `login_UNIQUE` (`login`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;

