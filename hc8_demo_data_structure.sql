-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 29, 2022 at 02:23 PM
-- Server version: 5.7.37
-- PHP Version: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `a580036_dev_hc_mm`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity`
--

CREATE TABLE `activity` (
  `id` bigint(40) NOT NULL,
  `caregiver` bigint(40) NOT NULL DEFAULT '0',
  `device` varchar(128) DEFAULT NULL,
  `firebase` varchar(256) DEFAULT NULL,
  `appos` varchar(64) DEFAULT NULL,
  `appversion` varchar(64) DEFAULT NULL,
  `action` varchar(64) DEFAULT NULL,
  `rel_id` bigint(40) NOT NULL DEFAULT '0',
  `lat` decimal(10,8) NOT NULL DEFAULT '0.00000000',
  `lng` decimal(11,8) NOT NULL DEFAULT '0.00000000',
  `meta` json DEFAULT NULL,
  `stamp` timestamp NULL DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `allergies`
--

CREATE TABLE `allergies` (
  `id` bigint(40) UNSIGNED NOT NULL,
  `names` set('latex','milk','peanut','penicillin','soy','wheat') NOT NULL,
  `patient` bigint(40) UNSIGNED NOT NULL,
  `caregiver` bigint(20) UNSIGNED NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `allergies_archive`
--

CREATE TABLE `allergies_archive` (
  `id` bigint(40) UNSIGNED NOT NULL,
  `names` set('latex','milk','peanut','penicillin','soy','wheat') NOT NULL,
  `patient` bigint(40) UNSIGNED NOT NULL,
  `caregiver` bigint(20) UNSIGNED NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `caregivers`
--

CREATE TABLE `caregivers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) DEFAULT NULL,
  `contact` bigint(40) UNSIGNED NOT NULL,
  `authhash` varchar(255) NOT NULL,
  `start_date` date DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `qualifications` set('A','B','C') NOT NULL DEFAULT 'A',
  `mon_start` time NOT NULL DEFAULT '06:30:00',
  `mon_end` time NOT NULL DEFAULT '16:30:00',
  `tue_start` time NOT NULL DEFAULT '06:30:00',
  `tue_end` time NOT NULL DEFAULT '16:30:00',
  `wed_start` time NOT NULL DEFAULT '06:30:00',
  `wed_end` time NOT NULL DEFAULT '16:30:00',
  `thu_start` time NOT NULL DEFAULT '06:30:00',
  `thu_end` time NOT NULL DEFAULT '16:30:00',
  `fri_start` time NOT NULL DEFAULT '06:30:00',
  `fri_end` time NOT NULL DEFAULT '16:30:00',
  `sat_start` time DEFAULT NULL,
  `sat_end` time DEFAULT NULL,
  `sun_start` time DEFAULT NULL,
  `sun_end` time DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `caregivers_archive`
--

CREATE TABLE `caregivers_archive` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `contact` bigint(40) UNSIGNED NOT NULL,
  `start_date` date NOT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `qualifications` set('A','B','C') NOT NULL,
  `mon_start` time NOT NULL DEFAULT '06:30:00',
  `mon_end` time NOT NULL DEFAULT '16:30:00',
  `tue_start` time NOT NULL DEFAULT '06:30:00',
  `tue_end` time NOT NULL DEFAULT '16:30:00',
  `wed_start` time NOT NULL DEFAULT '06:30:00',
  `wed_end` time NOT NULL DEFAULT '16:30:00',
  `thu_start` time NOT NULL DEFAULT '06:30:00',
  `thu_end` time NOT NULL DEFAULT '16:30:00',
  `fri_start` time NOT NULL DEFAULT '06:30:00',
  `fri_end` time NOT NULL DEFAULT '16:30:00',
  `sat_start` time NOT NULL,
  `sat_end` time NOT NULL,
  `sun_start` time NOT NULL,
  `sun_end` time NOT NULL,
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `caregivers_meta`
--

