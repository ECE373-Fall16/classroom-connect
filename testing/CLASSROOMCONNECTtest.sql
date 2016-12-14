SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";
CREATE DATABASE IF NOT EXISTS CLASSROOMCONNECT DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE CLASSROOMCONNECT;

CREATE TABLE CLASSES (
  class_id int(10) UNSIGNED NOT NULL,
  time_created timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  class_name varchar(60) NOT NULL,
  user_id int(11) NOT NULL,
  poll_id int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
INSERT INTO CLASSES (class_id, time_created, class_name, user_id, poll_id) VALUES
(1, '2016-12-07 00:55:22', 'Software Intensive Engineering', 0, 373),
(2, '2016-12-07 01:41:48', 'idea', 0, 16),
(3, '2016-12-07 01:42:53', 'hi', 0, 334),
(4, '2016-12-07 01:53:38', 'hi', 0, 378);
CREATE TABLE MARKERS (
  id int(10) UNSIGNED NOT NULL,
  time_created timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  marker_id int(11) NOT NULL,
  comments varchar(1000) NOT NULL,
  email varchar(100) NOT NULL,
  class_id int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
INSERT INTO MARKERS (id, time_created, marker_id, comments, email, class_id) VALUES
(1, '2016-12-07 01:05:49', 10, '', 'anthony.me.chan@gmail.com', 373),
(97, '2016-12-07 05:20:03', 5, '', 'mooshutofu@gmail.com', 373),
(133, '2016-12-07 01:08:16', 5, '', 'jkcao@umass.edu', 373);
CREATE TABLE POLL (
  id int(10) UNSIGNED NOT NULL,
  marker_id int(10) UNSIGNED NOT NULL,
  email varchar(100) NOT NULL,
  class_id int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
INSERT INTO POLL (id, marker_id, email, class_id) VALUES
(1, 0, 'anthony.me.chan@gmail.com', 373),
(9, 2, 'mooshutofu@gmail.com', 373),
(17, 0, 'jkcao@umass.edu', 373);
CREATE TABLE USERS (
  user_id int(10) UNSIGNED NOT NULL,
  first_name varchar(30) NOT NULL,
  last_name varchar(30) NOT NULL,
  email varchar(60) NOT NULL,
  user_password varchar(30) NOT NULL,
  poll_id int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
INSERT INTO USERS (user_id, first_name, last_name, email, user_password, poll_id) VALUES
(1, '', '', 'anthony.me.chan@gmail.com', '', 373),
(3, '', '', 'mooshutofu@gmail.com', '', 373),
(4, '', '', 'jkcao@umass.edu', '', 373);

ALTER TABLE CLASSES
  ADD PRIMARY KEY (class_id);

ALTER TABLE MARKERS
  ADD PRIMARY KEY (id),
  ADD UNIQUE KEY email (email);

ALTER TABLE POLL
  ADD PRIMARY KEY (id),
  ADD UNIQUE KEY email (email);

ALTER TABLE USERS
  ADD PRIMARY KEY (user_id),
  ADD UNIQUE KEY email (email);


ALTER TABLE CLASSES
  MODIFY class_id int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE MARKERS
  MODIFY id int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE POLL
  MODIFY id int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE USERS
  MODIFY user_id int(10) UNSIGNED NOT NULL AUTO_INCREMENT;