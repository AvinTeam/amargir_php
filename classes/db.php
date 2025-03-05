<?php
class DB
{
    protected $connect;
    protected $dbtable;
    public $this_query;

    // سازنده کلاس
    public function __construct($table)
    {

        $this->connect();
        $this->created_db();
        $this->dbtable = 'mr_' . $table;
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

    public function query($sql, $params = [  ], $fetchStyle = PDO::FETCH_ASSOC)
    {
        try {
            // آماده‌سازی کوئری
            $stmt = $this->connect->prepare($sql);

            // اتصال پارامترها
            foreach ($params as $key => $value) {
                // اگر پارامترها به صورت named باشند (مثلاً :id)
                if (is_string($key)) {
                    $stmt->bindValue(':' . $key, $value);
                } else {
                    // اگر پارامترها به صورت positional باشند (مثلاً ?)
                    $stmt->bindValue($key + 1, $value);
                }
            }

            // اجرای کوئری
            $stmt->execute();

            // اگر کوئری از نوع SELECT باشد، نتایج را برگردان
            if (stripos($sql, 'SELECT') === 0) {
                return $stmt->fetchAll($fetchStyle);
            }

            // برای کوئری‌های INSERT, UPDATE, DELETE تعداد رکوردهای affected را برگردان
            return $stmt->rowCount();
        } catch (\PDOException $e) {
            // مدیریت خطاها
            throw new \PDOException("خطا در اجرای کوئری: " . $e->getMessage());
        }
    } /*query*/

    public function created_db()
    {

        $collate = COLLATE;

        $sql_user = "CREATE TABLE IF NOT EXISTS `mr_user` (
                        `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                        `user_username` varchar(100) NOT NULL,
                        `user_password` varchar(50) NOT NULL,
                        `user_type` varchar(10) NOT NULL,
                        `user_verify` varchar(50) NOT NULL,
                        PRIMARY KEY (`id`) )
                        ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=$collate";

        $this->query($sql_user);

        $sql_sms = "CREATE TABLE IF NOT EXISTS  `mr_sms` (
                    `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                    `sms_key` int unsigned NOT NULL,
                    `sms_count` int unsigned NOT NULL,
                    `mr_date` date NOT NULL,
                    PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=$collate";

        $this->query($sql_sms);

        $sql_program_view = "CREATE TABLE IF NOT EXISTS `mr_program_view` (
                    `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                    `p_key` varchar(20) NOT NULL,
                    `p_count` int unsigned NOT NULL,
                    `mr_date` date NOT NULL,
                    PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=$collate";

        $this->query($sql_program_view);

        $sql_program_mc = "CREATE TABLE IF NOT EXISTS `mr_program_mc` (
                    `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                    `p_key` varchar(20) NOT NULL,
                    `p_count` int unsigned NOT NULL,
                    `mr_date` date NOT NULL,
                    PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=$collate";

        $this->query($sql_program_mc);

        $sql_gender = "CREATE TABLE IF NOT EXISTS `mr_gender` (
                    `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                    `p_key` varchar(20) NOT NULL,
                    `male` int unsigned NOT NULL,
                    `female` int unsigned NOT NULL,
                    `mr_date` date NOT NULL,
                    PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=$collate";

        $this->query($sql_gender);

        $sql_match_clock = "CREATE TABLE IF NOT EXISTS `mr_match_clock` (
                    `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                    `clock_0` int unsigned NOT NULL,
                    `clock_6` int unsigned NOT NULL,
                    `clock_12` int unsigned NOT NULL,
                    `clock_18` int unsigned NOT NULL,
                    `mr_date` date NOT NULL,
                    PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=$collate";

        $this->query($sql_match_clock);

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

        $this->this_query = $sql = "SELECT * FROM `$this->dbtable` $in_where  ";

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

        $this->this_query = $sql = "INSERT INTO `$this->dbtable` ($fields) VALUES ($formats)";

        $stmt = $this->connect->prepare($sql);

        foreach ($values as $key => $value) {

            $stmt->bindvalue($key + 1, $value);
        } /*foreach*/

        $stmt->execute();

        return $this->num();

    } /*insert*/

    public function select(array $args = [  ], $style = PDO::FETCH_CLASS)
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
                    $where .= " AND `$key` = " . $value;

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

        $this->this_query = $sql = "SELECT $star FROM `$this->dbtable` WHERE $where";

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

        $this->this_query = $sql = "SELECT $filter FROM `$this->dbtable` WHERE $conditions";

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

        // ساخت بخش SET کوئری
        foreach ($data as $field => $value) {
            $fields[  ] = "`$field` = ?";
            $array[  ]  = $value;
        }

        // ساخت بخش WHERE کوئری
        foreach ($where as $field => $value) {
            $conditions[  ] = "`$field` = ?";
            $array[  ]      = $value;
        }

        // ترکیب بخش‌های SET و WHERE
        $fields     = implode(', ', $fields);
        $conditions = implode(' AND ', $conditions);

        // ساخت کوئری کامل
        $this->this_query = $sql = "UPDATE `$this->dbtable` SET $fields WHERE $conditions";

        try {

            // اجرای کوئری
            $stmt = $this->connect->prepare($sql);

            foreach ($array as $key => $value) {
                $stmt->bindValue($key + 1, $value);
            }

            $stmt->execute();

            // تعداد رکوردهای به‌روزرسانی شده
            return $stmt->rowCount();
        } catch (\Throwable $th) {
            // نمایش خطا
            echo "خطا: " . $th->getMessage();
            return 0;
        }
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

        $this->this_query = $sql = "DELETE FROM `$this->dbtable` WHERE $conditions";

        $stmt = $this->connect->prepare($sql);

        foreach ($values as $key => $value) {

            $stmt->bindvalue($key + 1, $value);
        } /*foreach*/

        $stmt->execute();
        return $stmt->rowCount();

    } /*delete*/

    public function sum(string $object, array $data, string $where = ""): int | string
    {
        $sqlwhere = "";

        if (! empty($data)) {

            foreach ($data as $key => $value) {

                $sqlwhere .= " AND  `$key` = {$this->set_type($value)} ";
            }
        }

        if (! empty($where)) {

            $sqlwhere = " AND  $where ";

        }

        $this->this_query = $sql = "SELECT SUM($object) FROM `$this->dbtable` WHERE 1=1 $sqlwhere";

        $stmt = $this->connect->query($sql);

        return $stmt->fetchColumn();

    } /*sum*/

    public function group(string $object, array $data = [  ], string $group = "", $style = PDO::FETCH_CLASS)
    {
        $sqlwhere = "";

        if (! empty($data)) {

            foreach ($data as $key => $value) {

                $sqlwhere .= " AND  `$key` = {$this->set_type($value)} ";
            }
        }

        if (! empty($group)) {

            $sqlwhere = " GROUP BY  $group ";

        }

        $this->this_query = $sql = "SELECT $object FROM `$this->dbtable` WHERE 1=1 $sqlwhere";

        $stmt = $this->connect->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll($style);

    } /*sum*/

    protected function set_type($item)
    {
        switch (gettype($item)) {
            case 'integer':
                return $item;
                break;

            case 'string':
                return "'$item'";
                break;

            default:
                return $item;
                break;
        }

    }

} /*class*/
