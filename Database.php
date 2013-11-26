<?
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
        $this->db->exec("set time_zone='+00:00'");
    }

    public static function db()
    {
        return static::getInstance()->db;
    }
}