<?php

declare(strict_types=1);

namespace App;

use Exception;
use PDO;
use PDOException;

final class Db
{
    private static ?Db $instance = null;

    private PDO $pdo;

    /**
     * @throws Exception
     */
    private function __construct()
    {
        try {
            /** @var string $dbHost */
            $dbHost = getenv('DB_HOST');
            /** @var string $dbName */
            $dbName = getenv('DB_DATABASE');
            /** @var string $dbUser */
            $dbUser = getenv('DB_USERNAME');
            /** @var string $dbPass */
            $dbPass = getenv('DB_PASSWORD');

            $this->pdo = new PDO(
                "pgsql:host=$dbHost;port=5432;dbname=$dbName",
                $dbUser,
                $dbPass,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]
            );
        } catch (PDOException $e) {
            throw new Exception('Ошибка при подключении к базе данных: ' . $e->getMessage());
        }
    }

    public function query(string $sql, array $params = [], string $className = 'stdClass'): ?array
    {
        $sth = $this->pdo->prepare($sql);
        $result = $sth->execute($params);

        if (false === $result) {
            return null;
        }

        return $sth->fetchAll(PDO::FETCH_CLASS, $className);
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getLastInsertId(): int
    {
        return (int) $this->pdo->lastInsertId();
    }
}
