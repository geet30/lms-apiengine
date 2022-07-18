<?php

namespace App\Traits\SaleSubmission;
use GuzzleHttp\Client;

trait CommonGuzzelTrait
{
    function submitJsonDataToProvider($headers,$url,$data,$method)
    {
		try
		{
			$guzzle = new Client; 
			$response =  $guzzle->request(
				$method,
				$url,
				[
					'headers' => $headers, 
					'body' => $data
				]
			); 
			return ['response' => $response,'status' => 200];
		}
		catch (\GuzzleHttp\Exception\RequestException $e) {
			return ['message' => $e->getMessage(),'status' => 400];
		}
    }
}
