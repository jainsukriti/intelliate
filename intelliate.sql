SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Table structure for table `tbl_connections`
--

CREATE TABLE `tbl_connections` (
  `connection_id` int(11) NOT NULL,
  `uid` int(20) NOT NULL,
  `friend_id` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_connections`
--

INSERT INTO `tbl_connections` (`connection_id`, `uid`, `friend_id`) VALUES
(8, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_groups`
--

CREATE TABLE `tbl_groups` (
  `group_id` int(11) NOT NULL,
  `group_name` varchar(150) NOT NULL,
  `group_category` varchar(150) NOT NULL,
  `creator` int(11) NOT NULL,
  `vanity` varchar(150) NOT NULL,
  `creation_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_groups`
--

INSERT INTO `tbl_groups` (`group_id`, `group_name`, `group_category`, `creator`, `vanity`, `creation_time`) VALUES
(1, 'Secret War', 'Secret Mission', 1, 'secret', '2017-03-28 05:43:35'),
(2, 'Dummy', 'Dummy Mission', 1, 'dummy', '2017-03-28 05:50:41'),
(3, 'local', 'Local Mission', 3, 'local', '2017-03-28 05:55:46');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_group_members`
--

CREATE TABLE `tbl_group_members` (
  `join_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `actor_id` int(11) NOT NULL,
  `join_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_group_members`
--

INSERT INTO `tbl_group_members` (`join_id`, `group_id`, `actor_id`, `join_time`) VALUES
(2, 1, 2, '2017-04-21 17:33:52'),
(4, 2, 2, '2017-04-21 18:23:04');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_messages`
--

CREATE TABLE `tbl_messages` (
  `msg_id` int(11) NOT NULL,
  `sender` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `msg_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_messages`
--

INSERT INTO `tbl_messages` (`msg_id`, `sender`, `group_id`, `message`, `msg_time`) VALUES
(1, 2, 1, 'hello.', '2017-04-21 17:53:54');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `uid` int(11) NOT NULL,
  `full_name` varchar(60) NOT NULL,
  `username` varchar(10) NOT NULL,
  `user_gender` varchar(10) NOT NULL DEFAULT 'Male',
  `user_birthday` date NOT NULL,
  `is_admin` int(1) NOT NULL DEFAULT '0',
  `phone` varchar(25) NOT NULL DEFAULT 'N/A',
  `user_email` varchar(60) NOT NULL DEFAULT 'N/A',
  `user_lat` varchar(100) NOT NULL,
  `user_lng` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `avatar` varchar(40) NOT NULL DEFAULT 'avatar.png',
  `online_status` tinyint(1) NOT NULL DEFAULT '0',
  `creation_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for table `tbl_connections`
--
ALTER TABLE `tbl_connections`
  ADD PRIMARY KEY (`connection_id`),
  ADD UNIQUE KEY `user_id` (`uid`,`friend_id`),
  ADD KEY `uid` (`uid`),
  ADD KEY `friend_id` (`friend_id`);

--
-- Indexes for table `tbl_groups`
--
ALTER TABLE `tbl_groups`
  ADD PRIMARY KEY (`group_id`),
  ADD UNIQUE KEY `vanity` (`vanity`),
  ADD KEY `creator` (`creator`);

--
-- Indexes for table `tbl_group_members`
--
ALTER TABLE `tbl_group_members`
  ADD PRIMARY KEY (`join_id`),
  ADD UNIQUE KEY `unique_members` (`group_id`,`actor_id`),
  ADD KEY `actor_id` (`actor_id`),
  ADD KEY `group_id` (`group_id`),
  ADD KEY `group_id_2` (`group_id`),
  ADD KEY `group_id_3` (`group_id`);

--
-- Indexes for table `tbl_messages`
--
ALTER TABLE `tbl_messages`
  ADD PRIMARY KEY (`msg_id`),
  ADD KEY `group_id` (`group_id`),
  ADD KEY `group_id_2` (`group_id`),
  ADD KEY `sender` (`sender`),
  ADD KEY `sender_2` (`sender`),
  ADD KEY `group_id_3` (`group_id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`uid`),
  ADD KEY `uid` (`uid`),
  ADD KEY `uid_2` (`uid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_connections`
--
ALTER TABLE `tbl_connections`
  MODIFY `connection_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `tbl_groups`
--
ALTER TABLE `tbl_groups`
  MODIFY `group_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tbl_group_members`
--
ALTER TABLE `tbl_group_members`
  MODIFY `join_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `tbl_messages`
--
ALTER TABLE `tbl_messages`
  MODIFY `msg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_groups`
--
ALTER TABLE `tbl_groups`
  ADD CONSTRAINT `tbl_groups_ibfk_1` FOREIGN KEY (`creator`) REFERENCES `tbl_users` (`uid`);

--
-- Constraints for table `tbl_group_members`
--
ALTER TABLE `tbl_group_members`
  ADD CONSTRAINT `tbl_group_members_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `tbl_groups` (`group_id`),
  ADD CONSTRAINT `tbl_group_members_ibfk_2` FOREIGN KEY (`actor_id`) REFERENCES `tbl_users` (`uid`);

--
-- Constraints for table `tbl_messages`
--
ALTER TABLE `tbl_messages`
  ADD CONSTRAINT `tbl_messages_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `tbl_groups` (`group_id`),
  ADD CONSTRAINT `tbl_messages_ibfk_2` FOREIGN KEY (`sender`) REFERENCES `tbl_group_members` (`actor_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
