# Слушатель событий

Реализация простого слушателя событий.

## Пример использования

```php
<?php

use Remils\EventListener\Dispatcher;
use Remils\EventListener\EventInterface;
use Remils\EventListener\ListenerInterface;

require './vendor/autoload.php';

class Entity
{
    public string $name;
}

class CreateEntityEvent implements EventInterface
{
    public string $name;
}

class CreateEntityListener implements ListenerInterface
{
    public function getEventNamespace(): string
    {
        return CreateEntityEvent::class;
    }

    /**
     * @param CreateEntityEvent $event
     * @return void
     */
    public function handle(EventInterface $event): void
    {
        $entity = new Entity();
        $entity->name = $event->name;

        var_dump($entity);
    }
}

$listeners = [
    new CreateEntityListener(),
];

$dispatcher = new Dispatcher($listeners);

$event = new CreateEntityEvent();
$event->name = 'Анатолий';

$dispatcher->dispatch($event);
```