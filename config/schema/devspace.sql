-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 19, 2015 at 04:26 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `devspace`
--

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE IF NOT EXISTS `articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `title`, `description`, `created`, `modified`) VALUES
(1, 'CakePHP 3.1 Released', 'The CakePHP core team is happy to announce the immediate availability of CakePHP 3.1.0. This release is an API stable release for 3.1. 3.1 delivers a number of improvements to the 3.x release series.', '2015-11-17 19:21:37', '2015-11-17 19:21:37'),
(2, 'Windows 10 reaches 100 million installs', 'Want to install Windows 10 on your own PC? We’ve got you covered with the instructions, although it’s just like installing any other version of Windows.', '2015-11-17 19:27:12', '2015-11-17 19:27:12'),
(3, 'Amazon releases mobile vs desktop visitor counts', 'Amazon''s shares of visits from mobile and desktop are almost equal, with desktop responsible for 51 percent of all visits. September even saw more visits from mobile devices, with mobile traffic increasing by 8 percent, surpassing desktop traffic by 6 percent', '2015-11-17 19:29:10', '2015-11-17 19:35:00');

-- --------------------------------------------------------

--
-- Table structure for table `bookmarks`
--

CREATE TABLE IF NOT EXISTS `bookmarks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `description` text,
  `url` text,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_key` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `bookmarks`
--

INSERT INTO `bookmarks` (`id`, `user_id`, `title`, `description`, `url`, `created`, `modified`) VALUES
(1, 1, 'CakePHP 3.x Documentation', 'CakePHP 3.x Documentation', 'http://book.cakephp.org/3.0/en/index.html', '2015-11-17 16:12:29', '2015-11-17 16:12:29'),
(2, 1, 'Google', 'Google search', 'google.com', '2015-11-17 16:14:43', '2015-11-17 16:14:43');

-- --------------------------------------------------------

--
-- Table structure for table `bookmarks_tags`
--

CREATE TABLE IF NOT EXISTS `bookmarks_tags` (
  `bookmark_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  PRIMARY KEY (`bookmark_id`,`tag_id`),
  KEY `tag_key` (`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bookmarks_tags`
--

INSERT INTO `bookmarks_tags` (`bookmark_id`, `tag_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE IF NOT EXISTS `contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `message` text,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `message`, `created`, `modified`) VALUES
(3, 'scott', 'scott@devspace.co', 'Hey, I need some stuff done.\r\n\r\nplease contact me!!', '2015-11-17 16:22:48', '2015-11-17 16:22:48'),
(4, '', '', '', '2015-11-18 20:24:38', '2015-11-18 20:24:38');

-- --------------------------------------------------------

--
-- Table structure for table `knowledgebase`
--

CREATE TABLE IF NOT EXISTS `knowledgebase` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_key` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `knowledgebase`
--

INSERT INTO `knowledgebase` (`id`, `user_id`, `title`, `description`, `created`, `modified`) VALUES
(4, 1, 'How to get query string parameters in PHP?', '$parts = parse_url($url);\r\nparse_str($parts[''query''], $query);\r\necho $query[''email''];', '2015-11-17 22:56:06', '2015-11-17 22:56:06'),
(5, 1, 'How to convert RBG to Hex?', 'http://www.rgbtohex.net/', '2015-11-17 22:58:11', '2015-11-17 22:58:11'),
(6, 1, 'What is MEAN?', 'MEAN is a free and open-source JavaScript software stack for building dynamic web sites and web applications.\r\n\r\nMEAN is a combination of MongoDB, Express.js and Angular.js, all of which run upon Node.js.\r\n\r\nThe components of the MEAN stack are:\r\n* MongoDB, a NoSQL database;\r\n* Express.js, a web applications framework;\r\n* Angular.js, a JavaScript MVC framework for web apps;\r\n* Node.js, a software platform for scalable server-side and networking applications.', '2015-11-19 03:57:06', '2015-11-19 04:01:50'),
(7, 1, 'What is AngularJS?', 'AngularJS (commonly referred to as "Angular" or "Angular.js") is an open-source web application framework mainly maintained by Google and by a community of individual developers and corporations to address many of the challenges encountered in developing single-page applications. It aims to simplify both the development and the testing of such applications by providing a framework for client-side model–view–controller (MVC) and model–view–viewmodel (MVVM) architectures, along with components commonly used in rich Internet applications.\r\n\r\nThe AngularJS library works by first reading the HTML page, which has embedded into it additional custom tag attributes. Angular interprets those attributes as directives to bind input or output parts of the page to a model that is represented by standard JavaScript variables. The values of those JavaScript variables can be manually set within the code, or retrieved from static or dynamic JSON resources.', '2015-11-19 03:58:07', '2015-11-19 03:58:07'),
(8, 1, 'What is MVVM?', 'Model View ViewModel (MVVM) is an architectural pattern for software development.  MVVM abstracts a view''s state and behavior.  \r\n\r\nMVVM and Presentation Model both derive from the model–view–controller pattern (MVC). MVVM facilitates a separation of the development of the graphical user interface (either as markup language or GUI code) from the development of the business logic or back-end logic (the data model). The view model of MVVM is a value converter; this means that the view model is responsible for exposing (converting) the data objects from the model in such a way that the objects are easily managed and consumed. In this respect, the view model is more model than view, and handles most if not all of the view’s display logic. The view model may also implement a mediator pattern, organising access to the backend logic around the set of use cases supported by the view.', '2015-11-19 04:00:38', '2015-11-19 04:00:38');

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `title`, `created`, `modified`) VALUES
(1, 'CakePHP', '2015-11-17 16:12:45', '2015-11-17 16:12:45');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `created`, `modified`) VALUES
(1, 'scott@devspace.co', '$2y$10$dergYy0fVAn8DYWs6a.fq.45lgpa4yBTC7HnxMa9sPlGc0RukPW32', '2015-11-17 16:11:22', '2015-11-17 16:11:22');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookmarks`
--
ALTER TABLE `bookmarks`
  ADD CONSTRAINT `bookmarks_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `bookmarks_tags`
--
ALTER TABLE `bookmarks_tags`
  ADD CONSTRAINT `bookmarks_tags_ibfk_1` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`),
  ADD CONSTRAINT `bookmarks_tags_ibfk_2` FOREIGN KEY (`bookmark_id`) REFERENCES `bookmarks` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
