<?
/**
/* @author Walker Gusmão - walker@praiseweb.com.br
/* @license http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
*/

abstract class Database
   {

    protected static $instance;

    protected $db;

    protected static $type = DBTYPE;
    protected static $host = DBHOST;
    protected static $user = DBUSER;
    protected static $pass = DBPASS;
    protected static $database = DBNAME;

    public static function getInstance()
    {
        if (!isset(self::$instance)) self::$instance = new static();

        return self::$instance;
    }

    protected function __construct()
    {
        $this->db = new PDO(sprintf('%s:host=%s;dbname=%s', static::$type, static::$host, static::$database), static::$user, static::$pass,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public static function db()
    {
        return static::getInstance()->db;
    }
}
