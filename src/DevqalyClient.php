<?php

namespace Devqaly\DevqalyClient;

use Devqaly\DevqalyClient\Events\DatabaseTransactionEvent;
use Devqaly\DevqalyClient\Events\LogEvent;

class DevqalyClient
{
    private DatabaseTransactionEvent $databaseEvent;

    private LogEvent $logEvent;

    public function __construct(?string $backendUrl, ?string $sourceIdentifier, string $securityToken)
    {
        $this->databaseEvent = new DatabaseTransactionEvent($backendUrl, $sourceIdentifier, $securityToken);
        $this->logEvent = new LogEvent($backendUrl, $sourceIdentifier, $securityToken);
    }

    public function createDatabaseEventTransaction(string $sessionId, string $sessionSecret, array $data): void
    {
        try {
            $this->databaseEvent->create($sessionId, $sessionSecret, $data);
        } catch (\Exception $e) {
            echo "Error making request to devqaly's servers: ".$e->getMessage();
        }
    }

    public function createLogEvent(string $sessionId, string $sessionSecret, array $data): void
    {
        try {
            $this->logEvent->create($sessionId, $sessionSecret, $data);
        } catch (\Exception $e) {
            echo "Error making request to devqaly's servers: ".$e->getMessage();
        }
    }
}
