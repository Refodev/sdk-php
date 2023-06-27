<?php

namespace Devqaly\DevqalyClient;

use CurlHandle;

class DevqalyClient
{
    private string $backendUrl;

    private CurlHandle $handle;

    public function __construct(?string $backendUrl)
    {
        $this->backendUrl = $backendUrl ?? 'https://api.devqaly.com';
        $this->handle = curl_init($backendUrl);
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
        if (! isset($data['sql'])) {
            throw new \Error('`sql` must be set to create a database transaction event in $data');
        }

        if ($sessionId === '') {
            throw new \Error('$sessionId must be set and not empty');
        }

        if ($sessionSecret === '') {
            throw new \Error('$sessionSecret must be set and not empty');
        }

        $endpoint = sprintf('%s/sessions/%s/events', $this->backendUrl, $sessionId);

        $this->setOption(CURLOPT_URL, $endpoint);
        $this->setOption(CURLOPT_RETURNTRANSFER, true);
        $this->setOption(CURLOPT_POSTFIELDS, $data);
        $this->setOption(CURLOPT_HTTPHEADER, ['x-session-secret-token: '.$sessionSecret]);
        $this->execute();
        $this->close();
    }
}
