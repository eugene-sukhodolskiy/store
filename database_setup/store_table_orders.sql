
-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `uap_id` int NOT NULL,
  `seller_id` int NOT NULL,
  `customer_id` int NOT NULL,
  `state` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'unconfirmed' COMMENT 'confirmed, unconfirmed, canceled,\r\ncompleted',
  `delivery_method` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `delivery_id` int NOT NULL,
  `comment` text COLLATE utf8mb4_general_ci NOT NULL,
  `price` float NOT NULL,
  `currency` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `create_at` timestamp NULL DEFAULT NULL,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
