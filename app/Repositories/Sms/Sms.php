<?php

namespace App\Repositories\Sms;

class Sms
{
    public $client;
    public $baseUrl;
    public $sendRequest = [];
    public function __construct()
	{
        $this->client = new \GuzzleHttp\Client();
    }

    /**
	 * Get Token
	 */
	public function getToken($data,$api_key)
	{
        $this->baseUrl = config('env.SMS_LOGIN');
        $this->sendRequest['service_id'] = $data['service_id'];
        $response = $this->client->post(
            $this->baseUrl,
            [
                'headers' => [
                    'Header'  => 'Content-type',
			        'Content-Type' => 'application/json',
			        'API-KEY' => $api_key,
                ],
                'body' => json_encode($this->sendRequest),
                'http_errors' => false
            ]
        );
        if($response->getStatusCode() == 200){
            $token =  json_decode($response->getBody());
            $token = $token->token;
            return $this->getPlivoNumber($api_key,$token);

        }
    }
    /**
     * Get Plivo Number
     */
    public function getPlivoNumber($api_key,$token){
        $this->baseUrl = config('env.GET_PLIVO_NUMBER');
        $response = $this->client->post(
            $this->baseUrl,
            [
                'headers' => [
                    'authorization' => 'Bearer ' . $token,
                    'Header'  => 'Content-type',
			        'Content-Type' => 'application/json',
			        'API-KEY' => $api_key,
                ],
                'body' => json_encode($this->sendRequest),
                'http_errors' => false
            ]
        );
        if($response->getStatusCode() == 200){
            $data = json_decode($response->getBody());
            return $data->data;
        }
    }
}
