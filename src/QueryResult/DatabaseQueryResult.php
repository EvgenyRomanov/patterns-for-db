<?php

declare(strict_types=1);

namespace App\QueryResult;

use App\Db;
use App\Event\DatabaseQueryResultIsCreated;
use App\Event\SqlIsExecuted;
use App\EventDispatcher;
use Exception;
use Iterator;

class DatabaseQueryResult implements Iterator
{
    protected Db $db;
    protected string $query;
    protected array $params;
    protected int $position;
    protected ?array $result = null;
    protected EventDispatcher $eventDispatcher;

    /**
     * @throws Exception
     */
    public function __construct($query, $params, EventDispatcher $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->db = Db::getInstance();
        $this->query = $query;
        $this->params = $params;
        $this->position = 0;

        $this->executeQuery();
        $this->eventDispatcher->dispatch(new DatabaseQueryResultIsCreated($this));
    }

    /**
     * @throws Exception
     */
    protected function executeQuery(): void
    {
        if (is_null($this->result)) {
            $this->result = $this->db->query($this->query, $this->params);
        }

        if (is_null($this->result)) {
            throw new Exception("Query execution error");
        }

        $this->eventDispatcher->dispatch(new SqlIsExecuted($this));
    }

    public function current(): mixed
    {
        return $this->result[$this->position];
    }

    public function next(): void
    {
        ++$this->position;
    }

    public function key(): int
    {
        return $this->position;
    }

    public function valid(): bool
    {
        return isset($this->result[$this->position]);
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function getQuery(): string
    {
        return $this->query;
    }
}
