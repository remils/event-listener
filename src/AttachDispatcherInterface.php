<?php

declare(strict_types=1);

namespace Remils\EventListener;

interface AttachDispatcherInterface
{
    /**
     * Добавляет диспетчер в класс слушателя/подписчика
     *
     * @param Dispatcher $dispatcher
     * @return void
     */
    public function setDispatcher(Dispatcher $dispatcher): void;
}
