TRUNCATE TABLE catalog_categories;

INSERT INTO `catalog_categories` (`category_id`, `category_name`, `category_left`, `category_right`, `category_level`, `category_scope`, `category_parent_id`, `category_meta_title`, `category_meta_description`, `category_meta_keywords`, `category_meta_robots`) VALUES
(1, 'ROOT', 1, 660, 1, 1, NULL, '', '', '', ''),
(71, 'Biura rachunkowe', 9, 10, 3, 1, 56, '', '', '', ''),
(72, 'Centrale telefoniczne', 11, 12, 3, 1, 56, '', '', '', ''),
(59, 'Edukacja i nauka', 82, 115, 2, 1, 1, '', '', '', ''),
(60, 'Finanse i ubezpieczenia', 116, 155, 2, 1, 1, '', '', '', ''),
(61, 'Komputery i internet', 156, 203, 2, 1, 1, '', '', '', ''),
(62, 'Marketing i reklama', 204, 239, 2, 1, 1, '', '', '', ''),
(63, 'Motoryzacja i transport', 240, 287, 2, 1, 1, '', '', '', ''),
(64, 'Nieruchomości', 288, 301, 2, 1, 1, '', '', '', ''),
(65, 'Producenci i hurtownie', 302, 367, 2, 1, 1, '', '', '', ''),
(66, 'Przemysł', 368, 397, 2, 1, 1, '', '', '', ''),
(67, 'Rolnictwo i zwierzęta', 398, 431, 2, 1, 1, '', '', '', ''),
(69, 'Banki danych', 5, 6, 3, 1, 56, '', '', '', ''),
(70, 'Biura ogłoszeń', 7, 8, 3, 1, 56, '', '', '', ''),
(57, 'Budownictwo', 30, 57, 2, 1, 1, '', '', '', ''),
(58, 'Doradztwo', 58, 81, 2, 1, 1, '', '', '', ''),
(82, 'Architektura wnętrz', 33, 34, 3, 1, 57, '', '', '', ''),
(81, 'Architektura', 31, 32, 3, 1, 57, '', '', '', ''),
(80, 'Rzeczoznawcy', 27, 28, 3, 1, 56, '', '', '', ''),
(79, 'Pozostałe usługi', 25, 26, 3, 1, 56, '', '', '', ''),
(78, 'Pośrednictwo pracy', 23, 24, 3, 1, 56, '', '', '', ''),
(77, 'Organizacja imprez, bankietów', 21, 22, 3, 1, 56, '', '', '', ''),
(76, 'Meble biurowe', 19, 20, 3, 1, 56, '', '', '', ''),
(75, 'Materiały biurowe i papiernicze', 17, 18, 3, 1, 56, '', '', '', ''),
(74, 'Maszyny i urządzenia biurowe', 15, 16, 3, 1, 56, '', '', '', ''),
(73, 'Komputery i akcesoria', 13, 14, 3, 1, 56, '', '', '', ''),
(68, 'Archiwizacja dokumentów', 3, 4, 3, 1, 56, '', '', '', ''),
(56, 'Biuro i firma', 2, 29, 2, 1, 1, '', '', '', ''),
(83, 'Armatura', 35, 36, 3, 1, 57, '', '', '', ''),
(84, 'Biura projektowe', 37, 38, 3, 1, 57, '', '', '', ''),
(85, 'Budownictwo drogowe', 39, 40, 3, 1, 57, '', '', '', ''),
(86, 'Budownictwo mieszkaniowe', 41, 42, 3, 1, 57, '', '', '', ''),
(87, 'Budownictwo przemysłowe', 43, 44, 3, 1, 57, '', '', '', ''),
(88, 'Docieplenia', 45, 46, 3, 1, 57, '', '', '', ''),
(89, 'Elektryka', 47, 48, 3, 1, 57, '', '', '', ''),
(90, 'Geodezja, geologia ikartografia', 49, 50, 3, 1, 57, '', '', '', ''),
(91, 'Instalacje centralnego ogrzewania', 51, 52, 3, 1, 57, '', '', '', ''),
(92, 'Instalacje gazowe', 53, 54, 3, 1, 57, '', '', '', ''),
(93, 'Instalacje elektryczne', 55, 56, 3, 1, 57, '', '', '', ''),
(94, 'Adwokaci', 59, 60, 3, 1, 58, '', '', '', ''),
(95, 'Badania i analizy techniczne', 61, 62, 3, 1, 58, '', '', '', ''),
(96, 'Biura pośrednictwa pracy', 63, 64, 3, 1, 58, '', '', '', ''),
(97, 'Doradcy księgowi i podatkowi', 65, 66, 3, 1, 58, '', '', '', ''),
(98, 'Doradcy personalni', 67, 68, 3, 1, 58, '', '', '', ''),
(99, 'Doradcy prawni', 69, 70, 3, 1, 58, '', '', '', ''),
(100, 'Doradztwo i badania', 71, 72, 3, 1, 58, '', '', '', ''),
(101, 'Inwestycyjne', 73, 74, 3, 1, 58, '', '', '', ''),
(102, 'Notariusze', 75, 76, 3, 1, 58, '', '', '', ''),
(103, 'Usługi konsultingowe', 77, 78, 3, 1, 58, '', '', '', ''),
(104, 'Zarządzanie przedsiębiorstwami', 79, 80, 3, 1, 58, '', '', '', ''),
(105, 'Biblioteki i czytelnie', 83, 84, 3, 1, 59, '', '', '', ''),
(106, 'Gimnazja', 85, 86, 3, 1, 59, '', '', '', ''),
(107, 'Księgarnie', 87, 88, 3, 1, 59, '', '', '', ''),
(108, 'Kursy inne', 89, 90, 3, 1, 59, '', '', '', ''),
(109, 'Kursy komputerowe', 91, 92, 3, 1, 59, '', '', '', ''),
(110, 'Kursy prawa jazdy', 93, 94, 3, 1, 59, '', '', '', ''),
(111, 'Kursy zawodowe', 95, 96, 3, 1, 59, '', '', '', ''),
(112, 'Nauka tańca', 97, 98, 3, 1, 59, '', '', '', ''),
(113, 'Przedszkola i żłobki', 99, 100, 3, 1, 59, '', '', '', ''),
(114, 'Szkoły językowe', 101, 102, 3, 1, 59, '', '', '', ''),
(115, 'Szkoły licealne', 103, 104, 3, 1, 59, '', '', '', ''),
(116, 'Szkoły muzyczne', 105, 106, 3, 1, 59, '', '', '', ''),
(117, 'Szkoły podstawowe', 107, 108, 3, 1, 59, '', '', '', ''),
(118, 'Szkoły policealne', 109, 110, 3, 1, 59, '', '', '', ''),
(119, 'Uczelnie wyższe', 111, 112, 3, 1, 59, '', '', '', ''),
(120, 'Wydawnictwa', 113, 114, 3, 1, 59, '', '', '', ''),
(121, 'Banki', 117, 118, 3, 1, 60, '', '', '', ''),
(122, 'Biura maklerskie', 119, 120, 3, 1, 60, '', '', '', ''),
(123, 'Biura rachunkowe', 121, 122, 3, 1, 60, '', '', '', ''),
(124, 'Brokerzy', 123, 124, 3, 1, 60, '', '', '', ''),
(125, 'Doradztwo finansowe i prawne', 125, 126, 3, 1, 60, '', '', '', ''),
(126, 'Fundusze i spółki inwestycyjne', 127, 128, 3, 1, 60, '', '', '', ''),
(127, 'Kantory', 129, 130, 3, 1, 60, '', '', '', ''),
(128, 'Kredyty i pożyczki', 131, 132, 3, 1, 60, '', '', '', ''),
(129, 'Księgowość', 133, 134, 3, 1, 60, '', '', '', ''),
(130, 'Leasing', 135, 136, 3, 1, 60, '', '', '', ''),
(131, 'Lombardy', 137, 138, 3, 1, 60, '', '', '', ''),
(132, 'Notariusze', 139, 140, 3, 1, 60, '', '', '', ''),
(133, 'Pośrednictwo finansowe', 141, 142, 3, 1, 60, '', '', '', ''),
(134, 'Prawnicy', 143, 144, 3, 1, 60, '', '', '', ''),
(135, 'Radcy prawni', 145, 146, 3, 1, 60, '', '', '', ''),
(136, 'Rzeczoznawcy', 147, 148, 3, 1, 60, '', '', '', ''),
(137, 'Towarzystwa emerytalne', 149, 150, 3, 1, 60, '', '', '', ''),
(138, 'Ubezpieczenia', 151, 152, 3, 1, 60, '', '', '', ''),
(139, 'Windykacja', 153, 154, 3, 1, 60, '', '', '', ''),
(140, 'Aplikacje internetowe', 157, 158, 3, 1, 61, '', '', '', ''),
(141, 'Doradztwo informatyczne', 159, 160, 3, 1, 61, '', '', '', ''),
(142, 'Drukarki - materiały, naprawa', 161, 162, 3, 1, 61, '', '', '', ''),
(143, 'E-commerce', 163, 164, 3, 1, 61, '', '', '', ''),
(144, 'Grafika', 165, 166, 3, 1, 61, '', '', '', ''),
(145, 'Hosting i domeny', 167, 168, 3, 1, 61, '', '', '', ''),
(146, 'Kamery cyfrowe', 169, 170, 3, 1, 61, '', '', '', ''),
(147, 'Karty identyfikacyjne i czytniki kodów', 171, 172, 3, 1, 61, '', '', '', ''),
(148, 'Kawiarenki internetowe', 173, 174, 3, 1, 61, '', '', '', ''),
(149, 'Komputery używane', 175, 176, 3, 1, 61, '', '', '', ''),
(150, 'Ksero', 177, 178, 3, 1, 61, '', '', '', ''),
(151, 'Kursy komputerowe', 179, 180, 3, 1, 61, '', '', '', ''),
(152, 'Naprawa komputerów i akcesoriów', 181, 182, 3, 1, 61, '', '', '', ''),
(153, 'Oprogramowanie', 183, 184, 3, 1, 61, '', '', '', ''),
(154, 'Oprogramowanie - sprzedaż', 185, 186, 3, 1, 61, '', '', '', ''),
(155, 'Oprogramowanie dla internetu', 187, 188, 3, 1, 61, '', '', '', ''),
(156, 'Portale i wortale internetowe', 189, 190, 3, 1, 61, '', '', '', ''),
(157, 'Pozycjonowanie stron', 191, 192, 3, 1, 61, '', '', '', ''),
(158, 'Przepisywanie tekstów', 193, 194, 3, 1, 61, '', '', '', ''),
(159, 'Sieci - zakładanie', 195, 196, 3, 1, 61, '', '', '', ''),
(160, 'Sprzedaż komputerów i akcesoriów', 197, 198, 3, 1, 61, '', '', '', ''),
(161, 'Tworzenie stron', 199, 200, 3, 1, 61, '', '', '', ''),
(162, 'Usługi internetowe', 201, 202, 3, 1, 61, '', '', '', ''),
(163, 'Agencje fotograficzne', 205, 206, 3, 1, 62, '', '', '', ''),
(164, 'Agencje marketingowe', 207, 208, 3, 1, 62, '', '', '', ''),
(165, 'Agencje modelek', 209, 210, 3, 1, 62, '', '', '', ''),
(166, 'Agencje public relations', 211, 212, 3, 1, 62, '', '', '', ''),
(167, 'Agencje reklamowe', 213, 214, 3, 1, 62, '', '', '', ''),
(168, 'Artykuły, gadżety reklamowe', 215, 216, 3, 1, 62, '', '', '', ''),
(169, 'Badania rynku i opinii publicznej', 217, 218, 3, 1, 62, '', '', '', ''),
(170, 'Drukarnie', 219, 220, 3, 1, 62, '', '', '', ''),
(171, 'Introligatorstwo', 221, 222, 3, 1, 62, '', '', '', ''),
(172, 'Kolportaż', 223, 224, 3, 1, 62, '', '', '', ''),
(173, 'Marketing bezpośredni', 225, 226, 3, 1, 62, '', '', '', ''),
(174, 'Poligrafia', 227, 228, 3, 1, 62, '', '', '', ''),
(175, 'Reklama i marketing w Internecie', 229, 230, 3, 1, 62, '', '', '', ''),
(176, 'Reklama prasowa', 231, 232, 3, 1, 62, '', '', '', ''),
(177, 'Reklama telewizyjna, filmowa, radiowa', 233, 234, 3, 1, 62, '', '', '', ''),
(178, 'Reklama zewnętrzna', 235, 236, 3, 1, 62, '', '', '', ''),
(179, 'Wydawnictwa', 237, 238, 3, 1, 62, '', '', '', ''),
(180, 'Audio i alarmy', 241, 242, 3, 1, 63, '', '', '', ''),
(181, 'Części i akcesoria samochodowe', 243, 244, 3, 1, 63, '', '', '', ''),
(182, 'Komisy i giełdy samochodowe', 245, 246, 3, 1, 63, '', '', '', ''),
(183, 'Kursy prawa jazdy', 247, 248, 3, 1, 63, '', '', '', ''),
(184, 'Materiały eksploatacyjne', 249, 250, 3, 1, 63, '', '', '', ''),
(185, 'Myjnie samochodowe', 251, 252, 3, 1, 63, '', '', '', ''),
(186, 'Parkingi i garaże', 253, 254, 3, 1, 63, '', '', '', ''),
(187, 'Przeprowadzki', 255, 256, 3, 1, 63, '', '', '', ''),
(188, 'Salony samochodowe', 257, 258, 3, 1, 63, '', '', '', ''),
(189, 'Serwisy motoryzacyjne', 259, 260, 3, 1, 63, '', '', '', ''),
(190, 'Spedycja', 261, 262, 3, 1, 63, '', '', '', ''),
(191, 'Stacje kontroli pojazdów', 263, 264, 3, 1, 63, '', '', '', ''),
(192, 'Stacje paliw', 265, 266, 3, 1, 63, '', '', '', ''),
(193, 'Taxi', 267, 268, 3, 1, 63, '', '', '', ''),
(194, 'Transport drogowy', 269, 270, 3, 1, 63, '', '', '', ''),
(195, 'Transport kolejowy', 271, 272, 3, 1, 63, '', '', '', ''),
(196, 'Transport morski', 273, 274, 3, 1, 63, '', '', '', ''),
(197, 'Tuning', 275, 276, 3, 1, 63, '', '', '', ''),
(198, 'Usługi kurierskie', 277, 278, 3, 1, 63, '', '', '', ''),
(199, 'Warsztaty samochodowe', 279, 280, 3, 1, 63, '', '', '', ''),
(200, 'Wulkanizacja', 281, 282, 3, 1, 63, '', '', '', ''),
(201, 'Wynajem samochodów', 283, 284, 3, 1, 63, '', '', '', ''),
(202, 'Auto Komis', 285, 286, 3, 1, 63, '', '', '', ''),
(203, 'Administracja i zarządzenie nieruchomościami', 289, 290, 3, 1, 64, '', '', '', ''),
(204, 'Agencje nieruchomości', 291, 292, 3, 1, 64, '', '', '', ''),
(205, 'Ochrona nieruchomości', 293, 294, 3, 1, 64, '', '', '', ''),
(206, 'Sprzedaż nieruchomości', 295, 296, 3, 1, 64, '', '', '', ''),
(207, 'Wycena nieruchomości', 297, 298, 3, 1, 64, '', '', '', ''),
(208, 'Wynajem nieruchomości', 299, 300, 3, 1, 64, '', '', '', ''),
(209, 'AGD i RTV', 303, 304, 3, 1, 65, '', '', '', ''),
(210, 'Alkohole', 305, 306, 3, 1, 65, '', '', '', ''),
(211, 'Artykuły biurowe', 307, 308, 3, 1, 65, '', '', '', ''),
(212, 'Artykuły rolnicze', 309, 310, 3, 1, 65, '', '', '', ''),
(213, 'Automatyka przemysłowa', 311, 312, 3, 1, 65, '', '', '', ''),
(214, 'Chemiczne i środków czyszczących', 313, 314, 3, 1, 65, '', '', '', ''),
(215, 'Farb, lakierów, tapet i wykładzin', 315, 316, 3, 1, 65, '', '', '', ''),
(216, 'Hurtownie budowlane', 317, 318, 3, 1, 65, '', '', '', ''),
(217, 'Hurtownie elektroniczne', 319, 320, 3, 1, 65, '', '', '', ''),
(218, 'Hurtownie elektryczne', 321, 322, 3, 1, 65, '', '', '', ''),
(219, 'Hurtownie i producenci meblowi', 323, 324, 3, 1, 65, '', '', '', ''),
(220, 'Hurtownie i producenci napojów', 325, 326, 3, 1, 65, '', '', '', ''),
(221, 'Hurtownie i producenci zabawek', 327, 328, 3, 1, 65, '', '', '', ''),
(222, 'Hurtownie kosmetyków', 329, 330, 3, 1, 65, '', '', '', ''),
(223, 'Hurtownie mięsne', 331, 332, 3, 1, 65, '', '', '', ''),
(224, 'Hurtownie motoryzacyjne', 333, 334, 3, 1, 65, '', '', '', ''),
(225, 'Hurtownie ogrodnicze', 335, 336, 3, 1, 65, '', '', '', ''),
(226, 'Hurtownie papiernicze', 337, 338, 3, 1, 65, '', '', '', ''),
(227, 'Hurtownie sportowe', 339, 340, 3, 1, 65, '', '', '', ''),
(228, 'Hurtownie spożywcze', 341, 342, 3, 1, 65, '', '', '', ''),
(229, 'Komputerów i urządzeń biurowych', 343, 344, 3, 1, 65, '', '', '', ''),
(230, 'Książek, gazet i czasopism', 345, 346, 3, 1, 65, '', '', '', ''),
(231, 'Maszyny', 347, 348, 3, 1, 65, '', '', '', ''),
(232, 'Narzędzia i elektronarzędzia', 349, 350, 3, 1, 65, '', '', '', ''),
(233, 'Obuwie', 351, 352, 3, 1, 65, '', '', '', ''),
(234, 'Odzieżowe i włókiennicze', 353, 354, 3, 1, 65, '', '', '', ''),
(235, 'Okna, drzwi', 355, 356, 3, 1, 65, '', '', '', ''),
(236, 'Opakowania', 357, 358, 3, 1, 65, '', '', '', ''),
(237, 'Producenci drewna', 359, 360, 3, 1, 65, '', '', '', ''),
(238, 'Producenci szkła', 361, 362, 3, 1, 65, '', '', '', ''),
(239, 'Tworzywa sztuczne', 363, 364, 3, 1, 65, '', '', '', ''),
(240, 'Wyposażenia wnętrz', 365, 366, 3, 1, 65, '', '', '', ''),
(241, 'Dźwigi i urządzenia dźwigowe', 369, 370, 3, 1, 66, '', '', '', ''),
(242, 'Elektromechanika', 371, 372, 3, 1, 66, '', '', '', ''),
(243, 'Elektrotechnika', 373, 374, 3, 1, 66, '', '', '', ''),
(244, 'Galwanizacja', 375, 376, 3, 1, 66, '', '', '', ''),
(245, 'Górnictwo - akcesoria i materiały', 377, 378, 3, 1, 66, '', '', '', ''),
(246, 'Hutnictwo - akcesoria i materiały', 379, 380, 3, 1, 66, '', '', '', ''),
(247, 'Hydraulika siłowa', 381, 382, 3, 1, 66, '', '', '', ''),
(248, 'Maszyny', 383, 384, 3, 1, 66, '', '', '', ''),
(249, 'Metalurgia', 385, 386, 3, 1, 66, '', '', '', ''),
(250, 'Narzędzia', 387, 388, 3, 1, 66, '', '', '', ''),
(251, 'Podnośniki, transportery', 389, 390, 3, 1, 66, '', '', '', ''),
(252, 'Silniki', 391, 392, 3, 1, 66, '', '', '', ''),
(253, 'Stal i wyroby stalowe', 393, 394, 3, 1, 66, '', '', '', ''),
(254, 'Złom', 395, 396, 3, 1, 66, '', '', '', ''),
(255, 'Leśnictwo i produkcja leśna', 399, 400, 3, 1, 67, '', '', '', ''),
(256, 'Garbarnie', 401, 402, 3, 1, 67, '', '', '', ''),
(257, 'Rolnicze - artykuły, sprzęt, narzędzia', 403, 404, 3, 1, 67, '', '', '', ''),
(258, 'Rolnicze - maszyny', 405, 406, 3, 1, 67, '', '', '', ''),
(259, 'Rolnicze - usługi', 407, 408, 3, 1, 67, '', '', '', ''),
(260, 'Rybołówstwo', 409, 410, 3, 1, 67, '', '', '', ''),
(261, 'Schroniska dla zwierząt', 411, 412, 3, 1, 67, '', '', '', ''),
(262, 'Sklepy zoologiczne', 413, 414, 3, 1, 67, '', '', '', ''),
(263, 'Skup warzyw, owoców, runa leśnego', 415, 416, 3, 1, 67, '', '', '', ''),
(264, 'Skup zwierząt', 417, 418, 3, 1, 67, '', '', '', ''),
(265, 'Skup, sprzedaż skór', 419, 420, 3, 1, 67, '', '', '', ''),
(266, 'Szkółki leśne', 421, 422, 3, 1, 67, '', '', '', ''),
(267, 'Tresura, szkolenia zwierząt', 423, 424, 3, 1, 67, '', '', '', ''),
(268, 'Weterynarze', 425, 426, 3, 1, 67, '', '', '', ''),
(269, 'Woda - badanie, uzdatnianie', 427, 428, 3, 1, 67, '', '', '', ''),
(270, 'Zwierzęta - sprzedaż, hodowla', 429, 430, 3, 1, 67, '', '', '', ''),
(271, 'Rozrywka i kultura', 432, 471, 2, 1, 1, '', '', '', ''),
(272, 'Sklepy', 472, 527, 2, 1, 1, '', '', '', ''),
(273, 'Telekomunikacja', 528, 539, 2, 1, 1, '', '', '', ''),
(274, 'Turystyka', 540, 569, 2, 1, 1, '', '', '', ''),
(275, 'Usługi', 570, 619, 2, 1, 1, '', '', '', ''),
(276, 'Zdrowie i uroda', 620, 659, 2, 1, 1, '', '', '', ''),
(277, 'Aktywny wypoczynek', 433, 434, 3, 1, 271, '', '', '', ''),
(278, 'Bary', 435, 436, 3, 1, 271, '', '', '', ''),
(279, 'Dyskoteki', 437, 438, 3, 1, 271, '', '', '', ''),
(280, 'Filmy video, dvd i bluray', 439, 440, 3, 1, 271, '', '', '', ''),
(281, 'Galerie', 441, 442, 3, 1, 271, '', '', '', ''),
(282, 'Gry, zabawki, automaty do gier', 443, 444, 3, 1, 271, '', '', '', ''),
(283, 'Kina', 445, 446, 3, 1, 271, '', '', '', ''),
(284, 'Kluby', 447, 448, 3, 1, 271, '', '', '', ''),
(285, 'Muzea', 449, 450, 3, 1, 271, '', '', '', ''),
(286, 'Muzyka', 451, 452, 3, 1, 271, '', '', '', ''),
(287, 'Organizatorzy imprez', 453, 454, 3, 1, 271, '', '', '', ''),
(288, 'Pirotechnika', 455, 456, 3, 1, 271, '', '', '', ''),
(289, 'Pizzerie', 457, 458, 3, 1, 271, '', '', '', ''),
(290, 'Pokazy artystyczne', 459, 460, 3, 1, 271, '', '', '', ''),
(291, 'Puby', 461, 462, 3, 1, 271, '', '', '', ''),
(292, 'Restauracje', 463, 464, 3, 1, 271, '', '', '', ''),
(293, 'Teatry', 465, 466, 3, 1, 271, '', '', '', ''),
(294, 'Telewizja', 467, 468, 3, 1, 271, '', '', '', ''),
(295, 'Wyroby artystyczne', 469, 470, 3, 1, 271, '', '', '', ''),
(296, 'Apteki', 473, 474, 3, 1, 272, '', '', '', ''),
(297, 'Artykuły biurowe', 475, 476, 3, 1, 272, '', '', '', ''),
(298, 'Artykuły dziecięce', 477, 478, 3, 1, 272, '', '', '', ''),
(299, 'Bukmacherskie zakłady sportowe', 479, 480, 3, 1, 272, '', '', '', ''),
(300, 'Farby, lakiery i kleje', 481, 482, 3, 1, 272, '', '', '', ''),
(301, 'Galanteria skórzana', 483, 484, 3, 1, 272, '', '', '', ''),
(302, 'Higiena', 485, 486, 3, 1, 272, '', '', '', ''),
(303, 'Komisy', 487, 488, 3, 1, 272, '', '', '', ''),
(304, 'Księgarnie', 489, 490, 3, 1, 272, '', '', '', ''),
(305, 'Kwiaciarnie', 491, 492, 3, 1, 272, '', '', '', ''),
(306, 'Odzież używana', 493, 494, 3, 1, 272, '', '', '', ''),
(307, 'Optyk', 495, 496, 3, 1, 272, '', '', '', ''),
(308, 'Pasmanteria', 497, 498, 3, 1, 272, '', '', '', ''),
(309, 'Piekarnie, cukiernie', 499, 500, 3, 1, 272, '', '', '', ''),
(310, 'Salony jubilerskie', 501, 502, 3, 1, 272, '', '', '', ''),
(311, 'Salony ślubne', 503, 504, 3, 1, 272, '', '', '', ''),
(312, 'Sklepy budowlane i metalowe', 505, 506, 3, 1, 272, '', '', '', ''),
(313, 'Sklepy internetowe', 507, 508, 3, 1, 272, '', '', '', ''),
(314, 'Sklepy komputerowe', 509, 510, 3, 1, 272, '', '', '', ''),
(315, 'Sklepy motoryzacyjne', 511, 512, 3, 1, 272, '', '', '', ''),
(316, 'Sklepy obuwnicze', 513, 514, 3, 1, 272, '', '', '', ''),
(317, 'Sklepy spożywcze', 515, 516, 3, 1, 272, '', '', '', ''),
(318, 'Sklepy z AGD i RTV', 517, 518, 3, 1, 272, '', '', '', ''),
(319, 'Sklepy z antykami', 519, 520, 3, 1, 272, '', '', '', ''),
(320, 'Sklepy z zabawkami', 521, 522, 3, 1, 272, '', '', '', ''),
(321, 'Wyposażenie mieszkań', 523, 524, 3, 1, 272, '', '', '', ''),
(322, 'Zdrowa żywność i zielarstwo', 525, 526, 3, 1, 272, '', '', '', ''),
(323, 'Akcesoria do telefonów', 529, 530, 3, 1, 273, '', '', '', ''),
(324, 'Sprzedaż telefonów i faksów', 531, 532, 3, 1, 273, '', '', '', ''),
(325, 'Telefonia komórkowa', 533, 534, 3, 1, 273, '', '', '', ''),
(326, 'Telefonia stacjonarna', 535, 536, 3, 1, 273, '', '', '', ''),
(327, 'VOIP', 537, 538, 3, 1, 273, '', '', '', ''),
(328, 'Agencje turystyczne', 541, 542, 3, 1, 274, '', '', '', ''),
(329, 'Agroturystyka', 543, 544, 3, 1, 274, '', '', '', ''),
(330, 'Aktywny wypoczynek', 545, 546, 3, 1, 274, '', '', '', ''),
(331, 'Autokarowe przewozy', 547, 548, 3, 1, 274, '', '', '', ''),
(332, 'Camping, pola namiotowe', 549, 550, 3, 1, 274, '', '', '', ''),
(333, 'Domki letniskowe', 551, 552, 3, 1, 274, '', '', '', ''),
(334, 'Hotele', 553, 554, 3, 1, 274, '', '', '', ''),
(335, 'Ośrodki wczasowe', 555, 556, 3, 1, 274, '', '', '', ''),
(336, 'Pensjonaty', 557, 558, 3, 1, 274, '', '', '', ''),
(337, 'Pokoje gościnne', 559, 560, 3, 1, 274, '', '', '', ''),
(338, 'Schroniska turystyczne', 561, 562, 3, 1, 274, '', '', '', ''),
(339, 'Sprzęt turystyczny', 563, 564, 3, 1, 274, '', '', '', ''),
(340, 'Wycieczki krajowe', 565, 566, 3, 1, 274, '', '', '', ''),
(341, 'Wycieczki zagraniczne', 567, 568, 3, 1, 274, '', '', '', ''),
(342, 'Agencje ochrony i detektywistyczne', 571, 572, 3, 1, 275, '', '', '', ''),
(343, 'Architekci', 573, 574, 3, 1, 275, '', '', '', ''),
(344, 'Automatyka przemysłowo-budowlana', 575, 576, 3, 1, 275, '', '', '', ''),
(345, 'Biura rachunkowe', 577, 578, 3, 1, 275, '', '', '', ''),
(346, 'Blacharstwo samochodowe', 579, 580, 3, 1, 275, '', '', '', ''),
(347, 'Budowlane', 581, 582, 3, 1, 275, '', '', '', ''),
(348, 'Hydrauliczne', 583, 584, 3, 1, 275, '', '', '', ''),
(349, 'Kamieniarstwo', 585, 586, 3, 1, 275, '', '', '', ''),
(350, 'Krawiectwo', 587, 588, 3, 1, 275, '', '', '', ''),
(351, 'Lakiernictwo', 589, 590, 3, 1, 275, '', '', '', ''),
(352, 'Mechanika pojazdowa', 591, 592, 3, 1, 275, '', '', '', ''),
(353, 'Naprawa sprzętu RTV i AGD', 593, 594, 3, 1, 275, '', '', '', ''),
(354, 'Pralnie i usługi pralnicze', 595, 596, 3, 1, 275, '', '', '', ''),
(355, 'Reklama i poligrafia', 597, 598, 3, 1, 275, '', '', '', ''),
(356, 'Remonty', 599, 600, 3, 1, 275, '', '', '', ''),
(357, 'Rzeczoznawstwo majątkowe', 601, 602, 3, 1, 275, '', '', '', ''),
(358, 'Salony fryzjerskie', 603, 604, 3, 1, 275, '', '', '', ''),
(359, 'Salony kosmetyczne', 605, 606, 3, 1, 275, '', '', '', ''),
(360, 'Ślusarskie', 607, 608, 3, 1, 275, '', '', '', ''),
(361, 'Stolarskie', 609, 610, 3, 1, 275, '', '', '', ''),
(362, 'Stomatologiczne i protetyczne', 611, 612, 3, 1, 275, '', '', '', ''),
(363, 'Tłumaczenia', 613, 614, 3, 1, 275, '', '', '', ''),
(364, 'Wideo-filmowanie', 615, 616, 3, 1, 275, '', '', '', ''),
(365, 'Wycena nieruchomości', 617, 618, 3, 1, 275, '', '', '', ''),
(366, 'Apteki', 621, 622, 3, 1, 276, '', '', '', ''),
(367, 'Fitness', 623, 624, 3, 1, 276, '', '', '', ''),
(368, 'Ginekologia', 625, 626, 3, 1, 276, '', '', '', ''),
(369, 'Kliniki prywatne', 627, 628, 3, 1, 276, '', '', '', ''),
(370, 'Lekarze domowi', 629, 630, 3, 1, 276, '', '', '', ''),
(371, 'Masaż', 631, 632, 3, 1, 276, '', '', '', ''),
(372, 'Medycyna naturalna', 633, 634, 3, 1, 276, '', '', '', ''),
(373, 'Okulistyka', 635, 636, 3, 1, 276, '', '', '', ''),
(374, 'Ortopedia', 637, 638, 3, 1, 276, '', '', '', ''),
(375, 'Przychodnie i poradnie', 639, 640, 3, 1, 276, '', '', '', ''),
(376, 'Rehabilitacja', 641, 642, 3, 1, 276, '', '', '', ''),
(377, 'Salony fryzjerskie', 643, 644, 3, 1, 276, '', '', '', ''),
(378, 'Salony kosmetyczne', 645, 646, 3, 1, 276, '', '', '', ''),
(379, 'Sanatoria, uzdrowiska', 647, 648, 3, 1, 276, '', '', '', ''),
(380, 'Siłownie', 649, 650, 3, 1, 276, '', '', '', ''),
(381, 'Solaria', 651, 652, 3, 1, 276, '', '', '', ''),
(382, 'Sprzęt medyczny', 653, 654, 3, 1, 276, '', '', '', ''),
(383, 'Szpitale', 655, 656, 3, 1, 276, '', '', '', ''),
(384, 'Zdrowa żywność i zielarstwo', 657, 658, 3, 1, 276, '', '', '', '');

