-- --------------------------------------------------------

--
-- Database: `historique`
--

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `eid` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `permalink` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `uid` int(11) NOT NULL,
  `validated` tinyint(1) NOT NULL,
  `published` tinyint(1) NOT NULL,
  `deleted` tinyint(1) NOT NULL,
  `dateadded` datetime NOT NULL,
  PRIMARY KEY (`eid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `events_sources`
--

CREATE TABLE IF NOT EXISTS `events_sources` (
  `esid` int(11) NOT NULL AUTO_INCREMENT,
  `eid` int(11) NOT NULL,
  `url` varchar(1024) NOT NULL,
  `data` text NOT NULL,
  `uid` int(11) NOT NULL,
  `verified` tinyint(1) NOT NULL,
  `published` tinyint(1) NOT NULL,
  `deleted` tinyint(1) NOT NULL,
  `dateadded` datetime NOT NULL,
  PRIMARY KEY (`esid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `events_tags`
--

CREATE TABLE IF NOT EXISTS `events_tags` (
  `etid` int(11) NOT NULL AUTO_INCREMENT,
  `eid` int(11) NOT NULL,
  `tid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `verified` tinyint(1) NOT NULL,
  `published` tinyint(1) NOT NULL,
  `dateadded` datetime NOT NULL,
  PRIMARY KEY (`etid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `folders`
--

CREATE TABLE IF NOT EXISTS `folders` (
  `fid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `uid` int(11) NOT NULL,
  `verified` tinyint(1) NOT NULL,
  `published` tinyint(1) NOT NULL,
  `deleted` tinyint(1) NOT NULL,
  `dateadded` datetime NOT NULL,
  PRIMARY KEY (`fid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `folders_events`
--

CREATE TABLE IF NOT EXISTS `folders_events` (
  `feid` int(11) NOT NULL AUTO_INCREMENT,
  `fid` int(11) NOT NULL,
  `eid` int(11) NOT NULL,
  `dateadded` datetime NOT NULL,
  PRIMARY KEY (`feid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `clean` varchar(255) NOT NULL,
  `label` varchar(255) NOT NULL,
  `uid` int(11) NOT NULL,
  `verified` tinyint(1) NOT NULL,
  `published` tinyint(1) NOT NULL,
  `deleted` tinyint(1) NOT NULL,
  `dateadded` datetime NOT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `pwd` varchar(255) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `occupation` varchar(50) NOT NULL,
  `exportKey` varchar(1024) NOT NULL,
  `published` tinyint(1) NOT NULL,
  `deleted` tinyint(1) NOT NULL,
  `dateadded` datetime NOT NULL,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `email` (`email`),
  KEY `exportKey` (`exportKey`(255))
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users_logins`
--

CREATE TABLE IF NOT EXISTS `users_logins` (
  `ulid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `useragent` varchar(255) NOT NULL,
  `dateadded` datetime NOT NULL,
  PRIMARY KEY (`ulid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
