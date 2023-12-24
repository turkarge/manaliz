<?php
class DB extends Upload
{
    const HOST = "localhost";
    const USERNAME = "celikerler_ma";
    const PASSWORD = "CelMa753!";
    const DATABASE = "celikerler_ma";
    protected static $connection;
    public static $table;
    public static $select = "*";
    public static $whereRawKey;
    public static $whereRawVal;
    public static $whereKey;
    public static $whereVal = array();
    public static $orderBy = NULL;
    public static $limit = NULL;
    public static $join = "";
    public static $leftJoin = "";
    function __construct()
    {
        self::__connect();
    }
    public static function __connect()
    {
        try {
            self::$connection = new PDO("mysql:host=" . self::HOST . ";dbname=" . self::DATABASE . ";charset=utf8", self::USERNAME, self::PASSWORD);
        } catch (PDOException $error) {
            $data = (object) ["type" => "501", "title" => "Connection Error!", "message" => "Veritabanına bağlantı başarısız oldu.", "code" => $error->getMessage()];
            return self::view("connection", $data);
            exit();
        }
    }
    public static function table($tableName)
    {
        self::$table = $tableName;
        self::$select = "*";
        self::$whereRawKey = NULL;
        self::$whereRawVal = NULL;
        self::$whereKey = NULL;
        self::$whereVal = array();
        self::$orderBy = NULL;
        self::$limit = NULL;
        self::$join = "";
        self::$leftJoin = "";
        return new self;
    }
    public static function select($colums)
    {
        self::$select = (is_array($colums)) ? implode(",", $colums) : $colums;
        return new self;
    }
    public static function whereRaw($whereRaw, $whereRawVal)
    {
        self::$whereRawKey = "(" . $whereRaw . ")";
        self::$whereRawVal = $whereRawVal;
        return new self;
    }
    public static function where($colums1, $colums2 = NULL, $colums3 = NULL)
    {
        if (is_array($colums1) != false) {
            $keyList = array();
            foreach ($colums1 as $key => $item) {
                self::$whereVal[] = $item;
                $keyList[] = $key;
            }
            self::$whereKey = implode("=? AND ", $keyList) . "=?";
        } else if ($colums2 != NULL && $colums3 == NULL) {
            self::$whereVal[] = $colums2;
            self::$whereKey = $colums1 . "=?";
        } else if ($colums3 != NULL) {
            self::$whereVal[] = $colums3;
            self::$whereKey = $colums1 . $colums2 . "?";
        }
        return new self;
    }
    public static function orderBy($parameter)
    {
        self::$orderBy = $parameter[0] . " " . ((!empty($parameter[1])) ? $parameter[1] : "ASC");
        return new self;
    }
    public static function limit($start, $end = NULL)
    {
        self::$limit = $start . (($end != NULL) ? "," . $end : "");
        return new self;
    }
    public static function join($tableName, $thisColums, $joinColums)
    {
        self::$join .= "INNER JOIN " . $tableName . " ON " . self::$table . "." . $thisColums . "=" . $tableName . "." . $joinColums . " ";
        return new self;
    }
    public static function leftJoin($tableName, $thisColums, $joinColums)
    {
        self::$join .= "LEFT JOIN " . $tableName . " ON " . self::$table . "." . $thisColums . "=" . $tableName . "." . $joinColums . " ";
        return new self;
    }

    public static function get()
    {
        $SQL = "SELECT " . self::$select . " FROM " . self::$table . " ";
        $SQL .= (!empty(self::$join)) ? self::$join : "";
        $SQL .= (!empty(self::$leftJoin)) ? self::$leftJoin : "";
        $WHERE = NULL;
        if (!empty(self::$whereKey) && !empty(self::$whereRawKey)) {
            $SQL .= "WHERE " . self::$whereKey . " AND " . self::$whereRawKey . " ";
            $WHERE = array_merge(self::$whereVal, self::$whereRawVal);
        } else {
            if (!empty(self::$whereKey)) {
                $SQL .= "WHERE " . self::$whereKey . " ";
                $WHERE = self::$whereVal;
            }
            if (!empty(self::$whereRawKey)) {
                $SQL .= "WHERE " . self::$whereRawKey . " ";
                $WHERE = self::$whereRawVal;
            }
        }

        $SQL .= (!empty(self::$orderBy)) ? "ORDER BY " . self::$orderBy . " " : "";
        $SQL .= (!empty(self::$limmit)) ? "LIMIT " . self::$limit : "";

        if ($WHERE != NULL) {
            $Entity = self::$connection->prepare($SQL);
            $Sync = $Entity->execute($WHERE);
        } else {
            $Entity = self::$connection->query($SQL);
        }
        $Result = $Entity->fetchAll(PDO::FETCH_ASSOC);
        if ($Result != false) {
            $data = [];
            foreach ($Result as $item) {
                $data[] = (object) $item;
            }
            return $data;

        } else {
            return false;
        }
    }

