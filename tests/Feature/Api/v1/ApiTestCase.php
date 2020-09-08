<?php


namespace Tests\Feature\Api\v1;

use Illuminate\Testing\TestResponse;
use Tests\Unit\TestCase;

class ApiTestCase extends TestCase
{
	protected function validateJsonResponse(TestResponse $response, int $statusCode) {
		$response->assertStatus($statusCode);
		$payload = $response->json();
		self::assertArrayHasKey('statusCode', $payload);
		self::assertArrayHasKey('payload', $payload);
		self::assertArrayHasKey('message', $payload);
		self::assertIsInt($payload['statusCode']);
		self::assertIsString($payload['message']);
		return $payload['payload'];
	}
}