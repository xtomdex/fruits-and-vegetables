<?php

declare(strict_types=1);

namespace App\Domain;

/**
 * Flusher is responsible for saving all changes after any manipulations with entities occurred.
 *
 * It can be achieved with internal EntityManager service, but flusher may contain more complex logic, for example, dispatching domain events. So it is more reasonable to extract this responsibility in a separate class.
 */
interface FlusherInterface
{
    /**
     * Flushes all changes.
     */
    public function flush(): void;
}
