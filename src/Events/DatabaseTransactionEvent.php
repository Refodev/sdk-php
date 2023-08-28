<?php

namespace Devqaly\DevqalyClient\Events;

class DatabaseTransactionEvent extends BaseEvent implements Event
{
    const EVENT_TYPE = 'App\Models\Session\Event\EventDatabaseTransaction';

    public function create(string $sessionId, string $sessionSecret, array $data): void
    {
        if (! isset($data['sql'])) {
            throw new \Error('`sql` must be set to create a database transaction event in $data');
        }

        $this->validateSessionId($sessionId);
        $this->validateSessionSecret($sessionId);

        $endpoint = $this->getCreateEventEndpoint($sessionId);

        $this->setOption(CURLOPT_URL, $endpoint);
        $this->setOption(CURLOPT_RETURNTRANSFER, true);
        $this->setOption(
            CURLOPT_POSTFIELDS,
            $this->generatePayload($data, self::EVENT_TYPE)
        );
        $this->setOption(CURLOPT_HTTPHEADER, ['x-devqaly-session-secret-token: '.$sessionSecret]);
        $this->execute();
        $this->close();
    }
}