INSERT INTO `catalog_companies` (`company_id`, `user_id`, `company_name`, `company_address`, `company_city`, `company_telephone`, `company_postal_code`, `company_email`, `company_description`, `company_products`, `company_logo`, `company_is_promoted`, `company_promotion_availability`, `province_select`, `link`, `company_date_added`, `company_date_updated`, `company_visits`, `company_is_approved`, `last_category_id`, `first_category_id`, `promotion_type`, `slug`, `company_county`, `ip_address`, `company_map_lat`, `company_map_lng`) VALUES
(1, 0, 'AkoSoft - rozwiązania dla eBiznesu', 'olgierda', 'Gdynia', '666', '81-178', 'noreply@akosoft.pl', '<p>E-biznes, to wciąż nowe zagadnienie dla Polak. Ci, ktzy posiadali dotychczas, swoje firmy stacjonarne, przenoszą się do sieci. AkoSOFT, to pasja do najnowszych rozwiązań internetowych, pomysł, kte warto wdrążyć, oraz pomocy z zakresu szeroko pojętego e-biznesu. AkoSoft, tworzą ludzie, ktzy w swojej branży są najlepsi, są to eksperci od: copywritingu, pozycjonowania, grafiki komputerowej, oraz innych rozwiązań dla biznesu internetowego.</p>\n\n<p>Dzięki doświadczeniu i pasji, każdego z nas, tworzymy mieszankę kreatywności, fachowego podejścia do potrzeb klient, oraz perfekcji, tak ważnej dla profesjonalist. Rzeczą, kta wyrnia nas, jest umiejętność wsppracy z klientem. Przed każdą pracą, wnikliwie badamy potrzeby kontrahenta, stale się z nim kontaktujemy, oraz nanosimy wszelkie poprawki, bowiem to jego zadowolenie, świadczy o naszej dobrej pracy. A wykonany projekt jet też naszą wizytką.</p>\n\n<p></p>\n\n<p></p>', '', 0, 1, '2015-03-29 15:33:22', '1', 'a.pl', '2013-03-29 09:44:37', '2013-04-03 09:56:34', 8, 1, 0, 70, 1, NULL, 1001, '', 54.4771, 18.5179),
(2, 0, 'AkoPortal - więcej niż portal', 'Olgierda 81', 'Gdynia', '666', '81-178', 'noreply@akosoft.pl', '<p>AkoPortal umożliwia uruchomienie rozbudowanego portalu internetowego lub dowolnego wybranego serwisu dedykowanego np. ogłoszeń. Każdy z moduł posiada jedną bazę użytkownik i jeden panel do zarządzania. Oznacz to że użytkownik rejestruje się raz w serwisie i będzie mł korzystać z każdego modułu serwisu (w tej chwili katalogu firm, ofert firm oraz ogłoszeń) w przyszłości z wiadomości, forum, aukcji itd. Wszelkie działania użytkownik są powiązane oznacz to że na stronie ogłoszeń danego użytkownika możemy poruszać się między jego wpisem firmy, ofertami. Od strony panelu administratora możemy zarządzać użytkownikami przydzielać im promocyjne wpisy firm, darmowe ogłoszenia promowane czy darmowe top oferty. AkoPortal posiada możliwość włączenia prac konserwacyjnych z ustaloną treścią, w przypadku włączenia strony prac konserwacyjnych front serwisu dostępny jest tylko dla zalogowanego administratora serwisu. Opcja logowanie przez FB umożliwia łatwą rejestrację serwisu za pomocą danych z serwisu społecznościowego jak i łatwe logowanie. Posiada liczne możliwości konfiguracji dostępne od strony panelu administratora. W module ogłoszeń mamy możliwość tworzenie dodatkowych p dedykowanych co oznacza że formularz dodawanie ogłoszenia możemy dynamicznie rozwijać z poziomy panelu administratora. Wszelkie pola dodatkowe prezentowane są w wydzielony sektorze na stronie ogłoszenia jako dodatkowe informacje.</p>', '<p><strong>Katalog firm</strong><br />\nRozbudowany moduł katalogu firm z opcją wizytki firmy w subdomenie. Trzy rodzaje wpisu w serwisie, opcje opinii o firmach, możliwość przydzielanie specjalnych rabat na wpis premium plus firmy (% udzielany rabat). Prezentacja wpisu firmy na podstronach serwisu z mapka lokalizacyjną, opisem i produktami firmy. Wpis zwykły może być dodany bez rejestracji wymaga on jednak zatwierdzenia przez administratora. Wpis Premium t prezentacja firmy na podstronach serwisu. Wpis Premium Plus to prezentacja firmy na stronie wizytki w subdomenie serwisu - (firma.akosoft.pl). Wpisy promowane dodawane są na okres 365 dni, po tym okresie, jeżeli nie zostaną przedłużone, zmieniają się w wpis zwykły.</p>\n\n<p></p>\n\n<p>Oferty Firm<br />\nModuł kupon rabatowych na usługi i produkty firmy czy osoby prywatnej. Podzielony jest na oferty zwykłe oraz oferty promowane "Top Oferta". Oferty promowane dostępne są za darmo dla firm posiadających wpis Premium Plus w katalogu firm oraz odpłatnie dla pozostałych. Kupon rabatowy określa wysokość rabatu na dany produkt czy usługę. Dodając ofertę mamy możliwość podania % rabatu, ceny produktu po rabacie oraz określić ważność oferty jak i ilość kupon. Zainteresowana osoba pobiera kupon kty wysyłany jest na podany adres e-mail w formacie pdf, natomiast firma dodająca ofertę informację na e-mail z adresem e-mail osoby kta dany kupon pobrała jak i z jego unikalnym numerem. Serwis nie ingeruje w realizację danego kuponu nie pobiera opłat za udostępnienie kuponu co powoduje że tego rodzaju usługa nie wymaga rejestracji takiej działalności (jak w przypadku serwis zakup grupowych, podlegają licznym rejestracją). Kupony rabatowe dodaje się w określonych kategoriach głnych. Powiadamiacz o ofertach specjalnych wysyła zapisanemu użytkownikowi codziennie raport z nowymi ofertami z wybranej kategorii.</p>\n\n<p></p>\n\n<p>Ogłoszenia<br />\nModuł ogłoszeń w serwisie umożliwia dodawanie ogłoszeń bez rejestracji (moderowane przez administratora) jak i możliwość dodawanie ogłoszeń dla zarejestrowanego użytkownika. Opcja komentowania ogłoszeń z moderacją od strony panelu administratora pozwala na komentowanie ogłoszenia na jego stronie jak i ocenianie ogłoszeń i odpowiedzi. W serwisie mamy trzy możliwości promocji ogłoszeń. Premium Plus - ten rodzaj promocji prezentuje ogłoszenia na stronie głnej serwisu oraz jako pierwsze na liście ogłoszeń w kategorii wyrnione ramką. Premium - ogłoszenie prezentowane jest na liście ogłoszeń w kategorii w ktej zostało dodane w wyrnionej ramce. Wyrnienie - to ogłoszenie prezentowane jest na liście ogłoszeń według daty dodanie znajduje się na wyrniającym je szarym tle. Każdym z rodzaju promocji zarządza się osobno, płatnościami jak i mamy możliwość wyłączenia dowolnego rodzaju promocji. AkoPortal umożliwia też podbijanie ogłoszeń promowanych (Premium i Premium Plus) na liście. Zakupując odpowiednią ilość punkt ogłoszenie może być prezentowane jako pierwsze na liście w danej kategorii.</p>\n\n<p></p>\n\n<p>Moduł powiadamiacza<br />\nTego nie ma konkurencja. Moduł powiadamiacza dostępny jest dla wszystkich odwiedzających serwis, nie trzeba się rejestrować aby z niego korzystać. Przeznaczony jest dla ogłoszeń oraz ofert firm. Za jego pomocą można wybrać dowolną kategorię podkategorię lub wszystkie kategorie w serwisie z ktych raz dziennie wysyłany jest raport z nowymi ogłoszeniami. Powiadamiacz ma za zadanie pozwolić na szybki powr do serwisu w razie znalezienia odpowiedniej oferty, oraz nawiązanie stałego kontaktu z odwiedzającymi serwis.</p>\n\n<p></p>\n\n<p>Uruchomisz skrypt lokalny lub ognopolski<br />\nDzięki możliwości wł/wył mapę i wojewztwa w panelu administratora możesz uruchomić skrypt w wersji lokalnej. Jedno kliknięcie a panelu administratora i znika mapa (w zamian są 3 ogłoszenia promowane) oraz wszelkie pola wojewztwa w całym serwisie. Wł/wył mapę i wojewztwa możesz osobno dal każdego modułu skryptu.</p>\n\n<p>Moduł statystyk reklam dla kupujących reklamy w serwisie<br />\nKażdy klient kupujący reklamę w serwisie otrzymuje automatycznie dane do logowania do wbudowanego panelu klienta AdSystem gdzie ma dostęp do statystyk zakupionych reklam. Nic nie musisz robić więcej. Dodajesz reklamę a informacje dla klienta wysyłane są automatycznie na jego adres email. Otrzymuje dane do logowania gdzie może śledzić statystyki swoich reklam.</p>\n\n<p></p>\n\n<p>Ikonki społecznościowe<br />\nDostępne dla każdego ogłoszenia jak i wpisu premium firmy. Łatwo dodasz ogłoszenie, wpis do serwis społecznościowych, zrobi to każdy odwiedzający.</p>\n\n<p></p>\n\n<p>Moduł RSS<br />\nNajnowsze ogłoszenia z serwisu na stronie FB? Zamieścisz je dzięki modułowi RSS.</p>\n\n<p></p>\n\n<p></p>', 0, 1, '2015-03-29 22:31:56', '1', 'akosoft.pl', '2013-03-29 09:54:25', '2013-04-02 18:26:36', 0, 1, 0, 140, 2, 'akosoft', 1001, '', 51.9194, 19.1451),
(3, 1, 'Firma przykładowa', 'Warszawska', 'Wrocław', '666', '25-120', 'noreply@akosoft.pl', 'Przykładowy opis firmy Przykładowy opis firmy Przykładowy opis firmy Przykładowy opis firmy Przykładowy opis firmy Przykładowy opis firmy Przykładowy opis firmy Przykładowy opis firmy ', '', 0, 0, '2013-03-29 10:51:51', '2', '', '2013-03-29 10:51:52', '2013-03-29 10:52:12', 0, 1, 0, 81, 0, NULL, 2000, '', 51.0643, 17.0782),
(4, 1, 'Przykładowa Firma', 'Warszawska', 'Toruń', '123123123', '10-120', 'noreply@akosoft.pl', '<p>Przykładowy wpis firmy dodany przez admina</p>', '', 0, 1, '2015-03-29 17:20:04', '3', 'akosoft.pl', '2013-03-29 11:31:19', '2013-04-02 18:33:05', 3, 1, 0, 68, 1, NULL, 3000, '', 53.0118, 18.6159),
(5, 1, 'Przykładowa firma 2', 'Warszawska', 'Toruń', '123123123', '10-250', 'noreply@akosoft.pl', '<p>Przykładowa firma 2</p>', '', 0, 1, '2015-03-29 17:22:21', '3', '', '2013-03-29 11:33:36', '2013-04-02 18:33:49', 3, 1, 0, 81, 1, NULL, 3000, '', 53.0118, 18.6159),
(6, 1, 'Przykładowa firma 3', 'Warszawska', 'Wrocław', '13123213', '10-250', 'noreply@akosoft.pl', '<p>Przykładowa firma 3</p>', '', 0, 1, '2015-03-29 17:23:37', '2', '', '2013-03-29 11:34:52', '2013-04-02 18:32:54', 4, 1, 0, 81, 1, NULL, 2000, '', 51.0643, 17.0782),
(7, 1, 'Przykładowa firma 4 Wrocław', 'Warszawska', 'Wrocław', '13123213', '10-250', 'noreply@akosoft.pl', '<p>Przykładowa firma 4</p>', '', 0, 1, '2015-03-29 17:24:41', '2', '', '2013-03-29 11:35:56', '2013-04-02 18:32:22', 1, 1, 0, 68, 1, NULL, 2000, '', 51.0643, 17.0782),
(8, 1, 'Przykładowa firma 5 Wrocław', 'Warszawska', 'Wrocław', '13123213', '10-250', 'noreply@akosoft.pl', 'Przykładowy opis firmy 5', '', 0, 0, '2013-03-29 11:37:29', '2', '', '2013-03-29 11:37:30', '2013-03-29 11:37:47', 0, 1, 0, 81, 0, NULL, 2000, '', 51.0643, 17.0782),
(9, 1, 'Przykładowa firma 6 Poznań', 'Gdańska', 'Poznań', '123123123', '75-142', 'noreply@akosoft.pl', 'Przykładowa firma - Poznań ', '', 0, 0, '2013-04-03 09:39:45', '15', '', '2013-04-03 09:39:46', '2013-04-03 09:40:05', 0, 1, 0, 68, 0, NULL, 15000, '', 52.4122, 16.9543);

