-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1:3306
-- Üretim Zamanı: 23 Eyl 2021, 06:43:05
-- Sunucu sürümü: 5.7.31
-- PHP Sürümü: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `versonpos_huseyin`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `anliksiparis`
--

DROP TABLE IF EXISTS `anliksiparis`;
CREATE TABLE IF NOT EXISTS `anliksiparis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `masaid` int(11) DEFAULT NULL,
  `urunid` int(11) DEFAULT NULL,
  `urunad` varchar(30) COLLATE utf8_turkish_ci DEFAULT NULL,
  `urunfiyat` float DEFAULT NULL,
  `adet` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=123 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `doluluk`
--

DROP TABLE IF EXISTS `doluluk`;
CREATE TABLE IF NOT EXISTS `doluluk` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bos` int(11) NOT NULL DEFAULT '0',
  `dolu` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `doluluk`
--

INSERT INTO `doluluk` (`id`, `bos`, `dolu`) VALUES
(1, 18, 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `gecicimasa`
--

DROP TABLE IF EXISTS `gecicimasa`;
CREATE TABLE IF NOT EXISTS `gecicimasa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `masaid` int(11) DEFAULT NULL,
  `masaad` varchar(30) COLLATE utf8_turkish_ci DEFAULT NULL,
  `hasilat` float DEFAULT NULL,
  `adet` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `geciciurun`
--

DROP TABLE IF EXISTS `geciciurun`;
CREATE TABLE IF NOT EXISTS `geciciurun` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `urunid` int(11) DEFAULT NULL,
  `urunad` varchar(30) COLLATE utf8_turkish_ci DEFAULT NULL,
  `hasilat` float DEFAULT NULL,
  `adet` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kategori`
--

DROP TABLE IF EXISTS `kategori`;
CREATE TABLE IF NOT EXISTS `kategori` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ad` varchar(50) COLLATE utf8_turkish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `kategori`
--

INSERT INTO `kategori` (`id`, `ad`) VALUES
(1, 'Sıcak içecekler'),
(2, 'Soğuk İçecekler'),
(3, 'Tatlılar'),
(4, 'Pizzalar'),
(5, 'tantuni'),
(9, 'Hamburger'),
(8, 'Dondurma');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `masalar`
--

DROP TABLE IF EXISTS `masalar`;
CREATE TABLE IF NOT EXISTS `masalar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ad` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `masalar`
--

INSERT INTO `masalar` (`id`, `ad`) VALUES
(1, 'Masa-1'),
(2, 'Masa-2'),
(3, 'Ms- 3'),
(4, 'Ms- 4'),
(5, 'Ms- 5'),
(6, 'Ms- 6'),
(7, 'Ms- 7'),
(8, 'Ms- 8'),
(9, 'Ms- 9'),
(10, 'Ms- 10'),
(11, 'Ms- 11'),
(12, 'Ms- 12'),
(26, 'Ms-15'),
(27, 'Ms-16'),
(24, 'Ms-13'),
(25, 'Ms-14'),
(28, 'Ms-17'),
(29, 'Ms-19');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `rapor`
--

DROP TABLE IF EXISTS `rapor`;
CREATE TABLE IF NOT EXISTS `rapor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `masaid` int(11) DEFAULT NULL,
  `urunid` int(11) DEFAULT NULL,
  `urunad` varchar(30) COLLATE utf8_turkish_ci DEFAULT NULL,
  `urunfiyat` float DEFAULT NULL,
  `adet` int(11) DEFAULT NULL,
  `tarih` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=49 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `rapor`
--

INSERT INTO `rapor` (`id`, `masaid`, `urunid`, `urunad`, `urunfiyat`, `adet`, `tarih`) VALUES
(1, 1, 7, 'Cay', 3, 2, '2021-09-13'),
(2, 1, 4, 'Dürüm Et Tantuni', 16, 3, '2021-09-13'),
(3, 1, 1, 'Yar?m Tavuk Tantuni', 10, 3, '2021-09-13'),
(4, 2, 6, 'Kutu Fanta', 5, 3, '2021-09-14'),
(5, 2, 5, 'Kutu Cola', 5, 5, '2021-09-14'),
(6, 2, 8, 'Küçük Ayran', 2, 15, '2021-09-14'),
(7, 6, 7, 'Cay', 3, 4, '2021-09-17'),
(8, 6, 4, 'Dürüm Et Tantuni', 16, 4, '2021-09-17'),
(9, 1, 7, 'Cay', 3, 3, '2021-09-20'),
(10, 2, 4, 'Dürüm Et Tantuni', 16, 5, '2021-09-20'),
(11, 2, 9, 'kemalpa?a', 4, 4, '2021-09-20'),
(12, 2, 7, 'Cay', 3, 12, '2021-09-20'),
(13, 3, 5, 'Kutu Cola', 5, 1, '2021-09-20'),
(14, 3, 9, 'kemalpa?a', 4, 3, '2021-09-20'),
(15, 4, 7, 'Cay', 3, 2, '2021-09-20'),
(16, 5, 5, 'Kutu Cola', 5, 4, '2021-09-20'),
(17, 6, 9, 'kemalpa?a', 4, 7, '2021-09-20'),
(18, 7, 7, 'Cay', 3, 2, '2021-09-20'),
(19, 7, 9, 'kemalpa?a', 4, 5, '2021-09-20'),
(20, 8, 10, 'künefe', 2, 4, '2021-09-20'),
(21, 9, 5, 'Kutu Cola', 5, 3, '2021-09-20'),
(22, 10, 5, 'Kutu Cola', 5, 4, '2021-09-20'),
(23, 2, 20, 'yar?m köfte ekmek', 12, 4, '2021-09-20'),
(24, 3, 6, 'Kutu Fanta', 5, 1, '2021-09-21'),
(25, 3, 20, 'yar?m köfte ekmek', 12, 10, '2021-09-21'),
(26, 2, 5, 'Kutu Cola', 5, 3, '2021-09-21'),
(27, 1, 20, 'yar?m köfte ekmek', 12, 3, '2021-09-21'),
(28, 1, 4, 'Dürüm Et Tantuni', 16, 3, '2021-09-21'),
(29, 1, 12, 'Kar???k Pizza orta', 30, 8, '2021-09-21'),
(30, 1, 5, 'Kutu Cola', 5, 2, '2021-09-21'),
(31, 9, 4, 'Dürüm Et Tantuni', 16, 12, '2021-09-21'),
(32, 9, 20, 'yar?m köfte ekmek', 12, 5, '2021-09-21'),
(33, 12, 7, 'Cay', 3, 2, '2021-09-21'),
(34, 1, 20, 'yar?m köfte ekmek', 12, 8, '2021-09-22'),
(35, 1, 4, 'Dürüm Et Tantuni', 16, 4, '2021-09-22'),
(36, 1, 12, 'Kar???k Pizza orta', 30, 2, '2021-09-22'),
(37, 2, 9, 'kemalpa?a', 4, 3, '2021-09-22'),
(38, 2, 20, 'yar?m köfte ekmek', 12, 7, '2021-09-22'),
(39, 2, 12, 'Kar???k Pizza orta', 30, 3, '2021-09-22'),
(40, 1, 20, 'yar?m köfte ekmek', 12, 8, '2021-09-22'),
(41, 1, 22, 'Çay', 5, 3, '2021-09-22'),
(42, 1, 23, 'Capichino', 10, 3, '2021-09-22'),
(43, 1, 5, 'Kutu Cola', 5, 2, '2021-09-22'),
(44, 1, 24, 'Sütlü Kahve', 10, 3, '2021-09-22'),
(45, 1, 20, 'yar?m köfte ekmek', 12, 2, '2021-09-22'),
(46, 1, 20, 'yar?m köfte ekmek', 12, 5, '2021-09-22'),
(47, 1, 4, 'Dürüm Et Tantuni', 16, 2, '2021-09-22'),
(48, 1, 4, 'Dürüm Et Tantuni', 16, 3, '2021-09-22');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `urunler`
--

DROP TABLE IF EXISTS `urunler`;
CREATE TABLE IF NOT EXISTS `urunler` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `katid` int(11) NOT NULL,
  `ad` varchar(50) COLLATE utf8_turkish_ci NOT NULL,
  `fiyat` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `urunler`
--

INSERT INTO `urunler` (`id`, `katid`, `ad`, `fiyat`) VALUES
(24, 1, 'Sütlü Kahve', 10),
(4, 5, 'Dürüm Et Tantuni', 16),
(5, 2, 'Kutu Cola', 5),
(6, 2, 'Kutu Fanta', 5),
(22, 1, 'Çay', 5),
(9, 3, 'kemalpaşa', 4),
(10, 3, 'künefe', 2),
(23, 1, 'Capichino', 10),
(12, 4, 'Karışık Pizza orta', 30),
(13, 4, 'Karışık Pizza Büyük', 40),
(14, 4, 'Ssosyal Pizza Küçük', 16),
(20, 8, 'yarım köfte ekmek', 12);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `yonetim`
--

DROP TABLE IF EXISTS `yonetim`;
CREATE TABLE IF NOT EXISTS `yonetim` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kulad` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `sifre` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `yonetim`
--

INSERT INTO `yonetim` (`id`, `kulad`, `sifre`) VALUES
(1, 'huseyin', '021c6cd3a69730ac97d0b65576a9004f');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
