<?php

declare(strict_types=1);

namespace Remils\EventListener;

final class Dispatcher
{
    /**
     * @param array<ListenerInterface|SubscriberInterface> $handlers
     */
    public function __construct(
        protected array $handlers = [],
    ) {
    }

    /**
     * @param EventInterface $event
     * @return void
     */
    public function dispatch(EventInterface $event): void
    {
        foreach ($this->handlers as $handler) {
            $isListener = is_a($handler, ListenerInterface::class);
            $isSubscriber = is_a($handler, SubscriberInterface::class);

            if (
                $isListener === false
                && $isSubscriber === false
            ) {
                throw new ListenerException(
                    message: sprintf(
                        'Класс %s должен реализовать интерфейс %s, либо %s.',
                        $handler::class,
                        ListenerInterface::class,
                        SubscriberInterface::class,
                    ),
                );
            }

            if (is_a($handler, AttachDispatcherInterface::class)) {
                /**
                 * @var AttachDispatcherInterface $handler
                 */
                $handler->setDispatcher($this);
            }

            if ($isListener && is_a($event, $handler->getEventNamespace())) {
                /**
                 * @var ListenerInterface $handler
                 */
                $handler->handle($event);
            }

            if ($isSubscriber) {
                /**
                 * @var SubscriberInterface $handler
                 */
                $eventNamespaces = $handler->getSubscribedEvents();

                foreach ($eventNamespaces as $eventNamespace => $method) {
                    if (is_a($event, $eventNamespace)) {
                        call_user_func([$handler, $method], $event);
                    }
                }
            }
        }
    }
}
