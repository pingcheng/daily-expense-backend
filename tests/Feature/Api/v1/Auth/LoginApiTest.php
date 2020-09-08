<?php


namespace Tests\Feature\Api\v1\Auth;


use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\ClientRepository;
use Tests\Feature\Api\v1\ApiTestCase;

class LoginApiTest extends ApiTestCase
{
	use DatabaseMigrations;

	/**
	 * @test
	 */
	public function email_must_be_exist(): void
	{
		$response = $this->post(route('login'), [
			'email' => 'no@sample.com'
		]);

		$payload = $this->validateJsonResponse($response, 422);
		self::assertArrayHasKey('email', $payload);
	}

	/**
	 * @test
	 */
	public function wrong_password_cannot_login(): void
	{
		$this->createUser([
			'email' => 'test@sample.com',
			'password' => Hash::make('1234567')
		]);
		$response = $this->post(route('login'), [
			'email' => 'test@sample.com',
			'password' => '123456'
		]);
		$payload = $this->validateJsonResponse($response, 422);
		self::assertArrayNotHasKey('email', $payload);
		self::assertArrayHasKey('password', $payload);
	}

	/**
	 * @test
	 */
	public function correct_credential_can_login(): void
	{
		$this->withoutExceptionHandling();
		$this->createUser([
			'email' => 'test@sample.com',
			'password' => Hash::make('1234567')
		]);
		$response = $this->post(route('login'), [
			'email' => 'test@sample.com',
			'password' => '1234567'
		]);
		$payload = $this->validateJsonResponse($response, 200);
		self::assertArrayHasKey('user', $payload);
		self::assertArrayHasKey('id', $payload['user']);
		self::assertArrayHasKey('name', $payload['user']);

		self::assertArrayHasKey('token', $payload);
		self::assertArrayHasKey('accessToken', $payload['token']);
		self::assertArrayHasKey('expires', $payload['token']);
	}

	/**
	 * Setup.
	 */
	protected function setUp(): void
	{
		parent::setUp();
		$clientRepository = new ClientRepository();
		$client = $clientRepository->createPersonalAccessClient(null, 'Test Personal Access Client', '');

		DB::table('oauth_personal_access_clients')->insert([
			'client_id' => $client->id,
		]);
	}
}