<?php

namespace Devqaly\DevqalyClient\Events;

class LogEvent extends BaseEvent implements Event
{
    const EVENT_TYPE = "App\Models\Session\Event\EventLog";

    public function create(string $sessionId, string $sessionSecret, array $data): void
    {
        if (! isset($data['level'])) {
            throw new \Error('`level` must be set to create a log event in $data');
        }

        if (! isset($data['log'])) {
            throw new \Error('`log` must be set to create a log event in $data');
        }

        $this->validateSessionSecret($sessionId);
        $this->validateSessionId($sessionId);

        $endpoint = $this->getCreateEventEndpoint($sessionId);

        $this->setOption(CURLOPT_URL, $endpoint);
        $this->setOption(CURLOPT_RETURNTRANSFER, true);
        $this->setOption(
            CURLOPT_POSTFIELDS,
            $this->generatePayload($data, self::EVENT_TYPE)
        );
        $this->setOption(CURLOPT_HTTPHEADER, ['x-session-secret-token: '.$sessionSecret]);
        $this->execute();
        $this->close();
    }
}
