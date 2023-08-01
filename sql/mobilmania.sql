-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2023. Aug 01. 13:58
-- Kiszolgáló verziója: 10.4.28-MariaDB
-- PHP verzió: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `mobilmania`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `colors`
--

CREATE TABLE `colors` (
  `id_color` int(11) NOT NULL,
  `id_phone` int(11) NOT NULL,
  `color` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `colors`
--

INSERT INTO `colors` (`id_color`, `id_phone`, `color`) VALUES
(150, 73, 'blue'),
(151, 73, 'black');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `contact`
--

CREATE TABLE `contact` (
  `id_contact` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` int(11) NOT NULL,
  `message` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `favourites`
--

CREATE TABLE `favourites` (
  `id_favourites` int(11) NOT NULL,
  `id_phone` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `manufacturers`
--

CREATE TABLE `manufacturers` (
  `id_manufacturer` int(11) NOT NULL,
  `manufacturer` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `manufacturers`
--

INSERT INTO `manufacturers` (`id_manufacturer`, `manufacturer`) VALUES
(5, 'SAMSUNG'),
(6, 'APPLE'),
(9, 'HUAWEII');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `orders`
--

CREATE TABLE `orders` (
  `id_order` int(11) NOT NULL,
  `id_phone` int(11) NOT NULL,
  `order_number` varchar(255) NOT NULL,
  `color` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `storage` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `phonenumber` varchar(255) NOT NULL,
  `delivery_method` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `postOffice` varchar(255) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `orders`
--

INSERT INTO `orders` (`id_order`, `id_phone`, `order_number`, `color`, `quantity`, `price`, `storage`, `id_user`, `firstname`, `lastname`, `phonenumber`, `delivery_method`, `city`, `postOffice`, `date`) VALUES
(85, 73, '20230801-e0348737', 'black', 3, 4500, 128, 73, 'Kovács', 'Szilvia', '+36202826172', 'Home delivery', 'Mosonmagyarovar', '', '2023-08-01');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `phones`
--

CREATE TABLE `phones` (
  `id_phone` int(11) NOT NULL,
  `id_manufacturer` int(11) NOT NULL,
  `model` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `operating_system` varchar(255) NOT NULL,
  `processor` varchar(255) NOT NULL,
  `operating_system_v` int(11) NOT NULL,
  `sim` varchar(255) NOT NULL,
  `screen_size` double NOT NULL,
  `capacity` int(11) NOT NULL,
  `fm_radio` enum('yes','no') NOT NULL,
  `ram` int(11) NOT NULL,
  `external` enum('yes','no') NOT NULL,
  `internal` int(11) NOT NULL,
  `main_primary_camera` varchar(255) NOT NULL,
  `main_flash` enum('yes','no') NOT NULL,
  `main_video_record` enum('yes','no') NOT NULL,
  `main_face_detect` enum('yes','no') NOT NULL,
  `main_autofocus` enum('yes','no') NOT NULL,
  `main_led_flash` enum('yes','no') NOT NULL,
  `secondary_second` varchar(255) NOT NULL,
  `second_smile_detection` enum('yes','no') NOT NULL,
  `second_video` enum('yes','no') NOT NULL,
  `second_led_flash` enum('yes','no') NOT NULL,
  `second_flash` enum('yes','no') NOT NULL,
  `second_autofocus` enum('yes','no') NOT NULL,
  `wifi` enum('yes','no') NOT NULL,
  `bluetooth` enum('yes','no') NOT NULL,
  `usb` enum('yes','no') NOT NULL,
  `nfc` enum('yes','no') NOT NULL,
  `gps` varchar(255) NOT NULL,
  `mobile_network` enum('yes','no') NOT NULL,
  `2g` enum('yes','no') NOT NULL,
  `3g` enum('yes','no') NOT NULL,
  `4g` enum('yes','no') NOT NULL,
  `5g` enum('yes','no') NOT NULL,
  `weight` double NOT NULL,
  `sms` enum('yes','no') NOT NULL,
  `email` enum('yes','no') NOT NULL,
  `height` double NOT NULL,
  `width` double NOT NULL,
  `length` double NOT NULL,
  `visible` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `phones`
--

INSERT INTO `phones` (`id_phone`, `id_manufacturer`, `model`, `price`, `operating_system`, `processor`, `operating_system_v`, `sim`, `screen_size`, `capacity`, `fm_radio`, `ram`, `external`, `internal`, `main_primary_camera`, `main_flash`, `main_video_record`, `main_face_detect`, `main_autofocus`, `main_led_flash`, `secondary_second`, `second_smile_detection`, `second_video`, `second_led_flash`, `second_flash`, `second_autofocus`, `wifi`, `bluetooth`, `usb`, `nfc`, `gps`, `mobile_network`, `2g`, `3g`, `4g`, `5g`, `weight`, `sms`, `email`, `height`, `width`, `length`, `visible`) VALUES
(73, 6, 'Iphone 11', 1500, 'iOS 15', 'Apple A15 Bionic, 6-core Processor 3.2GHz and 4-core Graphics', 15, 'Dual SIM', 6.1, 3240, 'yes', 4, 'yes', 128, '12', 'yes', 'yes', 'yes', 'yes', 'yes', '12', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'A-GPS', 'yes', 'yes', 'yes', 'yes', 'yes', 174, 'yes', 'yes', 146.7, 7.65, 71.505, 1);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `quantity`
--

CREATE TABLE `quantity` (
  `id_quantity` int(11) NOT NULL,
  `id_phone` int(11) NOT NULL,
  `number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `quantity`
--

INSERT INTO `quantity` (`id_quantity`, `id_phone`, `number`) VALUES
(2, 73, 460);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `ratings`
--

CREATE TABLE `ratings` (
  `id_rating` int(11) NOT NULL,
  `id_phone` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `storage`
--

CREATE TABLE `storage` (
  `id_storage` int(11) NOT NULL,
  `id_phone` int(11) NOT NULL,
  `storage` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `storage`
--

INSERT INTO `storage` (`id_storage`, `id_phone`, `storage`) VALUES
(15, 73, 128);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `email`, `token`, `status`, `role`) VALUES
(70, 'lacikovacs330', '$2y$10$8PJEXpCiJcqvsEacjDvTr.TO9d0tnNKlIuwehMDRKg1kEGxxdpg72', 'lacikovacs330@gmail.com', '82b5583c24d248ddd212fb7ddd11a365', 1, 'admin'),
(73, 'lacikovacs333', '$2y$10$rSPAYsvPtcwN93jxKKDRKuyV5hfEEKmZnGw05fWcN5WrDkeQF2SSi', 'lacikovacs333@gmail.com', '39576e09109a2f676e81d8c51db1017d', 1, 'user');

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`id_color`),
  ADD KEY `id_phone` (`id_phone`);

--
-- A tábla indexei `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id_contact`),
  ADD KEY `id_user` (`id_user`);

--
-- A tábla indexei `favourites`
--
ALTER TABLE `favourites`
  ADD PRIMARY KEY (`id_favourites`),
  ADD KEY `id_phone` (`id_phone`),
  ADD KEY `id_user` (`id_user`);

--
-- A tábla indexei `manufacturers`
--
ALTER TABLE `manufacturers`
  ADD PRIMARY KEY (`id_manufacturer`);

--
-- A tábla indexei `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id_order`),
  ADD KEY `id_phone` (`id_phone`),
  ADD KEY `id_user` (`id_user`);

