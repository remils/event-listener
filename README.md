# Слушатель событий

Реализация простого слушателя событий.

## Пример использования

```php
<?php

use Remils\EventListener\AttachDispatcherInterface;
use Remils\EventListener\Dispatcher;
use Remils\EventListener\EventInterface;
use Remils\EventListener\ListenerInterface;
use Remils\EventListener\SubscriberInterface;

require './vendor/autoload.php';

class Entity
{
    public string $name;
    public int $age;
}

class SetAgeEntityEvent implements EventInterface
{
    public int $age;
}

class SetNameEntityEvent implements EventInterface
{
    public string $name;
}

class SendEntityEvent implements EventInterface
{
}

class ResponseEntityEvent implements EventInterface
{
    public Entity $entity;
}

class EntitySubscriber implements SubscriberInterface, AttachDispatcherInterface
{
    protected Dispatcher $dispatcher;

    protected Entity $entity;

    public function __construct()
    {
        $this->entity = new Entity();
    }

    public function setDispatcher(Dispatcher $dispatcher): void
    {
        $this->dispatcher = $dispatcher;
    }

    public function getSubscribedEvents(): array
    {
        return [
            SetAgeEntityEvent::class => 'setAge',
            SetNameEntityEvent::class => 'setName',
            SendEntityEvent::class => 'sendEntity',
        ];
    }

    public function setAge(SetAgeEntityEvent $event): void
    {
        $this->entity->age = $event->age;
    }

    public function setName(SetNameEntityEvent $event): void
    {
        $this->entity->name = $event->name;
    }

    public function sendEntity(SendEntityEvent $event): void
    {
        $event = new ResponseEntityEvent();
        $event->entity = $this->entity;

        $this->dispatcher->dispatch($event);
    }
}

class ResponseEntityListener implements ListenerInterface
{
    public function getEventNamespace(): string
    {
        return ResponseEntityEvent::class;
    }

    /**
     * @param ResponseEntityEvent $event
     * @return void
     */
    public function handle(EventInterface $event): void
    {
        var_dump($event->entity);
    }
}

$listeners = [
    new EntitySubscriber(),
    new ResponseEntityListener(),
];

$dispatcher = new Dispatcher($listeners);

$event = new SetAgeEntityEvent();
$event->age = 64;

$dispatcher->dispatch($event);

$event = new SetNameEntityEvent();
$event->name = 'Анатолий';

$dispatcher->dispatch($event);

$event = new SendEntityEvent();

$dispatcher->dispatch($event);

```