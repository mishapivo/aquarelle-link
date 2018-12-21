<?php
/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе
 * установки. Необязательно использовать веб-интерфейс, можно
 * скопировать файл в "wp-config.php" и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки MySQL
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define('DB_NAME', 'aquarelle_link');

/** Имя пользователя MySQL */
define('DB_USER', 'aquarelle');

/** Пароль к базе данных MySQL */
define('DB_PASSWORD', 'PIvovarenkO16');

/** Имя сервера MySQL */
define('DB_HOST', '192.168.0.10');

/** Кодировка базы данных для создания таблиц. */
define('DB_CHARSET', 'utf8mb4');

/** Схема сопоставления. Не меняйте, если не уверены. */
define('DB_COLLATE', '');

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '[W44vaj,MHdy8B?c0`cZ?S=q9y7HgOoq+P/qHU(X[>^|6dy~X:%@7O]8A]H3u3yc');
define('SECURE_AUTH_KEY',  '&O>f~e}1K aq~h?k+ApveP*Ay$`2rj:*y$aHPjhyyT*g IA|N%+^!p39.[UDJL r');
define('LOGGED_IN_KEY',    '>n{-]%4tvx9Mb>W`jr 3&,7j|p-eOcn@5QOvC&pd!r8(oi-E^M=cW?_<`J2c+<Nb');
define('NONCE_KEY',        '4gZq.[h*S;B8cCs|=rZBgNaVarXDCZ#q/y3=KkElP^LYViuWU5XinTC&O+g;A1_|');
define('AUTH_SALT',        '}a.@-?WbU~/QLar4}R%ufK3C]-jFZTHPT>Lushgi6T>WB&Lsk:QopiN,0U8bs-uo');
define('SECURE_AUTH_SALT', 'p}m9RmWR$eq%}y/b,zgw4:KYV6;JlO<>p58K_{gNP5zzB*<VS;a?jod4yOMD<pX|');
define('LOGGED_IN_SALT',   'SH)f5<%_^3$Cb&aaFamSC^110:3yPpB.l+CQbT,{k*1A%A>[PRl>@l3G MU -Xv<');
define('NONCE_SALT',       '@sUd$` ,Q8oT4rkt 4Cz*aMS(5c#e1xBU5X!$`K;}TE &k>;~h5wWAAoGz<i7m8o');

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix  = 'aquarelle_wp_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 *
 * Информацию о других отладочных константах можно найти в Кодексе.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* Multisite */
define( 'WP_ALLOW_MULTISITE', true );

define('MULTISITE', true);
define('SUBDOMAIN_INSTALL', false);
define('DOMAIN_CURRENT_SITE', '192.168.0.10');
define('PATH_CURRENT_SITE', '/aquarelle/');
define('SITE_ID_CURRENT_SITE', 1);
define('BLOG_ID_CURRENT_SITE', 1);


/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Инициализирует переменные WordPress и подключает файлы. */
require_once(ABSPATH . 'wp-settings.php');
