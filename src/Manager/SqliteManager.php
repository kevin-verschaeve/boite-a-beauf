<?php

namespace BAB\Manager;

class SqliteManager
{
    /** @var \PDO */
    private $pdo;

    public function __construct(string $dsn)
    {
        $pdo = new \PDO($dsn);
        $pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_CLASS);
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        $this->pdo = $pdo;
    }

    public function query(string $sql, array $params = [], string $className = 'stdClass'): array
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(\PDO::FETCH_CLASS, $className);
    }

    public function queryRow(string $sql, array $params = [], string $className = 'stdClass')
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        $result = $stmt->fetchObject($className);

        if (false === $result) {
            throw new \Exception('Aucun son trouvé.');
        }

        return $result;
    }

    public function insert(string $sql, array $params = []): bool
    {
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute($params);
    }
}