--
-- A tábla indexei `phones`
--
ALTER TABLE `phones`
  ADD PRIMARY KEY (`id_phone`),
  ADD KEY `id_manufacturer` (`id_manufacturer`);

--
-- A tábla indexei `quantity`
--
ALTER TABLE `quantity`
  ADD PRIMARY KEY (`id_quantity`),
  ADD KEY `id_phone` (`id_phone`);

--
-- A tábla indexei `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id_rating`),
  ADD KEY `id_phone` (`id_phone`),
  ADD KEY `id_user` (`id_user`);

--
-- A tábla indexei `storage`
--
ALTER TABLE `storage`
  ADD PRIMARY KEY (`id_storage`),
  ADD KEY `id_phone` (`id_phone`);

--
-- A tábla indexei `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `colors`
--
ALTER TABLE `colors`
  MODIFY `id_color` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=152;

--
-- AUTO_INCREMENT a táblához `contact`
--
ALTER TABLE `contact`
  MODIFY `id_contact` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT a táblához `favourites`
--
ALTER TABLE `favourites`
  MODIFY `id_favourites` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT a táblához `manufacturers`
--
ALTER TABLE `manufacturers`
  MODIFY `id_manufacturer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT a táblához `orders`
--
ALTER TABLE `orders`
  MODIFY `id_order` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT a táblához `phones`
--
ALTER TABLE `phones`
  MODIFY `id_phone` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT a táblához `quantity`
--
ALTER TABLE `quantity`
  MODIFY `id_quantity` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT a táblához `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id_rating` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT a táblához `storage`
--
ALTER TABLE `storage`
  MODIFY `id_storage` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT a táblához `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `colors`
--
ALTER TABLE `colors`
  ADD CONSTRAINT `colors_ibfk_1` FOREIGN KEY (`id_phone`) REFERENCES `phones` (`id_phone`);

--
-- Megkötések a táblához `favourites`
--
ALTER TABLE `favourites`
  ADD CONSTRAINT `favourites_ibfk_1` FOREIGN KEY (`id_phone`) REFERENCES `phones` (`id_phone`),
  ADD CONSTRAINT `favourites_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

--
-- Megkötések a táblához `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`id_phone`) REFERENCES `phones` (`id_phone`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

--
-- Megkötések a táblához `phones`
--
ALTER TABLE `phones`
  ADD CONSTRAINT `phones_ibfk_1` FOREIGN KEY (`id_manufacturer`) REFERENCES `manufacturers` (`id_manufacturer`);

--
-- Megkötések a táblához `quantity`
--
ALTER TABLE `quantity`
  ADD CONSTRAINT `quantity_ibfk_1` FOREIGN KEY (`id_phone`) REFERENCES `phones` (`id_phone`);

--
-- Megkötések a táblához `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `ratings_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `ratings_ibfk_2` FOREIGN KEY (`id_phone`) REFERENCES `phones` (`id_phone`);

--
-- Megkötések a táblához `storage`
--
ALTER TABLE `storage`
  ADD CONSTRAINT `storage_ibfk_1` FOREIGN KEY (`id_phone`) REFERENCES `phones` (`id_phone`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
