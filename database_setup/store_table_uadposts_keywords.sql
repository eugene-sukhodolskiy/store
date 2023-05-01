
-- --------------------------------------------------------

--
-- Структура таблицы `uadposts_keywords`
--

CREATE TABLE `uadposts_keywords` (
  `id` int NOT NULL,
  `uap_id` int NOT NULL,
  `keyword` varchar(80) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
