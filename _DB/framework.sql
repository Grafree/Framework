-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Ven 19 Janvier 2018 à 16:51
-- Version du serveur :  5.6.15-log
-- Version de PHP :  5.5.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `formations`
--

-- --------------------------------------------------------

--
-- Structure de la table `adminmenumodules`
--

CREATE TABLE IF NOT EXISTS `adminmenumodules` (
  `IdModule` int(11) NOT NULL AUTO_INCREMENT,
  `NameModule` varchar(30) NOT NULL,
  PRIMARY KEY (`IdModule`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Contenu de la table `adminmenumodules`
--

INSERT INTO `adminmenumodules` (`IdModule`, `NameModule`) VALUES
(1, 'offices'),
(2, 'tools'),
(3, 'menus'),
(4, 'admins'),
(5, 'users'),
(6, 'workshops'),
(7, 'contacts'),
(9, 'mailbox'),
(10, 'inventory'),
(11, 'request'),
(12, 'schedule'),
(13, 'timestamp'),
(14, 'reports'),
(15, 'activityreports ');

-- --------------------------------------------------------

--
-- Structure de la table `adminmenus`
--

CREATE TABLE IF NOT EXISTS `adminmenus` (
  `IdMenu` int(11) NOT NULL AUTO_INCREMENT,
  `NameMenu` varchar(50) NOT NULL,
  `TitleMenu` varchar(50) NOT NULL,
  `ModuleMenu` varchar(50) NOT NULL,
  `ActionMenu` varchar(20) NOT NULL,
  `IsActiveMenu` tinyint(4) NOT NULL,
  `HeadingMenu` set('pages','modules','users','params','suivi','planification','rapports','profil') NOT NULL,
  `OrderMenu` int(11) NOT NULL,
  PRIMARY KEY (`IdMenu`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT AUTO_INCREMENT=52 ;

--
-- Contenu de la table `adminmenus`
--

INSERT INTO `adminmenus` (`IdMenu`, `NameMenu`, `TitleMenu`, `ModuleMenu`, `ActionMenu`, `IsActiveMenu`, `HeadingMenu`, `OrderMenu`) VALUES
(4, 'CrÃ©ateur de modules', 'CrÃ©ateur de modules', '2', '', 1, 'params', 4),
(11, 'Menu de l''administration', 'Menu de l''administration', '3', '', 1, 'params', 1),
(14, 'Ateliers et formation', 'Ateliers et formation', '6', '', 1, 'planification', 1),
(23, 'Groupes', 'Groupes d''utilisateurs', '5', 'groups', 1, 'users', 1),
(25, 'Utilisateurs et participants', 'Gestion des participants', '5', '', 1, 'users', 3),
(31, 'Audit systÃ¨me', 'Audit', '2', 'audit', 1, 'params', 5),
(36, 'Documentation', '', '2', 'documentation', 1, 'params', 3);

-- --------------------------------------------------------

--
-- Structure de la table `coachs`
--

CREATE TABLE IF NOT EXISTS `coachs` (
  `IdCoach` int(10) NOT NULL AUTO_INCREMENT,
  `LastnameCoach` varchar(50) NOT NULL,
  `FirstnameCoach` varchar(50) NOT NULL,
  `PhoneCoach` varchar(20) NOT NULL,
  `EmailCoach` varchar(50) NOT NULL,
  `AddressCoach` varchar(255) NOT NULL,
  `NpaCoach` varchar(10) NOT NULL,
  `CityCoach` varchar(25) NOT NULL,
  `ExpertiseCoach` varchar(25) NOT NULL,
  `IsActiveCoach` tinyint(2) NOT NULL,
  PRIMARY KEY (`IdCoach`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `coachs`
--

INSERT INTO `coachs` (`IdCoach`, `LastnameCoach`, `FirstnameCoach`, `PhoneCoach`, `EmailCoach`, `AddressCoach`, `NpaCoach`, `CityCoach`, `ExpertiseCoach`, `IsActiveCoach`) VALUES
(1, 'Paun', 'Sorin', '021 222 22 22', 'info@insertionsuisse.ch', 'Rue de la Vigie 3', '1000', 'Lausanne', 'HTML', 1),
(2, 'Cruchon', 'StÃ©phane', '', '', '', '', '', '', 1);

-- --------------------------------------------------------

--
-- Structure de la table `countries`
--

CREATE TABLE IF NOT EXISTS `countries` (
  `id_country` int(3) NOT NULL AUTO_INCREMENT,
  `name_country` varchar(60) NOT NULL,
  `currency_country` varchar(10) NOT NULL,
  `symbol_country` varchar(3) NOT NULL,
  `domain_country` varchar(2) NOT NULL,
  `id_region_country` int(11) NOT NULL,
  `active_country` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0 = inactive; 1 = active;',
  PRIMARY KEY (`id_country`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT AUTO_INCREMENT=204 ;

--
-- Contenu de la table `countries`
--

INSERT INTO `countries` (`id_country`, `name_country`, `currency_country`, `symbol_country`, `domain_country`, `id_region_country`, `active_country`) VALUES
(1, 'Afghanistan', 'AFN', 'AF', 'af', 9, 0),
(2, 'Albanie', 'ALL', 'AL', 'al', 12, 1),
(3, 'AlgÃ©rie', 'DZD', 'DZ', 'dz', 2, 1),
(4, 'Andorre', 'â‚¬ (EUR)', 'AD', 'ad', 12, 0),
(5, 'Angola', 'AOA', 'AO', 'ao', 2, 0),
(6, 'Anguilla', '$ (XCD)', 'AI', 'ai', 7, 0),
(7, 'Antigua et Barbuda', '$ (XCD)', 'AG', 'ag', 7, 0),
(8, 'Argentine', 'ARS', 'AR', 'ar', 7, 0),
(9, 'ArmÃ©nie', 'AMD', 'AM', 'am', 9, 0),
(10, 'Australie', '$ (AUD)', 'AU', 'au', 15, 0),
(11, 'Autriche', 'â‚¬ (EUR)', 'AT', 'at', 17, 0),
(12, 'AzerbaÃ¯djan', 'AZN', 'AZ', 'az', 9, 0),
(13, 'Bahamas', '$ (BSD)', 'BS', 'bs', 7, 0),
(14, 'BahreÃ¯n', 'BHD', 'BH', 'bh', 9, 0),
(15, 'Bangladesh', 'BDT', 'BD', 'bd', 9, 0),
(16, 'Barbade', '$ (BBD)', 'BB', 'bb', 7, 0),
(17, 'BÃ©larus', 'BYR', 'BY', 'by', 13, 1),
(18, 'Belgique', 'â‚¬ (EUR)', 'BE', 'be', 17, 1),
(19, 'Belize', '$ (BZD)', 'BZ', 'bz', 7, 0),
(20, 'BÃ©nin', 'Franc CFA', 'BJ', 'bj', 2, 1),
(21, 'Bermudes', '$ (USD)', 'BM', 'bm', 8, 0),
(22, 'Bhoutan', 'BTN', 'BT', 'bt', 9, 0),
(23, 'Bolivie', 'BOB', 'BO', 'bo', 7, 0),
(24, 'Bosnie et HerzÃ©govine', 'BAM', 'BA', 'ba', 12, 1),
(25, 'Botswana', 'BWP', 'BW', 'bw', 2, 0),
(26, 'BrÃ©sil', 'BRL', 'BR', 'br', 7, 0),
(27, 'Brunei', '$ (BND)', 'BN', 'bn', 9, 0),
(28, 'Bulgarie', 'BGN', 'BG', 'bg', 13, 1),
(29, 'Burkina-Faso', 'Franc CFA', 'BF', 'bf', 2, 0),
(30, 'Birmanie', 'MKK', 'MM', 'mm', 9, 0),
(31, 'Burundi', 'BIF', 'BI', 'bi', 2, 0),
(32, 'Cambodge', 'KHR', 'KH', 'kh', 9, 0),
(33, 'Cameroun', 'Franc CFA', 'CM', 'cm', 2, 0),
(34, 'Canada', '$ (CAD)', 'CA', 'ca', 8, 1),
(35, 'Cap-Vert', 'CVE', 'CV', 'cv', 2, 0),
(36, 'Ã®les Cayman', '$ (KYD)', 'KY', 'ky', 7, 0),
(37, 'RÃ©publique centrafricaine', 'Franc CFA', 'CF', 'cf', 2, 0),
(38, 'Tchad', 'Franc CFA', 'TD', 'td', 2, 0),
(39, 'Chili', 'CLP', 'CL', 'cl', 7, 0),
(40, 'Chine', 'CNY', 'CN', 'cn', 9, 0),
(41, 'Colombie', 'COP', 'CO', 'co', 7, 0),
(42, 'Comores', 'KMF', 'KM', 'km', 2, 0),
(43, 'Congo (Brazzaville)', 'Franc CFA', 'CG', 'cg', 2, 0),
(44, 'Congo (Kinshasa)', 'CDF', 'CD', 'cd', 2, 0),
(45, 'Costa Rica', 'CRC', 'CR', 'cr', 7, 0),
(46, 'CÃ´te d\\''Ivoire', 'Franc CFA', 'CI', 'ci', 2, 0),
(47, 'Croatie', 'HRK', 'HR', 'hr', 12, 1),
(48, 'Cuba', 'CUP', 'CU', 'cu', 7, 0),
(49, 'Chypre', '', '', '', 13, 0),
(50, 'RÃ©publique tchÃ¨que', 'CZK', 'CZ', 'cz', 13, 1),
(51, 'Danemark', 'DKK', 'DK', 'dk', 16, 0),
(52, 'Djibouti', 'DJF', 'DJ', 'dj', 2, 0),
(53, 'Dominique', '', '', '', 7, 0),
(54, 'RÃ©publique dominicaine', 'DOP', 'DO', 'do', 7, 0),
(55, 'Ã‰quateur', '$ (USD)', 'EC', 'ec', 7, 0),
(56, 'Ã‰gypte', 'EGP', 'EG', 'eg', 2, 0),
(57, 'El Salvador', '$ (USD)', 'SV', 'sv', 7, 0),
(58, 'GuinÃ©e Ã©quatoriale', 'Franc CFA', 'GQ', 'gq', 2, 0),
(59, 'Ã‰rythrÃ©e', 'ERN', 'ER', 'er', 2, 0),
(60, 'Estonie', 'EEK', 'EE', 'ee', 13, 1),
(61, 'Ã‰thiopie', 'ETB', 'ET', 'et', 2, 0),
(62, 'Fidji', '$ (FDJ)', 'FJ', 'fj', 15, 0),
(63, 'Finlande', 'â‚¬ (EUR)', 'FI', 'fi', 16, 0),
(64, 'France', 'â‚¬ (EUR)', 'FR', 'fr', 17, 1),
(65, 'Guyane franÃ§aise', 'â‚¬ (EUR)', 'GF', 'gf', 7, 0),
(66, 'Gabon', 'Franc CFA', 'GA', 'ga', 2, 0),
(67, 'Gambie', 'GMD', 'GM', 'gm', 2, 0),
(68, 'GÃ©orgie', 'GEL', 'GE', 'ge', 9, 0),
(69, 'Allemagne', 'â‚¬ (EUR)', 'DE', 'de', 17, 1),
(70, 'Ghana', 'GHS', 'GH', 'gh', 2, 0),
(71, 'GrÃ¨ce', 'â‚¬ (EUR)', 'GR', 'gr', 12, 0),
(72, 'Grenade', '$ (XCD)', 'GD', 'gd', 7, 0),
(73, 'Guadeloupe', 'â‚¬ (EUR)', 'GP', 'gp', 7, 0),
(74, 'Guatemala', 'GTQ', 'GT', 'gt', 7, 0),
(75, 'GuinÃ©e', 'GNF', 'GN', 'gn', 2, 0),
(76, 'GuinÃ©e-Bissau', 'Franc CFA', 'GW', 'gw', 2, 0),
(77, 'Guyane', 'â‚¬ (EUR)', 'GF', 'gf', 7, 0),
(78, 'HaÃ¯ti', 'HTG', 'HT', 'ht', 7, 0),
(79, 'Honduras', 'HNL', 'HN', 'hn', 7, 0),
(80, 'Hongrie', 'HUF', 'HU', 'hu', 13, 1),
(81, 'Islande', 'ISK', 'IS', 'is', 16, 0),
(82, 'Inde', 'INR', 'IN', 'in', 9, 0),
(83, 'IndonÃ©sie', 'IDR', 'ID', 'id', 9, 0),
(84, 'Iran', 'IRR', 'IR', 'ir', 9, 0),
(85, 'Iraq', 'IQD', 'IQ', 'iq', 9, 0),
(86, 'Irlande', 'â‚¬ (EUR)', 'IE', 'ie', 16, 0),
(87, 'IsraÃ«l ', 'NIS', 'IL', 'il', 9, 0),
(88, 'Italie', 'â‚¬ (EUR)', 'IT', 'it', 12, 1),
(89, 'JamaÃ¯que', '$ (JMD)', 'JM', 'jm', 7, 0),
(90, 'Japon', 'JPY', 'JP', 'jp', 9, 0),
(91, 'Jordanie', 'JOD', 'JO', 'jo', 9, 0),
(92, 'Kazakhstan', 'KZT', 'KZ', 'kz', 9, 0),
(93, 'Kenya', 'KES', 'KE', 'ke', 2, 0),
(94, 'Kiribati', '$ (AUD)', 'KI', 'ki', 15, 0),
(95, 'CorÃ©e du Nord', 'KPW', 'KP', 'kp', 9, 0),
(96, 'CorÃ©e du Sud', 'KRW', 'KR', 'kr', 9, 0),
(97, 'Kosovo', 'â‚¬ (EUR)', '', '', 13, 1),
(98, 'KoweÃ¯t', 'KWD', 'KW', 'kw', 9, 0),
(99, 'Kirghizistan', 'KGS', 'KG', 'kg', 9, 0),
(100, 'Laos', 'LAOS', 'LA', 'la', 9, 0),
(101, 'Lettonie', 'LVL', 'LV', 'lv', 16, 1),
(102, 'Liban', 'LBP', 'LB', 'lb', 9, 0),
(103, 'Lesotho', 'LSL', 'LS', 'ls', 2, 0),
(104, 'LibÃ©ria', '$ (LRD)', 'LR', 'lr', 2, 0),
(105, 'Libye', 'LYB', 'LY', 'ly', 2, 0),
(106, 'Liechtenstein', 'CHF', 'LI', 'li', 17, 0),
(107, 'Lituanie', 'LTL', 'LT', 'lt', 16, 1),
(108, 'Luxembourg', 'â‚¬ (EUR)', 'LU', 'lu', 17, 0),
(109, 'MacÃ©doine', 'MKD', 'MK', 'mk', 12, 0),
(110, 'Madagascar', 'MGA', 'MG', 'mg', 2, 0),
(111, 'Malawi', 'MWK', 'MW', 'mw', 2, 0),
(112, 'Malaisie', 'MYR', 'MY', 'my', 9, 0),
(113, 'Maldives', 'MVR', 'MV', 'mv', 9, 0),
(114, 'Mali', 'Franc CFA', 'ML', 'ml', 2, 0),
(115, 'Malte', 'â‚¬ (EUR)', 'MT', 'mt', 12, 0),
(116, 'ÃŽles Marshall', '$ (USD)', 'MH', 'mh', 15, 0),
(117, 'Martinique', 'â‚¬ (EUR)', 'MQ', 'mq', 7, 0),
(118, 'Mauritanie', 'MRO', 'MR', 'mr', 2, 0),
(119, 'Maurice', '', '', '', 2, 0),
(120, 'Mexique', '$ (MXN)', 'MX', 'mx', 7, 0),
(121, 'MicronÃ©sie', '$ (USD)', 'FM', 'fm', 15, 0),
(122, 'Moldova', 'MDL', 'MD', 'md', 13, 1),
(123, 'Mongolie', 'MNT', 'MN', 'mn', 9, 0),
(124, 'MontÃ©nÃ©gro', 'â‚¬ (EUR)', 'ME', 'me', 13, 1),
(125, 'Maroc', 'MAD', 'MA', 'ma', 2, 1),
(126, 'Mozambique', 'MZM', 'MZ', 'mz', 2, 0),
(127, 'Namibie', '$ (NAD)', 'NA', 'na', 2, 0),
(128, 'Nauru', '$ (AUD)', 'NR', 'nr', 15, 0),
(129, 'NÃ©pal', 'NPR', 'NP', 'np', 9, 0),
(130, 'Pays-Bas', 'â‚¬ (EUR)', 'NL', 'nl', 17, 1),
(131, 'Antilles nÃ©erlandaises', 'ANG', 'AN', 'an', 7, 0),
(132, 'Nouvelle-ZÃ©lande', '$ (NZD)', 'NZ', 'nz', 15, 0),
(133, 'Nicaragua', 'NIO', 'NI', 'ni', 7, 0),
(134, 'Niger', 'Franc CFA', 'NE', 'ne', 2, 0),
(135, 'NigÃ©ria', 'NGN', 'NG', 'ng', 2, 1),
(136, 'NorvÃ¨ge', 'NOK', 'NO', 'no', 16, 0),
(137, 'Oman', 'OMR', 'OM', 'om', 9, 0),
(138, 'Pakistan', 'PKR', 'PK', 'pk', 9, 0),
(139, 'Territoires Palestiniens', '', '', '', 9, 0),
(140, 'Panama', 'PAB', 'PA', 'pa', 7, 0),
(141, 'Papouasie-Nouvelle-GuinÃ©e', 'PGK', 'PG', 'pg', 15, 0),
(142, 'Paraguay', 'PYG', 'PY', 'py', 7, 0),
(143, 'PÃ©rou', 'PEN', 'PE', 'pe', 7, 0),
(144, 'Philippines', 'PHP', 'PH', 'ph', 9, 0),
(145, 'Pologne', 'PLN', 'PL', 'pl', 13, 1),
(146, 'Portugal', 'â‚¬ (EUR)', 'PO', 'pt', 12, 0),
(147, 'Qatar', 'QAR', 'QA', 'qa', 9, 0),
(148, 'Roumanie', 'RON', 'RO', 'ro', 13, 1),
(149, 'Russie', 'RUB', 'RU', 'ru', 13, 0),
(150, 'Rwanda', 'RWF', 'RW', 'rw', 2, 0),
(151, 'Saint-Kitts-et-Nevis', '$ (XCD)', 'KN', 'kn', 7, 0),
(152, 'Sainte-Lucie', '$ (XCD)', 'LC', 'lc', 7, 0),
(153, 'Saint Vincent et les Grenadines', '$ (XCD)', 'VC', 'vc', 7, 0),
(154, 'Samoa', 'WST', 'WS', 'ws', 15, 0),
(155, 'Samoa', 'WST', 'WS', 'ws', 12, 0),
(156, 'Sao TomÃ©-et-Principe', 'STD', 'ST', 'st', 2, 0),
(157, 'Arabie saoudite', 'SAR', 'SA', 'sa', 9, 0),
(158, 'SÃ©nÃ©gal', 'Franc CFA', 'SN', 'sn', 2, 0),
(159, 'Serbie', 'RSD', 'RS', 'rs', 13, 1),
(160, 'Seychelles', 'SCR', 'SC', 'sc', 2, 0),
(161, 'Sierra Leone', 'SLL', 'SL', 'sl', 2, 0),
(162, 'Singapour', '$ (SGD)', 'SG', 'sg', 9, 0),
(163, 'Slovaquie', 'â‚¬ (EUR)', 'SK', 'sk', 17, 0),
(164, 'SlovÃ©nie', 'â‚¬ (EUR)', 'SI', 'si', 17, 0),
(165, 'ÃŽles Salomon', 'SBD', 'SL', 'sl', 15, 0),
(166, 'Somalie', 'SOS', 'SO', 'so', 2, 0),
(167, 'Afrique du Sud', 'ZAR', 'ZA', 'za', 2, 1),
(168, 'Espagne', 'â‚¬ (EUR)', 'ES', 'es', 12, 1),
(169, 'Sri Lanka', 'LKR', 'LK', 'lk', 9, 0),
(170, 'Soudan', 'SDG', 'SD', 'sd', 2, 0),
(171, 'Suriname', '$ (SRD)', 'SR', 'sr', 7, 0),
(172, 'Swaziland', 'SZL', 'SZ', 'sz', 2, 0),
(173, 'SuÃ¨de', 'SEK', 'SE', 'se', 16, 1),
(174, 'Suisse', 'CHF', 'CH', 'ch', 17, 1),
(175, 'Syrie', 'SP', 'SY', 'sy', 9, 0),
(176, 'Tadjikistan', 'TJS', 'TJ', 'tj', 9, 0),
(177, 'Tanzanie', 'TZS', 'TZ', 'tz', 2, 0),
(178, 'ThaÃ¯lande', 'THB', 'TH', 'th', 9, 0),
(179, 'Timor Oriental', '$ (USD)', 'TL', 'tl', 9, 0),
(180, 'Tonga', 'TOP', 'TO', 'to', 15, 0),
(181, 'Togo', 'Franc CFA', 'TG', 'tg', 2, 0),
(182, 'TrinitÃ©-et-Tobago', '$ (TTD)', 'TT', 'tt', 7, 0),
(183, 'Tunisie', 'TND', 'TN', 'tn', 2, 0),
(184, 'Turquie', 'TL', 'TR', 'tr', 13, 0),
(185, 'TurkmÃ©nistan', 'TMM', 'TM', 'tm', 9, 0),
(186, 'Turks et CaÃ¯ques', '$ (USD)', 'TC', 'tc', 7, 0),
(187, 'Tuvalu', '$ (AUD)', 'TV', 'tv', 15, 0),
(188, 'Ouganda', 'UGX', 'UG', 'ug', 2, 0),
(189, 'Ukraine', 'UAH', 'UA', 'ua', 13, 0),
(190, 'Ã‰mirats arabes unis (EAU)', 'EAD', 'EA', 'ea', 9, 0),
(191, 'Royaume-Uni', 'Â£ (GBP)', 'GB', 'uk', 17, 1),
(192, 'Ã‰tats-Unis d\\''AmÃ©rique', '$ (USD)', 'US', 'us', 8, 1),
(193, 'Uruguay', 'UYU', 'UY', 'uy', 7, 0),
(194, 'UzbÃ©kistan', 'UKS', 'UZ', 'uz', 9, 0),
(195, 'Vanuatu', 'VUV', 'VU', 'vu', 9, 0),
(196, 'VÃ©nÃ©zuela ', 'VEF', 'VE', 've', 7, 0),
(197, 'Vietnam', 'VND', 'VN', 'vn', 9, 0),
(198, 'YÃ©men', 'YER', 'YE', 'ye', 9, 0),
(199, 'Zambie', 'ZMK', 'ZM', 'zm', 2, 0),
(200, 'Zimbabwe', '$ (ZWD)', 'ZW', 'zw', 2, 0),
(201, 'Aucun', '', '', '', 1, 0),
(203, 'World (online)', '', '', '', 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `domaine`
--

CREATE TABLE IF NOT EXISTS `domaine` (
  `IDDomaine` int(11) NOT NULL AUTO_INCREMENT,
  `NomDomaine` varchar(50) NOT NULL,
  PRIMARY KEY (`IDDomaine`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=59 ;

--
-- Contenu de la table `domaine`
--

INSERT INTO `domaine` (`IDDomaine`, `NomDomaine`) VALUES
(2, 'Mobile & Web Designer'),
(58, 'UX Design');

-- --------------------------------------------------------

--
-- Structure de la table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `IdGroup` int(11) NOT NULL AUTO_INCREMENT,
  `NameGroup` varchar(50) NOT NULL,
  `IdMenuLanding` int(11) NOT NULL,
  PRIMARY KEY (`IdGroup`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `groups`
--

INSERT INTO `groups` (`IdGroup`, `NameGroup`, `IdMenuLanding`) VALUES
(1, 'Administrateur', 14),
(2, 'Formateur', 0),
(3, 'Participant', 0);

-- --------------------------------------------------------

--
-- Structure de la table `group_rights`
--

CREATE TABLE IF NOT EXISTS `group_rights` (
  `IdGroup` int(11) NOT NULL,
  `IdMenu` int(11) NOT NULL,
  `Rights` set('r','a','m','d','v','w') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `group_rights`
--

INSERT INTO `group_rights` (`IdGroup`, `IdMenu`, `Rights`) VALUES
(2, 1, 'r'),
(2, 1, 'w'),
(2, 1, 'm'),
(2, 1, 'd'),
(1, 14, 'r'),
(1, 14, 'w'),
(1, 14, 'v'),
(1, 14, 'm'),
(1, 14, 'd'),
(1, 9, 'r'),
(1, 9, 'w'),
(1, 9, 'm'),
(1, 9, 'd'),
(1, 11, 'r'),
(1, 11, 'w'),
(1, 11, 'v'),
(1, 11, 'm'),
(1, 11, 'd'),
(1, 4, 'r'),
(1, 4, 'w'),
(1, 4, 'm'),
(1, 4, 'd'),
(1, 22, 'r'),
(1, 22, 'w'),
(1, 22, 'm'),
(1, 22, 'v'),
(1, 22, 'd'),
(1, 23, 'r'),
(1, 23, 'w'),
(1, 23, 'm'),
(1, 23, 'v'),
(1, 23, 'd'),
(1, 24, 'v'),
(1, 24, 'r'),
(1, 24, 'w'),
(1, 24, 'm'),
(1, 24, 'd'),
(1, 25, 'r'),
(1, 25, 'w'),
(1, 25, 'm'),
(1, 25, 'd'),
(1, 25, 'v'),
(1, 27, 'r'),
(1, 27, 'w'),
(1, 27, 'm'),
(1, 27, 'd'),
(1, 27, 'v'),
(1, 28, 'r'),
(1, 28, 'w'),
(1, 28, 'm'),
(1, 28, 'd'),
(1, 28, 'v'),
(1, 9, 'v'),
(1, 4, 'v'),
(1, 29, 'r'),
(1, 29, 'w'),
(1, 29, 'm'),
(1, 29, 'd'),
(1, 29, 'v'),
(1, 49, 'w'),
(1, 31, 'r'),
(1, 31, 'w'),
(1, 31, 'm'),
(1, 31, 'd'),
(1, 31, 'v'),
(2, 14, 'r'),
(2, 14, 'w'),
(2, 14, 'm'),
(2, 14, 'd'),
(2, 14, 'v');

-- --------------------------------------------------------

--
-- Structure de la table `systemaudits`
--

CREATE TABLE IF NOT EXISTS `systemaudits` (
  `IdAudit` int(11) NOT NULL AUTO_INCREMENT,
  `DateAudit` datetime NOT NULL,
  `FirstnameUserAudit` varchar(50) NOT NULL,
  `NameUserAudit` varchar(50) NOT NULL,
  `LoginUserAudit` varchar(60) NOT NULL,
  `EmailUserAudit` varchar(60) NOT NULL,
  `IpUserAudit` varchar(15) NOT NULL,
  `UrlSystemAudit` varchar(150) NOT NULL,
  `ModuleSystemAudit` varchar(30) NOT NULL,
  `ActionSystemAudit` varchar(30) NOT NULL,
  `DescriptionAudit` text NOT NULL,
  PRIMARY KEY (`IdAudit`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1147 ;

--
-- Contenu de la table `systemaudits`
--

INSERT INTO `systemaudits` (`IdAudit`, `DateAudit`, `FirstnameUserAudit`, `NameUserAudit`, `LoginUserAudit`, `EmailUserAudit`, `IpUserAudit`, `UrlSystemAudit`, `ModuleSystemAudit`, `ActionSystemAudit`, `DescriptionAudit`) VALUES
(1086, '2018-01-12 07:32:29', '', '', '', '', '127.0.0.1', '', '', '', 'Login SUCCESS'),
(1087, '2018-01-12 07:32:43', '', '', '', '', '127.0.0.1', '', '', '', 'Login SUCCESS'),
(1088, '2018-01-12 07:36:05', '', '', '', '', '127.0.0.1', '', '', '', 'Login SUCCESS'),
(1089, '2018-01-12 12:19:25', '', '', '', '', '127.0.0.1', '/workshops/workshops/eval', 'workshops', 'workshops', 'LOGOUT'),
(1090, '2018-01-12 12:23:12', '', '', '', '', '127.0.0.1', '', '', '', 'Login SUCCESS'),
(1091, '2018-01-12 12:33:39', '', '', '', '', '127.0.0.1', '', 'login', '', 'LOGOUT'),
(1092, '2018-01-12 12:33:47', '', '', '', '', '127.0.0.1', '', '', '', 'Login SUCCESS'),
(1093, '2018-01-12 13:10:49', '', '', '', '', '212.147.13.57', '', '', '', 'Login SUCCESS'),
(1094, '2018-01-12 13:13:11', '', '', '', '', '212.147.13.57', '/home', 'home', '', 'LOGOUT'),
(1095, '2018-01-12 13:20:39', '', '', '', '', '212.147.13.57', '', '', '', 'Login SUCCESS'),
(1096, '2018-01-12 13:52:01', '', '', '', '', '212.147.13.57', '/home', 'home', '', 'LOGOUT'),
(1097, '2018-01-12 14:08:52', '', '', '', '', '212.147.13.57', '', '', '', 'Login SUCCESS'),
(1098, '2018-01-12 14:09:25', '', '', '', '', '212.147.13.57', '/workshops', 'workshops', '', 'LOGOUT'),
(1099, '2018-01-12 14:09:49', '', '', '', '', '212.147.13.57', '', '', '', 'Login SUCCESS'),
(1100, '2018-01-12 14:17:40', '', '', '', '', '212.147.13.57', '/workshops/questions', 'workshops', 'questions', 'LOGOUT'),
(1101, '2018-01-12 14:17:46', '', '', '', '', '212.147.13.57', '', '', '', 'Login SUCCESS'),
(1102, '2018-01-12 14:21:42', '', '', '', '', '212.147.13.57', '/workshops', 'workshops', '', 'LOGOUT'),
(1103, '2018-01-12 14:21:49', '', '', '', '', '212.147.13.57', '', '', '', 'Login SUCCESS'),
(1104, '2018-01-12 14:23:31', '', '', '', '', '212.147.13.57', '/workshops', 'workshops', '', 'LOGOUT'),
(1105, '2018-01-12 14:23:38', '', '', '', '', '212.147.13.57', '', '', '', 'Login SUCCESS'),
(1106, '2018-01-12 14:29:10', '', '', '', '', '212.147.13.57', '/workshops', 'workshops', '', 'LOGOUT'),
(1107, '2018-01-12 14:29:17', '', '', '', '', '212.147.13.57', '', '', '', 'Login SUCCESS'),
(1108, '2018-01-13 07:02:33', '', '', '', '', '84.74.225.180', '', '', '', 'Login SUCCESS'),
(1109, '2018-01-13 07:30:01', '', '', '', '', '84.74.225.180', '', 'login', 'disconnect', 'LOGOUT'),
(1110, '2018-01-13 08:16:24', '', '', '', '', '84.74.225.180', '', '', '', 'Login SUCCESS'),
(1111, '2018-01-13 08:20:59', '', '', '', '', '84.74.225.180', '/workshops/questions', 'workshops', 'questions', 'LOGOUT'),
(1112, '2018-01-13 08:21:12', '', '', '', '', '84.74.225.180', '', '', '', 'Login SUCCESS'),
(1113, '2018-01-13 08:47:53', '', '', '', '', '84.74.225.180', '/workshops/evalsendinvite/17', 'workshops', 'evalsendinvite', 'LOGOUT'),
(1114, '2018-01-13 08:48:12', '', '', '', '', '84.74.225.180', '', '', '', 'Login SUCCESS'),
(1115, '2018-01-13 21:18:48', '', '', '', '', '84.74.225.180', '', 'login', 'disconnect', 'LOGOUT'),
(1116, '2018-01-13 21:19:21', '', '', '', '', '84.74.225.180', '', '', '', 'Login SUCCESS'),
(1117, '2018-01-13 21:19:58', '', '', '', '', '84.74.225.180', '/workshops/evale', 'workshops', 'evale', 'LOGOUT'),
(1118, '2018-01-13 21:20:28', '', '', '', '', '84.74.225.180', '', '', '', 'Login SUCCESS'),
(1119, '2018-01-13 21:21:30', '', '', '', '', '84.74.225.180', '/workshops/evalsendinvite/7', 'workshops', 'evalsendinvite', 'LOGOUT'),
(1120, '2018-01-13 21:25:32', '', '', '', '', '84.74.225.180', '', '', '', 'Login SUCCESS'),
(1121, '2018-01-13 21:25:34', '', '', '', '', '84.74.225.180', '', 'login', 'disconnect', 'LOGOUT'),
(1122, '2018-01-13 21:47:35', '', '', '', '', '84.74.225.180', '', '', '', 'Login SUCCESS'),
(1123, '2018-01-13 21:47:52', '', '', '', '', '84.74.225.180', '/workshops/evald', 'workshops', 'evald', 'LOGOUT'),
(1124, '2018-01-13 21:51:31', '', '', '', '', '84.74.225.180', '', '', '', 'Login SUCCESS'),
(1125, '2018-01-13 21:57:11', '', '', '', '', '84.74.225.180', '/users/groupactiverightAjax/ajax', 'users', 'groupactiverightAjax', 'AJAXFAIL; b27d8399c41aa1e7117cc8e3b75fec96; e416d2101e539a916a9bd0e62230ea71; 2bcd7f2c3e07f561df684a3463a6b362; 2bcd7f2c3e07f561df684a3463a6b362; users; groupactiverightAjax'),
(1126, '2018-01-13 21:57:12', '', '', '', '', '84.74.225.180', '/users/groupactiverightAjax/ajax', 'users', 'groupactiverightAjax', 'AJAXFAIL; e416d2101e539a916a9bd0e62230ea71; 2bcd7f2c3e07f561df684a3463a6b362; 95486afdc94c950589d7b658aa073ca8; 95486afdc94c950589d7b658aa073ca8; users; groupactiverightAjax'),
(1127, '2018-01-13 21:57:58', '', '', '', '', '84.74.225.180', '', 'login', 'disconnect', 'LOGOUT'),
(1128, '2018-01-13 22:47:32', '', '', '', '', '84.74.225.180', '/workshops/evald', 'workshops', 'evald', 'LOGOUT'),
(1129, '2018-01-13 22:47:35', '', '', '', '', '84.74.225.180', '', '', '', 'Login SUCCESS'),
(1130, '2018-01-13 23:34:01', '', '', '', '', '84.74.225.180', '/workshops/evale', 'workshops', 'evale', 'LOGOUT'),
(1131, '2018-01-13 23:34:05', '', '', '', '', '84.74.225.180', '', '', '', 'Login SUCCESS'),
(1132, '2018-01-14 01:34:08', '', '', '', '', '84.74.225.180', '', 'login', 'disconnect', 'LOGOUT'),
(1133, '2018-01-14 01:34:18', '', '', '', '', '84.74.225.180', '', '', '', 'Login SUCCESS'),
(1134, '2018-01-14 01:34:52', '', '', '', '', '84.74.225.180', '', 'login', 'eval', 'Login By Url for Olivier Dommange'),
(1135, '2018-01-14 01:34:58', '', '', '', '', '84.74.225.180', '/workshops/evalsd', 'workshops', 'evalsd', 'LOGOUT'),
(1136, '2018-01-14 01:35:09', '', '', '', '', '84.74.225.180', '', 'login', 'eval', 'Login By Url for Olivier Dommange'),
(1137, '2018-01-14 01:35:18', '', '', '', '', '84.74.225.180', '/workshops/evald', 'workshops', 'evald', 'LOGOUT'),
(1138, '2018-01-14 01:35:22', '', '', '', '', '84.74.225.180', '', '', '', 'Login SUCCESS'),
(1139, '2018-01-14 01:35:40', '', '', '', '', '84.74.225.180', '', 'login', 'eval', 'Login By Url for Olivier Dommange'),
(1140, '2018-01-14 01:35:54', '', '', '', '', '84.74.225.180', '/workshops/evald', 'workshops', 'evald', 'LOGOUT'),
(1141, '2018-01-16 17:09:45', '', '', '', '', '127.0.0.1', '', 'login', 'disconnect', 'LOGOUT'),
(1142, '2018-01-16 17:10:59', '', '', '', '', '127.0.0.1', '', 'login', 'disconnect', 'LOGOUT'),
(1143, '2018-01-16 17:12:36', '', '', '', '', '127.0.0.1', '', 'login', 'disconnect', 'LOGOUT'),
(1144, '2018-01-16 17:17:24', '', '', '', '', '127.0.0.1', '', 'login', 'newpassAjax', 'AJAXFAIL; 168f387ac1a28b93ff370b8509d49070; 61391fe3e2ae01d5b711e71b350676ac; 8df5b1e813db8ca8dfe08bfb99ae2ff5; 8df5b1e813db8ca8dfe08bfb99ae2ff5; login; newpassAjax'),
(1145, '2018-01-16 17:21:17', '', '', '', '', '127.0.0.1', '', 'login', 'newpassAjax', 'AJAXFAIL; b1c9119a6f5174bcdb587eee938d8113; 67fe918e9ad475f7d5578afc36946002; c6168194f9d103e6cd5a657a9f7d9df6; c6168194f9d103e6cd5a657a9f7d9df6; login; newpassAjax'),
(1146, '2018-01-16 17:24:42', '', '', '', '', '127.0.0.1', '', 'login', 'newpassAjax', 'AJAXFAIL; c6168194f9d103e6cd5a657a9f7d9df6; 58924028e5be6d38daa7099fa62718a0; d661c6e6a00f3cdc2bacb976fe335e4f; d661c6e6a00f3cdc2bacb976fe335e4f; login; newpassAjax');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `IdUser` int(10) NOT NULL AUTO_INCREMENT,
  `PseudoUser` varchar(50) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `PassUser` varchar(32) CHARACTER SET latin1 NOT NULL,
  `IdGroup` int(10) NOT NULL,
  `LastnameUser` varchar(50) DEFAULT NULL,
  `FirstnameUser` varchar(50) DEFAULT NULL,
  `EmailUser` varchar(60) DEFAULT NULL,
  `PhoneUser` varchar(20) DEFAULT NULL,
  `AddressUser` varchar(60) NOT NULL,
  `ZipCodeUser` varchar(8) NOT NULL,
  `CityUser` varchar(40) NOT NULL,
  PRIMARY KEY (`IdUser`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`IdUser`, `PseudoUser`, `PassUser`, `IdGroup`, `LastnameUser`, `FirstnameUser`, `EmailUser`, `PhoneUser`, `AddressUser`, `ZipCodeUser`, `CityUser`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 1, 'Administrateur', 'Super2', 'admin@user.ch', '+41 (0) 21 621 92 62', 'Sevelin 28', '1004', 'Lausanne'),
(8, 'admin2', '55c7aafa075b9fd964b6', 1, 'Dommange', 'Olivier', 'olivier.dommange@gmail.com', '+41764385927', 'Chemin de l''Orio 6', '1032', 'Romanel-sur-Lausanne'),
(12, 'gomez.rafaella@gmail.com', 'f917d5', 3, 'Gomez', 'Raffaella', 'gomez.rafaella@gmail.com', '079 904 52 88', 'Av. Des Figuiers, 23', '1007', 'Lausanne'),
(13, 'rochat.sand@gmail.com', '7f8982', 3, 'Rochat', 'Sandrine', 'rochat.sand@gmail.com', '079 780 55 39', 'Sonnenweg, 1', '3184', 'WÃ¼nnewil'),
(14, 'celimaso@gmail.com', '392842', 3, 'Mayor', 'CÃ©line', 'celimaso@gmail.com', '078 620 81 47', 'Route du Village 17', '1977', 'Icogne'),
(15, 'sandyaurore@yahoo.fr', 'bfc173', 3, 'Michaud ', 'Aurore', 'sandyaurore@yahoo.fr', '079 833 32 52', 'Route du prÃ© de l''Ã©tang 6', '1752', 'Villars-sur-GlÃ¢ne'),
(16, 'melody.auberson@letemps.ch', '7d4c69', 3, 'Auberson', 'MÃ©lody ', 'melody.auberson@letemps.ch', '079 628 19 59', 'Route de la Clochatte 24', '1018', 'Lausanne'),
(17, 'marina.caroselli@gmail.com', '321ac0', 3, 'Caroselli', 'Marina', 'marina.caroselli@gmail.com', '076 446 46 15', 'Bd Paderewski 23', '1800', 'Vevey'),
(18, 'hm.michaud@hotmail.com', '7fa70a', 1, 'Michaud ', 'HÃ©lÃ¨ne', 'hm.michaud@hotmail.com', '026 665 16 84', 'Bellevue 9', '1483', 'Vesin'),
(19, 'hello@stephane-cruchon.com', '64cdd2', 2, 'Cruchon', 'StÃ©phane', 'hello@stephane-cruchon.com', '', '', '', '');

-- --------------------------------------------------------

--
-- Structure de la table `workshops`
--

CREATE TABLE IF NOT EXISTS `workshops` (
  `IdWorkshop` int(10) NOT NULL AUTO_INCREMENT,
  `IdSector` smallint(10) NOT NULL,
  `IdCoach` varchar(10) NOT NULL,
  `TitleWorkshop` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `PlaceWorkshop` text,
  `NbPeriodsWorkshop` int(10) DEFAULT NULL,
  `DateStartWorkshop` date NOT NULL,
  `DateEndWorkshop` date NOT NULL,
  `DescriptionWorkshop` text,
  `PrerequisWorkshop` text CHARACTER SET latin1 NOT NULL,
  `RemarquesWorkshop` text NOT NULL,
  `StatutWorkshop` set('actif','archive','futur') NOT NULL DEFAULT 'actif',
  PRIMARY KEY (`IdWorkshop`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `workshops`
--

INSERT INTO `workshops` (`IdWorkshop`, `IdSector`, `IdCoach`, `TitleWorkshop`, `PlaceWorkshop`, `NbPeriodsWorkshop`, `DateStartWorkshop`, `DateEndWorkshop`, `DescriptionWorkshop`, `PrerequisWorkshop`, `RemarquesWorkshop`, `StatutWorkshop`) VALUES
(1, 2, '1', 'Mobile & Web designer - Automne 2017', 'Lausanne', 117, '2017-09-02', '2017-12-18', '', '', '', 'actif'),
(2, 58, '2', 'UX designer - Automne 2017', '', 57, '2017-10-02', '2017-12-11', '', '', '', 'actif'),
(3, 2, '1', 'Mobile & Web designer - Printemps 2018', 'Lausanne', 32, '2018-03-23', '2018-07-02', 'Description', 'PrÃ©requis', 'Remarques', 'actif');

-- --------------------------------------------------------

--
-- Structure de la table `workshop_answers`
--

CREATE TABLE IF NOT EXISTS `workshop_answers` (
  `IdAnswer` int(11) NOT NULL AUTO_INCREMENT,
  `IdQuestion` int(10) NOT NULL,
  `ValueAnswer` text NOT NULL COMMENT 'INT: 1 a 5; TEXT, SELECT',
  `IdWorkshopUser` int(11) NOT NULL,
  PRIMARY KEY (`IdAnswer`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=159 ;

--
-- Contenu de la table `workshop_answers`
--

INSERT INTO `workshop_answers` (`IdAnswer`, `IdQuestion`, `ValueAnswer`, `IdWorkshopUser`) VALUES
(110, 26, 'La diversitÃ© des salles n''Ã©tait pas dÃ©rangeante, mais dans certaines d''elles les projecteurs n''Ã©taient pas d''une qualitÃ© irrÃ©prochable et lors d''un cours de design ou de retouche photo ceci est tout de mÃªme important.\r\n\r\nAu vu du contenu de chaque module et de la densitÃ© de ceux-ci, la durÃ©e de la formation est un peut courte. Un ou deux mois de plus n''auraient pas Ã©tÃ© de trop car il y avait beaucoup Ã  apprendre. Nous aurions parfois aimÃ© pouvoir Ã©changer un peu plus avec les formateurs.\r\n\r\nDurant cette formation, certains formateurs nous ont demandÃ©s Ã  plusieurs reprises si nous avions dÃ©jÃ  vu tel ou tel sujet durant un prÃ©cÃ©dent module. Je m''attendais Ã  ce qu''ils sachent ce que les autres allaient enseigner, en tout cas dans les grandes lignes, pour Ã©viter de perdre du temps en enseignant deux fois la mÃªme chose.\r\nPeut-Ãªtre qu''une meilleure coordination des contenus des modules enseignÃ©s et un meilleur Ã©change entre les formateurs pourrait palier Ã  ce problÃ¨me', 14),
(109, 25, '1', 14),
(108, 24, '2', 14),
(107, 23, '2', 14),
(106, 22, '1', 14),
(105, 21, '2', 14),
(104, 20, '3', 14),
(103, 19, '2', 14),
(102, 18, '2', 14),
(101, 17, '3', 14),
(111, 28, '2', 14),
(112, 29, '1', 14),
(113, 30, '3', 14),
(114, 31, '3', 14),
(115, 32, '1', 14),
(116, 33, '3', 14),
(117, 34, '3', 14),
(118, 35, '1) Concernant le module "Outils de conception avec Photoshop et Illustrator":\r\nLes niveaux des inscrits Ã©tant trÃ¨s diffÃ©rents, ce module peut Ã  la fois paraÃ®tre pratiquement superflu Ã  certains et Ã  la fois trÃ¨s utile Ã  d''autres.\r\n\r\n2) Concernant le module "Photoshop: Interfaces Web":\r\nCelui-ci a beaucoup Ã©tÃ© axÃ© sur les wireframes, ayant dÃ©jÃ  Ã©tÃ© abordÃ©s durant le module "Ergonomie d''interfaces web", j''ai donc trouvÃ© dommage que le formateur passe du temps Ã  nous montrer comment il a rÃ©alisÃ© les siens, sans forcÃ©ment nous demander comment nous voyions la chose et sans vÃ©ritable partage de solutions. Il aurait Ã©tÃ© intÃ©ressant de voir les faÃ§ons diffÃ©rentes d''aborder le design en confrontant nos idÃ©es, mais surtout de parler design et pas wireframe.\r\nLe module s''est cantonnÃ© Ã  Photoshop alors que tout le monde n''est pas Ã  l''aise avec ce programme et que les possibilitÃ©s alternatives de logiciels de design (Illustrator, Xd ou Sketch par exemple) ne manquent pas, certaines de celles-ci Ã©tant mÃªme plus utilisÃ©es dans le mÃ©tier que Photoshop. \r\nNous avons ensuite rÃ©alisÃ© une maquette. Celle-ci ayant Ã©tÃ© dÃ©jÃ  faite par le formateur, nous l''avons "copiÃ©e" au pixel prÃ¨s, ce qui nous a certes permis de voir certains dÃ©tail dans la rÃ©alisation d''une maquette, mais qui nous a aussi parfois semblÃ© un peu absurde vu que nous n''aurions pas tous eu la mÃªme faÃ§on d''aborder le design de l''exemple en question.', 14),
(119, 36, '1) Je suis consciente qu''il est trÃ¨s difficile de palier Ã  ce problÃ¨me, cette formation s''adressant autant Ã  des personnes venant de la programmation Web dÃ©sireuses de faire plus de design autant Ã  des personnes venant du Design voulant acquÃ©rir des compÃ©tences dans le Design spÃ©cifique du Web. Cette formation, trÃ¨s transversale, s''adresse Ã  beaucoup de monde venant d''horizons trÃ¨s diffÃ©rents et il serait dommage de la fermer Ã  certains.\r\n\r\n2) Il aurait Ã©tÃ© plus intÃ©ressant de montrer un aperÃ§u global des logiciels utilisÃ©s avec avantages et inconvÃ©nients et laisser libre choix de celui-ci aux participants (partie thÃ©orique) et de les laisser rÃ©aliser une maquette selon leurs propres wireframes, rÃ©alisÃ©s durant le module "Ergonomie d''interfaces web" (partie pratique) (peut-Ãªtre un projet suivi durant la formation ou le travail de diplÃ´me cela importe peu) et d''Ãªtre Ã  disposition pour d''Ã©ventuelles questions.', 14),
(120, 37, '3', 14),
(121, 17, '4', 9),
(122, 18, '2', 9),
(123, 19, '4', 9),
(124, 20, '3', 9),
(125, 21, '4', 9),
(126, 22, '2', 9),
(127, 23, '3', 9),
(128, 24, '3', 9),
(129, 25, '4', 9),
(130, 26, '', 9),
(131, 28, '4', 9),
(132, 29, '2', 9),
(133, 30, '3', 9),
(134, 31, '4', 9),
(135, 32, '4', 9),
(136, 33, '4', 9),
(137, 34, '4', 9),
(138, 35, '', 9),
(139, 36, '', 9),
(140, 37, '4', 9),
(141, 17, '4', 16),
(142, 18, '4', 16),
(143, 19, '4', 16),
(144, 20, '4', 16),
(145, 21, '4', 16),
(146, 22, '4', 16),
(147, 23, '4', 16),
(148, 24, '3', 16),
(149, 25, '3', 16),
(150, 26, 'Remarques', 16),
(151, 39, '2', 16),
(152, 40, '4', 16),
(153, 41, '4', 16),
(154, 42, '4', 16),
(155, 43, '4', 16),
(156, 44, 'Modules', 16),
(157, 45, 'Merci', 16),
(158, 46, '3', 16);

-- --------------------------------------------------------

--
-- Structure de la table `workshop_questions`
--

CREATE TABLE IF NOT EXISTS `workshop_questions` (
  `IDQuestion` int(10) NOT NULL AUTO_INCREMENT,
  `Question` varchar(255) CHARACTER SET latin1 NOT NULL,
  `TypeQuestion` smallint(2) NOT NULL COMMENT '1=>Champ; 2=>Zone de texte; 3=>Evaluation 1 à 5; 4=>Oui | Non',
  `IdWorkshop` mediumint(11) NOT NULL,
  `IsActiveQuestion` tinyint(1) NOT NULL COMMENT '0:archive; 1:actif;',
  PRIMARY KEY (`IDQuestion`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=47 ;

--
-- Contenu de la table `workshop_questions`
--

INSERT INTO `workshop_questions` (`IDQuestion`, `Question`, `TypeQuestion`, `IdWorkshop`, `IsActiveQuestion`) VALUES
(16, 'Comment avez-vous apprÃ©ciÃ© :', 0, 0, 1),
(17, 'Les locaux', 3, 0, 1),
(18, 'Lâ€™Ã©quipement mis Ã  la disposition', 3, 0, 1),
(19, 'Lâ€™information gÃ©nÃ©rale', 3, 0, 1),
(20, 'La qualitÃ© de lâ€™enseignement', 3, 0, 1),
(21, 'Le nombre dâ€™intervenants', 3, 0, 1),
(22, 'La durÃ©e de la formation', 3, 0, 1),
(23, 'La documentation', 3, 0, 1),
(24, 'La densitÃ© de la formation', 3, 0, 1),
(25, 'La relation entre les modules', 3, 0, 1),
(26, 'Remarques gÃ©nÃ©rales', 2, 0, 1),
(27, 'Les modules :', 0, 1, 1),
(28, 'La production WebÂ : principes, outils et mÃ©thodes', 3, 1, 1),
(29, 'Outils de conception avec Photoshop et Illustrator', 3, 1, 1),
(30, 'Ergonomie dâ€™interfaces Web', 3, 1, 1),
(31, 'Design & prototypage dâ€™applications mobiles', 3, 1, 1),
(32, 'PhotoshopÂ : Interfaces Web', 3, 1, 1),
(33, 'HTML-CSS', 3, 1, 1),
(34, 'HTML-CSS avancÃ©', 3, 1, 1),
(35, 'Remarques concernant les modules', 2, 1, 1),
(36, 'Quelles amÃ©liorations suggÃ©reriez-vous ?', 2, 1, 1),
(37, 'Recommandreriez-vous cette formation ?', 3, 1, 1),
(38, 'Les modules :', 0, 2, 1),
(39, 'La production Web : principes, outils et mÃ©thodes   ', 3, 2, 1),
(40, 'L''utilisateur : outils et mÃ©thodes d''analyse', 3, 2, 1),
(41, 'IdÃ©ation, mÃ©thodologie UX', 3, 2, 1),
(42, 'Architecture de l''information / Arborescence', 3, 2, 1),
(43, 'Bonnes pratiques dans l''Ã©criture web', 3, 2, 1),
(44, 'Remarques concernant les modules ', 2, 2, 1),
(45, 'Quelles amÃ©liorations suggÃ©reriez-vous ? ', 2, 2, 1),
(46, 'Recommandreriez-vous cette formation ? ', 3, 2, 1);

-- --------------------------------------------------------

--
-- Structure de la table `workshop_user`
--

CREATE TABLE IF NOT EXISTS `workshop_user` (
  `IdUserWorkshop` int(10) NOT NULL AUTO_INCREMENT,
  `IdWorkshop` int(10) NOT NULL,
  `IdUser` int(10) NOT NULL,
  `DateUserWorkshop` date NOT NULL DEFAULT '0000-00-00',
  `StatutUserWorkshop` set('demande','inscrit','suivi','absent') CHARACTER SET latin1 NOT NULL DEFAULT 'demande',
  `IsEvalUserWorkshop` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`IdUserWorkshop`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Contenu de la table `workshop_user`
--

INSERT INTO `workshop_user` (`IdUserWorkshop`, `IdWorkshop`, `IdUser`, `DateUserWorkshop`, `StatutUserWorkshop`, `IsEvalUserWorkshop`) VALUES
(8, 1, 18, '2018-01-12', 'inscrit', 0),
(7, 1, 8, '2018-01-12', 'inscrit', 0),
(9, 1, 12, '2018-01-12', 'inscrit', 1),
(10, 1, 13, '2018-01-12', 'inscrit', 0),
(11, 1, 14, '2018-01-12', 'inscrit', 0),
(12, 1, 15, '2018-01-12', 'inscrit', 0),
(13, 1, 16, '2018-01-12', 'inscrit', 0),
(14, 1, 17, '2018-01-12', 'inscrit', 1),
(16, 2, 8, '2018-01-13', 'inscrit', 1),
(17, 2, 19, '2018-01-13', 'inscrit', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
