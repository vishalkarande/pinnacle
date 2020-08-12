-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 11, 2020 at 06:20 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.2.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `publisher`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` enum('admin','superadmin') NOT NULL DEFAULT 'admin',
  `access_token` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='only for admin' ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `user_type`, `access_token`, `email`) VALUES
(1, 'admin', 'e6e061838856bf47e1de730719fb2609', 'admin', '', 'gthorat492k@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `author`
--

CREATE TABLE `author` (
  `id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `discription` varchar(500) NOT NULL,
  `is_deleted` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `author`
--

INSERT INTO `author` (`id`, `name`, `discription`, `is_deleted`) VALUES
(1, 'Dr. APJ Abdul Kalam', 'hghg', 0),
(2, 'Kyle Simpson', 'hg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(10) NOT NULL,
  `name` varchar(150) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `sub_cat_id` int(11) NOT NULL,
  `tag` varchar(100) NOT NULL,
  `author_id` int(10) NOT NULL,
  `edition` int(3) NOT NULL,
  `price` float NOT NULL,
  `discount` float NOT NULL,
  `quantity` int(5) NOT NULL,
  `discription` varchar(500) NOT NULL,
  `image_name` varchar(300) NOT NULL,
  `is_deleted` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `name`, `cat_id`, `sub_cat_id`, `tag`, `author_id`, `edition`, `price`, `discount`, `quantity`, `discription`, `image_name`, `is_deleted`) VALUES
