-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Апр 18 2020 г., 15:14
-- Версия сервера: 5.5.39
-- Версия PHP: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `formuly`
--

-- --------------------------------------------------------

--
-- Структура таблицы `answers_1_1`
--

CREATE TABLE IF NOT EXISTS `answers_1_1` (
  `id_Task` tinyint(4) NOT NULL,
  `textarea` int(11) DEFAULT '0',
  `input` tinytext,
  `radio` tinyint(4) DEFAULT '0',
  `checkbox` tinyint(4) DEFAULT '0',
  `points` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `answers_1_1`
--

INSERT INTO `answers_1_1` (`id_Task`, `textarea`, `input`, `radio`, `checkbox`, `points`) VALUES
(1, 0, NULL, 1, 0, 1),
(2, 0, NULL, 1, 0, 1),
(3, 0, NULL, 1, 0, 1),
(4, 0, NULL, 1, 0, 1),
(5, 0, NULL, 1, 0, 1),
(6, 0, NULL, 1, 0, 1),
(7, 0, NULL, 1, 0, 1),
(8, 0, NULL, 1, 0, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `radio_1_1`
--

CREATE TABLE IF NOT EXISTS `radio_1_1` (
  `id_Task` int(11) NOT NULL,
  `idRadio` int(11) NOT NULL,
  `radio_answer` tinyint(4) DEFAULT '0',
  `text_answer` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `radio_1_1`
--

INSERT INTO `radio_1_1` (`id_Task`, `idRadio`, `radio_answer`, `text_answer`) VALUES
(1, 1, 0, 'процесс распространения тепла'),
(1, 2, 0, 'процесс диффузии'),
(1, 3, 1, 'процесс колебаний струны или колебаний  электромагнитного поля'),
(1, 4, 0, 'стационарный физический процесс, то есть процесс, который не зависит от времени'),
(2, 1, 0, 'волновое уравнение'),
(2, 2, 1, 'уравнение теплопроводности'),
(2, 3, 0, 'уравнение Лапласа'),
(2, 4, 0, 'уравнение Пуассона'),
(3, 1, 1, 'эллиптического типа'),
(3, 2, 0, 'гиперболического типа'),
(3, 3, 0, 'параболического типа'),
(3, 4, 0, 'тип уравнения в области меняется'),
(4, 1, 1, 'параболическому'),
(4, 2, 0, 'гиперболическому'),
(4, 3, 0, 'смешанному'),
(4, 4, 0, 'эллиптическому'),
(5, 1, 0, 'решением задачи Коши для волнового уравнения методом Даламбера'),
(5, 2, 0, 'решением уравнения теплопроводности при заданных начальных и граничных условиях методом Фурье'),
(5, 3, 1, 'решением волнового уравнения при заданных начальных и граничных условиях методом Фурье'),
(5, 4, 0, 'решением задачи Коши для уравнения теплопроводности, то есть интеграла Пуассона'),
(6, 1, 1, 'решением задачи Коши для волнового уравнения методом Даламбера'),
(6, 2, 0, 'решением уравнения теплопроводности при заданных начальных и граничных условиях методом Фурье'),
(6, 3, 0, 'решением волнового уравнения при заданных начальных и граничных условиях методом Фурье'),
(6, 4, 0, 'решением задачи Коши для уравнения теплопроводности, то есть интеграла Пуассона'),
(7, 1, 1, 'распространения тепла в конечном стержне'),
(7, 2, 0, 'колебаний конечной струны'),
(7, 3, 0, 'колебания бесконечной струны'),
(7, 4, 0, 'Лапласа'),
(8, 1, 1, '\\(u(x,t)=X(x)T(t)\\)'),
(8, 2, 0, '\\(u(x,t)=\\cfrac{X(x)}{T(t)}\\)'),
(8, 3, 0, '\\(u(x,t)=X(x)+T(t)\\)');

-- --------------------------------------------------------

--
-- Структура таблицы `sections`
--

CREATE TABLE IF NOT EXISTS `sections` (
`id_section` int(11) NOT NULL,
  `id_subject` int(11) NOT NULL,
  `section` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `subjects`
--

CREATE TABLE IF NOT EXISTS `subjects` (
`id_subject` int(11) NOT NULL,
  `subject` tinytext NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `subjects`
--

INSERT INTO `subjects` (`id_subject`, `subject`) VALUES
(1, 'Математический анализ');

-- --------------------------------------------------------

--
-- Структура таблицы `tasktest_1`
--

CREATE TABLE IF NOT EXISTS `tasktest_1` (
  `id_Test` int(11) NOT NULL,
  `countTask` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `tasktest_1`
--

INSERT INTO `tasktest_1` (`id_Test`, `countTask`) VALUES
(1, 8);

-- --------------------------------------------------------

--
-- Структура таблицы `tests`
--

CREATE TABLE IF NOT EXISTS `tests` (
  `idAuthor` int(11) NOT NULL,
  `idTest` int(11) NOT NULL,
  `taskName` tinytext NOT NULL,
  `dataRegistration` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `tests`
--

INSERT INTO `tests` (`idAuthor`, `idTest`, `taskName`, `dataRegistration`) VALUES
(1, 1, 'new_task', '2020-03-31 15:34:44');

-- --------------------------------------------------------

--
-- Структура таблицы `totaltasktable_1_1`
--

CREATE TABLE IF NOT EXISTS `totaltasktable_1_1` (
  `id_Task` int(11) NOT NULL,
  `total_task` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `totaltasktable_1_1`
--

INSERT INTO `totaltasktable_1_1` (`id_Task`, `total_task`) VALUES
(1, 'Укажите, какой из физических процессов определяется уравнением \\(\\cfrac{\\partial^{2}u}{\\partial t^{2}}=a^{2}\\cfrac{\\partial^{2}u}{\\partial x^{2}} \\)'),
(2, 'Укажите название уравнения \\( \\cfrac{\\partial^{2}u}{\\partial t^{2}}=a^{2}\\cfrac{\\partial^{2}u}{\\partial x^{2}}\\)'),
(3, 'Определите тип уравнения  \\( \\Delta u=\\cfrac{\\partial^{2}u}{\\partial x^{2}}+\\cfrac{\\partial^{2}u}{\\partial y^{2}}+\\cfrac{\\partial^{2}u}{\\partial z^{2}}=0\\)'),
(4, 'Уравнение \\(\\cfrac{\\partial U}{\\partial t}=a^{2}\\cfrac{\\partial^{2}U}{\\partial x^{2}}\\) относится к ___ типу'),
(5, 'Определите, решением какой задачи является формула \\(\\sum^{\\infty}_{n=1}\\left(A_{n}\\cos\\cfrac{n\\pi at}{l}+B_{n}\\sin\\cfrac{n\\pi at}{l}\\right)\\sin\\cfrac{n\\pi x}{l}\\)'),
(6, 'Определите, решением какой задачи является формула \\(u(x,t)=\\cfrac{1}{2}[\\varphi(x-at)+\\varphi(x+at)]+\\cfrac{1}{2a}\\int^{x+at}_{x-at}\\Psi(z)dz\\)'),
(7, 'Формула \\(U(x,t)=\\sum^{\\infty}_{n=1}C_{n}\\e^{-\\left(\\frac{an\\pi}{l}\\right)^{2}t}\\sin\\cfrac{n\\pi x}{l}\\) дает решение уравнения'),
(8, 'Определите формулу для решения методом Фурье волнового уравнения');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(8) NOT NULL,
  `login` varchar(255) NOT NULL,
  `userPassword` tinytext NOT NULL,
  `name` tinytext NOT NULL,
  `surname` tinytext NOT NULL,
  `root` enum('студент','преподаватель') DEFAULT 'студент',
  `dateRegistration` datetime NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `userPassword`, `name`, `surname`, `root`, `dateRegistration`) VALUES
(1, 'admins_exist', 'cfde9b2b1d3d8b741cfc58fcae182027', 'Администраторы', 'сайта', 'преподаватель', '2020-03-29 14:10:36');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
 ADD PRIMARY KEY (`id_section`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
 ADD PRIMARY KEY (`id_subject`);

--
-- Indexes for table `tests`
--
ALTER TABLE `tests`
 ADD PRIMARY KEY (`idAuthor`,`idTest`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
MODIFY `id_section` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
MODIFY `id_subject` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(8) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
