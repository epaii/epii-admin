-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 172.16.0.6
-- Generation Time: 2019-01-23 09:41:00
-- 服务器版本： 5.6.19-log
-- PHP Version: 7.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `epii`
--

-- --------------------------------------------------------

--
-- 表的结构 `epii_admin`
--

CREATE TABLE `epii_admin` (
  `id` int(10) UNSIGNED NOT NULL COMMENT 'ID',
  `username` varchar(20) NOT NULL DEFAULT '' COMMENT '用户名',
  `password` varchar(32) NOT NULL DEFAULT '' COMMENT '密码',
  `addtime` int(11) NOT NULL COMMENT '创建时间',
  `updatetime` int(11) NOT NULL COMMENT '更新时间',
  `phone` varchar(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL COMMENT '用户邮箱',
  `photo` varchar(255) DEFAULT NULL COMMENT '用户头像',
  `status` varchar(30) NOT NULL DEFAULT 'normal' COMMENT '状态',
  `group_name` varchar(80) NOT NULL,
  `role` smallint(6) DEFAULT NULL COMMENT '管理员角色'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='管理员表' ROW_FORMAT=COMPACT;

--
-- 转存表中的数据 `epii_admin`
--

INSERT INTO `epii_admin` (`id`, `username`, `password`, `addtime`, `updatetime`, `phone`, `email`, `photo`, `status`, `group_name`, `role`) VALUES
(1, 'admin', 'dd4b21e9ef71e1291183a46b913ae6f2', 1546926683, 1547449710, '3333355881', '3', '', 'normal', '超级管理员', 1),
(14, 'yunwei', 'dd4b21e9ef71e1291183a46b913ae6f2', 1547196609, 1547202406, NULL, NULL, NULL, 'normal', 'yunwei', 9),
(15, 'jishu', 'dd4b21e9ef71e1291183a46b913ae6f2', 1547260829, 1547449715, NULL, NULL, NULL, 'normal', '123456', 1);

-- --------------------------------------------------------

--
-- 表的结构 `epii_node`
--

CREATE TABLE `epii_node` (
  `id` smallint(6) UNSIGNED NOT NULL,
  `name` varchar(50) DEFAULT NULL COMMENT '节点名称',
  `url` varchar(255) DEFAULT NULL COMMENT 'url',
  `status` tinyint(1) DEFAULT '0' COMMENT '状态0未开启,1开启',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  `sort` smallint(6) UNSIGNED DEFAULT '255' COMMENT '排序',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '父级节点ID',
  `icon` varchar(50) NOT NULL COMMENT '图标',
  `badge` varchar(20) DEFAULT NULL COMMENT '小标',
  `is_open` varchar(10) DEFAULT NULL COMMENT '是否默认打开',
  `open_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1新窗口打开 0 addtab'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='节点表';

--
-- 转存表中的数据 `epii_node`
--

INSERT INTO `epii_node` (`id`, `name`, `url`, `status`, `remark`, `sort`, `pid`, `icon`, `badge`, `is_open`, `open_type`) VALUES
(3, '系统中心', '', 1, '权限管理', 2, 0, 'fa fa fa-cog', NULL, NULL, 0),
(4, '管理员列表', '?app=admin@index&_vendor=1', 1, '管理员列表', 1, 3, 'fa fa-users', NULL, NULL, 0),
(5, '导航管理', '?app=nodelist@index&_vendor=1', 1, '', 2, 3, 'fa fa-bars', NULL, NULL, 0),
(6, '角色管理', '?app=rolelist@index&_vendor=1', 1, '111', 8, 3, 'fa fa-address-card', NULL, '1', 0),
(13, '个人中心', '', 1, '', 10, 0, 'fa fa-user', NULL, '', 0),
(14, '修改资料', '?app=user@modify&_vendor=1', 1, '', 3, 13, 'fa fa-pencil', NULL, '', 0),
(16, '应用设置', '?app=config@index&_vendor=1', 1, '', 20, 3, 'fa fa-cogs', NULL, '', 0),
(17, '后台首页', '?app=root@home', 1, '请修改为您的连接地址', 1, 0, 'fa fa-dashboard', NULL, NULL, 0),
(18, '教程', 'http://docs.epii-admin.epii.cn/704402', 1, '', 100, 0, 'fa fa-circle-o text-danger', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- 表的结构 `epii_role`
--

CREATE TABLE `epii_role` (
  `id` smallint(6) UNSIGNED NOT NULL,
  `name` varchar(30) DEFAULT NULL COMMENT '角色名称',
  `status` tinyint(1) UNSIGNED DEFAULT NULL COMMENT '状态0未启用1启用',
  `powers` text,
  `nodes` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `epii_role`
--

INSERT INTO `epii_role` (`id`, `name`, `status`, `powers`, `nodes`) VALUES
(1, '总管理员', 1, '{\"type\":\"2\",\"power\":{\"epii\\\\admin\\\\center\\\\app\\\\admin\":[\"ajaxdata\",\"add\"],\"epii\\\\admin\\\\center\\\\app\\\\nodelist\":[\"add\",\"edit\"],\"epii\\\\admin\\\\center\\\\app\\\\rolelist\":[\"index\",\"ajaxdata\"],\"epii\\\\admin\\\\center\\\\app\\\\test\":[\"index\"],\"epii\\\\admin\\\\center\\\\app\\\\user\":[\"logout\",\"modify\"]}}', NULL),
(9, '运维人员', 1, '{\"type\":\"1\",\"power\":{\"epii\\\\admin\\\\center\\\\app\\\\root\":[\"home\"],\"epii\\\\admin\\\\center\\\\app\\\\user\":[\"logout\",\"modify\",\"modify_info\"]}}', '[\"5\",\"4\",\"17\",0,3,3]'),
(10, '技术人员', 1, '{\"type\":\"1\",\"power\":{\"epii\\\\admin\\\\center\\\\app\\\\nodelist\":[\"index\",\"ajaxdata\",\"add\"],\"epii\\\\admin\\\\center\\\\app\\\\rolelist\":[\"index\",\"ajaxdata\",\"add\",\"power\",\"nav\"]}}', '[\"6\",\"14\",\"17\",0,3,13]');

-- --------------------------------------------------------

--
-- 表的结构 `epii_setting`
--

CREATE TABLE `epii_setting` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `value` varchar(1000) NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '2' COMMENT '1系统类型0用户类型',
  `addtime` int(11) NOT NULL,
  `tip` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `epii_setting`
--

INSERT INTO `epii_setting` (`id`, `name`, `value`, `type`, `addtime`, `tip`) VALUES
(5, 'app.style.nav_theme', 'gray-light', 1, 1, '头部样式light primary warning info  danger success gray-light'),
(6, 'app.style.left_bg_theme', 'dark', 1, 1, '左侧背景dark or light'),
(7, 'app.style.left_top_theme', 'clear', 1, 1, '左侧头部背景 clear primary warning info  danger success'),
(8, 'app.style.left_selected_theme', 'primary', 1, 1547189470, '左侧选中时背景primary warning info  danger    success'),
(9, 'app.logo', 'https://epii.gitee.io/epiiadmin-js/img/AdminLTELogo.png', 1, 1547191738, '左上角logo图标'),
(10, 'app.login.bgimgs', 'http://epii.gitee.io/static/imgs/login_imgs/login4.jpg', 1, 1547191738, '左上角logo图标'),
(11, 'app.title', '我的管理中心', 1, 1547191854, '左侧上部titledd');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `epii_admin`
--
ALTER TABLE `epii_admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`) USING BTREE,
  ADD KEY `role` (`role`);

--
-- Indexes for table `epii_node`
--
ALTER TABLE `epii_node`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pid` (`pid`),
  ADD KEY `status` (`status`),
  ADD KEY `pid_2` (`pid`),
  ADD KEY `open_type` (`open_type`);

--
-- Indexes for table `epii_role`
--
ALTER TABLE `epii_role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `epii_setting`
--
ALTER TABLE `epii_setting`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `addtime` (`addtime`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `epii_admin`
--
ALTER TABLE `epii_admin`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=16;

--
-- 使用表AUTO_INCREMENT `epii_node`
--
ALTER TABLE `epii_node`
  MODIFY `id` smallint(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- 使用表AUTO_INCREMENT `epii_role`
--
ALTER TABLE `epii_role`
  MODIFY `id` smallint(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- 使用表AUTO_INCREMENT `epii_setting`
--
ALTER TABLE `epii_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

ALTER TABLE `epii_setting` ADD `uid` INT NOT NULL DEFAULT '0' AFTER `tip`, ADD INDEX (`uid`);
ALTER TABLE `epii_setting` DROP INDEX `name`, ADD UNIQUE `name` (`name`, `uid`) USING BTREE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;



