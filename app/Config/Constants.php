<?php

/*
 | --------------------------------------------------------------------
 | App Namespace
 | --------------------------------------------------------------------
 |
 | This defines the default Namespace that is used throughout
 | CodeIgniter to refer to the Application directory. Change
 | this constant to change the namespace that all application
 | classes should use.
 |
 | NOTE: changing this will require manually modifying the
 | existing namespaces of App\* namespaced-classes.
 */
defined('APP_NAMESPACE') || define('APP_NAMESPACE', 'App');

/*
 | --------------------------------------------------------------------------
 | Composer Path
 | --------------------------------------------------------------------------
 |
 | The path that Composer's autoload file is expected to live. By default,
 | the vendor folder is in the Root directory, but you can customize that here.
 */
defined('COMPOSER_PATH') || define('COMPOSER_PATH', ROOTPATH . 'vendor/autoload.php');

/*
 |--------------------------------------------------------------------------
 | Timing Constants
 |--------------------------------------------------------------------------
 |
 | Provide simple ways to work with the myriad of PHP functions that
 | require information to be in seconds.
 */
defined('SECOND') || define('SECOND', 1);
defined('MINUTE') || define('MINUTE', 60);
defined('HOUR')   || define('HOUR', 3600);
defined('DAY')    || define('DAY', 86400);
defined('WEEK')   || define('WEEK', 604800);
defined('MONTH')  || define('MONTH', 2_592_000);
defined('YEAR')   || define('YEAR', 31_536_000);
defined('DECADE') || define('DECADE', 315_360_000);

/*
 | --------------------------------------------------------------------------
 | Exit Status Codes
 | --------------------------------------------------------------------------
 |
 | Used to indicate the conditions under which the script is exit()ing.
 | While there is no universal standard for error codes, there are some
 | broad conventions.  Three such conventions are mentioned below, for
 | those who wish to make use of them.  The CodeIgniter defaults were
 | chosen for the least overlap with these conventions, while still
 | leaving room for others to be defined in future versions and user
 | applications.
 |
 | The three main conventions used for determining exit status codes
 | are as follows:
 |
 |    Standard C/C++ Library (stdlibc):
 |       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
 |       (This link also contains other GNU-specific conventions)
 |    BSD sysexits.h:
 |       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
 |    Bash scripting:
 |       http://tldp.org/LDP/abs/html/exitcodes.html
 |
 */
defined('EXIT_SUCCESS')        || define('EXIT_SUCCESS', 0);        // no errors
defined('EXIT_ERROR')          || define('EXIT_ERROR', 1);          // generic error
defined('EXIT_CONFIG')         || define('EXIT_CONFIG', 3);         // configuration error
defined('EXIT_UNKNOWN_FILE')   || define('EXIT_UNKNOWN_FILE', 4);   // file not found
defined('EXIT_UNKNOWN_CLASS')  || define('EXIT_UNKNOWN_CLASS', 5);  // unknown class
defined('EXIT_UNKNOWN_METHOD') || define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     || define('EXIT_USER_INPUT', 7);     // invalid user input
defined('EXIT_DATABASE')       || define('EXIT_DATABASE', 8);       // database error
defined('EXIT__AUTO_MIN')      || define('EXIT__AUTO_MIN', 9);      // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      || define('EXIT__AUTO_MAX', 125);    // highest automatically-assigned error code

/**
 * @deprecated Use \CodeIgniter\Events\Events::PRIORITY_LOW instead.
 */
define('EVENT_PRIORITY_LOW', 200);

/**
 * @deprecated Use \CodeIgniter\Events\Events::PRIORITY_NORMAL instead.
 */
define('EVENT_PRIORITY_NORMAL', 100);

/**
 * @deprecated Use \CodeIgniter\Events\Events::PRIORITY_HIGH instead.
 */
define('EVENT_PRIORITY_HIGH', 10);

if ($_SERVER['HTTP_HOST'] == 'localhost') {
    $addurl = '/' . 'pnglobal/';
} else {
    $addurl = '/';
}

$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https://' . $_SERVER['HTTP_HOST'] . $addurl : 'http://' . $_SERVER['HTTP_HOST'] . $addurl;
defined('BASE_URL') || define('BASE_URL', $protocol);


define("NAMETITLE", 'PN Global');
define("SATOSHITITLE", 'Satoshi Signal');