    public static function first()
    {
        $entity = self::get();
        if ($entity) {
            return $entity[0];
        } else {
            return false;
        }
    }

    public static function create($arrayColums)
    {
        $colums = array_keys($arrayColums);
        $columsVal = array_values($arrayColums);
        $SQL = "INSERT INTO " . self::$table . " SET " . implode("=?, ", $colums) . "=?";

        $entity = self::$connection->prepare($SQL);
        $sync = $entity->execute($columsVal);
        if ($sync != false)
            return true;
        else
            return false;
    }

    public static function update($arrayColums)
    {
        $colums = array_keys($arrayColums);
        $columsVal = array_values($arrayColums);
        $SQL = "UPDATE " . self::$table . " SET " . implode("=?, ", $colums) . "=? ";
        $WHERE = NULL;
        if (!empty(self::$whereKey) && !empty(self::$whereRawKey)) {
            $SQL .= "WHERE " . self::$whereKey . " AND " . self::$whereRawKey . " ";
            $WHERE = array_merge(self::$whereVal, self::$whereRawVal);
        } else {
            if (!empty(self::$whereKey)) {
                $SQL .= "WHERE " . self::$whereKey . " ";
                $WHERE = self::$whereVal;
            }
            if (!empty(self::$whereRawKey)) {
                $SQL .= "WHERE " . self::$whereRawKey . " ";
                $WHERE = self::$whereRawVal;
            }
        }
        if ($WHERE != NULL) {
            $arrayColums = array_merge($columsVal, $WHERE);
        }
        $entity = self::$connection->prepare($SQL);
        $sync = $entity->execute($arrayColums);
        if ($sync != false)
            return true;
        else
            return false;
    }

    public static function delete()
    {
        $SQL = "DELETE FROM " . self::$table . " ";
        $WHERE = NULL;
        if (!empty(self::$whereKey) && !empty(self::$whereRawKey)) {
            $SQL .= "WHERE " . self::$whereKey . " AND " . self::$whereRawKey . " ";
            $WHERE = array_merge(self::$whereVal, self::$whereRawVal);
        } else {
            if (!empty(self::$whereKey)) {
                $SQL .= "WHERE " . self::$whereKey . " ";
                $WHERE = self::$whereVal;
            }
            if (!empty(self::$whereRawKey)) {
                $SQL .= "WHERE " . self::$whereRawKey . " ";
                $WHERE = self::$whereRawVal;
            }
        }
        $entity = self::$connection->prepare($SQL);
        $sync = $entity->execute($WHERE);
        if ($sync != false)
            return true;
        else
            return false;
    }

    public static function primaryID($tableName)
    {
        $SQL = "SHOW TABLE STATUS FROM " . self::DATABASE . " WHERE Name='" . $tableName . "'";
        $entity = self::$connection->query($SQL);
        $result = $entity->fetchAll(PDO::FETCH_ASSOC);
        return ($result[0]["Auto_increment"]);
    }

    public static function updateOrCreate($whereArray, $columsArray)
    {
        self::where($whereArray);
        $getResult = self::first();
        if ($getResult)
            return self::update($columsArray);
        else
            return self::create($columsArray);
    }
    public static function view($pagename, $error)
    {
        $fileHref = "errors/" . $pagename . ".php";
        if (file_exists($fileHref))
            include_once($fileHref);
        elseif (file_exists("../" . $fileHref))
            include_once("../" . $fileHref);
    }
    public static function filter($data)
    {
        return addslashes(strip_tags($data));
    }
}
?>