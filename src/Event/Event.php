<?php

declare(strict_types=1);

namespace App\Event;

use App\QueryResult\DatabaseQueryResult;

interface Event
{
    public function getQueryResult(): DatabaseQueryResult;
}