INSERT INTO `catalog_categories_to_companies` (`category_to_company_id`, `category_id`, `company_id`, `relation_nb`) VALUES
(111, 61, 1, 2),
(110, 1, 1, 2),
(109, 155, 1, 2),
(108, 61, 1, 1),
(107, 1, 1, 1),
(106, 140, 1, 1),
(105, 56, 1, 0),
(104, 1, 1, 0),
(103, 70, 1, 0),
(120, 56, 6, 1),
(119, 1, 6, 1),
(118, 69, 6, 1),
(123, 57, 5, 0),
(122, 1, 5, 0),
(121, 81, 5, 0),
(66, 56, 4, 0),
(65, 1, 4, 0),
(64, 68, 4, 0),
(48, 57, 3, 0),
(47, 1, 3, 0),
(46, 81, 3, 0),
(102, 61, 2, 4),
(101, 1, 2, 4),
(100, 155, 2, 4),
(114, 56, 7, 0),
(113, 1, 7, 0),
(112, 68, 7, 0),
(61, 81, 8, 0),
(62, 1, 8, 0),
(63, 57, 8, 0),
(117, 57, 6, 0),
(116, 1, 6, 0),
(115, 81, 6, 0),
(99, 61, 2, 3),
(98, 1, 2, 3),
(97, 156, 2, 3),
(96, 61, 2, 2),
(95, 1, 2, 2),
(94, 154, 2, 2),
(93, 61, 2, 1),
(92, 1, 2, 1),
(91, 153, 2, 1),
(90, 61, 2, 0),
(89, 1, 2, 0),
(88, 140, 2, 0),
(124, 68, 9, 0),
(125, 1, 9, 0),
(126, 56, 9, 0);

