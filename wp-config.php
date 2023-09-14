<?php
/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе установки.
 * Необязательно использовать веб-интерфейс, можно скопировать файл в "wp-config.php"
 * и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки базы данных
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://ru.wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Параметры базы данных: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define( 'DB_NAME', 'wppi' );

/** Имя пользователя базы данных */
define( 'DB_USER', 'root' );

/** Пароль к базе данных */
define( 'DB_PASSWORD', 'root' );

/** Имя сервера базы данных */
define( 'DB_HOST', 'localhost' );

/** Кодировка базы данных для создания таблиц. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Схема сопоставления. Не меняйте, если не уверены. */
define( 'DB_COLLATE', '' );

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу. Можно сгенерировать их с помощью
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}.
 *
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными.
 * Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'I6I#mF3u?bN90d={Md$Gz3PA8]9^j doGCf0F}9R<gq(&2[GY%dN-T88? b{vy]{' );
define( 'SECURE_AUTH_KEY',  '^)w>:2i(Q aWSkr#I;TAC@;he>x%)k(0[6mW#X-^Qx24t3#L(veDk(Cm70qJc/}a' );
define( 'LOGGED_IN_KEY',    'dE5&CO9;AG4G?S&G~IlC-QftP|Y9Vhq|^Bx>M!iT1TBW3eI@iO(@/5I;.:s0=<>q' );
define( 'NONCE_KEY',        'v~rdAz+<t)-!sB9z>*rRq9rtvo+N~?6 ICdo&Uc9COQz6GI_iw<|`),%{agE*,a ' );
define( 'AUTH_SALT',        'hZ;?dmpAY|)Q<ehaQX%xe.,^HUP*yUW 4,?bWNs,$-!z:~fOtX#Qyu%PS@,nN^h=' );
define( 'SECURE_AUTH_SALT', '|?0=HF!iRs+kO@)=j.Dc/1gc+*PFoB(j?9MX(M<wtG`GQPpeQu{c#6=dj*aFi4 ~' );
define( 'LOGGED_IN_SALT',   '3qK{M&=UJVn4Des5(+?i`7lz%^rb%2!<&Nt7I$9O2<,_S$DWN(]Z|ZEEYmeK|MX6' );
define( 'NONCE_SALT',       'k+f,q.|una OYMAoD,EoiUD;Cwxp0$?S,iE,2>AkbvJA>2O(.V;0JdNM(AOM&J^z' );

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix = 'wp_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 *
 * Информацию о других отладочных константах можно найти в документации.
 *
 * @link https://ru.wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Произвольные значения добавляйте между этой строкой и надписью "дальше не редактируем". */



/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Инициализирует переменные WordPress и подключает файлы. */
require_once ABSPATH . 'wp-settings.php';
