<?php

declare(strict_types=1);

namespace App\Event;

use App\QueryResult\DatabaseQueryResult;

final class SqlIsExecuted implements Event
{
    protected DatabaseQueryResult $queryResult;

    public function __construct(DatabaseQueryResult $queryResult)
    {
        $this->queryResult = $queryResult;
    }

    public function __toString(): string
    {
        return self::class;
    }

    public function getQueryResult(): DatabaseQueryResult
    {
        return $this->queryResult;
    }
}
