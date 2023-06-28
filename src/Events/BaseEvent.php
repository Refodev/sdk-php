<?php

namespace Devqaly\DevqalyClient\Events;

use CurlHandle;

class BaseEvent
{
    private CurlHandle $handle;

    private string $sourceIdentifier;

    private string $backendUrl;

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

    public function getCreateEventEndpoint(string $sessionId): string
    {
        return sprintf('%s/sessions/%s/events', $this->backendUrl, $sessionId);
    }

    public function generatePayload(array $data, string $type): array
    {
        return [
            ...$data,
            'type' => $type,
            'source' => $this->sourceIdentifier,
            'clientUtcEventCreatedAt' => (new \DateTime())->format('Y-m-d H:i:s.SSSSSS'),
        ];
    }

    public function validateSessionId(string $sessionId): void
    {
        if ($sessionId === '') {
            throw new \Error('$sessionId must be set and not empty');
        }
    }

    public function validateSessionSecret(string $sessionSecret): void
    {
        if ($sessionSecret === '') {
            throw new \Error('$sessionSecret must be set and not empty');
        }
    }
}
