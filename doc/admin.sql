-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- 主机: 192.168.2.27:3306
-- 生成日期: 2015 年 04 月 20 日 10:10
-- 服务器版本: 5.6.22
-- PHP 版本: 5.3.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `admin`
--

-- --------------------------------------------------------

--
-- 表的结构 `permission`
--

CREATE TABLE IF NOT EXISTS `permission` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(16) NOT NULL DEFAULT '' COMMENT '菜单，类名，方法名',
  `code` varchar(16) NOT NULL DEFAULT '' COMMENT '类，方法',
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父级，菜单级别为0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='权限节点表' AUTO_INCREMENT=31 ;

--
-- 转存表中的数据 `permission`
--

INSERT INTO `permission` (`id`, `name`, `code`, `pid`) VALUES
(1, '管理', 'Admin', 0),
(3, '角色组', 'Role', 1),
(8, '权限', 'Permission', 1),
(9, '列表', 'index', 8),
(10, '增加', 'add', 8),
(11, '编辑', 'edit', 8),
(12, '删除', 'del', 8),
(13, '订单模块', 'Order', 0),
(18, '列表', 'index', 3),
(19, '增加角色组', 'add', 3),
(20, '编辑角色组', 'edit', 3),
(21, '删除角色组', 'del', 3),
(22, '用户', 'User', 1),
(23, '列表', 'index', 22),
(24, '添加用户', 'add', 22),
(25, '编辑用户', 'edit', 22),
(26, '删除用户', 'del', 22),
(27, '账号授权', 'roleUser', 3),
(29, '权限授权', 'rolePermission', 3),
(30, '修改密码', 'setpwd', 22);

-- --------------------------------------------------------

--
-- 表的结构 `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '角色组',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '0正常，1锁定',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='角色表' AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `role`
--

INSERT INTO `role` (`id`, `name`, `status`) VALUES
(1, '产品组', 0);

-- --------------------------------------------------------

--
-- 表的结构 `role_permission`
--

CREATE TABLE IF NOT EXISTS `role_permission` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `roleId` int(11) unsigned NOT NULL DEFAULT '0',
  `permissionId` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='角色-权限表' AUTO_INCREMENT=21 ;

--
-- 转存表中的数据 `role_permission`
--

INSERT INTO `role_permission` (`id`, `roleId`, `permissionId`) VALUES
(13, 1, 1),
(14, 1, 3),
(15, 1, 18),
(16, 1, 19),
(17, 1, 20),
(18, 1, 21),
(19, 1, 27),
(20, 1, 8);

-- --------------------------------------------------------

--
-- 表的结构 `role_user`
--

CREATE TABLE IF NOT EXISTS `role_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(11) unsigned NOT NULL DEFAULT '0',
  `roleId` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='角色-用户表' AUTO_INCREMENT=42 ;

--
-- 转存表中的数据 `role_user`
--

INSERT INTO `role_user` (`id`, `userId`, `roleId`) VALUES
(38, 3, 1),
(39, 5, 1),
(40, 9, 1),
(41, 10, 1);

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `account` varchar(16) NOT NULL DEFAULT '' COMMENT '账号',
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '显示名称',
  `password` varchar(32) NOT NULL DEFAULT '' COMMENT '密码',
  `createTime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `lastLoginTime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '上次登录时间',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '0正常，1锁定',
  `isadmin` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '0正常，1超级管理员',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='用户表' AUTO_INCREMENT=21 ;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `account`, `name`, `password`, `createTime`, `lastLoginTime`, `status`, `isadmin`) VALUES
(1, 'admin', 'admin', 'admin', 0, 1429513817, 0, 1),
(3, 'aaa', 'aaa', '123111', 1429174340, 1429500181, 0, 0),
(5, 'bbb', 'bbb', '123123', 1429177887, 1429177887, 0, 0),
(9, 'adf', 'asdf', '123213', 1429261156, 1429261156, 0, 0),
(10, 'adfdas', '12313', '1231', 1429261161, 1429261161, 0, 0),
(11, 'bbbb', '123', '123', 1429261165, 1429500099, 0, 0),
(12, 'asdf', 'adsf', 'adsf', 1429261173, 1429261173, 0, 0),
(13, 'asdfas', 'sdafa', 'adfas', 1429261181, 1429261181, 0, 0),
(16, 'dsafdasf', 'aad', 'adfas', 1429509264, 1429509264, 0, 0),
(17, 'adfasf', 'sdfa', 'dsafasfa', 1429509269, 1429509269, 0, 0),
(18, 'adsfasfdas', 'adfas', 'dafaf', 1429509274, 1429509274, 0, 0),
(19, 'adsfa', 'dasfas', 'adsfasf', 1429509280, 1429509280, 0, 0),
(20, 'dasfas', 'dasfasf', 'asdfa', 1429509300, 1429509300, 0, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
