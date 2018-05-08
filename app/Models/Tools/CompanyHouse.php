<?php

namespace App\Models\Tools;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use App\Models\CompanyDetails;


class CompanyHouse
{
    protected $client;
    protected $api_key;
    protected $uri;

    private $company_fields = [
        'address',
        'description',
        'company_type',
        'company_number',
        'date_of_creation',
        'company_status'
    ];

    public function __construct()
    {
        $this->client  = new Client();
        $this->api_key = config('app.company_house_api_key');
        $this->uri     = config('app.company_house_api_url');
    }

    public function getCompany($company_name)
    {
        $response = ['success' => false];

        try {
            $result = $this->client->get($this->uri . '/search/companies?q='.$company_name, [
                'headers' => [
                    'Authorization' => $this->api_key
                ]
            ]);

            if ($result->getStatusCode() == 200) {
                $body = json_decode($result->getBody(), true);
                $response = ['success' => true, 'body' => $body['items']];
            }

        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
        }

        return $response;
    }

    public function save($company_id, $company_name, $data)
    {
        foreach ($data as $details) {
            foreach ($details as $key => $value) {
                var_dump(preg_match("/".strtolower($company_name)."/", strtolower($details['title'])).", ".$details['title'].", ".$company_name);

                if (strtolower($details['title']) == strtolower($company_name) or preg_match("/".strtolower($company_name)."/", strtolower($details['title'])) == 1) {
                    if (in_array($key, $this->company_fields) == true) {
                        if (is_array($value)) {
                            foreach ($value as $k => $v) {
                                CompanyDetails::create([
                                    'company_id' => $company_id,
                                    'meta_key' => $k,
                                    'meta_value' => $v
                                ]);
                            }
                        } else {
                            CompanyDetails::create([
                                'company_id' => $company_id,
                                'meta_key' => $key,
                                'meta_value' => $value
                            ]);
                        }
                    }
                }
            }
        }
    }
}
