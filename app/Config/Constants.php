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
defined('MONTH')  || define('MONTH', 2592000);
defined('YEAR')   || define('YEAR', 31536000);
defined('DECADE') || define('DECADE', 315360000);

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
defined('EXIT_SUCCESS')        || define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          || define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         || define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   || define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  || define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') || define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     || define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       || define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      || define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      || define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

/**
 * CUSTOM CONSTANTS
 */
defined('CSSPATH')              || define('CSSPATH', "/public/assets/css"); // CSS PATH
defined('JSPATH')               || define('JSPATH', "/public/assets/js"); // JS PATH
defined('IMGPATH')              || define('IMGPATH', "/public/assets/img"); // IMG PATH
defined('JSLIB')                || define('JSLIB', "/public/assets/bundles"); // IMG PATH
defined('ADMIN')                || define('ADMIN', "/admin");
defined('ADMINPROFILEFOLDER')   || define('ADMINPROFILEFOLDER', 'admin-profile-images');
defined('USERPROFILEFOLDER')    || define('USERPROFILEFOLDER', 'user-profile-images');
defined("UPLOADPATH")           || define('UPLOADPATH', "/public/uploads/");
defined("USERPROFILEIMAGEPATH") || define('USERPROFILEIMAGEPATH', UPLOADPATH.USERPROFILEFOLDER);
defined("ADMINPROFILEIMAGEPATH")|| define('ADMINPROFILEIMAGEPATH', UPLOADPATH.ADMINPROFILEFOLDER);
defined("CONTESTBANNERFOLDER")  || define('CONTESTBANNERFOLDER','contest-banneers');
defined("CONTESTBANNERFOLDERPATH")|| define('CONTESTBANNERFOLDERPATH', UPLOADPATH.CONTESTBANNERFOLDER);
defined("CONTESTPDFFOLDER")    || define('CONTESTPDFFOLDER','contest-pdf');
defined("CONTESTPDFFOLDERPATH")|| define('CONTESTPDFFOLDERPATH', UPLOADPATH.CONTESTPDFFOLDER);
defined("BANNERFOLDER")        || define('BANNERFOLDER','banners');
defined("BANNERFOLDERPATH")    || define('BANNERFOLDERPATH', UPLOADPATH.BANNERFOLDER);
defined("PROMOCODEBANNERFOLDER") || define('PROMOCODEBANNERFOLDER','promocodebanner');
defined("PROMOCODEBANNERFOLDERPATH")|| define('PROMOCODEBANNERFOLDERPATH', UPLOADPATH.PROMOCODEBANNERFOLDER);

/**
 * SETTING CONSTANT
 */
#Setting Key
defined('POINT_PRICE') | define('POINT_PRICE', 'POINT_PRICE');
defined('PAYPAL_SETTING') | define('PAYPAL_SETTING', 'PAYPAL_SETTING');
#End Setting Key
#Price json key
defined('POINT') | define('POINT', 'POINT');
defined('POINT_PRICE_VALUE') | define('POINT_PRICE_VALUE', 'POINT_PRICE_VALUE');
#End
#PAYPAL KEY
defined('PAYPAL_CLIENT_KEY') | define('PAYPAL_CLIENT_KEY', 'PAYPAL_CLIENT_KEY');
defined('PAYPAL_SECRET_KEY') | define('PAYPAL_SECRET_KEY', 'PAYPAL_SECRET_KEY');
#END
#FIREBASE
defined('FIREBASE_SERVER_KEY') | define('FIREBASE_SERVER_KEY', 'FIREBASE_SERVER_KEY');
#END

defined('CURRENCY') | define('CURRENCY', '$');

#API ACCESS TOKEN
defined('ACCESS_TOKON') | define('ACCESS_TOKON', 'WeeklythrowWood072a653');

#PAYPAL PAYMENT MODE
defined('PAYPALMODE') | define('PAYPALMODE', 'SANDBOX');
#defined('PAYPALMODE') | define('PAYPALMODE', 'PRODUCTION');