(1, 'India 2020', 2, 0, '', 1, 0, 400, 4, 25, '&lt;p&gt;India 2020&lt;/p&gt;', '9920200807062046.jpg', 0),
(2, 'Up and Going Js', 1, 0, '', 2, 0, 500, 5, 50, '&lt;p&gt;kfklg&lt;/p&gt;', '2420200808075408.jpeg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `books_category`
--

CREATE TABLE `books_category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `is_deleted` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `books_category`
--

INSERT INTO `books_category` (`id`, `name`, `is_deleted`) VALUES
(1, 'Technical', 0),
(2, 'Nontechnical', 0);

-- --------------------------------------------------------

--
-- Table structure for table `books_sub_category`
--

CREATE TABLE `books_sub_category` (
  `id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image_name` varchar(255) NOT NULL,
  `discription` varchar(500) NOT NULL,
  `is_show` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `books_sub_category`
--

INSERT INTO `books_sub_category` (`id`, `cat_id`, `name`, `image_name`, `discription`, `is_show`) VALUES
(1, 1, 'PHP', 'dfg', '', 1),
(3, 2, 'Novel', '6620200810110329.jpg', '', 1),
(4, 1, 'JS', '4220200810111119.jpg', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `chapter`
--

CREATE TABLE `chapter` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `domain_id` int(11) NOT NULL,
  `a_id` int(10) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `discription` varchar(500) NOT NULL,
  `is_deleted` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `chapter`
--

INSERT INTO `chapter` (`id`, `name`, `domain_id`, `a_id`, `filename`, `discription`, `is_deleted`) VALUES
(1, 'GSM Chapter', 2, 0, '', '', 0),
(2, 'gh', 2, 2, 'fhfh', 'ghfg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `contact_enquiry`
--

CREATE TABLE `contact_enquiry` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `mobile_no` bigint(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `domain`
--

CREATE TABLE `domain` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `is_deleted` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `domain`
--

INSERT INTO `domain` (`id`, `name`, `is_deleted`) VALUES
(1, 'Mobile Computing', 0),
(2, 'Data Mining', 0),
(4, 'klk', 0),
(5, 'Applied Science', 0);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `event_date` date NOT NULL,
  `discription` varchar(500) NOT NULL,
  `is_deleted` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `name`, `event_date`, `discription`, `is_deleted`) VALUES
(1, 'event  one', '0000-00-00', 'fgfh', 0),
(7, 'event2', '2020-08-10', 'event2', 0),
(8, 'event 3', '2020-08-10', 'event3', 0);

-- --------------------------------------------------------

--
-- Table structure for table `journal`
--

CREATE TABLE `journal` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `type_id` int(11) NOT NULL,
  `domain_id` int(11) NOT NULL,
  `author_id` int(10) NOT NULL,
  `quantity` int(5) NOT NULL,
  `publish_date` date NOT NULL,
  `synopsis` varchar(500) NOT NULL,
  `image_name` varchar(200) DEFAULT NULL,
  `is_deleted` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `journal`
--

INSERT INTO `journal` (`id`, `name`, `type_id`, `domain_id`, `author_id`, `quantity`, `publish_date`, `synopsis`, `image_name`, `is_deleted`) VALUES
(1, 'International Journal on Computer Science and Engineering', 1, 1, 1, 12, '0000-00-00', '', 'ijcse-cover', 0),
(5, 'internsation journal of Appied Science', 2, 0, 2, 12, '2019-09-04', '&lt;p&gt;sdfdf&lt;/p&gt;', '3120200808020322.jpeg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `journal_type`
--

CREATE TABLE `journal_type` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `is_deleted` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `journal_type`
--

INSERT INTO `journal_type` (`id`, `name`, `is_deleted`) VALUES
(1, 'National', 0),
(2, 'International', 0);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `name` int(255) NOT NULL,
  `news` varchar(500) NOT NULL,
  `image` varchar(150) NOT NULL,
  `is_show` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `address_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` enum('in-process','pending','delivered','cancelled') NOT NULL DEFAULT 'in-process',
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `delivery_date` varchar(255) NOT NULL DEFAULT '0',
  `is_deleted` int(1) NOT NULL DEFAULT 0,
  `is_paid` int(1) NOT NULL DEFAULT 0,
  `delivery_charge` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `order_has_products`
--

CREATE TABLE `order_has_products` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `price` float NOT NULL,
  `discount` float NOT NULL DEFAULT 0,
  `order_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pageandcontents`
--

CREATE TABLE `pageandcontents` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `text` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pageandcontents`
--

INSERT INTO `pageandcontents` (`id`, `name`, `text`) VALUES
(1, 'About Us', '&lt;p&gt;gdfgrfgfjgnfgnfnfngfngf&lt;/p&gt;&lt;p&gt;&lt;b&gt;kjhjhjhjhjhjhjhjhjhjhjhjhjhjhjh&lt;/b&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;kjhjhjhjhjhjhjhjhjhjhjhjhjhjhjh&lt;/span&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;kjhjhjhjhjhjhjhjhjhjhjhjhjhjhjh&lt;/span&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;kjhjhjhjhjhjhjhjhjhjhjhjhjhjhjh&lt;/span&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;kjhjhjhjhjh&lt;/span&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;kjhjhjhjhjhjhjhjhjhjhjhjhjhjhjh&lt;/span&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;jhjhjhj&lt;/span&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;kjhjhjhjhjhjhjhjhjhjhjhjhjhjhjh&lt;/span&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;kjhjhjhjhjhjhjhjhjhjhjhjhjhjhjh&lt;/span&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;kjhjhjhjhjhjhjhjhjhjhjhjhjhjhjh&lt;/span&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;hjhjhjhjhjhjh&lt;/span&gt;&lt;/p&gt;'),
(2, 'Contact us', ''),
(3, 'Discount & Offers', ''),
(7, 'return policy', ''),
(5, 'privacy policy', ''),
(6, 'terms and condition', ''),
(8, 'Delivery Policy', '');

-- --------------------------------------------------------

--
-- Table structure for table `readers`
--

CREATE TABLE `readers` (
  `id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image_name` varchar(500) NOT NULL,
  `opinion` varchar(500) NOT NULL,
  `is_show` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `readers`
--

INSERT INTO `readers` (`id`, `name`, `image_name`, `opinion`, `is_show`) VALUES
(1, 'Gauri', '9720200810064055.jpg', 'This is very helpfull for research study', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile_no` bigint(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `pincode` int(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_verified` int(1) NOT NULL DEFAULT 0,
  `access_token` varchar(255) NOT NULL,
  `is_deleted` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `author`
--
ALTER TABLE `author`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk` (`author_id`),
  ADD KEY `cat_id` (`cat_id`);

--
-- Indexes for table `books_category`
--
ALTER TABLE `books_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `books_sub_category`
--
ALTER TABLE `books_sub_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cat_id` (`cat_id`);

--
-- Indexes for table `chapter`
--
ALTER TABLE `chapter`
  ADD KEY `author_id` (`a_id`),
  ADD KEY `domain_id` (`domain_id`);

--
-- Indexes for table `contact_enquiry`
--
ALTER TABLE `contact_enquiry`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `domain`
--
ALTER TABLE `domain`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `journal`
--
ALTER TABLE `journal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type_id` (`type_id`),
  ADD KEY `domain_id` (`domain_id`);

--
-- Indexes for table `journal_type`
--
ALTER TABLE `journal_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_has_products`
--
ALTER TABLE `order_has_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pageandcontents`
--
ALTER TABLE `pageandcontents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `readers`
--
ALTER TABLE `readers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `author`
--
ALTER TABLE `author`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `books_category`
--
ALTER TABLE `books_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `books_sub_category`
--
ALTER TABLE `books_sub_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `contact_enquiry`
--
ALTER TABLE `contact_enquiry`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `domain`
--
ALTER TABLE `domain`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `journal`
--
ALTER TABLE `journal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `journal_type`
--
ALTER TABLE `journal_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_has_products`
--
ALTER TABLE `order_has_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pageandcontents`
--
ALTER TABLE `pageandcontents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `readers`
--
ALTER TABLE `readers`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
