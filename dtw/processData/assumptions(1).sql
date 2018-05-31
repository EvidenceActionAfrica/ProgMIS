-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 20, 2014 at 09:50 AM
-- Server version: 5.5.25a
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `evidence_action`
--

-- --------------------------------------------------------

--
-- Table structure for table `assumptions`
--

CREATE TABLE IF NOT EXISTS `assumptions` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `aChildrenTreatedPerAdult` varchar(50) NOT NULL,
  `pChildrenTreatedPerAdult` varchar(50) NOT NULL,
  `aNonEnrolledPerSchool` varchar(50) NOT NULL,
  `pNonEnrolledPerSchool` varchar(50) NOT NULL,
  `aUnderFivesTreated` varchar(50) NOT NULL,
  `pUnderFivesTreated` varchar(50) NOT NULL,
  `aPopulationGrowthAnnual` varchar(50) NOT NULL,
  `pPopulationGrowthAnnual` varchar(50) NOT NULL,
  `aSpoilage` varchar(50) NOT NULL,
  `pSpoilage` varchar(50) NOT NULL,
  `aTinSize` varchar(50) NOT NULL,
  `pTinSize` varchar(50) NOT NULL,
  `aAverageChildDose` varchar(50) NOT NULL,
  `pAverageChildDose` varchar(50) NOT NULL,
  `aAdultDose` varchar(50) NOT NULL,
  `pAdultDose` varchar(50) NOT NULL,
  `aMaxDrugShortagePermittedKids` varchar(50) NOT NULL,
  `pMaxDrugShortagePermittedKids` varchar(50) NOT NULL,
  `aExtraSchoolsPerDistrict` varchar(50) NOT NULL,
  `pExtraSchoolsPerDistrict` varchar(50) NOT NULL,
  `aAssumedSchoolSize` varchar(50) NOT NULL,
  `pAssumedSchoolSize` varchar(50) NOT NULL,
  `aMaxDrugShortagePermittedDrugs` varchar(50) NOT NULL,
  `pMaxDrugShortagePermittedDrugs` varchar(50) NOT NULL,
  `aAverageDrugNeed` varchar(50) NOT NULL,
  `pAverageDrugNeed` varchar(50) NOT NULL,
  `aAverageTinsNeededPerSchools` varchar(50) NOT NULL,
  `pAverageTinsNeededPerSchools` varchar(50) NOT NULL,
  `aCalcDrugsPerSchool` varchar(50) NOT NULL,
  `pCalcDrugsPerSchool` varchar(50) NOT NULL,
  `aTreatYear` varchar(50) NOT NULL,
  `pTreatYear` varchar(50) NOT NULL,
  `areaAssumptions` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
