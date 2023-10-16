<?php

declare(strict_types=1);

namespace Remils\EventListener;

final class Dispatcher
{
    /**
     * @param ListenerInterface[] $listeners
     */
    public function __construct(
        protected array $listeners = [],
    ) {
    }

    /**
     * @param EventInterface $event
     * @return void
     */
    public function dispatch(EventInterface $event): void
    {
        foreach ($this->listeners as $listener) {
            if (!$listener instanceof ListenerInterface) {
                throw new ListenerException(
                    message: sprintf(
                        'Слушатель %s не реализует интерфейс %s.',
                        $listener::class,
                        ListenerInterface::class,
                    ),
                );
            }

            if ($listener->getEventNamespace() === $event::class) {
                $listener->handle($event);
            }
        }
    }
}
