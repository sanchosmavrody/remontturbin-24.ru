<?PHP
if (TRUE) {
    define("DBHOST_T", "185.246.65.104");

    define("DBNAME_T", "tecdoc");

    define("DBUSER_T", "tc_remote");

    define("DBPASS_T", "123123123");

    define("PREFIX_T", "TC");

    define("USERPREFIX_T", "TC");

    define("COLLATE_T", "utf8mb4");

    define('SECURE_AUTH_KEY_T', '0+Y:Gvpd!vNO>KUpsy;nIy56/G 5RXd/z]%t2Uid2H&7s|#3~-NHxp{CXs{c;7');
} else {


    define("DBHOST_T", "94.103.12.166");

    define("DBNAME_T", "TECDOC");

    define("DBUSER_T", "tc");

    define("DBPASS_T", "123123123");

    define("PREFIX_T", "TC");

    define("USERPREFIX_T", "TC");

    define("COLLATE", "utf8mb4");

    define('SECURE_AUTH_KEY', '0+Y:Gvpd!vNO>KUpsy;nIy56/G 5RXd/z]%t2Uid2H&7s|#3~-NHxp{CXs{c;7');
}
$db_TC = new db;

?>