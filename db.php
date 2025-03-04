<?php

require_once 'config_test.php';
//require_once 'config.php';

class DB_Class
{
    private $connect;
    private $dbtable;

    // سازنده کلاس
    public function __construct($table)
    {

        $this->connect();
        $this->created_db();
        $this->dbtable = $table;
    }

    private function connect()
    {
        $host    = 'localhost'; // هاست دیتابیس
        $db      = DB_NAME;     // نام دیتابیس
        $user    = DB_USER;     // نام کاربری دیتابیس
        $pass    = DB_PASSWORD; // رمز عبور دیتابیس
        $charset = 'utf8mb4';

        $dsn     = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
         ];

        try {
            $this->connect = new PDO($dsn, $user, $pass, $options);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }
    }

    public function query($sql, $array = [  ], $style = PDO::FETCH_CLASS)
    {
        $stmt = $this->connect->prepare($sql);

        foreach ($array as $key => $value) {

            $stmt->bindvalue($key + 1, $value);
        } /*foreach*/

        $stmt->execute();

        return $stmt->fetchAll($style);

    } /*query*/

    public function created_db()
    {
        $sql = "CREATE TABLE IF NOT EXISTS `$this->dbtable` (
                `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                `name` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL,
                `slug` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
                `latest_version` varchar(10) NOT NULL,
                `description` text COLLATE utf8mb4_unicode_520_ci,
                `author` varchar(100) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
                `type` varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL,
                `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci";

        $this->query($sql);
    }

    public function num(array $where = [  ])
    {
        if (! is_array($where)) {
            return false;
        }

        $conditions = [  ];
        $values     = [  ];
        foreach ($where as $field => $value) {
            $conditions[  ] = "`$field` = ?";
            $values[  ]     = $value;
        }

        $conditions = implode(' AND ', $conditions);

        $in_where = "";

        if (sizeof($where) > 0) {$in_where = "WHERE $conditions";}

        $sql = "SELECT * FROM `$this->dbtable` $in_where  ";

        $stmt = $this->connect->prepare($sql);

        foreach ($values as $key => $value) {

            $stmt->bindValue($key + 1, $value);
        } /*forach*/

        $stmt->execute();

        return $stmt->rowCount();

    } /*select*/

    public function insert(array $data)
    {

        $formats = [  ];
        $values  = [  ];
        foreach ($data as $value) {
            $formats[  ] = '?';
            $values[  ]  = $value;
        }

        $fields  = '`' . implode('`, `', array_keys($data)) . '`';
        $formats = implode(', ', $formats);

        $sql = "INSERT INTO `$this->dbtable` ($fields) VALUES ($formats)";

        $stmt = $this->connect->prepare($sql);

        foreach ($values as $key => $value) {

            $stmt->bindvalue($key + 1, $value);
        } /*foreach*/

        $stmt->execute();

        return $this->num();

    } /*insert*/

    public function select(array $where = [  ], $style = PDO::FETCH_CLASS)
    {

        $where = '1=1 ';

        if (isset($args[ 'data' ])) {
            foreach ($args[ 'data' ] as $key => $value) {

                if (is_array($value)) {
                    $where .= ' AND (';
                    foreach ($value as $i => $row) {
                        if ($i == 1) {$where .= ' OR ';}

                        $where .= " `$key` = " . $row;
                    }
                    $where .= ')';
                } else {
                    $where .= " `$key` = " . $value;

                }

            }
        }

        if (isset($args[ 's' ])) {

            $key   = $args[ 's' ][ 0 ];
            $value = $args[ 's' ][ 1 ];

            $where .= " AND ` $key` LIKE $value";
        }

        if (isset($args[ 'where' ])) {
            $where .= " AND  {$args[ 'where' ]} ";
        }

        if (isset($args[ 'order_by' ])) {

            $key   = $args[ 'order_by' ][ 0 ];
            $value = $args[ 'order_by' ][ 1 ];

            $where .= " ORDER BY $key $value";
        }
        if (isset($args[ 'limit' ])) {

            $where .= " LIMIT " . intval($args[ 'limit' ]);
        }

        if (isset($args[ 'offset' ])) {
            $where .= " OFFSET " . intval($args[ 'offset' ]);
        }

        $star = (isset($args[ 'star' ])) ? $args[ 'star' ] : "*";

        $sql = "SELECT $star FROM `$this->dbtable` WHERE $where";

        $stmt = $this->connect->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll($style);

    } /*select*/

    public function get(array $where, $filter = [ '*' ], $style = PDO::FETCH_CLASS)
    {
        if (! is_array($where)) {
            return false;
        }

        $conditions = [  ];
        $values     = [  ];
        foreach ($where as $field => $value) {

            $conditions[  ] = "`$field` = ?";
            $values[  ]     = $value;
        }
        $filter = implode(', ', $filter);

        $conditions = implode(' AND ', $conditions);

        $sql = "SELECT $filter FROM `$this->dbtable` WHERE $conditions";

        $stmt = $this->connect->prepare($sql);

        foreach ($values as $key => $value) {

            $stmt->bindValue($key + 1, $value);
        } /*forach*/

        $stmt->execute();

        $row = $stmt->fetchAll($style);

        return ($row) ? $row[ 0 ] : 0;

    } /*get*/

    public function update(array $data, array $where)
    {

        $fields     = [  ];
        $conditions = [  ];
        $array      = [  ];

        foreach ($data as $field => $value) {
            $fields[  ] = "`$field` = ?";
            $array[  ]  = $value;
        }

        foreach ($where as $field => $value) {
            $conditions[  ] = "`$field` = ?";
            $array[  ]      = $value;
        }

        $fields     = implode(', ', $fields);
        $conditions = implode(' AND ', $conditions);

        $sql = "UPDATE `$this->dbtable` SET $fields WHERE $conditions";

        try {

            $stmt = $this->connect->prepare($sql);

            foreach ($array as $key => $value) {

                $stmt->bindvalue($key + 1, $value);
            } /*foreach*/

            $stmt->execute();

            $res = $stmt->rowCount();
        } catch (\Throwable $th) {
            //throw $th;

            $res = 0;
        }
        return $res;

    } /*update*/

    public function delete(array $where)
    {

        if (! is_array($where)) {
            return false;
        }

        $conditions = [  ];
        $values     = [  ];
        foreach ($where as $field => $value) {

            $conditions[  ] = "`$field` = ?";
            $values[  ]     = $value;
        }

        $conditions = implode(' AND ', $conditions);

        $sql = "DELETE FROM `$this->dbtable` WHERE $conditions";

        $stmt = $this->connect->prepare($sql);

        foreach ($values as $key => $value) {

            $stmt->bindvalue($key + 1, $value);
        } /*foreach*/

        $stmt->execute();
        return $stmt->rowCount();

    } /*delete*/

    public function sum(string $object): int | string
    {

        $sql = "SELECT SUM($object) FROM `$this->dbtable`";

        $stmt = $this->connect->prepare($sql);

        $stmt->execute();

        return $stmt->rowCount();

    } /*sum*/

} /*class*/