INSERT INTO `config` (`config_id`, `config_group_name`, `config_key`, `config_value`) VALUES
(NULL, 'modules.site_catalog.widgets.recommended', 'enabled', 's:1:"1";'),
(NULL, 'modules.site_catalog', 'map', 's:1:"1";'),
(NULL, 'modules.site_catalog', 'email_view_disabled', 's:1:"1";'),
(NULL, 'modules.site_catalog.settings.reviews', 'enabled', 's:1:"1";'),
(NULL, 'modules.site_catalog.settings.reviews.moderate', 'disabled', 's:1:"1";'),
(NULL, 'modules.site_catalog.payment.promote.1', 'disabled', 's:1:"0";'),
(NULL, 'modules.site_catalog.payment.promote.2', 'disabled', 's:1:"0";'),
(NULL, 'modules.site_catalog.payment.company_add.default', 'enabled', 's:1:"2";'),
(NULL, 'modules.site_catalog.payment.dotpay.sms.company_add', 'enabled', 's:1:"1";'),
(NULL, 'modules.site_catalog.payment.dotpay.sms.company_add.default', 'service_id', 's:5:"demo1";'),
(NULL, 'modules.site_catalog.payment.dotpay.sms.company_add.default', 'price', 's:1:"1";'),
(NULL, 'modules.site_catalog.payment.dotpay.sms.company_add.default', 'konektor', 's:5:"76025";'),
(NULL, 'modules.site_catalog.payment.dotpay.online.company_add', 'enabled', 's:1:"1";'),
(NULL, 'modules.site_catalog.payment.dotpay.online.company_add.default', 'service_id', 's:5:"demo1";'),
(NULL, 'modules.site_catalog.payment.dotpay.online.company_add.default', 'price', 's:1:"1";'),
(NULL, 'modules.site_catalog.payment.transfer.company_add', 'enabled', 's:1:"1";'),
(NULL, 'modules.site_catalog.payment.transfer.company_add.default', 'price', 's:1:"1";'),
(NULL, 'modules.site_catalog.payment.dotpay.sms.promote', 'enabled', 's:1:"0";'),
(NULL, 'modules.site_catalog.payment.dotpay.online.promote', 'enabled', 's:1:"1";'),
(NULL, 'modules.site_catalog.payment.dotpay.online.promote.1', 'service_id', 's:5:"demo1";'),
(NULL, 'modules.site_catalog.payment.dotpay.online.promote.1', 'price', 's:1:"1";'),
(NULL, 'modules.site_catalog.payment.dotpay.online.promote.2', 'service_id', 's:5:"demo1";'),
(NULL, 'modules.site_catalog.payment.dotpay.online.promote.2', 'price', 's:1:"1";'),
(NULL, 'modules.site_catalog.payment.transfer.promote', 'enabled', 's:1:"1";'),
(NULL, 'modules.site_catalog.payment.transfer.promote.1', 'price', 's:1:"1";'),
(NULL, 'modules.site_catalog.payment.transfer.promote.2', 'price', 's:1:"1";');