<?php

declare(strict_types=1);

namespace Remils\EventListener;

interface ListenerInterface
{
    /**
     * Пространство имени для события, которое ждет слушатель
     * @return string
     */
    public function getEventNamespace(): string;

    /**
     * Обработчик для события
     * @param EventInterface $event
     * @return void
     */
    public function handle(EventInterface $event): void;
}
