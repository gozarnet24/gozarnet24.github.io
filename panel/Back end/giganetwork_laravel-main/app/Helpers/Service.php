<?php

namespace App\Helpers;

use GuzzleHttp\Client;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Morilog\Jalali\Jalalian;

class Service
{
    public const BASE_URL = 'https://rahanet.org:1043/1.0';
    private const LOGIN_URL = 'https://rahanet.org/users/commonpages/DSUserProcessLogin.php';

    private const HEADERS = [
        'Accept' => '*/*',
        'Accept-Language' => 'en-US,en;q=0.9',
        'Connection' => 'keep-alive',
        'Content-Type' => 'application/x-www-form-urlencoded; charset=UTF-8',
        'Cookie' => 'MicrosoftApplicationsTelemetryDeviceId=c7ad0375-41ad-4383-bde2-4870037bf4c5; MicrosoftApplicationsTelemetryFirstLaunchTime=2024-07-26T21:04:53.333Z; DSUSERSESSID=gufv3fl71r0i21g43n7duh3da0; DSUserTimeOut=0',
        'Origin' => 'https://rahanet.org',
        'Referer' => 'https://rahanet.org/users/computer/DS_Login.php?&WebNewUser=No&NCR=No&Feedback=No&User_Id=0&Device=computer',
        'Sec-Fetch-Dest' => 'empty',
        'Sec-Fetch-Mode' => 'cors',
        'Sec-Fetch-Site' => 'same-origin',
        'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36',
        'X-Requested-With' => 'XMLHttpRequest',
        'sec-ch-ua' => '"Not)A;Brand";v="99", "Google Chrome";v="127", "Chromium";v="127"',
        'sec-ch-ua-mobile' => '?0',
        'sec-ch-ua-platform' => '"Windows"'
    ];
    public static function login($username, $password)
    {
        $response = (new Client([
            'verify' => false
        ]))->request(
            'POST',
            self::LOGIN_URL,
            [
                'query' => [
                    'User_Id' => '0'
                ],
                'headers' => self::HEADERS,
                'form_params' => [
                    'Username' => $username,
                    'Password' => $password,
                    'null' => '',
                    'act' => 'ManualLogin'
                ]
            ]
        );

        $contents = (string) $response->getBody()->getContents();
        return $response->getStatusCode() == 200 && str_starts_with($contents, 'OK');
    }

    private static function getToken()
    {
        $request = new \GuzzleHttp\Psr7\Request('POST', self::BASE_URL . '/auth/', [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ]);
        $res = (new Client([
            'verify' => false
        ]))->send($request, [
            'form_params' => [
                'Api_Username' => env('API_USERNAME'),
                'Api_Key' => hash('sha512', env('API_PASSWORD')),
                'Action' => 'gettoken'
            ]
        ]);
        $response = json_decode($res->getBody()->getContents(), true);

        return $response['token'] ?? '';
    }

    public static function information($username)
    {
        $token = self::getToken();
        $res = (new Client([
            'verify' => false
        ]))->get(self::BASE_URL . "/user/?Action=creditinfo&Filter=Username='$username'", [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
            ],
        ]);
        $response = json_decode($res->getBody()->getContents(), true)[0];

        return [
            'service_name' => $response['ServiceName'],
            'service_status' => $response['ServiceStatus'] == 'Active',
            'service_period' => $response['Period'],
            'start_date' => Jalalian::fromDateTime($response['StartDate'])->format('Y/m/d'),
            'end_date' => Jalalian::fromDateTime($response['EndDate'])->format('Y/m/d'),
            'total_traffic' => (float) number_format(self::convertToGB($response['STrA']) + self::convertToGB($response['ETrA']), 1, '.', ''),
            'rest_traffic' => (float) number_format(self::convertToGB($response['STrR']) + self::convertToGB($response['ETrR']), 1, '.', ''),
            'used_traffic' => (float) number_format(self::convertToGB($response['STrU']) + self::convertToGB($response['ETrU']), 1, '.', ''),

        ] ?? [];
    }

    public static function resetPassword($username, $password)
    {
        $token = self::getToken();
        $res = (new Client([
            'verify' => false
        ]))->put(self::BASE_URL . "/user/", [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
            ],
            'form_params' => [
                'Action' => 'edit',
                'Username' => $username,
                'Password' => $password
            ]
        ]);
        $response = json_decode($res->getBody()->getContents(), true);
        return isset($response['status']) && $response['status'] == 1;
    }

    private static function convertToGB($bytes)
    {
        return ((float) str_replace(',', '', $bytes)) / (1024 * 1024 * 1024);
    }
}
