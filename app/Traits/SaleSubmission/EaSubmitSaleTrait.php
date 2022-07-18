<?php

namespace App\Traits\SaleSubmission;
use GuzzleHttp\Client;

trait EaSubmitSaleTrait
{
    function getOktaToken()
    {
            $guzzle = new Client; 
            $url = config('app.ea_okta_authorization_url');
            $response = $guzzle->post($url, [
                'form_params' => [
                    'grant_type' => 'client_credentials',
                    'client_id' => config('app.ea_okta_client_id'),
                    'client_secret' => config('app.ea_okta_client_secret'),
                    'scope' => 'integration',
                ],
            ]);
            return json_decode((string) $response->getBody(), true)['access_token'];
    }

    function submitSaleToProvider($accessToken,$graphQLquery)
    {
        $response = (new Client)->request('post', config('app.ea_sale_submission_url'), [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
                'X-EA-Env' => config('app.x_ea_env')
            ],
            'body' => $graphQLquery
        ]);
        return json_decode((string) $response->getBody(), true);
    }
}
