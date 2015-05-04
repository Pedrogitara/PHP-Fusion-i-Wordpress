<?php
/**
 * Podstawowa konfiguracja WordPressa.
 *
 * Ten plik zawiera konfiguracje: ustawień MySQL-a, prefiksu tabel
 * w bazie danych, tajnych kluczy i ABSPATH. Więcej informacji
 * znajduje się na stronie
 * {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Kodeksu. Ustawienia MySQL-a możesz zdobyć
 * od administratora Twojego serwera.
 *
 * Ten plik jest używany przez skrypt automatycznie tworzący plik
 * wp-config.php podczas instalacji. Nie musisz korzystać z tego
 * skryptu, możesz po prostu skopiować ten plik, nazwać go
 * "wp-config.php" i wprowadzić do niego odpowiednie wartości.
 *
 * @package WordPress
 */

// ** Ustawienia MySQL-a - możesz uzyskać je od administratora Twojego serwera ** //
/** Nazwa bazy danych, której używać ma WordPress */
define('DB_NAME', 'wordpress');

/** Nazwa użytkownika bazy danych MySQL */
define('DB_USER', 'root');

/** Hasło użytkownika bazy danych MySQL */
define('DB_PASSWORD', 'root');

/** Nazwa hosta serwera MySQL */
define('DB_HOST', 'localhost');

/** Kodowanie bazy danych używane do stworzenia tabel w bazie danych. */
define('DB_CHARSET', 'utf8');

/** Typ porównań w bazie danych. Nie zmieniaj tego ustawienia, jeśli masz jakieś wątpliwości. */
define('DB_COLLATE', '');

/**#@+
 * Unikatowe klucze uwierzytelniania i sole.
 *
 * Zmień każdy klucz tak, aby był inną, unikatową frazą!
 * Możesz wygenerować klucze przy pomocy {@link https://api.wordpress.org/secret-key/1.1/salt/ serwisu generującego tajne klucze witryny WordPress.org}
 * Klucze te mogą zostać zmienione w dowolnej chwili, aby uczynić nieważnymi wszelkie istniejące ciasteczka. Uczynienie tego zmusi wszystkich użytkowników do ponownego zalogowania się.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'Yo=Q6=V-Q|=|$isMr;l2zE<:DlY8jbDx:Y7x4%(`l+N$,ObDQ`G+_HcM?al5Lw>~');
define('SECURE_AUTH_KEY',  'kcW^PLbwM>-J`MFXUUk[3<cysVE%L9HnC]/Y(|;7]gqnyL-F~3%zm?vJSm4L6T}2');
define('LOGGED_IN_KEY',    'C&Cfs[uyq/40yUq^_@G/>+ Cx;RJ9>7Pde_([gw?viPmeB2YB~XBxB+Br*l7m{0s');
define('NONCE_KEY',        'B#u;FN#ZQ|eR)TNI*A2$i>ab[ux]yBrA:e:xlDA+@pjkt)RBAx=5a.dLWtqo7%@O');
define('AUTH_SALT',        'wc4l9{FSf+zhvZQMQha!+CBxn+R]7$=]fgmT=>|Dy!4qzwBo*cpKIU%`E(2iM@bA');
define('SECURE_AUTH_SALT', '&6j~B%V-QIJci(w]m-X6P?3|C|:)r_2u{MXU->s1*&`lzS3ziHd:=wL|=/doU*6q');
define('LOGGED_IN_SALT',   'TH&pc@gE;:;jw>;rr |!u_dR^Egz]XvV(@-|bnPMQ-X-8+3H78kgG/M^,H)<gY{%');
define('NONCE_SALT',       'N[37d]-kV~s V+D|jERHH!h]?uW9q`XL+4 bR#)v.<*qQ6i@P-+G/S$z-Al[pM7|');

/**#@-*/

/**
 * Prefiks tabel WordPressa w bazie danych.
 *
 * Możesz posiadać kilka instalacji WordPressa w jednej bazie danych,
 * jeżeli nadasz każdej z nich unikalny prefiks.
 * Tylko cyfry, litery i znaki podkreślenia, proszę!
 */
$table_prefix  = 'wp_';

/**
 * Dla programistów: tryb debugowania WordPressa.
 *
 * Zmień wartość tej stałej na true, aby włączyć wyświetlanie ostrzeżeń
 * podczas modyfikowania kodu WordPressa.
 * Wielce zalecane jest, aby twórcy wtyczek oraz motywów używali
 * WP_DEBUG w miejscach pracy nad nimi.
 */
define('WP_DEBUG', false);

/* To wszystko, zakończ edycję w tym miejscu! Miłego blogowania! */

/** Absolutna ścieżka do katalogu WordPressa. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Ustawia zmienne WordPressa i dołączane pliki. */
require_once(ABSPATH . 'wp-settings.php');
