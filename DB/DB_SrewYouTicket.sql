SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";
CREATE DATABASE `screwyouticket` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `screwyouticket`;

DROP TABLE IF EXISTS `address`;
CREATE TABLE IF NOT EXISTS `address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `street_name` varchar(1000) NOT NULL,
  `street_number` varchar(250) NOT NULL,
  `name` varchar(1000) NOT NULL,
  `zip_code` int(11) NOT NULL,
  `town` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `event`;
CREATE TABLE IF NOT EXISTS `event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_date` date DEFAULT NULL,
  `time_start` time DEFAULT NULL,
  `time_end` time DEFAULT NULL,
  `name` varchar(250) DEFAULT NULL,
  `address_id` int(11) DEFAULT NULL,
  `isactive` bit(1) DEFAULT NULL,
  `description` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `address_id` (`address_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `event_images`;
CREATE TABLE IF NOT EXISTS `event_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL,
  `image_url` varchar(1000) NOT NULL,
  `description` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `event_id` (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `payment`;
CREATE TABLE IF NOT EXISTS `payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `purchase_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `event_id` int(11) NOT NULL,
  `price` double NOT NULL,
  `payee_name` varchar(2500) NOT NULL,
  `payee_mail` varchar(250) NOT NULL,
  `payee_birthday` date NOT NULL,
  `paymentsystem_code` int(11) NOT NULL,
  `num_of_tickets` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `event_id` (`event_id`),
  UNIQUE KEY `paymentsystem_code` (`paymentsystem_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `payment_system_codes`;
CREATE TABLE IF NOT EXISTS `payment_system_codes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

INSERT INTO `payment_system_codes` (`id`, `description`) VALUES
(1, 'Rejected by acquirer'),
(2, 'Communication error'),
(3, 'Card expired'),
(4, 'Transition is not allowed for transaction current state'),
(5, 'Authorization is expired'),
(6, 'Error reported by acquirer'),
(7, 'Error reported by QuickPay'),
(8, 'Error in request data'),
(9, 'Payment aborted by shopper'),
(10, 'Approved');

DROP TABLE IF EXISTS `price`;
CREATE TABLE IF NOT EXISTS `price` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time4lastpurchase` datetime NOT NULL,
  `event_id` int(11) NOT NULL,
  `price` double NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `event_id` (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `ticket`;
CREATE TABLE IF NOT EXISTS `ticket` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL,
  `payment_id` int(11) NOT NULL,
  `is_redeemed` bit(1) NOT NULL,
  `hash_value` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `event_id` (`event_id`),
  UNIQUE KEY `payment_id` (`payment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


ALTER TABLE `event`
  ADD CONSTRAINT `event_ibfk_1` FOREIGN KEY (`address_id`) REFERENCES `address` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

ALTER TABLE `event_images`
  ADD CONSTRAINT `event_images_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_2` FOREIGN KEY (`paymentsystem_code`) REFERENCES `payment_system_codes` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

ALTER TABLE `price`
  ADD CONSTRAINT `price_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

ALTER TABLE `ticket`
  ADD CONSTRAINT `ticket_ibfk_2` FOREIGN KEY (`payment_id`) REFERENCES `payment` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `ticket_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;
