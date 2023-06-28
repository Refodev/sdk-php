<?php

namespace Devqaly\DevqalyClient;

use CurlHandle;

class DevqalyClient
{
    private string $backendUrl;

    private string $sourceIdentifier;

    private CurlHandle $handle;

    public function __construct(?string $backendUrl, ?string $sourceIdentifier)
    {
        $this->handle = curl_init($backendUrl);
        $this->backendUrl = $backendUrl ?? 'https://api.devqaly.com';
        $this->sourceIdentifier = $sourceIdentifier;
    }

    public function setOption($name, $value): void
    {
        curl_setopt($this->handle, $name, $value);
    }

    public function execute(): bool|string
    {
        return curl_exec($this->handle);
    }

    public function close(): void
    {
        curl_close($this->handle);
    }

    public function createDatabaseEventTransaction(string $sessionId, string $sessionSecret, array $data): void
    {
        if (!isset($data['sql'])) {
            throw new \Error('`sql` must be set to create a database transaction event in $data');
        }

        $this->validateSessionId($sessionId);
        $this->validateSessionSecret($sessionId);

        $endpoint = $this->getCreateEventEndpoint($sessionId);

        $this->setOption(CURLOPT_URL, $endpoint);
        $this->setOption(CURLOPT_RETURNTRANSFER, true);
        $this->setOption(CURLOPT_POSTFIELDS, $this->generatePayload($data));
        $this->setOption(CURLOPT_HTTPHEADER, ['x-session-secret-token: ' . $sessionSecret]);
        $this->execute();
        $this->close();
    }

    public function createLogEvent(string $sessionId, string $sessionSecret, array $data): void
    {
        if (!isset($data['level'])) {
            throw new \Error('`level` must be set to create a log event in $data');
        }

        if (!isset($data['log'])) {
            throw new \Error('`log` must be set to create a log event in $data');
        }

        $this->validateSessionSecret($sessionId);
        $this->validateSessionId($sessionId);

        $endpoint = $this->getCreateEventEndpoint($sessionId);

        $this->setOption(CURLOPT_URL, $endpoint);
        $this->setOption(CURLOPT_RETURNTRANSFER, true);
        $this->setOption(CURLOPT_POSTFIELDS, $this->generatePayload($data));
        $this->setOption(CURLOPT_HTTPHEADER, ['x-session-secret-token: ' . $sessionSecret]);
        $this->execute();
        $this->close();
    }

    private function generatePayload(array $data): array
    {
        return [
            ...$data,
            'source' => $this->sourceIdentifier,
            'clientUtcEventCreatedAt' => (new \DateTime())->format('Y-m-d H:i:s.SSSSSS'),
        ];
    }

    private function validateSessionId(string $sessionId): void
    {
        if ($sessionId === '') {
            throw new \Error('$sessionId must be set and not empty');
        }
    }

    private function validateSessionSecret(string $sessionSecret): void
    {
        if ($sessionSecret === '') {
            throw new \Error('$sessionSecret must be set and not empty');
        }
    }

    private function getCreateEventEndpoint(string $sessionId): string
    {
        return sprintf('%s/sessions/%s/events', $this->backendUrl, $sessionId);
    }
}
