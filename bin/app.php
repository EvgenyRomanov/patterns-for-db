<?php

/** @psalm-suppress MissingFile */

use App\QueryBuilder\SelectQueryBuilder;
use App\SimpleEventDispatcher;
use App\Subscriber\SomeHandler;
use App\Event\DatabaseQueryResultIsCreated;
use App\Event\SqlIsExecuted;

require __DIR__ . '/../vendor/autoload.php';


try {
    $handler = new SomeHandler();
    $eventDispatcher = new SimpleEventDispatcher();
    $eventDispatcher->addListener(DatabaseQueryResultIsCreated::class, $handler);
    $eventDispatcher->addListener(SqlIsExecuted::class, $handler);

    $queryBuilder = new SelectQueryBuilder($eventDispatcher);
    $result = $queryBuilder
        ->from('clients')
        ->orderBy('middle_name', 'ASC')
        ->where('first_name', 'test')
        ->execute();

    foreach ($result as $item) {
         echo sprintf(
             "id: %d, first_name: %s, middle_name: %s, last_name: %s",
             $item->id,
             $item->first_name,
             $item->middle_name,
             $item->last_name
             ) . PHP_EOL;
    }
} catch (Exception $e) {
    print_r($e->getMessage() . PHP_EOL);
}
