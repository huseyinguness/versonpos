-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 25 Eki 2021, 18:39:03
-- Sunucu sürümü: 10.4.21-MariaDB
-- PHP Sürümü: 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `versonpos`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `anliksiparis`
--

CREATE TABLE `anliksiparis` (
  `id` int(11) NOT NULL,
  `masaid` int(11) NOT NULL,
  `garsonid` int(11) NOT NULL,
  `urunid` int(11) NOT NULL,
  `urunad` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `urunfiyat` float NOT NULL,
  `adet` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `anliksiparis`
--

INSERT INTO `anliksiparis` (`id`, `masaid`, `garsonid`, `urunid`, `urunad`, `urunfiyat`, `adet`) VALUES
(349, 25, 1, 19, 'Tavuklu Ham.', 8, 4),
(350, 21, 1, 11, 'Şarap', 27.9, 4),
(352, 16, 1, 6, 'Sütlaç', 12.5, 5),
(353, 16, 1, 56, 'Ezogelin Ç.', 9, 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `bolumler`
--

CREATE TABLE `bolumler` (
  `id` int(11) NOT NULL,
  `ad` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `renk` varchar(30) COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `bolumler`
--

INSERT INTO `bolumler` (`id`, `ad`, `renk`) VALUES
(1, 'SALON', 'success'),
(2, 'BAHÇE', 'info'),
(3, 'BALKON', 'warning'),
(4, 'TERAS', 'dark');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `doluluk`
--

CREATE TABLE `doluluk` (
  `id` int(11) NOT NULL,
  `bos` int(11) NOT NULL DEFAULT 0,
  `dolu` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `doluluk`
--

INSERT INTO `doluluk` (`id`, `bos`, `dolu`) VALUES
(1, 3, 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `garson`
--

CREATE TABLE `garson` (
  `id` int(11) NOT NULL,
  `ad` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `sifre` int(11) NOT NULL,
  `durum` tinyint(1) NOT NULL DEFAULT 0,
  `AktifBolum` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `garson`
--

INSERT INTO `garson` (`id`, `ad`, `sifre`, `durum`, `AktifBolum`) VALUES
(1, 'arda', 1, 1, 4),
(11, 'huseyin', 1, 0, 0),
(12, 'songül', 1, 0, 0),
(13, 'ahmet', 1, 0, 0),
(14, 'ekrem', 1, 0, 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `gecicigarson`
--

CREATE TABLE `gecicigarson` (
  `id` int(11) NOT NULL,
  `garsonid` int(11) NOT NULL,
  `garsonad` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `hasilat` float NOT NULL,
  `adet` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `gecicigarson`
--

INSERT INTO `gecicigarson` (`id`, `garsonid`, `garsonad`, `hasilat`, `adet`) VALUES
(1, 1, 'arda', 3602.31, 352);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `gecicimasa`
--

CREATE TABLE `gecicimasa` (
  `id` int(11) NOT NULL,
  `masaid` int(11) NOT NULL,
  `masaad` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `hasilat` float NOT NULL,
  `adet` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `gecicimasa`
--

INSERT INTO `gecicimasa` (`id`, `masaid`, `masaad`, `hasilat`, `adet`) VALUES
(1, 3, 'MS-3', 253.12, 18),
(2, 4, 'MS-4', 129, 10),
(3, 11, 'MS-11', 46, 5),
(4, 25, 'Ms-100', 36, 4);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `geciciodeme`
--

CREATE TABLE `geciciodeme` (
  `id` int(11) NOT NULL,
  `secenek` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `hasilat` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `geciciodeme`
--

INSERT INTO `geciciodeme` (`id`, `secenek`, `hasilat`) VALUES
(1, 'Nakit', 332.12),
(2, 'Kredi Kartı', 60),
(3, 'Y.Kartı', 72);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `geciciurun`
--

CREATE TABLE `geciciurun` (
  `id` int(11) NOT NULL,
  `urunid` int(11) NOT NULL,
  `urunad` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `hasilat` float NOT NULL,
  `adet` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `geciciurun`
--

INSERT INTO `geciciurun` (`id`, `urunid`, `urunad`, `hasilat`, `adet`) VALUES
(1, 3, 'Su', 1.58449, 1),
(2, 37, 'Bol Malzeme', 101.535, 8),
(3, 16, 'Kahvaltı', 160, 8),
(4, 28, 'Bira', 24, 2),
(5, 36, 'Profitol', 45, 5),
(6, 6, 'Sütlaç', 50, 4),
(7, 20, 'Sahlep', 10, 2),
(8, 5, 'Keşkül', 36, 3),
(9, 56, 'Ezogelin Ç.', 36, 4);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kasiyer`
--

CREATE TABLE `kasiyer` (
  `id` int(11) NOT NULL,
  `ad` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `sifre` int(11) NOT NULL,
  `durum` tinyint(1) NOT NULL DEFAULT 0,
  `AktifBolum` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `kasiyer`
--

INSERT INTO `kasiyer` (`id`, `ad`, `sifre`, `durum`, `AktifBolum`) VALUES
(1, 'arda2', 1, 0, 0),
(11, 'huseyin2', 1, 0, 0),
(12, 'songül2', 1, 0, 0),
(13, 'ahmet2', 1, 0, 0),
(14, 'ekrem2', 1, 0, 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kategori`
--

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL,
  `ad` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `mutfakdurum` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `kategori`
--

INSERT INTO `kategori` (`id`, `ad`, `mutfakdurum`) VALUES
(1, 'Sıcak İçecekler', 0),
(2, 'Soğuk İçecekler', 0),
(3, 'Tatlılar', 0),
(4, 'Pizzalar', 0),
(5, 'Tostlar', 0),
(6, 'Makarnalar', 0),
(7, 'Alkollü İçecekler', 0),
(8, 'Kahvaltı', 0),
(9, 'Salatalar', 0),
(10, 'Hamburgerler', 0),
(14, 'Ara Sıcak', 0),
(15, 'Çorbalar', 0),
(16, 'Balıklar', 0),
(17, 'Çocuk Menü', 0),
(18, 'Izgaralar', 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `masabakiye`
--

CREATE TABLE `masabakiye` (
  `id` int(11) NOT NULL,
  `masaid` int(11) NOT NULL,
  `tutar` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `masalar`
--

CREATE TABLE `masalar` (
  `id` int(11) NOT NULL,
  `ad` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `durum` int(11) NOT NULL DEFAULT 0,
  `saat` int(11) NOT NULL DEFAULT 0,
  `dakika` int(11) NOT NULL DEFAULT 0,
  `rezervedurum` int(11) NOT NULL DEFAULT 0,
  `kisi` varchar(50) COLLATE utf8_turkish_ci NOT NULL DEFAULT 'bos',
  `rezervesaat` varchar(5) COLLATE utf8_turkish_ci NOT NULL DEFAULT '00:00',
  `kategori` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `masalar`
--

INSERT INTO `masalar` (`id`, `ad`, `durum`, `saat`, `dakika`, `rezervedurum`, `kisi`, `rezervesaat`, `kategori`) VALUES
(1, 'MS-1', 0, 0, 0, 0, 'Yok', '17:00', 1),
(2, 'MS-2', 0, 0, 0, 0, 'Yok', '', 1),
(3, 'MS-3', 0, 0, 0, 0, 'Yok', 'demne', 1),
(4, 'MS-4', 0, 0, 0, 0, 'Yok', '15:00', 1),
(5, 'MS-5', 0, 0, 0, 0, 'bos', '00:00', 2),
(6, 'MS-6', 0, 0, 0, 0, 'Yok', '19:00', 2),
(7, 'MS-7', 0, 0, 0, 0, 'bos', '00:00', 2),
(8, 'MS-8', 0, 0, 0, 0, 'Yok', '20:00', 2),
(9, 'MS-9', 0, 0, 0, 0, 'bos', '00:00', 2),
(10, 'MS-10', 0, 0, 0, 0, 'yok', '00:00', 2),
(11, 'MS-11', 0, 0, 0, 0, 'yok', '00:00', 3),
(12, 'MS-12', 0, 0, 0, 0, 'bos', '00:00', 3),
(13, 'MS-13', 0, 0, 0, 0, 'bos', '00:00', 3),
(14, 'MS-14', 0, 0, 0, 0, 'bos', '00:00', 3),
(15, 'MS-15', 0, 0, 0, 0, 'Yok', '00:00', 4),
(16, 'MS-16', 1, 18, 32, 0, 'yok', '00:00', 4),
(17, 'MS-17', 0, 0, 0, 0, 'yok', '00:00', 4),
(18, 'MS-18', 0, 0, 0, 0, 'bos', '00:00', 4);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `mutfak`
--

CREATE TABLE `mutfak` (
  `id` int(11) NOT NULL,
  `ad` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `sifre` int(11) NOT NULL,
  `durum` tinyint(1) NOT NULL DEFAULT 0,
  `AktifBolum` int(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `mutfak`
--

INSERT INTO `mutfak` (`id`, `ad`, `sifre`, `durum`, `AktifBolum`) VALUES
(1, 'arda3', 1, 0, 0),
(11, 'huseyin3', 1, 0, 0),
(12, 'songül3', 1, 0, 0),
(13, 'ahmet3', 1, 0, 0),
(14, 'ekrem3', 1, 0, 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `mutfaksiparis`
--

CREATE TABLE `mutfaksiparis` (
  `id` int(11) NOT NULL,
  `masaid` int(11) NOT NULL,
  `urunid` int(11) NOT NULL,
  `urunad` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `adet` int(11) NOT NULL,
  `saat` int(11) NOT NULL DEFAULT 0,
  `dakika` int(11) NOT NULL DEFAULT 0,
  `durum` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `mutfaksiparis`
--

INSERT INTO `mutfaksiparis` (`id`, `masaid`, `urunid`, `urunad`, `adet`, `saat`, `dakika`, `durum`) VALUES
(135, 16, 6, 'Sütlaç', 5, 18, 32, 1),
(136, 16, 56, 'Ezogelin Ç.', 1, 18, 32, 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `rapor`
--

CREATE TABLE `rapor` (
  `id` int(11) NOT NULL,
  `masaid` int(11) NOT NULL,
  `garsonid` int(11) NOT NULL,
  `urunid` int(11) NOT NULL,
  `urunad` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `urunfiyat` float NOT NULL,
  `adet` int(11) NOT NULL,
  `odemesecenek` varchar(30) COLLATE utf8_turkish_ci NOT NULL DEFAULT 'Nakit',
  `tarih` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `rapor`
--

INSERT INTO `rapor` (`id`, `masaid`, `garsonid`, `urunid`, `urunad`, `urunfiyat`, `adet`, `odemesecenek`, `tarih`) VALUES
(283, 5, 1, 16, 'Kahvaltı', 20, 5, 'Nakit', '2021-10-03'),
(284, 2, 1, 16, 'Kahvaltı', 20, 5, 'Nakit', '2021-10-03'),
(285, 2, 1, 11, 'Şarap', 27.9, 4, 'Nakit', '2021-10-03'),
(286, 2, 1, 19, 'Tavuklu Ham.', 8, 5, 'Nakit', '2021-10-03'),
(287, 2, 1, 5, 'Keşkül', 12, 5, 'Nakit', '2021-10-03'),
(288, 3, 1, 16, 'Kahvaltı', 20, 5, 'Nakit', '2021-10-03'),
(289, 5, 1, 56, 'Ezogelin Ç.', 9, 5, 'Nakit', '2021-10-04'),
(290, 6, 1, 47, 'Balık Çorbası', -8.88178e-16, 5, 'Nakit', '2021-10-04'),
(291, 6, 1, 46, 'Karides Güveç', 14, 4, 'Nakit', '2021-10-04'),
(292, 6, 1, 45, 'Lüfer Izgara', 30, 2, 'Nakit', '2021-10-04'),
(293, 6, 1, 16, 'Kahvaltı', 20, 1, 'Nakit', '2021-10-04'),
(294, 6, 1, 5, 'Keşkül', 12, 3, 'Nakit', '2021-10-04'),
(295, 6, 1, 52, 'Mücver', 6, 9, 'Nakit', '2021-10-04'),
(296, 6, 1, 19, 'Tavuklu Ham.', 8, 5, 'Nakit', '2021-10-04'),
(297, 6, 1, 50, 'Avcı Böreği', 7.2, 9, 'Nakit', '2021-10-04'),
(298, 6, 1, 38, 'Köfte Burger', 12, 3, 'Nakit', '2021-10-04'),
(299, 2, 1, 23, 'Türk Kahvesi', 6, 3, 'Nakit', '2021-10-04'),
(300, 2, 1, 19, 'Tavuklu Ham.', 8, 8, 'Nakit', '2021-10-04'),
(301, 2, 1, 17, 'Ton Balıklı', 9, 9, 'Nakit', '2021-10-04'),
(302, 2, 1, 52, 'Mücver', 5.4, 5, 'Nakit', '2021-10-04'),
(303, 2, 1, 18, 'Sezar Salata', 8, 5, 'Nakit', '2021-10-04'),
(304, 2, 1, 20, 'Sahlep', 5, 1, 'Nakit', '2021-10-04'),
(305, 2, 1, 3, 'Su', 3, 2, 'Nakit', '2021-10-04'),
(306, 2, 1, 43, 'Domates Ç.', 9, 4, 'Nakit', '2021-10-04'),
(307, 3, 1, 30, 'Votka', 23.328, 2, 'Nakit', '2021-10-05'),
(308, 3, 1, 43, 'Domates Ç.', 4.6656, 3, 'Nakit', '2021-10-05'),
(309, 3, 1, 47, 'Balık Çorbası', 3.6288, 3, 'Nakit', '2021-10-05'),
(310, 3, 1, 16, 'Kahvaltı', 10.368, 4, 'Nakit', '2021-10-05'),
(311, 3, 1, 7, 'Mozeralla', 10.368, 1, 'Nakit', '2021-10-05'),
(312, 3, 1, 38, 'Köfte Burger', 6.2208, 4, 'Nakit', '2021-10-05'),
(313, 3, 1, 39, 'Kıymalı Makarna', 4.6656, 7, 'Nakit', '2021-10-05'),
(314, 3, 1, 51, 'Humus', 3.1104, 3, 'Nakit', '2021-10-05'),
(315, 3, 1, 56, 'Ezogelin Ç.', 4.6656, 2, 'Nakit', '2021-10-05'),
(316, 3, 1, 57, 'Yayla Ç.', 4.6656, 3, 'Nakit', '2021-10-05'),
(317, 2, 1, 7, 'Mozeralla', 20, 2, 'Nakit', '2021-10-06'),
(318, 4, 1, 43, 'Domates Ç.', 4.6656, 5, 'Nakit', '2021-10-06'),
(319, 4, 1, 4, 'Soda', 2.75, 1, 'Nakit', '2021-10-06'),
(320, 4, 1, 19, 'Tavuklu Ham.', 8, 2, 'Nakit', '2021-10-06'),
(321, 4, 1, 50, 'Avcı Böreği', 8, 1, 'Nakit', '2021-10-06'),
(322, 4, 1, 51, 'Humus', 3.1104, 2, 'Nakit', '2021-10-06'),
(323, 4, 1, 53, 'Köfte Menü', 8.1, 1, 'Nakit', '2021-10-06'),
(324, 3, 1, 58, 'Adana K.', 18, 1, 'Nakit', '2021-10-06'),
(325, 3, 1, 11, 'Şarap', 27.9, 1, 'Nakit', '2021-10-06'),
(326, 2, 1, 28, 'Bira', 12, 1, 'Nakit', '2021-10-07'),
(327, 2, 1, 49, 'Paçanga', 6, 1, 'Y.Kartı', '2021-10-07'),
(328, 4, 1, 60, 'Kanat', 16, 3, 'Y.Kartı', '2021-10-08'),
(329, 4, 1, 58, 'Adana K.', 18, 2, 'Y.Kartı', '2021-10-08'),
(330, 4, 1, 6, 'Sütlaç', 12.5, 1, 'Y.Kartı', '2021-10-08'),
(331, 4, 1, 56, 'Ezogelin Ç.', 9, 2, 'Kredi Kartı', '2021-10-08'),
(332, 4, 1, 7, 'Mozeralla', 20, 1, 'Kredi Kartı', '2021-10-08'),
(333, 4, 1, 56, 'Ezogelin Ç.', 9, 1, 'Kredi Kartı', '2021-10-08'),
(334, 4, 1, 56, 'Ezogelin Ç.', 9, 1, 'Kredi Kartı', '2021-10-08'),
(335, 4, 1, 59, 'Lahmacun', 6, 1, 'Kredi Kartı', '2021-10-08'),
(336, 4, 1, 16, 'Kahvaltı', 20, 2, 'Kredi Kartı', '2021-10-08'),
(337, 4, 1, 32, 'M. Suyu - Vişne', 5, 1, 'Kredi Kartı', '2021-10-08'),
(338, 4, 1, 19, 'Tavuklu Ham.', 8, 1, 'Kredi Kartı', '2021-10-08'),
(339, 4, 1, 28, 'Bira', 12, 2, 'Kredi Kartı', '2021-10-08'),
(340, 4, 1, 28, 'Bira', 12, 1, 'Y.Kartı', '2021-10-08'),
(341, 3, 1, 37, 'Bol Malzeme', 18, 3, 'Nakit', '2021-10-08'),
(342, 3, 1, 36, 'Profitol', 9, 5, 'Kredi Kartı', '2021-10-08'),
(343, 3, 1, 6, 'Sütlaç', 12.5, 3, 'Nakit', '2021-10-09'),
(344, 3, 1, 37, 'Bol Malzeme', 18, 2, 'Nakit', '2021-10-09'),
(345, 3, 1, 43, 'Domates Ç.', 9, 2, 'Nakit', '2021-10-09'),
(346, 5, 1, 4, 'Soda', 2.75, 1, 'Kredi Kartı', '2021-10-09'),
(347, 5, 1, 52, 'Mücver', 6, 5, 'Kredi Kartı', '2021-10-09'),
(348, 3, 1, 3, 'Su', 3, 4, 'Nakit', '2021-10-10'),
(349, 3, 1, 3, 'Su', 3, 4, 'Nakit', '2021-10-10'),
(350, 3, 1, 3, 'Su', 3, 4, 'Kredi Kartı', '2021-10-10'),
(351, 3, 1, 3, 'Su', 3, 4, 'Kredi Kartı', '2021-10-10'),
(352, 4, 1, 56, 'Ezogelin Ç.', 9, 5, '', '2021-10-10'),
(353, 4, 1, 56, 'Ezogelin Ç.', 9, 5, '', '2021-10-10'),
(354, 4, 1, 56, 'Ezogelin Ç.', 9, 5, 'Y.Kartı', '2021-10-10'),
(355, 4, 1, 56, 'Ezogelin Ç.', 9, 5, 'Y.Kartı', '2021-10-10'),
(356, 4, 1, 56, 'Ezogelin Ç.', 9, 5, 'Nakit', '2021-10-10'),
(357, 4, 1, 56, 'Ezogelin Ç.', 9, 5, 'Nakit', '2021-10-10'),
(358, 4, 1, 56, 'Ezogelin Ç.', 9, 5, 'Nakit', '2021-10-10'),
(359, 3, 1, 3, 'Su', 3, 4, 'Kredi Kartı', '2021-10-10'),
(360, 3, 1, 50, 'Avcı Böreği', 8, 2, 'Kredi Kartı', '2021-10-10'),
(361, 3, 1, 6, 'Sütlaç', 12.5, 2, 'Kredi Kartı', '2021-10-10'),
(362, 3, 1, 6, 'Sütlaç', 12.5, 2, 'Kredi Kartı', '2021-10-10'),
(363, 3, 1, 6, 'Sütlaç', 12.5, 2, 'Nakit', '2021-10-10'),
(364, 3, 1, 6, 'Sütlaç', 12.5, 2, 'Nakit', '2021-10-10'),
(365, 3, 1, 6, 'Sütlaç', 12.5, 2, 'Nakit', '2021-10-10'),
(366, 3, 1, 3, 'Su', 3, 4, 'Nakit', '2021-10-10'),
(367, 3, 1, 21, 'Limonata', 6, 5, 'Nakit', '2021-10-10'),
(368, 3, 1, 6, 'Sütlaç', 12.5, 2, 'Nakit', '2021-10-10'),
(369, 3, 1, 36, 'Profitol', 9, 3, 'Kredi Kartı', '2021-10-10'),
(370, 3, 1, 27, 'Cola', 3, 2, 'Kredi Kartı', '2021-10-10'),
(371, 3, 1, 15, 'Sade Makarna', 8.95, 3, 'Kredi Kartı', '2021-10-10'),
(372, 3, 1, 16, 'Kahvaltı', 20, 3, 'Kredi Kartı', '2021-10-10'),
(373, 10, 1, 16, 'Kahvaltı', 20, 2, 'Nakit', '2021-10-11'),
(374, 1, 1, 39, 'Kıymalı Makarna', 9, 1, 'Kredi Kartı', '2021-10-11'),
(375, 2, 1, 16, 'Kahvaltı', 20, 1, 'Y.Kartı', '2021-10-11'),
(376, 7, 1, 37, 'Bol Malzeme', 18, 1, 'Kredi Kartı', '2021-10-11'),
(377, 7, 1, 28, 'Bira', 12, 2, 'Kredi Kartı', '2021-10-11'),
(378, 7, 1, 55, 'Somon Menü', 11, 4, 'Kredi Kartı', '2021-10-11'),
(379, 7, 1, 11, 'Şarap', 27.9, 2, 'Kredi Kartı', '2021-10-11'),
(380, 2, 1, 60, 'Kanat', 16, 2, 'Nakit', '2021-10-12'),
(381, 2, 1, 16, 'Kahvaltı', 20, 5, 'Nakit', '2021-10-12'),
(382, 5, 1, 6, 'Sütlaç', 12.5, 1, 'Kredi Kartı', '2021-10-21'),
(383, 5, 1, 56, 'Ezogelin Ç.', 9, 3, 'Kredi Kartı', '2021-10-21'),
(384, 3, 1, 3, 'Su', 1.58449, 1, 'Nakit', '2021-10-24'),
(385, 3, 1, 37, 'Bol Malzeme', 9.50706, 5, 'Nakit', '2021-10-24'),
(386, 3, 1, 16, 'Kahvaltı', 20, 5, 'Nakit', '2021-10-24'),
(387, 3, 1, 37, 'Bol Malzeme', 18, 3, 'Nakit', '2021-10-24'),
(388, 4, 1, 28, 'Bira', 12, 2, 'Nakit', '2021-10-24'),
(389, 4, 1, 16, 'Kahvaltı', 20, 3, 'Nakit', '2021-10-24'),
(390, 4, 1, 36, 'Profitol', 9, 5, 'Nakit', '2021-10-24'),
(391, 3, 1, 6, 'Sütlaç', 12.5, 4, 'Kredi Kartı', '2021-10-24'),
(392, 11, 1, 20, 'Sahlep', 5, 2, 'Kredi Kartı', '2021-10-24'),
(393, 11, 1, 5, 'Keşkül', 12, 3, 'Y.Kartı', '2021-10-24'),
(394, 25, 1, 56, 'Ezogelin Ç.', 9, 4, 'Y.Kartı', '2021-10-24'),
(395, 2, 1, 66, 'deneme55', 16.2, 5, 'Kredi Kartı', '2021-10-25'),
(396, 3, 1, 51, 'Humus', 6, 2, 'Y.Kartı', '2021-10-25'),
(397, 4, 1, 37, 'Bol Malzeme', 18, 5, 'Kredi Kartı', '2021-10-25'),
(398, 4, 1, 16, 'Kahvaltı', 20, 5, 'Kredi Kartı', '2021-10-25'),
(399, 17, 1, 51, 'Humus', 6, 5, 'Kredi Kartı', '2021-10-25'),
(400, 18, 1, 6, 'Sütlaç', 4.50412, 3, 'Y.Kartı', '2021-10-25');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `urunler`
--

CREATE TABLE `urunler` (
  `id` int(11) NOT NULL,
  `katid` int(11) NOT NULL,
  `ad` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `fiyat` float NOT NULL,
  `stok` varchar(11) COLLATE utf8_turkish_ci NOT NULL DEFAULT 'Yok'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `urunler`
--

INSERT INTO `urunler` (`id`, `katid`, `ad`, `fiyat`, `stok`) VALUES
(3, 2, 'Su', 3, '305'),
(4, 2, 'Soda', 2.75, 'Yok'),
(5, 3, 'Keşkül', 12, 'Yok'),
(6, 3, 'Sütlaç', 12.5, 'Yok'),
(7, 4, 'Mozeralla', 20, 'Yok'),
(11, 7, 'Şarap', 27.9, 'Yok'),
(12, 5, 'Kaşarlı Tost', 5, 'Yok'),
(14, 6, 'Peynirli', 11, 'Yok'),
(15, 6, 'Sade Makarna', 8.95, 'Yok'),
(16, 8, 'Kahvaltı', 20, 'Yok'),
(17, 9, 'Ton Balıklı', 9, 'Yok'),
(18, 9, 'Sezar Salata', 8, 'Yok'),
(19, 10, 'Tavuklu Ham.', 8, 'Yok'),
(20, 1, 'Sahlep', 5, 'Yok'),
(21, 2, 'Limonata', 6, '146'),
(23, 1, 'Türk Kahvesi', 6, 'Yok'),
(24, 1, 'Bardak Çay', 2, 'Yok'),
(25, 5, 'Sucuklu Tost', 7, 'Yok'),
(26, 9, 'Çoban Salata', 7, 'Yok'),
(27, 2, 'Cola', 3, 'Yok'),
(28, 7, 'Bira', 12, 'Yok'),
(29, 1, 'Nescafe', 4, 'Yok'),
(30, 7, 'Votka', 45, 'Yok'),
(31, 2, 'M. Suyu - Şeftali', 5, 'Yok'),
(32, 2, 'M. Suyu - Vişne', 5, 'Yok'),
(33, 2, 'M. Suyu - Kayısı', 5, 'Yok'),
(34, 2, 'Fanta', 4, 'Yok'),
(35, 2, 'Sprite', 4, 'Yok'),
(36, 3, 'Profitol', 9, 'Yok'),
(37, 4, 'Bol Malzeme', 18, 'Yok'),
(38, 10, 'Köfte Burger', 12, 'Yok'),
(39, 6, 'Kıymalı Makarna', 9, 'Yok'),
(40, 2, 'Ayran', 2, 'Yok'),
(41, 1, 'Ihlamur', 4, 'Yok'),
(42, 15, 'Mercimek Ç.', 9, 'Yok'),
(43, 15, 'Domates Ç.', 9, 'Yok'),
(44, 2, 'Şalgam', 4, 'Yok'),
(45, 16, 'Lüfer Izgara', 30, 'Yok'),
(46, 16, 'Karides Güveç', 14, 'Yok'),
(47, 16, 'Balık Çorbası', 7, 'Yok'),
(48, 16, 'Kalamar', 9, 'Yok'),
(49, 14, 'Paçanga', 6, 'Yok'),
(50, 14, 'Avcı Böreği', 8, 'Yok'),
(51, 14, 'Humus', 6, 'Yok'),
(52, 14, 'Mücver', 6, 'Yok'),
(53, 17, 'Köfte Menü', 9, 'Yok'),
(54, 17, 'Nugget Menü', 8, 'Yok'),
(55, 17, 'Somon Menü', 11, 'Yok'),
(56, 15, 'Ezogelin Ç.', 9, 'Yok'),
(57, 15, 'Yayla Ç.', 9, 'Yok'),
(58, 18, 'Adana K.', 18, 'Yok'),
(59, 18, 'Lahmacun', 6, 'Yok'),
(60, 18, 'Kanat', 16, 'Yok'),
(61, 1, 'Fincan Çay', 3, 'Yok'),
(62, 1, 'Oralet', 3, 'Yok'),
(63, 1, 'Ada Çayı', 4, 'Yok'),
(65, 1, 'deneme', 15, 'Yok'),
(66, 18, 'deneme55', 20, '115'),
(67, 1, 'yarım köfte ekmek', 15, '150');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `yonetim`
--

CREATE TABLE `yonetim` (
  `id` int(11) NOT NULL,
  `kulad` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `adsoyad` varchar(200) COLLATE utf8_turkish_ci NOT NULL,
  `sifre` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `durum` int(11) NOT NULL,
  `yetki` int(11) NOT NULL DEFAULT 0,
  `aktif` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `yonetim`
--

INSERT INTO `yonetim` (`id`, `kulad`, `adsoyad`, `sifre`, `durum`, `yetki`, `aktif`) VALUES
(1, 'admin', 'Hüseyin Güneş', '021c6cd3a69730ac97d0b65576a9004f', 1, 1, 1),
(4, 'arda', 'Arda Güneş', '021c6cd3a69730ac97d0b65576a9004f', 1, 0, 0),
(6, 'songul', 'Songül Güneş', '021c6cd3a69730ac97d0b65576a9004f', 1, 0, 0),
(7, 'ahmet', 'ahmet battal', '021c6cd3a69730ac97d0b65576a9004f', 1, 0, 0),
(8, 'sena', 'sena güneş', '021c6cd3a69730ac97d0b65576a9004f', 1, 0, 0);

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `anliksiparis`
--
ALTER TABLE `anliksiparis`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `bolumler`
--
ALTER TABLE `bolumler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `doluluk`
--
ALTER TABLE `doluluk`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `garson`
--
ALTER TABLE `garson`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `gecicigarson`
--
ALTER TABLE `gecicigarson`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `gecicimasa`
--
ALTER TABLE `gecicimasa`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `geciciodeme`
--
ALTER TABLE `geciciodeme`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `geciciurun`
--
ALTER TABLE `geciciurun`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `kasiyer`
--
ALTER TABLE `kasiyer`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `masabakiye`
--
ALTER TABLE `masabakiye`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `masalar`
--
ALTER TABLE `masalar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `mutfak`
--
ALTER TABLE `mutfak`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `mutfaksiparis`
--
ALTER TABLE `mutfaksiparis`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `rapor`
--
ALTER TABLE `rapor`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `urunler`
--
ALTER TABLE `urunler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `yonetim`
--
ALTER TABLE `yonetim`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `anliksiparis`
--
ALTER TABLE `anliksiparis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=354;

--
-- Tablo için AUTO_INCREMENT değeri `bolumler`
--
ALTER TABLE `bolumler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Tablo için AUTO_INCREMENT değeri `doluluk`
--
ALTER TABLE `doluluk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `garson`
--
ALTER TABLE `garson`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Tablo için AUTO_INCREMENT değeri `gecicigarson`
--
ALTER TABLE `gecicigarson`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `gecicimasa`
--
ALTER TABLE `gecicimasa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `geciciodeme`
--
ALTER TABLE `geciciodeme`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `geciciurun`
--
ALTER TABLE `geciciurun`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Tablo için AUTO_INCREMENT değeri `kasiyer`
--
ALTER TABLE `kasiyer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Tablo için AUTO_INCREMENT değeri `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Tablo için AUTO_INCREMENT değeri `masabakiye`
--
ALTER TABLE `masabakiye`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- Tablo için AUTO_INCREMENT değeri `masalar`
--
ALTER TABLE `masalar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Tablo için AUTO_INCREMENT değeri `mutfak`
--
ALTER TABLE `mutfak`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Tablo için AUTO_INCREMENT değeri `mutfaksiparis`
--
ALTER TABLE `mutfaksiparis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=137;

--
-- Tablo için AUTO_INCREMENT değeri `rapor`
--
ALTER TABLE `rapor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=401;

--
-- Tablo için AUTO_INCREMENT değeri `urunler`
--
ALTER TABLE `urunler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- Tablo için AUTO_INCREMENT değeri `yonetim`
--
ALTER TABLE `yonetim`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
