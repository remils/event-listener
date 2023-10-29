<?php

declare(strict_types=1);

namespace Remils\EventListener;

interface SubscriberInterface
{
    /**
     * Должен возвращать список событий привязанных к методу.
     *
     * Пример:
     *
     * @code
     * return [
     *     Event1::class => 'nameMethod1',
     *     Event2::class => 'nameMethod2',
     *     EventN::class => 'nameMethodN'
     * ];
     * @endcode
     *
     * @return array<string,string>
     */
    public function getSubscribedEvents(): array;
}