$host = $_SERVER['HTTP_HOST']; // e.g., sandbox.satoshisignal.app

$parts = explode('.', $host);
if ($parts[0] === 'sandbox' || $host === 'localhost:8080') {
    define("URLAPI", 'https://api2-sandbox.pnglobalinternational.com');
    define("URLAPI2", 'https://sandbox-api.pnglobalinternational.com');
    define("URL_HEDGEFUND", 'https://elite-sandbox.pnglobalinternational.com');
    define("URL_COURSE", 'https://course-sandbox.pnglobalinternational.com');

    //email DEMO
    define("EMAIL_ONE", 'demo@gmail.com');
    define("EMAIL_TWO", 'demo@gmail.com');
    //STRIPE DEMO
    define("PUBLIC_KEY", 'pk_test_51Ph1A4RpjQaOZ7NCQcbJtlXTgcbQm5ulhsm1YgkkfS5LHvHKVZ79p1qP0lOJaxz1XsDMpALi1aUeoxocxD6Can5900DCqNrIHS');
    define("SECRET_KEY", 'sk_test_51Ph1A4RpjQaOZ7NCuVCzdyyy342tNGnlrfnDyox5YirDorblTYDPP7dXK9K4fGqJazDRwyReh9HnLf5MWS7hOUsA00GtKiFgQQ');

    define('COINPAYMENTS_PUBLIC_KEY', 'c88682370e2305c4b62170adad73ea0fc9804e36a7bee57554de8c464802e4a8');
    define('COINPAYMENTS_PRIVATE_KEY', '98D2F844E0d3B4366E49252A50AC49ce1d4163d2B422e1233962c1c309924996');
    define('COINPAYMENTS_API_URL', 'https://www.coinpayments.net/api.php');
    define('COINPAYMENTS_CURRENCY_USDT', 'LTCT');
    define('COINPAYMENTS_CURRENCY_USDC', 'LTCT');
    define('ADMIN_ID', 1);

    // account ftp
    define('FTP_HOSTNAME', 'remote.piggybankservice.com');
    define('FTP_USERNAME', 'pnglobal@remote.piggybankservice.com');
    define('FTP_PASSWORD', 'YnTAc)9M;]Y#)*rG');
} else {
    define("URLAPI", 'https://broker.pnglobalinternational.com');
    define("URLAPI2", 'https://api.pnglobalinternational.com');
    define("URL_HEDGEFUND", 'https://hedgefund.pnglobalinternational.com');
    define("URL_COURSE", 'https://course.pnglobalinternational.com');

    //email live
    define("EMAIL_ONE", 'pnglobal.usa@gmail.com');
    define("EMAIL_TWO", 'robnolfo62@gmail.com');

    //STRIPE RIIL
    define("PUBLIC_KEY", 'pk_live_51OHVdwC8KQHLEjXQ88yk2DqcZUQtLIAAWJYumnMwHJC4tQi95Cu514mFtxPD8ezJMOJI6NhTgDy9T5GJJ7dSRyyR00RLGJMXU9');
    define("SECRET_KEY", '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');

    define('COINPAYMENTS_PUBLIC_KEY', 'b6f12a1d9377e1f6d7fd2597d5f8804db63a146e840f3cc36aa9002f83909ea3');
    define('COINPAYMENTS_PRIVATE_KEY', 'a5b69FDe3B46d849ddD2eB0d8C2563E135B9ad58e3F45E54F5617F02500Df42e');
    define('COINPAYMENTS_API_URL', 'https://www.coinpayments.net/api.php');
    define('COINPAYMENTS_CURRENCY_USDT', 'USDT.BEP20');
    define('COINPAYMENTS_CURRENCY_USDC', 'USDC.BEP20');
    define('ADMIN_ID', 1);

    // account ftp
    define('FTP_HOSTNAME', 'remote.piggybankservice.com');
    define('FTP_USERNAME', 'pnglobal@remote.piggybankservice.com');
    define('FTP_PASSWORD', 'YnTAc)9M;]Y#)*rG');
}

define("FEEMEETING", 'EUR 150');
define("IDGTAG", 'G-Y7SBM0618C');

// For Email
define("HOST_MAIL", 'mail.pnglobalinternational.com');
define("USERNAME_MAIL", 'no-reply@pnglobalinternational.com');
define("PASS_MAIL", 'Jzg-iF%^HM!x');