CREATE TABLE `caregivers_meta` (
  `id` bigint(40) UNSIGNED NOT NULL,
  `caregiver` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(64) NOT NULL,
  `name` varchar(128) NOT NULL,
  `type` bit(64) NOT NULL DEFAULT b'0',
  `bool` tinyint(1) NOT NULL,
  `int` bigint(40) NOT NULL,
  `dec` decimal(30,15) NOT NULL,
  `dub` double NOT NULL,
  `money` decimal(15,2) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `url` varchar(1024) NOT NULL,
  `coords` point NOT NULL,
  `text` text NOT NULL,
  `list` json NOT NULL,
  `object` json NOT NULL,
  `meta` json NOT NULL,
  `archive` tinyint(1) NOT NULL DEFAULT '0',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `caregivers_meta_archive`
--

CREATE TABLE `caregivers_meta_archive` (
  `id` bigint(40) UNSIGNED NOT NULL,
  `caregiver` bigint(40) UNSIGNED NOT NULL,
  `key` varchar(64) NOT NULL,
  `name` varchar(128) NOT NULL,
  `type` bit(64) NOT NULL DEFAULT b'0',
  `bool` tinyint(1) NOT NULL,
  `int` bigint(40) NOT NULL,
  `dec` decimal(30,15) NOT NULL,
  `dub` double NOT NULL,
  `money` decimal(15,2) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `url` varchar(1024) NOT NULL,
  `coords` point NOT NULL,
  `text` text NOT NULL,
  `list` json NOT NULL,
  `object` json NOT NULL,
  `meta` json NOT NULL,
  `archive` tinyint(1) NOT NULL DEFAULT '0',
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `caregiver_schedules`
--

CREATE TABLE `caregiver_schedules` (
  `id` bigint(40) UNSIGNED NOT NULL,
  `caregiver` bigint(20) UNSIGNED NOT NULL,
  `year` year(4) NOT NULL,
  `week` tinyint(2) NOT NULL,
  `week_status` enum('ON','OFF','VACATION') NOT NULL DEFAULT 'ON',
  `mon_status` enum('ON','OFF','VACATION') NOT NULL DEFAULT 'ON',
  `tue_status` enum('ON','OFF','VACATION') NOT NULL DEFAULT 'ON',
  `wed_status` enum('ON','OFF','VACATION') NOT NULL DEFAULT 'ON',
  `thu_status` enum('ON','OFF','VACATION') NOT NULL DEFAULT 'ON',
  `fri_status` enum('ON','OFF','VACATION') NOT NULL DEFAULT 'ON',
  `sat_status` enum('ON','OFF','VACATION') NOT NULL DEFAULT 'OFF',
  `sun_status` enum('ON','OFF','VACATION') NOT NULL DEFAULT 'OFF',
  `mon_start` time NOT NULL,
  `mon_end` time NOT NULL,
  `tue_start` time NOT NULL,
  `tue_end` time NOT NULL,
  `wed_start` time NOT NULL,
  `wed_end` time NOT NULL,
  `thu_start` time NOT NULL,
  `thu_end` time NOT NULL,
  `fri_start` time NOT NULL,
  `fri_end` time NOT NULL,
  `sat_start` time NOT NULL,
  `sat_end` time NOT NULL,
  `sun_start` time NOT NULL,
  `sun_end` time NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `caregiver_schedules_archive`
--

CREATE TABLE `caregiver_schedules_archive` (
  `id` bigint(40) UNSIGNED NOT NULL,
  `caregiver` bigint(20) UNSIGNED NOT NULL,
  `year` year(4) NOT NULL,
  `week` tinyint(2) UNSIGNED NOT NULL,
  `week_status` enum('ON','OFF','VACATION') NOT NULL DEFAULT 'ON',
  `mon_status` enum('ON','OFF','VACATION') NOT NULL DEFAULT 'ON',
  `tue_status` enum('ON','OFF','VACATION') NOT NULL DEFAULT 'ON',
  `wed_status` enum('ON','OFF','VACATION') NOT NULL DEFAULT 'ON',
  `thu_status` enum('ON','OFF','VACATION') NOT NULL DEFAULT 'ON',
  `fri_status` enum('ON','OFF','VACATION') NOT NULL DEFAULT 'ON',
  `sat_status` enum('ON','OFF','VACATION') NOT NULL DEFAULT 'OFF',
  `sun_status` enum('ON','OFF','VACATION') NOT NULL DEFAULT 'OFF',
  `mon_start` time NOT NULL,
  `mon_end` time NOT NULL,
  `tue_start` time NOT NULL,
  `tue_end` time NOT NULL,
  `wed_start` time NOT NULL,
  `wed_end` time NOT NULL,
  `thu_start` time NOT NULL,
  `thu_end` time NOT NULL,
  `fri_start` time NOT NULL,
  `fri_end` time NOT NULL,
  `sat_start` time NOT NULL,
  `sat_end` time NOT NULL,
  `sun_start` time NOT NULL,
  `sun_end` time NOT NULL,
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `care_measures`
--

CREATE TABLE `care_measures` (
  `id` int(11) UNSIGNED NOT NULL,
  `bit` bit(32) NOT NULL,
  `code` varchar(64) NOT NULL,
  `type` enum('BP','GLUCOSE','HEART_RATE','HEIGHT','LUNG_CAPACITY','SPO2','TEMP','WEIGHT') NOT NULL,
  `days` int(4) UNSIGNED NOT NULL,
  `qualifications` set('A','B','C') NOT NULL,
  `price` decimal(9,2) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `care_modules`
--

CREATE TABLE `care_modules` (
  `id` int(11) UNSIGNED NOT NULL,
  `bit` bit(32) NOT NULL,
  `code` varchar(64) NOT NULL,
  `seconds` int(4) UNSIGNED NOT NULL,
  `qualifications` set('A','B','C') NOT NULL,
  `price` decimal(9,2) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `care_plans`
--

CREATE TABLE `care_plans` (
  `id` int(8) UNSIGNED NOT NULL,
  `bits` bit(32) NOT NULL,
  `order` varchar(256) NOT NULL,
  `qualifications` set('A','B','C') NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `care_plans_archive`
--

CREATE TABLE `care_plans_archive` (
  `id` int(8) UNSIGNED NOT NULL,
  `bits` bit(32) NOT NULL,
  `order` varchar(256) NOT NULL,
  `qualifications` set('A','B','C') NOT NULL,
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(40) UNSIGNED NOT NULL,
  `uuid` char(36) DEFAULT NULL,
  `type` set('PATIENT','RELATIVE','CAREGIVER','HOC','SUPER_ADMIN','OFFICE_ADMIN','BILLING_ADMIN','DOCTOR','PHARMACY','NETWORK','OTHER') NOT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `sex` enum('male','female') DEFAULT NULL,
  `dob` date NOT NULL,
  `email` varchar(220) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `address` varchar(144) DEFAULT NULL,
  `city` varchar(40) DEFAULT NULL,
  `region` varchar(40) DEFAULT NULL,
  `country` varchar(40) DEFAULT NULL,
  `zip` varchar(24) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Triggers `contacts`
--
DELIMITER $$
CREATE TRIGGER `before_insert_contact` BEFORE INSERT ON `contacts` FOR EACH ROW BEGIN
  IF new.uuid IS NULL THEN
    SET new.uuid = uuid();
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `contacts_archive`
--

CREATE TABLE `contacts_archive` (
  `id` bigint(40) UNSIGNED NOT NULL,
  `uuid` char(36) DEFAULT NULL,
  `type` set('PATIENT','RELATIVE','CAREGIVER','HOC','SUPER_ADMIN','OFFICE_ADMIN','BILLING_ADMIN','DOCTOR','PHARMACY','NETWORK','OTHER') NOT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `sex` enum('male','female') DEFAULT NULL,
  `dob` date NOT NULL,
  `email` varchar(220) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `address` varchar(144) DEFAULT NULL,
  `city` varchar(40) DEFAULT NULL,
  `region` varchar(40) DEFAULT NULL,
  `country` varchar(40) DEFAULT NULL,
  `zip` varchar(24) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `contacts_meta`
--

CREATE TABLE `contacts_meta` (
  `id` bigint(40) UNSIGNED NOT NULL,
  `contact` bigint(40) UNSIGNED NOT NULL,
  `key` varchar(64) NOT NULL,
  `name` varchar(128) NOT NULL,
  `type` bit(64) NOT NULL DEFAULT b'0',
  `bool` tinyint(1) NOT NULL,
  `int` bigint(40) NOT NULL,
  `dec` decimal(30,15) NOT NULL,
  `dub` double NOT NULL,
  `money` decimal(15,2) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `url` varchar(1024) NOT NULL,
  `coords` point NOT NULL,
  `text` text NOT NULL,
  `list` json NOT NULL,
  `object` json NOT NULL,
  `meta` json NOT NULL,
  `archive` tinyint(1) NOT NULL DEFAULT '0',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `contacts_meta_archive`
--

CREATE TABLE `contacts_meta_archive` (
  `id` bigint(40) UNSIGNED NOT NULL,
  `contact` bigint(40) UNSIGNED NOT NULL,
  `key` varchar(64) NOT NULL,
  `name` varchar(128) NOT NULL,
  `type` bit(64) NOT NULL DEFAULT b'0',
  `bool` tinyint(1) NOT NULL,
  `int` bigint(40) NOT NULL,
  `dec` decimal(30,15) NOT NULL,
  `dub` double NOT NULL,
  `money` decimal(15,2) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `url` varchar(1024) NOT NULL,
  `coords` point NOT NULL,
  `text` text NOT NULL,
  `list` json NOT NULL,
  `object` json NOT NULL,
  `meta` json NOT NULL,
  `archive` tinyint(1) NOT NULL DEFAULT '0',
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `infections`
--

CREATE TABLE `infections` (
  `id` bigint(40) UNSIGNED NOT NULL,
  `name` enum('3mrgn','4mrgn','clostridium_d','esbl','gastroenteritis','hepatitis_a_e','meningitis','mrsa','salmonellen','tbc','vre') NOT NULL,
  `patient` bigint(40) UNSIGNED NOT NULL,
  `caregiver` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `infections_archive`
--

CREATE TABLE `infections_archive` (
  `id` bigint(40) UNSIGNED NOT NULL,
  `name` enum('3mrgn','4mrgn','clostridium_d','esbl','gastroenteritis','hepatitis_a_e','meningitis','mrsa','salmonellen','tbc','vre') NOT NULL,
  `patient` bigint(40) UNSIGNED NOT NULL,
  `caregiver` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `medication`
--

CREATE TABLE `medication` (
  `id` bigint(40) UNSIGNED NOT NULL,
  `code` varchar(64) NOT NULL,
  `patient` bigint(40) UNSIGNED NOT NULL,
  `doctor` bigint(40) UNSIGNED NOT NULL,
  `dosage` int(11) NOT NULL,
  `msr` enum('mg','g','ml','dl','units') NOT NULL,
  `time` set('am','noon','pm') NOT NULL,
  `with_food` tinyint(1) NOT NULL,
  `advice` varchar(255) NOT NULL,
  `expire` date NOT NULL,
  `ref` varchar(255) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `medication_archive`
--

CREATE TABLE `medication_archive` (
  `id` bigint(40) UNSIGNED NOT NULL,
  `code` varchar(64) NOT NULL,
  `patient` bigint(40) UNSIGNED NOT NULL,
  `doctor` bigint(40) UNSIGNED NOT NULL,
  `dosage` int(11) NOT NULL,
  `msr` enum('mg','g','ml','dl','units') NOT NULL,
  `time` set('am','noon','pm') NOT NULL,
  `with_food` tinyint(1) NOT NULL,
  `advice` varchar(255) NOT NULL,
  `expire` date NOT NULL,
  `ref` varchar(255) NOT NULL,
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `id` bigint(40) UNSIGNED NOT NULL,
  `caregiver` bigint(20) UNSIGNED NOT NULL,
  `patient` bigint(40) UNSIGNED NOT NULL DEFAULT '0',
  `tags` set('IMPORTANT','MEMO','TASK','PATIENT','PRIVATE') NOT NULL,
  `due` datetime NOT NULL,
  `completed` datetime NOT NULL,
  `note` varchar(255) NOT NULL,
  `audio` varchar(1024) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `notes_archive`
--

CREATE TABLE `notes_archive` (
  `id` bigint(40) UNSIGNED NOT NULL,
  `caregiver` bigint(20) UNSIGNED NOT NULL,
  `patient` bigint(40) UNSIGNED NOT NULL DEFAULT '0',
  `tags` set('IMPORTANT','MEMO','TASK','PATIENT','PRIVATE') NOT NULL,
  `due` datetime NOT NULL,
  `completed` datetime NOT NULL,
  `note` varchar(255) NOT NULL,
  `audio` varchar(1024) NOT NULL,
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE `options` (
  `id` bigint(40) UNSIGNED NOT NULL,
  `key` varchar(64) NOT NULL,
  `name` varchar(128) NOT NULL,
  `type` bit(64) NOT NULL DEFAULT b'0',
  `bool` tinyint(1) NOT NULL,
  `int` bigint(40) NOT NULL,
  `dec` decimal(30,15) NOT NULL,
  `dub` double NOT NULL,
  `money` decimal(15,2) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `url` varchar(1024) NOT NULL,
  `coords` point NOT NULL,
  `text` text NOT NULL,
  `list` json NOT NULL,
  `object` json NOT NULL,
  `meta` json NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` bigint(40) UNSIGNED NOT NULL,
  `contact` bigint(40) UNSIGNED NOT NULL,
  `poa` bigint(40) UNSIGNED NOT NULL,
  `emergency` bigint(40) UNSIGNED NOT NULL,
  `doctor` bigint(40) UNSIGNED NOT NULL,
  `insurance` varchar(255) NOT NULL,
  `key_no` varchar(16) NOT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `week_status` set('MORNING','AFTERNOON','EVENING','INACTIVE') NOT NULL,
  `mon_status` set('MORNING','AFTERNOON','EVENING','INACTIVE') NOT NULL DEFAULT 'MORNING',
  `tue_status` set('MORNING','AFTERNOON','EVENING','INACTIVE') NOT NULL DEFAULT 'MORNING',
  `wed_status` set('MORNING','AFTERNOON','EVENING','INACTIVE') NOT NULL DEFAULT 'MORNING',
  `thu_status` set('MORNING','AFTERNOON','EVENING','INACTIVE') NOT NULL DEFAULT 'MORNING',
  `fri_status` set('MORNING','AFTERNOON','EVENING','INACTIVE') NOT NULL DEFAULT 'MORNING',
  `sat_status` set('MORNING','AFTERNOON','EVENING','INACTIVE') NOT NULL DEFAULT 'INACTIVE',
  `sun_status` set('MORNING','AFTERNOON','EVENING','INACTIVE') NOT NULL DEFAULT 'INACTIVE',
  `mon_morning` time NOT NULL,
  `mon_afternoon` time NOT NULL,
  `mon_evening` time NOT NULL,
  `tue_morning` time NOT NULL,
  `tue_afternoon` time NOT NULL,
  `tue_evening` time NOT NULL,
  `wed_morning` time NOT NULL,
  `wed_afternoon` time NOT NULL,
  `wed_evening` time NOT NULL,
  `thu_morning` time NOT NULL,
  `thu_afternoon` time NOT NULL,
  `thu_evening` time NOT NULL,
  `fri_morning` time NOT NULL,
  `fri_afternoon` time NOT NULL,
  `fri_evening` time NOT NULL,
  `sat_morning` time NOT NULL,
  `sat_afternoon` time NOT NULL,
  `sat_evening` time NOT NULL,
  `sun_morning` time NOT NULL,
  `sun_afternoon` time NOT NULL,
  `sun_evening` time NOT NULL,
  `mon_morning_care_plan` int(11) NOT NULL,
  `mon_afternoon_care_plan` int(11) NOT NULL,
  `mon_evening_care_plan` int(11) NOT NULL,
  `tue_morning_care_plan` int(11) NOT NULL,
  `tue_afternoon_care_plan` int(11) NOT NULL,
  `tue_evening_care_plan` int(11) NOT NULL,
  `wed_morning_care_plan` int(11) NOT NULL,
  `wed_afternoon_care_plan` int(11) NOT NULL,
  `wed_evening_care_plan` int(11) NOT NULL,
  `thu_morning_care_plan` int(11) NOT NULL,
  `thu_afternoon_care_plan` int(11) NOT NULL,
  `thu_evening_care_plan` int(11) NOT NULL,
  `fri_morning_care_plan` int(11) NOT NULL,
  `fri_afternoon_care_plan` int(11) NOT NULL,
  `fri_evening_care_plan` int(11) NOT NULL,
  `sat_morning_care_plan` int(11) NOT NULL,
  `sat_afternoon_care_plan` int(11) NOT NULL,
  `sat_evening_care_plan` int(11) NOT NULL,
  `sun_morning_care_plan` int(11) NOT NULL,
  `sun_afternoon_care_plan` int(11) NOT NULL,
  `sun_evening_care_plan` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `patients_archive`
--

CREATE TABLE `patients_archive` (
  `id` bigint(40) UNSIGNED NOT NULL,
  `contact` bigint(40) UNSIGNED NOT NULL,
  `poa` bigint(40) UNSIGNED NOT NULL,
  `emergency` bigint(40) UNSIGNED NOT NULL,
  `doctor` bigint(40) UNSIGNED NOT NULL,
  `insurance` varchar(255) NOT NULL,
  `key_no` varchar(16) NOT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL,
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `patients_meta`
--

CREATE TABLE `patients_meta` (
  `id` bigint(40) UNSIGNED NOT NULL,
  `patient` bigint(40) UNSIGNED NOT NULL,
  `key` varchar(64) NOT NULL,
  `name` varchar(128) NOT NULL,
  `type` bit(64) NOT NULL DEFAULT b'0',
  `bool` tinyint(1) NOT NULL,
  `int` bigint(40) NOT NULL,
  `dec` decimal(30,15) NOT NULL,
  `dub` double NOT NULL,
  `money` decimal(15,2) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `url` varchar(1024) NOT NULL,
  `coords` point NOT NULL,
  `text` text NOT NULL,
  `list` json NOT NULL,
  `object` json NOT NULL,
  `meta` json NOT NULL,
  `archive` tinyint(1) NOT NULL DEFAULT '0',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `patients_meta_archive`
--

CREATE TABLE `patients_meta_archive` (
  `id` bigint(40) UNSIGNED NOT NULL,
  `patient` bigint(40) UNSIGNED NOT NULL,
  `key` varchar(64) NOT NULL,
  `name` varchar(128) NOT NULL,
  `type` bit(64) NOT NULL DEFAULT b'0',
  `bool` tinyint(1) NOT NULL,
  `int` bigint(40) NOT NULL,
  `dec` decimal(30,15) NOT NULL,
  `dub` double NOT NULL,
  `money` decimal(15,2) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `url` varchar(1024) NOT NULL,
  `coords` point NOT NULL,
  `text` text NOT NULL,
  `list` json NOT NULL,
  `object` json NOT NULL,
  `meta` json NOT NULL,
  `archive` tinyint(1) NOT NULL DEFAULT '0',
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `patient_schedules`
--

CREATE TABLE `patient_schedules` (
  `id` bigint(40) UNSIGNED NOT NULL,
  `patient` bigint(40) UNSIGNED NOT NULL,
  `year` year(4) NOT NULL,
  `week` tinyint(2) NOT NULL,
  `week_status` set('MORNING','AFTERNOON','EVENING','INACTIVE') NOT NULL DEFAULT 'MORNING',
  `mon_status` set('MORNING','AFTERNOON','EVENING','INACTIVE') NOT NULL DEFAULT 'MORNING',
  `tue_status` set('MORNING','AFTERNOON','EVENING','INACTIVE') NOT NULL DEFAULT 'MORNING',
  `wed_status` set('MORNING','AFTERNOON','EVENING','INACTIVE') NOT NULL DEFAULT 'MORNING',
  `thu_status` set('MORNING','AFTERNOON','EVENING','INACTIVE') NOT NULL DEFAULT 'MORNING',
  `fri_status` set('MORNING','AFTERNOON','EVENING','INACTIVE') NOT NULL DEFAULT 'MORNING',
  `sat_status` set('MORNING','AFTERNOON','EVENING','INACTIVE') NOT NULL DEFAULT 'INACTIVE',
  `sun_status` set('MORNING','AFTERNOON','EVENING','INACTIVE') NOT NULL DEFAULT 'INACTIVE',
  `mon_morning` time NOT NULL,
  `mon_afternoon` time NOT NULL,
  `mon_evening` time NOT NULL,
  `tue_morning` time NOT NULL,
  `tue_afternoon` time NOT NULL,
  `tue_evening` time NOT NULL,
  `wed_morning` time NOT NULL,
  `wed_afternoon` time NOT NULL,
  `wed_evening` time NOT NULL,
  `thu_morning` time NOT NULL,
  `thu_afternoon` time NOT NULL,
  `thu_evening` time NOT NULL,
  `fri_morning` time NOT NULL,
  `fri_afternoon` time NOT NULL,
  `fri_evening` time NOT NULL,
  `sat_morning` time NOT NULL,
  `sat_afternoon` time NOT NULL,
  `sat_evening` time NOT NULL,
  `sun_morning` time NOT NULL,
  `sun_afternoon` time NOT NULL,
  `sun_evening` time NOT NULL,
  `mon_morning_care_plan` int(11) NOT NULL,
  `mon_afternoon_care_plan` int(11) NOT NULL,
  `mon_evening_care_plan` int(11) NOT NULL,
  `tue_morning_care_plan` int(11) NOT NULL,
  `tue_afternoon_care_plan` int(11) NOT NULL,
  `tue_evening_care_plan` int(11) NOT NULL,
  `wed_morning_care_plan` int(11) NOT NULL,
  `wed_afternoon_care_plan` int(11) NOT NULL,
  `wed_evening_care_plan` int(11) NOT NULL,
  `thu_morning_care_plan` int(11) NOT NULL,
  `thu_afternoon_care_plan` int(11) NOT NULL,
  `thu_evening_care_plan` int(11) NOT NULL,
  `fri_morning_care_plan` int(11) NOT NULL,
  `fri_afternoon_care_plan` int(11) NOT NULL,
  `fri_evening_care_plan` int(11) NOT NULL,
  `sat_morning_care_plan` int(11) NOT NULL,
  `sat_afternoon_care_plan` int(11) NOT NULL,
  `sat_evening_care_plan` int(11) NOT NULL,
  `sun_morning_care_plan` int(11) NOT NULL,
  `sun_afternoon_care_plan` int(11) NOT NULL,
  `sun_evening_care_plan` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `patient_schedules_archive`
--

CREATE TABLE `patient_schedules_archive` (
  `id` bigint(40) UNSIGNED NOT NULL,
  `patient` bigint(40) UNSIGNED NOT NULL,
  `year` year(4) NOT NULL,
  `week` tinyint(2) NOT NULL,
  `week_status` set('MORNING','AFTERNOON','EVENING','INACTIVE') NOT NULL DEFAULT 'MORNING',
  `mon_status` set('MORNING','AFTERNOON','EVENING','INACTIVE') NOT NULL DEFAULT 'MORNING',
  `tue_status` set('MORNING','AFTERNOON','EVENING','INACTIVE') NOT NULL DEFAULT 'MORNING',
  `wed_status` set('MORNING','AFTERNOON','EVENING','INACTIVE') NOT NULL DEFAULT 'MORNING',
  `thu_status` set('MORNING','AFTERNOON','EVENING','INACTIVE') NOT NULL DEFAULT 'MORNING',
  `fri_status` set('MORNING','AFTERNOON','EVENING','INACTIVE') NOT NULL DEFAULT 'MORNING',
  `sat_status` set('MORNING','AFTERNOON','EVENING','INACTIVE') NOT NULL DEFAULT 'INACTIVE',
  `sun_status` set('MORNING','AFTERNOON','EVENING','INACTIVE') NOT NULL DEFAULT 'INACTIVE',
  `mon_morning` time NOT NULL,
  `mon_afternoon` time NOT NULL,
  `mon_evening` time NOT NULL,
  `tue_morning` time NOT NULL,
  `tue_afternoon` time NOT NULL,
  `tue_evening` time NOT NULL,
  `wed_morning` time NOT NULL,
  `wed_afternoon` time NOT NULL,
  `wed_evening` time NOT NULL,
  `thu_morning` time NOT NULL,
  `thu_afternoon` time NOT NULL,
  `thu_evening` time NOT NULL,
  `fri_morning` time NOT NULL,
  `fri_afternoon` time NOT NULL,
  `fri_evening` time NOT NULL,
  `sat_morning` time NOT NULL,
  `sat_afternoon` time NOT NULL,
  `sat_evening` time NOT NULL,
  `sun_morning` time NOT NULL,
  `sun_afternoon` time NOT NULL,
  `sun_evening` time NOT NULL,
  `mon_morning_care_plan` int(11) NOT NULL,
  `mon_afternoon_care_plan` int(11) NOT NULL,
  `mon_evening_care_plan` int(11) NOT NULL,
  `tue_morning_care_plan` int(11) NOT NULL,
  `tue_afternoon_care_plan` int(11) NOT NULL,
  `tue_evening_care_plan` int(11) NOT NULL,
  `wed_morning_care_plan` int(11) NOT NULL,
  `wed_afternoon_care_plan` int(11) NOT NULL,
  `wed_evening_care_plan` int(11) NOT NULL,
  `thu_morning_care_plan` int(11) NOT NULL,
  `thu_afternoon_care_plan` int(11) NOT NULL,
  `thu_evening_care_plan` int(11) NOT NULL,
  `fri_morning_care_plan` int(11) NOT NULL,
  `fri_afternoon_care_plan` int(11) NOT NULL,
  `fri_evening_care_plan` int(11) NOT NULL,
  `sat_morning_care_plan` int(11) NOT NULL,
  `sat_afternoon_care_plan` int(11) NOT NULL,
  `sat_evening_care_plan` int(11) NOT NULL,
  `sun_morning_care_plan` int(11) NOT NULL,
  `sun_afternoon_care_plan` int(11) NOT NULL,
  `sun_evening_care_plan` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `risk_assessments`
--

CREATE TABLE `risk_assessments` (
  `id` bigint(40) UNSIGNED NOT NULL,
  `patient` bigint(40) UNSIGNED NOT NULL,
  `caregiver` bigint(20) UNSIGNED NOT NULL,
  `type` enum('DECUBITUS','DEHYDRATION','FALLING','INCONTINENCE','MALNUTRITION','MOBILITY') NOT NULL,
  `grade` enum('1','2','3','4','5') NOT NULL,
  `note` varchar(1024) NOT NULL,
  `audio` varchar(1024) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `risk_assessments_archive`
--

CREATE TABLE `risk_assessments_archive` (
  `id` bigint(40) UNSIGNED NOT NULL,
  `patient` bigint(40) UNSIGNED NOT NULL,
  `caregiver` bigint(20) UNSIGNED NOT NULL,
  `type` enum('DECUBITUS','DEHYDRATION','FALLING','INCONTINENCE','MALNUTRITION','MOBILITY') NOT NULL,
  `grade` enum('1','2','3','4','5') NOT NULL,
  `note` varchar(1024) NOT NULL,
  `audio` varchar(1024) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `risk_profiles`
--

CREATE TABLE `risk_profiles` (
  `id` bigint(40) UNSIGNED NOT NULL,
  `type` enum('DECUBITUS','DEHYDRATION','FALLING','INCONTINENCE','MALNUTRITION','MOBILITY') NOT NULL,
  `patient` bigint(40) UNSIGNED NOT NULL,
  `caregiver` bigint(20) UNSIGNED NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `risk_profile_meta`
--

CREATE TABLE `risk_profile_meta` (
  `id` bigint(40) UNSIGNED NOT NULL,
  `risk_profile` bigint(40) UNSIGNED NOT NULL,
  `key` varchar(64) NOT NULL,
  `value` mediumtext NOT NULL,
  `caregiver` bigint(20) UNSIGNED NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `risk_profile_meta_archive`
--

CREATE TABLE `risk_profile_meta_archive` (
  `id` bigint(40) UNSIGNED NOT NULL,
  `risk_profile` bigint(40) UNSIGNED NOT NULL,
  `key` varchar(64) NOT NULL,
  `value` mediumtext NOT NULL,
  `caregiver` bigint(20) UNSIGNED NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `time_log`
--

CREATE TABLE `time_log` (
  `id` bigint(40) UNSIGNED NOT NULL,
  `tour` bigint(40) UNSIGNED NOT NULL,
  `visit` bigint(40) UNSIGNED NOT NULL DEFAULT '0',
  `type` enum('PAUSE_CARE','COMMUTE','BREAK','CARE','ADMIN','OTHER') NOT NULL DEFAULT 'PAUSE_CARE',
  `start` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `end` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `note` varchar(1024) NOT NULL,
  `audio` varchar(1024) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `time_log_archive`
--

CREATE TABLE `time_log_archive` (
  `id` bigint(40) UNSIGNED NOT NULL,
  `tour` bigint(40) UNSIGNED NOT NULL,
  `visit` bigint(40) UNSIGNED NOT NULL DEFAULT '0',
  `type` enum('PAUSE_CARE','COMMUTE','BREAK','CARE','ADMIN','OTHER') NOT NULL DEFAULT 'PAUSE_CARE',
  `start` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `end` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `note` varchar(1024) NOT NULL,
  `audio` varchar(1024) NOT NULL,
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tours`
--

CREATE TABLE `tours` (
  `id` bigint(40) UNSIGNED NOT NULL,
  `caregiver` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `keys` json NOT NULL,
  `visits` json NOT NULL,
  `start` timestamp NULL DEFAULT NULL,
  `end` timestamp NULL DEFAULT NULL,
  `vehicle` int(10) UNSIGNED NOT NULL,
  `start_km` int(8) NOT NULL,
  `end_km` int(8) NOT NULL,
  `total_km` int(8) GENERATED ALWAYS AS ((`start_km` - `end_km`)) VIRTUAL NOT NULL,
  `status` enum('STARTED','COMPLETED','ABORTED','PLANNED','CANCELED') NOT NULL DEFAULT 'PLANNED',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tours_archive`
--

CREATE TABLE `tours_archive` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `caregiver` bigint(20) UNSIGNED NOT NULL,
  `visits` json NOT NULL,
  `start` timestamp NULL DEFAULT NULL,
  `end` timestamp NULL DEFAULT NULL,
  `vehicle` int(10) UNSIGNED NOT NULL,
  `start_km` int(8) NOT NULL,
  `end_km` int(8) NOT NULL,
  `total_km` int(8) GENERATED ALWAYS AS ((`start_km` - `end_km`)) VIRTUAL NOT NULL,
  `created` timestamp NULL DEFAULT NULL,
  `modified` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `transient`
--

CREATE TABLE `transient` (
  `id` bigint(40) NOT NULL,
  `person` bigint(20) NOT NULL DEFAULT '0',
  `device` varchar(128) DEFAULT NULL,
  `appos` varchar(64) DEFAULT NULL,
  `action` varchar(64) DEFAULT NULL,
  `otphash` varchar(255) DEFAULT NULL,
  `attempts` int(11) NOT NULL DEFAULT '0',
  `meta` json DEFAULT NULL,
  `expires` timestamp NULL DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `registration` varchar(16) NOT NULL,
  `make` varchar(64) NOT NULL,
  `model` varchar(64) NOT NULL,
  `year` smallint(4) NOT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `vehicles_archive`
--

CREATE TABLE `vehicles_archive` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `registration` varchar(16) NOT NULL,
  `make` varchar(64) NOT NULL,
  `model` varchar(64) NOT NULL,
  `year` smallint(4) NOT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `visits`
--

CREATE TABLE `visits` (
  `id` bigint(40) UNSIGNED NOT NULL,
  `scheduled` datetime NOT NULL,
  `tour` bigint(40) UNSIGNED NOT NULL,
  `patient` bigint(40) UNSIGNED NOT NULL,
  `care_plan` int(11) NOT NULL,
  `start` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `end` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` enum('STARTED','COMPLETED','ABORTED','PLANNED','CANCELED') NOT NULL DEFAULT 'PLANNED',
  `patient_status` enum('POOR','AVERAGE','GOOD') NOT NULL,
  `note` varchar(1024) NOT NULL,
  `audio` varchar(1024) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `visits_archive`
--

CREATE TABLE `visits_archive` (
  `id` bigint(40) UNSIGNED NOT NULL,
  `scheduled` datetime NOT NULL,
  `tour` bigint(40) UNSIGNED NOT NULL,
  `patient` bigint(40) UNSIGNED NOT NULL,
  `care_plan` int(11) NOT NULL,
  `start` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `end` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` enum('STARTED','COMPLETED','ABORTED','PLANNED','CANCELED') NOT NULL,
  `patient_status` enum('POOR','AVERAGE','GOOD') NOT NULL,
  `note` varchar(1024) NOT NULL,
  `audio` varchar(1024) NOT NULL,
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `visit_care`
--

CREATE TABLE `visit_care` (
  `id` bigint(40) UNSIGNED NOT NULL,
  `visit` bigint(40) UNSIGNED NOT NULL,
  `care_module` bigint(20) UNSIGNED NOT NULL,
  `type` enum('PLANNED','ADDED') NOT NULL,
  `status` enum('QUEUED','DONE','SKIPPED') NOT NULL DEFAULT 'QUEUED',
  `note` varchar(1024) NOT NULL,
  `audio` varchar(1024) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `visit_care_archive`
--

CREATE TABLE `visit_care_archive` (
  `id` bigint(40) UNSIGNED NOT NULL,
  `visit` bigint(40) UNSIGNED NOT NULL,
  `care_module` bigint(20) UNSIGNED NOT NULL,
  `type` enum('PLANNED','ADDED') NOT NULL,
  `status` enum('QUEUED','DONE','SKIPPED') NOT NULL DEFAULT 'QUEUED',
  `note` varchar(1024) NOT NULL,
  `audio` varchar(1024) NOT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `visit_measures`
--

CREATE TABLE `visit_measures` (
  `id` bigint(40) UNSIGNED NOT NULL,
  `visit` bigint(40) UNSIGNED NOT NULL,
  `measure` enum('BP_SYSTOLIC','BP_DIASTOLIC','GLUCOSE_FASTED','GLUCOSE_NOT_FASTED','GLUCOSE_INSULIN','HEART_RATE','HEIGHT','LUNG_CAPACITY','SPO2','TEMP','WEIGHT') GENERATED ALWAYS AS (if((`sub_type` > ''),concat(`type`,'_',`sub_type`),`type`)) VIRTUAL NOT NULL,
  `type` enum('BP','GLUCOSE','HEART_RATE','HEIGHT','LUNG_CAPACITY','SPO2','TEMP','WEIGHT') NOT NULL,
  `sub_type` enum('','SYSTOLIC','DIASTOLIC','FASTED','NOT_FASTED','INSULIN') NOT NULL DEFAULT '',
  `value` decimal(5,2) UNSIGNED NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tags` set('REQUESTED','ADDED') NOT NULL DEFAULT 'ADDED',
  `status` enum('QUEUED','DONE','SKIPPED') NOT NULL DEFAULT 'QUEUED',
  `note` varchar(1024) NOT NULL,
  `audio` varchar(1024) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `visit_measures_archive`
--

CREATE TABLE `visit_measures_archive` (
  `id` bigint(40) UNSIGNED NOT NULL,
  `visit` bigint(40) UNSIGNED NOT NULL,
  `measure` enum('BP_SYSTOLIC','BP_DIASTOLIC','GLUCOSE_FASTED','GLUCOSE_NOT_FASTED','GLUCOSE_INSULIN','HEART_RATE','HEIGHT','LUNG_CAPACITY','SPO2','TEMP','WEIGHT') GENERATED ALWAYS AS (if((`sub_type` > ''),concat(`type`,'_',`sub_type`),`type`)) VIRTUAL NOT NULL,
  `type` enum('BP','GLUCOSE','HEART_RATE','HEIGHT','LUNG_CAPACITY','SPO2','TEMP','WEIGHT') NOT NULL,
  `sub_type` enum('','SYSTOLIC','DIASTOLIC','FASTED','NOT_FASTED','INSULIN') NOT NULL DEFAULT '',
  `value` decimal(5,2) UNSIGNED NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tags` set('REQUESTED','ADDED') NOT NULL DEFAULT 'ADDED',
  `status` enum('QUEUED','DONE','SKIPPED') NOT NULL DEFAULT 'QUEUED',
  `note` varchar(1024) NOT NULL,
  `audio` varchar(1024) NOT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity`
--
ALTER TABLE `activity`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `caregiver` (`caregiver`);

--
-- Indexes for table `allergies`
--
ALTER TABLE `allergies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `patient` (`patient`) USING BTREE,
  ADD KEY `caregiver` (`caregiver`);

--
-- Indexes for table `allergies_archive`
--
ALTER TABLE `allergies_archive`
  ADD PRIMARY KEY (`id`),
  ADD KEY `caregiver` (`caregiver`),
  ADD KEY `patient` (`patient`);

--
-- Indexes for table `caregivers`
--
ALTER TABLE `caregivers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `contact` (`contact`);

--
-- Indexes for table `caregivers_archive`
--
ALTER TABLE `caregivers_archive`
  ADD KEY `id` (`id`),
  ADD KEY `contact` (`contact`);

--
-- Indexes for table `caregivers_meta`
--
ALTER TABLE `caregivers_meta`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `caregiver_key` (`caregiver`,`key`) USING BTREE,
  ADD KEY `key` (`key`),
  ADD SPATIAL KEY `coords` (`coords`),
  ADD KEY `caregiver` (`caregiver`) USING BTREE;

--
-- Indexes for table `caregivers_meta_archive`
--
ALTER TABLE `caregivers_meta_archive`
  ADD KEY `id` (`id`),
  ADD KEY `key` (`key`),
  ADD SPATIAL KEY `coords` (`coords`),
  ADD KEY `caregiver` (`caregiver`) USING BTREE,
  ADD KEY `caregiver_key` (`caregiver`,`key`) USING BTREE;

--
-- Indexes for table `caregiver_schedules`
--
ALTER TABLE `caregiver_schedules`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `year_week` (`year`,`week`) USING BTREE,
  ADD KEY `caregiver` (`caregiver`);

--
-- Indexes for table `caregiver_schedules_archive`
--
ALTER TABLE `caregiver_schedules_archive`
  ADD UNIQUE KEY `year` (`year`,`week`),
  ADD UNIQUE KEY `id` (`id`) USING BTREE,
  ADD KEY `caregiver` (`caregiver`);

--
-- Indexes for table `care_measures`
--
ALTER TABLE `care_measures`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD UNIQUE KEY `bid` (`bit`) USING BTREE,
  ADD UNIQUE KEY `type` (`type`) USING BTREE;

--
-- Indexes for table `care_modules`
--
ALTER TABLE `care_modules`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD UNIQUE KEY `bid` (`bit`) USING BTREE;

--
-- Indexes for table `care_plans`
--
ALTER TABLE `care_plans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bits` (`bits`);

--
-- Indexes for table `care_plans_archive`
--
ALTER TABLE `care_plans_archive`
  ADD KEY `id` (`id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contacts_archive`
--
ALTER TABLE `contacts_archive`
  ADD KEY `id` (`id`);

--
-- Indexes for table `contacts_meta`
--
ALTER TABLE `contacts_meta`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `contact_key` (`contact`,`key`) USING BTREE,
  ADD KEY `key` (`key`),
  ADD SPATIAL KEY `coords` (`coords`),
  ADD KEY `contact` (`contact`) USING BTREE;

--
-- Indexes for table `contacts_meta_archive`
--
ALTER TABLE `contacts_meta_archive`
  ADD UNIQUE KEY `contact_key` (`contact`,`key`) USING BTREE,
  ADD KEY `id` (`id`),
  ADD KEY `key` (`key`),
  ADD SPATIAL KEY `coords` (`coords`),
  ADD KEY `contact` (`contact`) USING BTREE;

--
-- Indexes for table `infections`
--
ALTER TABLE `infections`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `patient_infection` (`patient`,`name`) USING BTREE,
  ADD KEY `caregiver` (`caregiver`);

--
-- Indexes for table `infections_archive`
--
ALTER TABLE `infections_archive`
  ADD KEY `caregiver` (`caregiver`),
  ADD KEY `id` (`id`),
  ADD KEY `patient_infection` (`patient`,`name`) USING BTREE;

--
-- Indexes for table `medication`
--
ALTER TABLE `medication`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `patient_medicine` (`patient`,`code`) USING BTREE,
  ADD KEY `patient` (`patient`),
  ADD KEY `doctor` (`doctor`),
  ADD KEY `code` (`code`);

--
-- Indexes for table `medication_archive`
--
ALTER TABLE `medication_archive`
  ADD KEY `id` (`id`),
  ADD KEY `patient_medicine` (`patient`,`code`) USING BTREE,
  ADD KEY `patient` (`patient`),
  ADD KEY `doctor` (`doctor`),
  ADD KEY `code` (`code`);

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `caregiver` (`caregiver`),
  ADD KEY `patient` (`patient`);

--
-- Indexes for table `notes_archive`
--
ALTER TABLE `notes_archive`
  ADD KEY `id` (`id`),
  ADD KEY `caregiver` (`caregiver`),
  ADD KEY `patient` (`patient`);

--
-- Indexes for table `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `key` (`key`) USING BTREE,
  ADD SPATIAL KEY `coords` (`coords`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `contact` (`contact`),
  ADD KEY `poa` (`poa`),
  ADD KEY `emergency` (`emergency`),
  ADD KEY `doctor` (`doctor`);

--
-- Indexes for table `patients_archive`
--
ALTER TABLE `patients_archive`
  ADD KEY `id` (`id`),
  ADD KEY `contact` (`contact`),
  ADD KEY `poa` (`poa`),
  ADD KEY `emergency` (`emergency`),
  ADD KEY `doctor` (`doctor`);

--
-- Indexes for table `patients_meta`
--
ALTER TABLE `patients_meta`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `patient_key` (`patient`,`key`) USING BTREE,
  ADD KEY `patient` (`patient`),
  ADD KEY `key` (`key`),
  ADD SPATIAL KEY `coords` (`coords`);

--
-- Indexes for table `patients_meta_archive`
--
ALTER TABLE `patients_meta_archive`
  ADD KEY `id` (`id`),
  ADD KEY `patient_key` (`patient`,`key`) USING BTREE,
  ADD KEY `patient` (`patient`),
  ADD KEY `key` (`key`),
  ADD SPATIAL KEY `coords` (`coords`);

--
-- Indexes for table `patient_schedules`
--
ALTER TABLE `patient_schedules`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `year_week` (`year`,`week`) USING BTREE,
  ADD KEY `patient` (`patient`);

--
-- Indexes for table `patient_schedules_archive`
--
ALTER TABLE `patient_schedules_archive`
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `year_week` (`year`,`week`) USING BTREE,
  ADD KEY `patient` (`patient`);

--
-- Indexes for table `risk_assessments`
--
ALTER TABLE `risk_assessments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `patient_risk` (`patient`,`type`) USING BTREE;

--
-- Indexes for table `risk_assessments_archive`
--
ALTER TABLE `risk_assessments_archive`
  ADD KEY `id` (`id`),
  ADD KEY `patient_risk` (`patient`,`type`) USING BTREE;

--
-- Indexes for table `risk_profiles`
--
ALTER TABLE `risk_profiles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `patient_risk` (`patient`,`type`) USING BTREE;

--
-- Indexes for table `risk_profile_meta`
--
ALTER TABLE `risk_profile_meta`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `risk_profile_key` (`risk_profile`,`key`) USING BTREE,
  ADD KEY `caregiver` (`caregiver`) USING BTREE;

--
-- Indexes for table `risk_profile_meta_archive`
--
ALTER TABLE `risk_profile_meta_archive`
  ADD KEY `id` (`id`) USING BTREE,
  ADD KEY `caregiver` (`caregiver`) USING BTREE,
  ADD KEY `risk_profile_key` (`risk_profile`,`key`) USING BTREE;

--
-- Indexes for table `time_log`
--
ALTER TABLE `time_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tour` (`tour`) USING BTREE,
  ADD KEY `visit` (`visit`) USING BTREE;

--
-- Indexes for table `time_log_archive`
--
ALTER TABLE `time_log_archive`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tour` (`tour`) USING BTREE,
  ADD KEY `visit` (`visit`) USING BTREE;

--
-- Indexes for table `tours`
--
ALTER TABLE `tours`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vehicle` (`vehicle`),
  ADD KEY `caregiver` (`caregiver`);

--
-- Indexes for table `tours_archive`
--
ALTER TABLE `tours_archive`
  ADD KEY `vehicle` (`vehicle`),
  ADD KEY `caregiver` (`caregiver`),
  ADD KEY `id` (`id`) USING BTREE;

--
-- Indexes for table `transient`
--
ALTER TABLE `transient`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `registration` (`registration`);

--
-- Indexes for table `vehicles_archive`
--
ALTER TABLE `vehicles_archive`
  ADD KEY `id` (`id`),
  ADD KEY `registration` (`registration`);

--
-- Indexes for table `visits`
--
ALTER TABLE `visits`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `patient_tour` (`patient`,`tour`) USING BTREE,
  ADD KEY `care_plan` (`care_plan`);

--
-- Indexes for table `visits_archive`
--
ALTER TABLE `visits_archive`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `patient_tour` (`patient`,`tour`) USING BTREE,
  ADD KEY `care_plan` (`care_plan`);

--
-- Indexes for table `visit_care`
--
ALTER TABLE `visit_care`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `visit_care_module` (`visit`,`care_module`) USING BTREE;

--
-- Indexes for table `visit_care_archive`
--
ALTER TABLE `visit_care_archive`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `visit_care_module` (`visit`,`care_module`) USING BTREE;

--
-- Indexes for table `visit_measures`
--
ALTER TABLE `visit_measures`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `visit_measure` (`visit`,`measure`) USING BTREE,
  ADD KEY `type_sub_type` (`type`,`sub_type`) USING BTREE;

--
-- Indexes for table `visit_measures_archive`
--
ALTER TABLE `visit_measures_archive`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type_sub_type` (`type`,`sub_type`) USING BTREE,
  ADD KEY `visit_measure` (`visit`,`measure`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity`
--
ALTER TABLE `activity`
  MODIFY `id` bigint(40) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `allergies`
--
ALTER TABLE `allergies`
  MODIFY `id` bigint(40) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `caregivers`
--
ALTER TABLE `caregivers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `caregivers_meta`
--
ALTER TABLE `caregivers_meta`
  MODIFY `id` bigint(40) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `caregiver_schedules`
--
ALTER TABLE `caregiver_schedules`
  MODIFY `id` bigint(40) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `care_measures`
--
ALTER TABLE `care_measures`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `care_modules`
--
ALTER TABLE `care_modules`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `care_plans`
--
ALTER TABLE `care_plans`
  MODIFY `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(40) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contacts_meta`
--
ALTER TABLE `contacts_meta`
  MODIFY `id` bigint(40) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `infections`
--
ALTER TABLE `infections`
  MODIFY `id` bigint(40) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `medication`
--
ALTER TABLE `medication`
  MODIFY `id` bigint(40) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `id` bigint(40) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `options`
--
ALTER TABLE `options`
  MODIFY `id` bigint(40) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` bigint(40) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `patients_meta`
--
ALTER TABLE `patients_meta`
  MODIFY `id` bigint(40) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `patient_schedules`
--
ALTER TABLE `patient_schedules`
  MODIFY `id` bigint(40) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `patient_schedules_archive`
--
ALTER TABLE `patient_schedules_archive`
  MODIFY `id` bigint(40) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `risk_profiles`
--
ALTER TABLE `risk_profiles`
  MODIFY `id` bigint(40) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `risk_profile_meta`
--
ALTER TABLE `risk_profile_meta`
  MODIFY `id` bigint(40) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `risk_profile_meta_archive`
--
ALTER TABLE `risk_profile_meta_archive`
  MODIFY `id` bigint(40) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `time_log`
--
ALTER TABLE `time_log`
  MODIFY `id` bigint(40) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tours`
--
ALTER TABLE `tours`
  MODIFY `id` bigint(40) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transient`
--
ALTER TABLE `transient`
  MODIFY `id` bigint(40) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `visits`
--
ALTER TABLE `visits`
  MODIFY `id` bigint(40) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `visit_care`
--
ALTER TABLE `visit_care`
  MODIFY `id` bigint(40) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `visit_measures`
--
ALTER TABLE `visit_measures`
  MODIFY `id` bigint(40) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
