<?php

namespace App\Repositories\SparkPost;

use App\Exceptions\CustomException;

class SparkPost
{
	public $baseUrl;
	public $loginheaders = [];
	public $client;
	public $key;
	public $contentType;
	public $validation = [];

	public function __construct()
	{
		$this->baseUrl = config('env.SPARKPOST_URL');
		$this->key = config('env.AFFILIATE_API_KEY');
		$this->contentType = 'application/json';
		$this->loginheaders = [
			'Header'  => 'Content-type',
			'Content-Type' => $this->contentType,
			'API-KEY' => $this->key
		];

		$this->client = new \GuzzleHttp\Client();
	}


	/**
	 * Get Token
	 */
	public function getToken($data)
	{
		try {
			$api_url = "/v1/login";
			$response = $this->client->post(
				$this->baseUrl . $api_url,
				[
					'headers' => $this->loginheaders,
					'body' => json_encode($data),
					'http_errors' => false
				]
			);
			$returnData = [];
			if ($response->getStatusCode() == 200) {
				$returnData =  json_decode($response->getBody());
				$messgae = trans('affiliates.tokencreated');
				$status = 200;
			} else {
				throw new CustomException(json_decode($response->getBody())->message);
			}


			return ['status' => $status, 'message' => $messgae, 'data' => $returnData];
		} catch (\Exception $err) {
			$status = 400;
			return ['status' => $status, 'message' => $err->getMessage()];
		}
	}

	/**
	 * Create Subaccount
	 */
	public function createNewSubaccount($sendrequest, $token)
	{
		try {
			$api_url = "/v1/sparkpost/subaccount";
			$response = $this->client->post(
				$this->baseUrl . $api_url,
				[
					'headers' => [
						'authorization' => 'Bearer ' . $token,
						'API-KEY' => $this->key,
						'Content-Type' => $this->contentType
					],
					'body' => json_encode($sendrequest)
				]
			);

			$returnData = [];
			if ($response->getStatusCode() == 200) {
				$returnData =  json_decode($response->getBody());
				$messgae = trans('affiliates.subaccountcreated');
				$status = 200;
			} else {
				$status = 404;
				$messgae = trans('affiliates.subaccountnotcreated');
			}

			return ['status' => $status, 'message' => $messgae, 'data' => $returnData];
		} catch (\Exception $err) {
			$status = 400;
			return ['status' => $status, 'message' => $err->getMessage()];
		}
	}


	/**
	 * Update Subaccount
	 */
	public function putUpdateSubaccount($sendrequest, $token)
	{
		try {
			$api_url = "/v1/sparkpost/update_subaccount";
			$response = $this->client->put(
				$this->baseUrl . $api_url,
				[
					'headers' => [
						'authorization' => 'Bearer ' . $token,
						'API-KEY' => $this->key,
						'Content-Type' => $this->contentType
					],
					'body' => json_encode($sendrequest)
				]
			);

			$returnData = [];
			if ($response->getStatusCode() == 200) {
				$returnData =  json_decode($response->getBody());
				$messgae = trans('affiliates.subaccountupdated');
				$status = 200;
			} else {
				$status = 404;
				$messgae = trans('affiliates.subaccountnotupdated');
			}

			return ['status' => $status, 'message' => $messgae, 'data' => $returnData];
		} catch (\Exception $err) {
			$status = 400;
			return ['status' => $status, 'message' => $err->getMessage()];
		}
	}

	/**
	 * Send Password email
	 */
	public function sendMail($sendrequest, $token)
	{
		try {
			$api_url = "/v1/mail/sendmail";
			$response = $this->client->post(
				$this->baseUrl . $api_url,
				[
					'headers' => [
						'authorization' => 'Bearer ' . $token,
						'API-KEY' => $this->key,
						'Content-Type' => $this->contentType
					],
					'body' => json_encode($sendrequest)
				]
			);

			$status = 404;
			$messgae = trans('affiliates.emailnotsend');

			$returnData = [];
			if ($response->getStatusCode() == 200) {
				$returnData =  json_decode($response->getBody());
				if ($returnData->data->results->total_accepted_recipients == 1) {
					$messgae = trans('affiliates.emailsend');
					$status = 200;
				}
			}

			return ['status' => $status, 'message' => $messgae];
		} catch (\Exception $err) {
			$status = 400;
			return ['status' => $status, 'message' => $err->getMessage()];
		}
	}

	/**
	 * get bounce domain or ip pool
	 */
	public function getDomainOrPool($sendrequest, $token)
	{
		try {
			$api_url = "/v1/sparkpost/getip_pool_sendingdomain";
			$response = $this->client->post(
				$this->baseUrl . $api_url,
				[
					'headers' => [
						'authorization' => 'Bearer ' . $token,
						'API-KEY' => $this->key,
						'Content-Type' => $this->contentType
					],
					'body' => json_encode($sendrequest)
				]
			);
			$returnData = [];
			if ($response->getStatusCode() == 200) {
				$returnData =  json_decode($response->getBody());
				$messgae = trans('affiliates.domainpool');
				$status = 200;
			} else {
				$status = 404;
				$messgae = trans('affiliates.domainpoolfail');
			}


			return ['status' => $status, 'message' => $messgae, 'data' => $returnData];
		} catch (\Exception $err) {
			$status = 400;
			return ['status' => $status, 'message' => $err->getMessage()];
		}
	}
	/**
	 * create template
	 */
	public function createUpdateTemplate($sendrequest, $token, $api_key, $action)
	{
		try {
			if ($action == 'create') {
				$api_url = "/v1/sparkpost/create_template";
				$method = 'post';
			} else {
				$api_url = "/v1/sparkpost/update_template";
				$method = "put";
			}
			$response = $this->client->request(
				$method,
				$this->baseUrl . $api_url,
				[
					'headers' => [
						'authorization' => 'Bearer ' . $token,
						'API-KEY' => $this->key,
						'Content-Type' => $this->contentType,


					],
					'body' => json_encode($sendrequest),
					'http_errors' => false
				]
			);
			$returnData = [];
			if ($response->getStatusCode() == 200) {
				$returnData =  json_decode($response->getBody());
				if ($action == 'create') {
					$returnData = $returnData->data->results->id;
				}
				$status = 200;
			} else {
				$returnData =  json_decode($response->getBody());
				$status = 400;
			}
			return ['status' => $status, 'data' => $returnData];
		} catch (\Exception $err) {
			$status = 400;
			return ['status' => $status, 'message' => $err->getMessage()];
		}
	}

	/**
	 * Send Password email
	 */
	public function sendEmail($sendrequest)
	{
		try {
			$response = $this->client->post(
				config('env.SPARKPOST_MAIL'),
				[
					'headers' => [
						'API-KEY'      => $this->key,
						'Content-Type' => $this->contentType,
						'CountryId'    => 1
					],
					'body' => json_encode($sendrequest),
					'http_errors' => false,
				]
			);
			$returnData =  json_decode($response->getBody());
			$status = $response->getStatusCode();
			return ['status' => $status, 'message' => $returnData];
		} catch (\Exception $err) {
			$status = 400;
			return ['status' => $status, 'message' => $err->getMessage()];
		}
	}

}
