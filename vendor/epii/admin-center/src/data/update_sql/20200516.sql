-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 172.16.0.6
-- Generation Time: 2020-05-16 05:01:29
-- 服务器版本： 5.6.19-log
-- PHP Version: 7.1.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `epii1`
--

-- --------------------------------------------------------

--
-- 表的结构 `epii_addons`
--

CREATE TABLE `epii_addons` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL COMMENT '唯一名称',
  `title` varchar(30) NOT NULL COMMENT '名称',
  `addtime` int(11) NOT NULL COMMENT '添加时间',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '开关',
  `version` varchar(10) NOT NULL DEFAULT '1.0.0',
  `subject` varchar(100) DEFAULT NULL COMMENT '描述',
  `menu_ids` varchar(100) DEFAULT NULL COMMENT '菜单IDs',
  `install` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `epii_addons`
--
ALTER TABLE `epii_addons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `status` (`status`),
  ADD KEY `install` (`install`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `epii_addons`
--
ALTER TABLE `epii_addons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;
COMMIT;
