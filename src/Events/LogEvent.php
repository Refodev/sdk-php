<?php

namespace Devqaly\DevqalyClient\Events;

class LogEvent extends BaseEvent implements Event
{
    const EVENT_TYPE = "App\Models\Session\Event\EventLog";

    const LOG_LEVEL_EMERGENCY = 'emergency';

    const LOG_LEVEL_ALERT = 'alert';

    const LOG_LEVEL_CRITICAL = 'critical';

    const LOG_LEVEL_ERROR = 'error';

    const LOG_LEVEL_WARNING = 'warning';

    const LOG_LEVEL_NOTICE = 'notice';

    const LOG_LEVEL_INFORMATIONAL = 'informational';

    const LOG_LEVEL_DEBUG = 'debug';

    const LOG_LEVELS = [
        self::LOG_LEVEL_EMERGENCY,
        self::LOG_LEVEL_ALERT,
        self::LOG_LEVEL_CRITICAL,
        self::LOG_LEVEL_ERROR,
        self::LOG_LEVEL_WARNING,
        self::LOG_LEVEL_NOTICE,
        self::LOG_LEVEL_INFORMATIONAL,
        self::LOG_LEVEL_DEBUG,
    ];

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

        $payload = json_encode($this->generatePayload($data, self::EVENT_TYPE));
        $this->setOption(CURLOPT_URL, $endpoint);
        $this->setOption(CURLOPT_RETURNTRANSFER, true);
        $this->setOption(CURLOPT_POST, true);
        $this->setOption(
            CURLOPT_POSTFIELDS,
            $payload
        );
        $this->setOption(CURLOPT_HTTPHEADER, [
            'x-devqaly-session-secret-token: '.$sessionSecret,
            'Accept: application/json',
            'Content-Type: application/json',
            'Content-Length: ' . strlen($payload)
        ]);
        $this->execute();
        $this->close();
    }
}
