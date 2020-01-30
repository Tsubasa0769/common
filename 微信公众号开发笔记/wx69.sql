-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 2018-12-15 18:27:31
-- 服务器版本： 5.7.18
-- PHP Version: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wx69`
--

-- --------------------------------------------------------

--
-- 表的结构 `material`
--

CREATE TABLE `material` (
  `id` int(10) UNSIGNED NOT NULL,
  `realpath` varchar(255) NOT NULL DEFAULT '' COMMENT '上传成功的地址',
  `ctime` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
  `is_forever` tinyint(3) UNSIGNED NOT NULL DEFAULT '0' COMMENT '0临时 1永久',
  `media_id` varchar(255) NOT NULL DEFAULT '' COMMENT '媒体ID',
  `type` enum('image','voice') NOT NULL DEFAULT 'image' COMMENT '素材类型'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='素材管理表';

--
-- 转存表中的数据 `material`
--

INSERT INTO `material` (`id`, `realpath`, `ctime`, `is_forever`, `media_id`, `type`) VALUES
(5, 'F:\\www\\class\\web69\\wx.com/up/1544690636.jpg', 1544690638, 0, 'aL_s97N3iRc8b30WkrANK9d5cl2tVO_MSr64o1kXqH8Jq0iDmgjpOLAc4Mbr4tIg', 'image'),
(7, 'F:\\www\\class\\web69\\wx.com/up/1544691324.jpg', 1544691326, 0, 'ZXLB2TLGAcJhUSeYAIe4C_zp01YuwyL0_6ynnq_lFXqwPFaAek0mq4bYNhpJGX96', 'image'),
(8, 'F:\\www\\class\\web69\\wx.com/up/1544691343.jpg', 1544691344, 1, 'T4fyJ7hV_NJFEfiMWFwg1UZ50YiuLcWrSm6W84jjGJ0', 'image');

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE `user` (
  `id` int(10) UNSIGNED NOT NULL,
  `openid` varchar(255) NOT NULL DEFAULT '' COMMENT 'openid',
  `f1` varchar(255) NOT NULL DEFAULT '' COMMENT '1级',
  `f2` varchar(255) NOT NULL DEFAULT '' COMMENT '2级',
  `f3` varchar(255) NOT NULL DEFAULT '' COMMENT '3级',
  `longitude` decimal(10,6) NOT NULL DEFAULT '0.000000' COMMENT '经度',
  `latitude` decimal(10,6) NOT NULL DEFAULT '0.000000' COMMENT '纬度'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户表';

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `openid`, `f1`, `f2`, `f3`, `longitude`, `latitude`) VALUES
(1, 'ovTcg1ZAoofbOGFx8WIlOfMV8IgM', '', '', '', '116.623672', '40.161133'),
(2, 'ovTcg1S9nm28Xtr-fQob157mOe2g', 'ovTcg1ZAoofbOGFx8WIlOfMV8IgM', '', '', '116.621826', '40.162056'),
(3, 'ovTcg1dPW4Pw7oaohuKCTNedasQs', 'ovTcg1ZAoofbOGFx8WIlOfMV8IgM', '', '', '0.000000', '0.000000'),
(4, 'ovTcg1SccNCUjBbYK-eQV6hMOv70', 'ovTcg1S9nm28Xtr-fQob157mOe2g', 'ovTcg1ZAoofbOGFx8WIlOfMV8IgM', '', '0.000000', '0.000000'),
(5, 'ovTcg1fYhZ3fQFnbJMcyp13zAEMM', 'ovTcg1SccNCUjBbYK-eQV6hMOv70', 'ovTcg1S9nm28Xtr-fQob157mOe2g', 'ovTcg1ZAoofbOGFx8WIlOfMV8IgM', '0.000000', '0.000000'),
(6, 'ovTcg1ZAoofbOGFx8WIlOfMV8IgM', '', '', '', '116.623672', '40.161133'),
(7, 'ovTcg1aGREPmigFQwNlwck5z1--Q', '', '', '', '116.621788', '40.161987'),
(8, 'ovTcg1d3E2Urte78dqDQ1UloqMk8', '', '', '', '0.000000', '0.000000'),
(9, 'ovTcg1ePODpTvxt0vPOCnXq6oIBc', '', '', '', '0.000000', '0.000000'),
(10, 'ovTcg1QTi2-pPGV88vv5nH3yl9yk', '', '', '', '0.000000', '0.000000'),
(11, 'ovTcg1QyzkxNZS2wfT7OQ6EqjVcU', '', '', '', '0.000000', '0.000000'),
(12, 'ovTcg1RGNE-8juMGwAdzEbxHniP4', '', '', '', '0.000000', '0.000000'),
(13, 'ovTcg1VRdMtdG_AcFA4C1hcRzJ2Y', '', '', '', '0.000000', '0.000000'),
(14, 'ovTcg1dPW4Pw7oaohuKCTNedasQs', '', '', '', '0.000000', '0.000000'),
(15, 'ovTcg1SccNCUjBbYK-eQV6hMOv70', '', '', '', '0.000000', '0.000000'),
(16, 'ovTcg1Xlk6-jFcpW4ahV6gydrjE0', '', '', '', '0.000000', '0.000000'),
(17, 'ovTcg1WHBD07g6kYG6-59BvAcrlY', '', '', '', '0.000000', '0.000000'),
(18, 'ovTcg1dIMHdLBNGEEdst73y1kaDI', '', '', '', '0.000000', '0.000000'),
(19, 'ovTcg1RNnygtdF97_ggTNkkRywo0', '', '', '', '0.000000', '0.000000'),
(20, 'ovTcg1UIdDeRj9yRK9uQRo8fQlGU', '', '', '', '116.621811', '40.162010'),
(21, 'ovTcg1ZAoofbOGFx8WIlOfMV8IgM', '', '', '', '116.623672', '40.161133'),
(22, 'ovTcg1QTi2-pPGV88vv5nH3yl9yk', '', '', '', '0.000000', '0.000000'),
(23, 'ovTcg1ZAoofbOGFx8WIlOfMV8IgM', '', '', '', '116.623672', '40.161133'),
(24, 'ovTcg1WVPL2-QhHwOvgIaPvma0wU', '', '', '', '0.000000', '0.000000');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `material`
--
ALTER TABLE `material`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `material`
--
ALTER TABLE `material`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- 使用表AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
