
-- --------------------------------------------------------

--
-- Структура таблицы `search_history`
--

CREATE TABLE `search_history` (
  `id` int NOT NULL,
  `uid` int NOT NULL,
  `query` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `filters` text COLLATE utf8mb4_general_ci,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
