# **СИСТЕМА ПЕРЕВОДОВ ЭЛЕМЕНТОВ ИНТЕРФЕЙСА**

Данный скрипт представляет собой 2 html-страницы:
1. страница управления переводами;
2. страница управления языками.

***
Используется PHP 7.0, HTML, CSS, JavaScript (jQuery-3.3.1).
HTML стилизация - Bootstrap-3.3.7.
Миграции реализованы c использованием phinx - (https://phinx.org/).

***
Структура БД:
>TABLE `key` (
>	`id` int(11) NOT NULL AUTO_INCREMENT,
>	`name` varchar(255) NOT NULL
>	)
>PRIMARY KEY (`id`)

>TABLE `language` (
>	`id` int(11) NOT NULL AUTO_INCREMENT,
>	`name` varchar(255) NOT NULL
>	`code` varchar(3) NOT NULL
>	)
>PRIMARY KEY (`id`)

>TABLE `translation` (
>	`id` int(11) NOT NULL AUTO_INCREMENT,
>	`key_id` int(11) NOT NULL FOREIGN KEY (`key` => `id`)
>	`lang_id` int(11) NOT NULL FOREIGN KEY (`language` => `id`)
>	`content` text NOT NULL
>	)
>PRIMARY KEY (`id`)

***
Ознакомиться со скриптом можно по ссылке: https://translationsystem.herokuapp.com/

Автор: Дмитрий Гольдберг
e-mail: dmitriy.goldberg@gmail.com