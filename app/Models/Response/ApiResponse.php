<?php


namespace App\Models\Response;


use Exception;

class ApiResponse {

	private int $statusCode;
	private string $message;
	private $payload;

	public function __construct(int $statusCode, ?string $message = '', $payload = null) {
		$this->statusCode = $statusCode;
		$this->message = $message ?? '';
		$this->payload = $payload;
	}

	public function getStatusCode(): int {
		return $this->statusCode;
	}

	public function getPayload() {
		return $this->payload;
	}

	public function getMessage(): string {
		return $this->message;
	}

	public function toJson(): string {
		try {
			return json_encode([
				'statusCode' => $this->getStatusCode(),
				'payload' => $this->getPayload(),
				'message' => $this->getMessage(),
			], JSON_THROW_ON_ERROR);
		} catch (Exception $e) {
			return "{}";
		}
	}
}