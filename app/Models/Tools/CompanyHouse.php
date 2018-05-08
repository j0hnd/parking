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

    private $officers_field = [
        'name',
        'officer_role',
        'occupation',
        'appointed_on'
    ];

    public function __construct()
    {
        $this->client  = new Client();
        $this->api_key = config('app.company_house_api_key');
        $this->uri     = config('app.company_house_api_url');
    }

    public function get($end_point)
    {
        $response = ['success' => false];

        try {
            $result = $this->client->get($this->uri . $end_point, [
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

    public function setCompany($company_id, $company_name, $data)
    {
        foreach ($data as $details) {
            foreach ($details as $key => $value) {
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

    public function setOfficers($company_id, $data)
    {
        $parent_id = null;

        foreach ($data as $details) {
            foreach ($details as $key => $value) {
                if (in_array($key, $this->officers_field) == true) {
                    if ($key == 'name') {
                        $officer = CompanyDetails::create([
                            'company_id' => $company_id,
                            'parent_id' => 0,
                            'meta_key' => $key,
                            'meta_value' => $value
                        ]);

                        $parent_id = $officer->id;
                    } else {
                        $officer = CompanyDetails::create([
                            'company_id' => $company_id,
                            'parent_id' => $parent_id,
                            'meta_key' => $key,
                            'meta_value' => $value
                        ]);
                    }
                }
            }
        }
    }
}
