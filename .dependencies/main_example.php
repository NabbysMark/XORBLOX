<?php

// SETTINGS * do not touch plz unless you know what your doing

$settings = [];

// site settings * turn off maintenance and change security key if your planning to host this
// also recommended to keep inviteonly on, 2008 is tricky when your dealing with a bunch of users.
$settings["site"]["maintenance"] = true;
$settings["site"]["inviteonly"] = true;
$settings["site"]["securitykey"] = "CHANGE_THIS_TO_ANYTHING_YOU_LIKE";

// database settings * change connectionstring.
$settings["db"]["connectionstring"] = "SQL_SERVER_IP;DATABASE_NAME_HERE;DATABASE_USER_HERE;PASSWORD_HERE;SQL_SERVER_PORT_USUALLY_3306";

// RCCService settings * change ip, port if your not using port 64989 and baseurl
$settings["rcc"]["ip"] = "localhost";
$settings["rcc"]["baseUrl"] = "http://www.zonbom.xyz/";
$settings["rcc"]["port"] = 64989;

// ACTUAL CODE WHICH CONTROLS DATABASE AND COMPONENTS, DONT TOUCH IF YOU DONT KNOW WHAT ANY OF THIS MEANS

class DateFormatter {
    public static function TimeAgo(string $datetime): string
    {
        $time = new DateTime($datetime);
        $now = new DateTime();

        $diff = $now->diff($time);

        if ($time > $now) {
            return "just now";
        }

        if ($diff->y > 0) {
            return $diff->y . " year" . ($diff->y > 1 ? "s" : "") . " ago";
        }

        if ($diff->m > 0) {
            return $diff->m . " month" . ($diff->m > 1 ? "s" : "") . " ago";
        }

        if ($diff->d > 0) {
            return $diff->d . " day" . ($diff->d > 1 ? "s" : "") . " ago";
        }

        if ($diff->h > 0) {
            return $diff->h . " hour" . ($diff->h > 1 ? "s" : "") . " ago";
        }

        if ($diff->i > 0) {
            return $diff->i . " minute" . ($diff->i > 1 ? "s" : "") . " ago";
        }

        return "just now";
    }
}

class Database {
    private ?string $connectionString = null;
    private ?PDO $connection = null;

    public function __construct(string $connectionString)
    {
        $this->connectionString = $connectionString;
    }

    public function getConnection(): PDO
    {
        if ($this->connection !== null) {
            return $this->connection;
        }

        $parts = explode(";", $this->connectionString);
        if (count($parts) !== 5) { throw new InvalidArgumentException("Invalid database connection string. Expected host;database;username;password;port."); }

        [$servername, $dbname, $username, $password, $port] = $parts;

        if (!is_numeric($port) || (int)$port < 1 || (int)$port > 65535) {
            throw new InvalidArgumentException("Invalid database port.");
        }

        $this->connection = new PDO(
            "mysql:host=$servername;port=$port;dbname=$dbname;charset=utf8mb4",
            $username,
            $password,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ]
        );

        return $this->connection;
    }

    public function query(string $sql, array $params = []): PDOStatement
    {
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute($params);

        return $stmt;
    }

    public function fetch(string $sql, array $params = []): ?array
    {
        $result = $this->query($sql, $params)->fetch();

        return $result === false ? null : $result;
    }

    public function fetchAll(string $sql, array $params = []): array
    {
        return $this->query($sql, $params)->fetchAll();
    }

    public function insert(string $sql, array $params = []): string
    {
        $this->query($sql, $params);

        return $this->getConnection()->lastInsertId();
    }

    public function execute(string $sql, array $params = []): int
    {
        return $this->query($sql, $params)->rowCount();
    }

    public function beginTransaction(): bool
    {
        return $this->getConnection()->beginTransaction();
    }

    public function commit(): bool
    {
        return $this->getConnection()->commit();
    }

    public function rollBack(): bool
    {
        $pdo = $this->getConnection();

        if ($pdo->inTransaction()) {
            return $pdo->rollBack();
        }

        return false;
    }

    public function inTransaction(): bool
    {
        return $this->getConnection()->inTransaction();
    }
}

class Component
{
    public static function Render(string $name, array $data = []): void
    {
        $name = str_replace("\\", "/", $name);
        $name = trim($name, "/");

        if (!preg_match('/^[a-zA-Z0-9_\/-]+$/', $name)) {
            echo "Invalid component name.";
            return;
        }

        if (!str_ends_with($name, ".php")) {
            $name .= ".php";
        }

        $basePath = realpath($_SERVER["DOCUMENT_ROOT"] . "/.components");
        $path = realpath($basePath . "/" . $name);

        if (!$basePath || !$path || !str_starts_with(
            $path,
            $basePath . DIRECTORY_SEPARATOR
        )) {
            echo "Component not found.";
            return;
        }

        if (!is_file($path)) {
            echo "Component not found.";
            return;
        }

        extract($data, EXTR_SKIP);

        require $path;
    }
}

$db = new Database($settings["db"]["connectionstring"]);

if ($settings["site"]["maintenance"]) {

}