-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 17. Mai 2021 um 15:54
-- Server-Version: 10.4.18-MariaDB
-- PHP-Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `shopdb`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `contact`
--

CREATE TABLE `contact` (
                           `PK_contact` int(11) NOT NULL,
                           `email` varchar(255) NOT NULL,
                           `subject` varchar(255) NOT NULL,
                           `text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `products`
--

CREATE TABLE `products` (
                            `PK_product` int(11) NOT NULL,
                            `productname` varchar(255) COLLATE utf8_german2_ci NOT NULL,
                            `price` float NOT NULL,
                            `status` enum('available','sold_out') COLLATE utf8_german2_ci NOT NULL,
                            `upload_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_german2_ci;

--
-- Daten für Tabelle `products`
--

INSERT INTO `products` (`PK_product`, `productname`, `price`, `status`, `upload_date`) VALUES
                                                                                           (1, 'M2L REFLECTIVE TURKER CAPS', 20, 'available', '2021-05-08 15:14:16'),
                                                                                           (3, 'Basic T-Shirt', 12.99, 'available', '2021-05-10 13:22:31'),
                                                                                           (4, 'Basic Hoodie Schwarz', 33, 'sold_out', '2021-05-10 14:59:54');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `product_colors`
--

CREATE TABLE `product_colors` (
                                  `FK_product` int(11) NOT NULL,
                                  `FK_color` varchar(10) COLLATE utf8_german2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_german2_ci;

--
-- Daten für Tabelle `product_colors`
--

INSERT INTO `product_colors` (`FK_product`, `FK_color`) VALUES
                                                            (1, '1'),
                                                            (1, '2'),
                                                            (3, '3'),
                                                            (3, '4'),
                                                            (4, '5');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `product_images`
--

CREATE TABLE `product_images` (
                                  `FK_product` int(11) NOT NULL,
                                  `pictureurl` varchar(1000) COLLATE utf8_german2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_german2_ci;

--
-- Daten für Tabelle `product_images`
--

INSERT INTO `product_images` (`FK_product`, `pictureurl`) VALUES
                                                              (1, 'IMG-5511.jpg'),
                                                              (1, 'IMG-5519.jpg'),
                                                              (1, 'IMG-5521.jpg'),
                                                              (3, '4767365c8d9a4f59960c586d79a8d3b8.jpg'),
                                                              (4, 'Large_Logo_Crop_Hoodie_Schwarz_GD2404_21_model.jpg');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `shop_colors`
--

CREATE TABLE `shop_colors` (
                               `PK_color` int(11) NOT NULL,
                               `color_tag` varchar(255) COLLATE utf8_german2_ci NOT NULL,
                               `colorcode` varchar(255) COLLATE utf8_german2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_german2_ci;

--
-- Daten für Tabelle `shop_colors`
--

INSERT INTO `shop_colors` (`PK_color`, `color_tag`, `colorcode`) VALUES
                                                                     (1, 'blue', '#0026ff'),
                                                                     (2, 'red', '#ff0000'),
                                                                     (3, 'pink', '#ff00ff'),
                                                                     (4, 'white', '#ffffff'),
                                                                     (5, 'black', '#000000');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `contact`
--
ALTER TABLE `contact`
    ADD PRIMARY KEY (`PK_contact`);

--
-- Indizes für die Tabelle `products`
--
ALTER TABLE `products`
    ADD PRIMARY KEY (`PK_product`);

--
-- Indizes für die Tabelle `product_colors`
--
ALTER TABLE `product_colors`
    ADD PRIMARY KEY (`FK_product`,`FK_color`);

--
-- Indizes für die Tabelle `product_images`
--
ALTER TABLE `product_images`
    ADD PRIMARY KEY (`FK_product`,`pictureurl`);

--
-- Indizes für die Tabelle `shop_colors`
--
ALTER TABLE `shop_colors`
    ADD PRIMARY KEY (`PK_color`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `contact`
--
ALTER TABLE `contact`
    MODIFY `PK_contact` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT für Tabelle `products`
--
ALTER TABLE `products`
    MODIFY `PK_product` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT für Tabelle `shop_colors`
--
ALTER TABLE `shop_colors`
    MODIFY `PK_color` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `product_colors`
--
ALTER TABLE `product_colors`
    ADD CONSTRAINT `product_colors_ibfk_1` FOREIGN KEY (`FK_product`) REFERENCES `products` (`PK_product`);

--
-- Constraints der Tabelle `product_images`
--
ALTER TABLE `product_images`
    ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`FK_product`) REFERENCES `products` (`PK_product`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;