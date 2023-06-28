<?php

namespace Devqaly\DevqalyClient;

use Devqaly\DevqalyClient\Events\DatabaseTransactionEvent;
use Devqaly\DevqalyClient\Events\LogEvent;

class DevqalyClient
{
    private DatabaseTransactionEvent $databaseEvent;

    private LogEvent $logEvent;

    public function __construct(?string $backendUrl, ?string $sourceIdentifier)
    {
        $this->databaseEvent = new DatabaseTransactionEvent($backendUrl, $sourceIdentifier);
        $this->logEvent = new LogEvent($backendUrl, $sourceIdentifier);
    }

    public function createDatabaseEventTransaction(string $sessionId, string $sessionSecret, array $data): void
    {
        $this->databaseEvent->create($sessionId, $sessionSecret, $data);
    }

    public function createLogEvent(string $sessionId, string $sessionSecret, array $data): void
    {
        $this->logEvent->create($sessionId, $sessionSecret, $data);
    }
}
