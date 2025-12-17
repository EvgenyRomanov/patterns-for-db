<?php

declare(strict_types=1);

namespace App\QueryResult;

use App\Db;
use App\Event\DatabaseQueryResultIsCreated;
use App\EventDispatcher;
use Exception;

class DatabaseQueryResultProxy extends DatabaseQueryResult
{
    private bool $firstIteration = true;
    protected EventDispatcher $eventDispatcher;

    public function __construct($query, $params, EventDispatcher $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->db = Db::getInstance();
        $this->query = $query;
        $this->params = $params;
        $this->position = 0;

        $this->eventDispatcher->dispatch(new DatabaseQueryResultIsCreated($this));
    }

    /**
     * @throws Exception
     */
    public function rewind(): void
    {
        $this->position = 0;

        if ($this->firstIteration) {
            $this->firstIteration = false;
            $this->executeQuery();
        }
    }
}
