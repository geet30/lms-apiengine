<?php

namespace App\Repositories\SparkPost;

use GuzzleHttp\Client;

class NodeMailer
{
	/**
	 * @var mixed
	 */
	private $baseUrl;

	/**
	 * @var array
	 */
	private $loginHeaders = [];

	/**
	 * @var \GuzzleHttp\Client
	 */
	private $client;

	/**
	 * @var mixed
	 */
	private $key;

	/**
	 * @var string
	 */
	private $contentType;

	/**
	 * @var mixed
	 */
	private $token;

	public function __construct()
	{
		$this->baseUrl      = config('env.SPARKPOST_URL');
		$this->key          = config('env.AFFILIATE_API_KEY');
		$this->contentType  = 'application/json';
		$this->loginHeaders = [
			'Header'  => 'Content-type',
			'Content-Type' => $this->contentType,
			'API-KEY' => $this->key
		];
		$this->token = null;
		$this->client = new Client();
	}

	/**
	 * Get Token
	 * @return mixed
	 */
	public function setToken()
	{
		try {
			$endPoint = "/v1/login";
			$response = $this->client->post(
				$this->baseUrl . $endPoint,
				[
					'headers' => $this->loginHeaders,
					'body' => json_encode(['service_id' => 1])
				]
			);
			if ($response->getStatusCode() == 200) {
				$returnData =  json_decode($response->getBody());
				$this->token = $returnData->token;
			}


			return $this->token;
		} catch (\Exception $err) {
			return false;
		}
	}

	/**
	 * Send email
	 * @param array $sendRequest
	 * @return mixed
	 */
	public function sendMail($sendRequest, $orgRes = null)
	{
		
		try {
			$isOk = $this->setToken();
			if (!$isOk) return null;

			$endPoint = "/v1/mail/sendmail";
			$response = $this->client->post(
				$this->baseUrl . $endPoint,
				[
					'headers' => [
						'authorization' => 'Bearer ' . $this->token,
						'API-KEY' => $this->key,
						'Content-Type' => $this->contentType
					],
					'body' => json_encode($sendRequest)
				]
			);
			if ($orgRes) return $response;
			if ($response->getStatusCode() == 200) {
				return json_decode($response->getBody());
			}

			return null;
		} catch (\Exception $err) {
			return false;
		}
	}
	public function sendMailWithTemplate($sendRequest, $orgRes = null)
	{
		
		try {
			$isOk = $this->setToken();
			
			if (!$isOk) return null;
			
			$endPoint = "/v1/mail/sendmail_templateId";
			
			$response = $this->client->post(
				$this->baseUrl . $endPoint,
				[
					'headers' => [
						'authorization' => 'Bearer ' . $this->token,
						'API-KEY' => $this->key,
						'Content-Type' => $this->contentType
					],
					'body' => json_encode($sendRequest)
				]
			);
		
			
			if ($orgRes) return $response;
			
			if ($response->getStatusCode() == 200) {
				return json_decode($response->getBody());
			}

			return null;
		} catch (\Exception $err) {
			dd($err->getMessage().'  Line no:'. $err->getLine().'  File:'. $err->getFile());
			return $err->getMessage().'  Line no:'. $err->getLine().'  File:'. $err->getFile();
		}
	}
}
