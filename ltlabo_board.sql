-- phpMyAdmin SQL Dump
-- version 4.6.0
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2017 年 11 月 16 日 18:41
-- サーバのバージョン： 5.7.17-log
-- PHP Version: 5.6.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ltlabo_board`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `datas`
--

CREATE TABLE `datas` (
  `mid` int(11) NOT NULL,
  `message` text NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `uid` int(11) NOT NULL,
  `number` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `datas`
--

INSERT INTO `datas` (`mid`, `message`, `created`, `uid`, `number`) VALUES
(4, 'takebe : たけべ', '2017-11-16 09:17:28', 0, '掲示板1'),
(5, 'takebe : あああ', '2017-11-16 09:19:45', 0, '掲示板1'),
(6, 'takebe : てすと', '2017-11-16 09:19:51', 0, '掲示板1'),
(7, 'takebe : ２', '2017-11-16 09:20:17', 0, '掲示板2'),
(9, 'takebe : ２だよ', '2017-11-16 09:21:06', 0, '掲示板2'),
(10, 'takebe : ２だよ', '2017-11-16 09:22:12', 0, '掲示板2'),
(11, 'takebe : ２だよ', '2017-11-16 09:22:41', 0, '掲示板2'),
(12, 'takebe : ２だよ', '2017-11-16 09:23:27', 0, '掲示板2'),
(13, 'takebe : ２だよ', '2017-11-16 09:24:02', 0, '掲示板2');

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `uid` int(11) NOT NULL,
  `userName` tinytext NOT NULL,
  `password` tinytext
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`uid`, `userName`, `password`) VALUES
(1, 'takebe', '$2y$10$fyVMa9l1erYSG8ig97pBzOvCwNazKuxzK1rmoZ7euu8dL0CJA8cMy');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `datas`
--
ALTER TABLE `datas`
  ADD PRIMARY KEY (`mid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `datas`
--
ALTER TABLE `datas`
  MODIFY `mid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
