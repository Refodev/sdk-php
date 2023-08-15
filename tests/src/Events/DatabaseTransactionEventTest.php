<?php

use Devqaly\DevqalyClient\Events\DatabaseTransactionEvent;

it('should throw an error when passing empty sql', function () {
    $backendUrl = 'https://devqaly.test/api';
    $sourceIdentifier = 'microservice-x';
    $sessionId = 'c7622e14-21f8-40c2-b151-3a311816b423';
    $sessionSecret = 'c7622e14-21f8-40c2-b151-3a311816b423';

    $client = new DatabaseTransactionEvent($backendUrl, $sourceIdentifier);

    $client->create($sessionId, $sessionSecret, []);
})->throws(\Error::class, '`sql` must be set to create a database transaction event in $data');

it('should execute curl request when calling `create` method and close', function() {
    $backendUrl = 'https://devqaly.test/api';
    $sourceIdentifier = 'microservice-x';
    $sessionId = 'c7622e14-21f8-40c2-b151-3a311816b423';
    $sessionSecret = 'c7622e14-21f8-40c2-b151-3a311816b423';

    $client = Mockery::mock(DatabaseTransactionEvent::class, [$backendUrl, $sourceIdentifier])->makePartial();

    $endpoint = 'https://something.com';

    $baseData = ['sql' => 'select * from users'];

    $client->shouldReceive('validateSessionId')->with($sessionId)->once();
    $client->shouldReceive('validateSessionSecret')->with($sessionSecret)->once();
    $client->shouldReceive('getCreateEventEndpoint')->with($sessionId)->once()->andReturn($endpoint);

    $client->shouldReceive('setOption')->times(1)->with(CURLOPT_URL, $endpoint);
    $client->shouldReceive('setOption')->times(1)->with(CURLOPT_RETURNTRANSFER, true);
    $client->shouldReceive('setOption')->times(1);
    $client->shouldReceive('setOption')->times(1)->with(CURLOPT_HTTPHEADER, ['x-devqaly-session-secret-token: '.$sessionSecret]);

    $client->shouldReceive('execute')->withNoArgs()->once();
    $client->shouldReceive('close')->withNoArgs()->once();

    $client->create($sessionId, $sessionSecret, $baseData);
});
