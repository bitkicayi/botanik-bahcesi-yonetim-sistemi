-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 14 Haz 2025, 18:55:10
-- Sunucu sürümü: 10.4.32-MariaDB
-- PHP Sürümü: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `botanik_bahce`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `bakim_planlari`
--

CREATE TABLE `bakim_planlari` (
  `plan_id` int(11) NOT NULL,
  `bitki_id` int(11) NOT NULL,
  `islem_turu` enum('Sulama','Gübreleme','Budama','Diğer') NOT NULL,
  `plan_tarihi` date NOT NULL,
  `aciklama` text DEFAULT NULL,
  `ekleyen_kullanici_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `bakim_planlari`
--

INSERT INTO `bakim_planlari` (`plan_id`, `bitki_id`, `islem_turu`, `plan_tarihi`, `aciklama`, `ekleyen_kullanici_id`) VALUES
(3, 2, 'Sulama', '2025-06-15', 'Yaz mevsimi olduğu için sabah erken saatlerde sulanmalı.', 1),
(4, 3, 'Gübreleme', '2025-06-20', 'Organik sıvı gübre uygulanacak.', 1),
(5, 4, 'Sulama', '2025-06-15', 'Yaz mevsimi nedeniyle sabah saatlerinde sulama yapılmalı.', 1),
(6, 5, 'Gübreleme', '2025-06-18', 'Çiçeklenmeyi teşvik eden sıvı gübre verilecek.', 1),
(7, 6, 'Budama', '2025-06-20', 'Kuru yapraklar temizlenecek.', 1),
(8, 7, 'Diğer', '2025-06-22', 'Yaprak kontrolü ve zararlı incelemesi yapılacak.', 1),
(9, 8, 'Sulama', '2025-06-25', 'Yayılma alanı geniş olduğu için bol su verilecek.', 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `bitkiler`
--

CREATE TABLE `bitkiler` (
  `bitki_id` int(11) NOT NULL,
  `bitki_ad` varchar(100) NOT NULL,
  `bitki_tur` varchar(100) DEFAULT NULL,
  `bitki_dikim_tarihi` date DEFAULT NULL,
  `bitki_sulama_sikligi` varchar(50) DEFAULT NULL,
  `bitki_aciklama` text DEFAULT NULL,
  `ekleyen_kullanici_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `bitkiler`
--

INSERT INTO `bitkiler` (`bitki_id`, `bitki_ad`, `bitki_tur`, `bitki_dikim_tarihi`, `bitki_sulama_sikligi`, `bitki_aciklama`, `ekleyen_kullanici_id`) VALUES
(2, 'Lavanta', 'Çalı', '2024-05-15', '7 günde 1', 'Güneşi çok seven ve hoş kokulu bir bitkidir.', 1),
(3, 'Aloe Vera', 'Sukulent', '2024-03-10', '10 günde 1', 'Jeli cilt için faydalıdır, çok su istemez.', 1),
(4, 'Kaktüs', 'Sukulent', '2024-01-20', '15 günde 1', 'Çok az su isteyen, dikenli yapısıyla bilinen dayanıklı bitki.', 1),
(5, 'Orkide', 'Çiçekli', '2024-02-14', '6 günde 1', 'Zarif çiçekleriyle süs bitkisi olarak tercih edilir.', 1),
(6, 'Menekşe', 'Çiçekli', '2024-03-10', '3 günde 1', 'Ev içi için uygun, renkli çiçekleri olan bir bitki.', 1),
(7, 'Defne', 'Ağaç', '2023-10-05', '7 günde 1', 'Yaprakları yemeklerde baharat olarak kullanılır.', 1),
(8, 'Sarmaşık', 'Tırmanıcı', '2024-04-18', '5 günde 1', 'Yayılmacı yapısı ile duvarları kaplar, gölge sağlar.', 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `etkinlikler`
--

CREATE TABLE `etkinlikler` (
  `etkinlik_id` int(11) NOT NULL,
  `etkinlik_ad` varchar(100) NOT NULL,
  `etkinlik_tarih` date DEFAULT NULL,
  `etkinlik_yeri` varchar(100) DEFAULT NULL,
  `etkinlik_aciklama` text DEFAULT NULL,
  `ekleyen_kullanici_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `etkinlikler`
--

INSERT INTO `etkinlikler` (`etkinlik_id`, `etkinlik_ad`, `etkinlik_tarih`, `etkinlik_yeri`, `etkinlik_aciklama`, `ekleyen_kullanici_id`) VALUES
(1, 'Fidan Dikim Etkinliği', '2025-11-21', 'Bahçenin Kuzey Alanı', 'Katılımcılarla birlikte 100 fidan dikimi yapılacaktır. Herkese açık bir etkinliktir. Eldiven ve çapa temin edilecektir.', 1),
(2, 'Bahar Şenliği', '2025-03-25', 'Açık Hava Alanı', 'Canlı müzik ve atölyeler eşliğinde baharın gelişini kutluyoruz.', 1),
(3, 'Sukulent Yetiştirme Atölyesi', '2025-04-05', 'Atölye Binası', 'Katılımcılar kendi sukulentlerini saksılayarak eve götürecek.', 1),
(4, 'Toprak Günü Etkinliği', '2025-04-22', 'Doğa Eğitim Merkezi', 'Çevre bilinci oluşturmak için çocuklara özel etkinlikler düzenlenecek.', 1),
(5, 'Bahçe Fotoğraf Yarışması', '2025-05-10', 'Ana Bahçe Girişi', 'Ziyaretçilerin çektiği en güzel bahçe fotoğrafları oylanacak.', 1),
(6, 'Gönüllü Tanıtım Günü', '2025-05-25', 'Sergi Alanı', 'Gönüllülük faaliyetleri tanıtılacak, kayıt alınacak.', 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `gorevler`
--

CREATE TABLE `gorevler` (
  `gorev_id` int(11) NOT NULL,
  `gorev_ad` varchar(100) NOT NULL,
  `gorev_tipi` enum('Bitki','Sergi') NOT NULL,
  `hedef_id` int(11) NOT NULL,
  `personel_id` int(11) NOT NULL,
  `gorev_tarih` date NOT NULL,
  `aciklama` text DEFAULT NULL,
  `ekleyen_kullanici_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `gorevler`
--

INSERT INTO `gorevler` (`gorev_id`, `gorev_ad`, `gorev_tipi`, `hedef_id`, `personel_id`, `gorev_tarih`, `aciklama`, `ekleyen_kullanici_id`) VALUES
(1, 'Lavanta Sulama Görevi', 'Bitki', 1, 1, '2025-06-15', 'Sabah 08:00\'de sulama yapılacak.', 1),
(2, 'Kaktüs Toprak Kontrolü', 'Bitki', 4, 2, '2025-06-16', 'Kaktüslerin saksı toprakları kontrol edilecek.', 1),
(3, 'Orkide Gübreleme Takibi', 'Bitki', 5, 3, '2025-06-18', 'Gübreleme sonrası gözlem yapılacak.', 1),
(4, 'Menekşe Budama İşlemi', 'Bitki', 6, 4, '2025-06-20', 'Solmuş çiçekler ve yapraklar budanacak.', 1),
(5, 'Defne Yaprak Zararlı Kontrolü', 'Bitki', 7, 5, '2025-06-22', 'Zararlı belirtisi var mı bakılacak.', 1),
(6, 'Sarmaşık Sulama Görevi', 'Bitki', 8, 1, '2025-06-25', 'Sulama hortumu kontrol edilip işlem yapılacak.', 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanicilar`
--

CREATE TABLE `kullanicilar` (
  `kullanici_id` int(11) NOT NULL,
  `kullanici_ad` varchar(50) NOT NULL,
  `kullanici_soyad` varchar(50) NOT NULL,
  `kullanici_email` varchar(100) NOT NULL,
  `kullanici_sifre` varchar(255) NOT NULL,
  `kullanici_kayit_tarihi` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `kullanicilar`
--

INSERT INTO `kullanicilar` (`kullanici_id`, `kullanici_ad`, `kullanici_soyad`, `kullanici_email`, `kullanici_sifre`, `kullanici_kayit_tarihi`) VALUES
(1, 'BURAK EGE', 'YAŞAR', 'burakege0000@gmail.com', '$2y$10$n0U0L3zP9HG94NS998vTgu2AllzmgKbK2N4PAdKhvQNTEk9l.qHIm', '2025-06-13 13:09:07');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `personel`
--

CREATE TABLE `personel` (
  `personel_id` int(11) NOT NULL,
  `ad_soyad` varchar(100) NOT NULL,
  `unvan` varchar(100) DEFAULT NULL,
  `telefon` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `aciklama` text DEFAULT NULL,
  `ekleyen_kullanici_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `personel`
--

INSERT INTO `personel` (`personel_id`, `ad_soyad`, `unvan`, `telefon`, `email`, `aciklama`, `ekleyen_kullanici_id`) VALUES
(1, 'Kemal Aydın', 'Bahçıvan', '05554343319', 'kemal@botanikbahce.com', '10 yıldır bahçıvan.', 1),
(2, 'Ayşe Toprak', 'Ziraat Mühendisi', '05551234567', 'ayse@botanikbahce.com', 'Bitki sağlığı konusunda uzman.', 1),
(3, 'Murat Güneş', 'Bahçıvan', '05557654321', 'murat@botanikbahce.com', '5 yıllık deneyime sahip.', 1),
(4, 'Zeynep Çimen', 'Peyzaj Uzmanı', '05559876543', 'zeynep@botanikbahce.com', 'Süs bitkileri üzerine çalışır.', 1),
(5, 'Ali Kara', 'Botanik Uzmanı', '05553456789', 'ali@botanikbahce.com', 'Endemik bitkiler konusunda bilgi sahibidir.', 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `sergiler`
--

CREATE TABLE `sergiler` (
  `sergi_id` int(11) NOT NULL,
  `sergi_ad` varchar(100) NOT NULL,
  `sergi_tarih` date DEFAULT NULL,
  `sergi_yeri` varchar(100) DEFAULT NULL,
  `sergi_aciklama` text DEFAULT NULL,
  `ekleyen_kullanici_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `sergiler`
--

INSERT INTO `sergiler` (`sergi_id`, `sergi_ad`, `sergi_tarih`, `sergi_yeri`, `sergi_aciklama`, `ekleyen_kullanici_id`) VALUES
(2, 'Endemik Bitkiler Sergisi', '2025-07-10', 'Giriş Holü', 'Türkiye\'de yetişen endemik bitkilerin tanıtımı.', 1),
(3, 'Sukulent Koleksiyonu', '2025-06-18', 'Doğu Kanadı', 'Dünyanın dört bir yanından getirilen sukulent türleri.', 1),
(4, 'Tıbbi Bitkiler Sergisi', '2025-08-01', 'Giriş Holü', 'Tedavi amaçlı kullanılan geleneksel ve modern bitkiler tanıtımı.', 1),
(5, 'Bonsai Güzelliği', '2025-09-10', 'Ana Salon', 'Minyatür ağaçların sanata dönüştüğü sergi.', 1),
(6, 'Kurak İklim Bitkileri Sergisi', '2025-10-05', 'Batı Alanı', 'Kaktüs ve benzeri bitkilerden oluşan özel koleksiyon.', 1),
(7, 'Kışa Hazırlık: İç Mekan Bitkileri', '2025-11-01', 'Sera Bölümü', 'Kışın yetiştirilebilecek dayanıklı türlerin tanıtımı.', 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ziyaretciler`
--

CREATE TABLE `ziyaretciler` (
  `ziyaretci_id` int(11) NOT NULL,
  `ad_soyad` varchar(100) NOT NULL,
  `ziyaret_tarihi` date NOT NULL,
  `ziyaret_nedeni` text DEFAULT NULL,
  `iletisim` varchar(100) DEFAULT NULL,
  `ekleyen_kullanici_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `ziyaretciler`
--

INSERT INTO `ziyaretciler` (`ziyaretci_id`, `ad_soyad`, `ziyaret_tarihi`, `ziyaret_nedeni`, `iletisim`, `ekleyen_kullanici_id`) VALUES
(1, 'Ayşe Demir', '2025-06-12', 'Botanik merakı nedeniyle ziyaret etti.', 'ayse@ziyaretci.com', 1),
(2, 'Mehmet Arslan', '2025-06-10', 'Botanik bahçesini gezmek için geldi.', 'mehmet@ziyaretci.com', 1),
(3, 'Elif Kırmızı', '2025-06-11', 'Etkinlik duyurusunu sosyal medyada gördü.', 'elif@ziyaretci.com', 1),
(4, 'Can Yıldız', '2025-06-13', 'Okul projesi için bitki araştırması yaptı.', 'can@ziyaretci.com', 1),
(5, 'Ayhan Taş', '2025-06-14', 'Lavanta türleriyle ilgileniyor.', 'ayhan@ziyaretci.com', 1),
(6, 'Zehra Demir', '2025-06-14', 'Kız kardeşi personel olarak çalışıyor, ziyarete geldi.', 'zehra@ziyaretci.com', 1);

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `bakim_planlari`
--
ALTER TABLE `bakim_planlari`
  ADD PRIMARY KEY (`plan_id`),
  ADD KEY `bitki_id` (`bitki_id`),
  ADD KEY `ekleyen_kullanici_id` (`ekleyen_kullanici_id`);

--
-- Tablo için indeksler `bitkiler`
--
ALTER TABLE `bitkiler`
  ADD PRIMARY KEY (`bitki_id`),
  ADD KEY `ekleyen_kullanici_id` (`ekleyen_kullanici_id`);

--
-- Tablo için indeksler `etkinlikler`
--
ALTER TABLE `etkinlikler`
  ADD PRIMARY KEY (`etkinlik_id`),
  ADD KEY `ekleyen_kullanici_id` (`ekleyen_kullanici_id`);

--
-- Tablo için indeksler `gorevler`
--
ALTER TABLE `gorevler`
  ADD PRIMARY KEY (`gorev_id`),
  ADD KEY `personel_id` (`personel_id`),
  ADD KEY `ekleyen_kullanici_id` (`ekleyen_kullanici_id`);

--
-- Tablo için indeksler `kullanicilar`
--
ALTER TABLE `kullanicilar`
  ADD PRIMARY KEY (`kullanici_id`),
  ADD UNIQUE KEY `kullanici_email` (`kullanici_email`);

--
-- Tablo için indeksler `personel`
--
ALTER TABLE `personel`
  ADD PRIMARY KEY (`personel_id`),
  ADD KEY `ekleyen_kullanici_id` (`ekleyen_kullanici_id`);

--
-- Tablo için indeksler `sergiler`
--
ALTER TABLE `sergiler`
  ADD PRIMARY KEY (`sergi_id`),
  ADD KEY `ekleyen_kullanici_id` (`ekleyen_kullanici_id`);

--
-- Tablo için indeksler `ziyaretciler`
--
ALTER TABLE `ziyaretciler`
  ADD PRIMARY KEY (`ziyaretci_id`),
  ADD KEY `ekleyen_kullanici_id` (`ekleyen_kullanici_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `bakim_planlari`
--
ALTER TABLE `bakim_planlari`
  MODIFY `plan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Tablo için AUTO_INCREMENT değeri `bitkiler`
--
ALTER TABLE `bitkiler`
  MODIFY `bitki_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Tablo için AUTO_INCREMENT değeri `etkinlikler`
--
ALTER TABLE `etkinlikler`
  MODIFY `etkinlik_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Tablo için AUTO_INCREMENT değeri `gorevler`
--
ALTER TABLE `gorevler`
  MODIFY `gorev_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Tablo için AUTO_INCREMENT değeri `kullanicilar`
--
ALTER TABLE `kullanicilar`
  MODIFY `kullanici_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `personel`
--
ALTER TABLE `personel`
  MODIFY `personel_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Tablo için AUTO_INCREMENT değeri `sergiler`
--
ALTER TABLE `sergiler`
  MODIFY `sergi_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Tablo için AUTO_INCREMENT değeri `ziyaretciler`
--
ALTER TABLE `ziyaretciler`
  MODIFY `ziyaretci_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `bakim_planlari`
--
ALTER TABLE `bakim_planlari`
  ADD CONSTRAINT `bakim_planlari_ibfk_1` FOREIGN KEY (`bitki_id`) REFERENCES `bitkiler` (`bitki_id`),
  ADD CONSTRAINT `bakim_planlari_ibfk_2` FOREIGN KEY (`ekleyen_kullanici_id`) REFERENCES `kullanicilar` (`kullanici_id`);

--
-- Tablo kısıtlamaları `bitkiler`
--
ALTER TABLE `bitkiler`
  ADD CONSTRAINT `bitkiler_ibfk_1` FOREIGN KEY (`ekleyen_kullanici_id`) REFERENCES `kullanicilar` (`kullanici_id`);

--
-- Tablo kısıtlamaları `etkinlikler`
--
ALTER TABLE `etkinlikler`
  ADD CONSTRAINT `etkinlikler_ibfk_1` FOREIGN KEY (`ekleyen_kullanici_id`) REFERENCES `kullanicilar` (`kullanici_id`);

--
-- Tablo kısıtlamaları `gorevler`
--
ALTER TABLE `gorevler`
  ADD CONSTRAINT `gorevler_ibfk_1` FOREIGN KEY (`personel_id`) REFERENCES `personel` (`personel_id`),
  ADD CONSTRAINT `gorevler_ibfk_2` FOREIGN KEY (`ekleyen_kullanici_id`) REFERENCES `kullanicilar` (`kullanici_id`);

--
-- Tablo kısıtlamaları `personel`
--
ALTER TABLE `personel`
  ADD CONSTRAINT `personel_ibfk_1` FOREIGN KEY (`ekleyen_kullanici_id`) REFERENCES `kullanicilar` (`kullanici_id`);

--
-- Tablo kısıtlamaları `sergiler`
--
ALTER TABLE `sergiler`
  ADD CONSTRAINT `sergiler_ibfk_1` FOREIGN KEY (`ekleyen_kullanici_id`) REFERENCES `kullanicilar` (`kullanici_id`);

--
-- Tablo kısıtlamaları `ziyaretciler`
--
ALTER TABLE `ziyaretciler`
  ADD CONSTRAINT `ziyaretciler_ibfk_1` FOREIGN KEY (`ekleyen_kullanici_id`) REFERENCES `kullanicilar` (`kullanici_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
