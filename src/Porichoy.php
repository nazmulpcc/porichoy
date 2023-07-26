<?php

namespace Porichoy;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class Porichoy
{
    protected ResponseInterface $response;

    public function __construct(protected string $api_host, protected string $api_key, protected $sandbox = true, protected ?Client $client = null)
    {
        $this->client = $this->client ?? new Client([
            'base_uri' => sprintf(
                '%s/%s/',
                rtrim($this->api_host, '/'),
                $sandbox ? 'sandbox-api' : 'api'
            ),
            'headers' => [
                'x-api-key' => $this->api_key,
                'Accept' => 'application/json',
            ]
        ]);
    }

    public function client(): ?Client
    {
        return $this->client;
    }

    public function response(): ResponseInterface
    {
        return $this->response;
    }

    /**
     * Autofill NID information based on NID number and date of birth
     * @param string $nid 10, 13 or 17 digit NID number
     * @param string|Carbon $dob Date of birth in Y-m-d format
     * @param bool $english Whether to return English translation of the name
     * @return array
     * @throws \Exception
     */
    public function autofill(string $nid, string|Carbon $dob, bool $english = false): array
    {
        $dob = $dob instanceof Carbon ? $dob->format('Y-m-d') : $dob;

        return $this->request('POST', 'v2/verifications/autofill', [
            'nidNumber' => $nid,
            'dateOfBirth' => $dob,
            'englishTranslation' => $english,
        ]);
    }

    public function verifyNid(string $nid, string|Carbon $dob, string $person_name, bool $match_name = false)
    {
        $dob = $dob instanceof Carbon ? $dob->format('Y-m-d') : $dob;

        if (!$this->sandbox) {
            return $this->request('POST', 'v2/verifications/basic-nid', [
                'national_id' => $nid,
                'person_dob' => $dob,
                'person_fullname' => $person_name,
                'match_name' => $match_name,
            ]);
        }

        /**
         * TODO: Remove this when Porichoy API is fixed
         * This api doesn't work in sandbox mode, so we fake it.
         */
        $failed = [
            'passKyc' => false,
            'errorCode' => collect([10001, 10002, 10003, 11000, 1100])->random(),
        ];
        try {
            $response = $this->autofill($nid, $dob);
        } catch (\Exception $e) {
            return $failed;
        }
        if (data_get($response, 'status', 'No') !== 'YES') {
            return $failed;
        }
        return [
            'passKyc' => true,
            'errorCode' => null,
        ];
    }

    public function subscription(): array
    {
        return $this->request('GET', '/api/orgs/subscription');
    }

    protected function request(string $method, string $endpoint, array $data = [])
    {
        $this->response = $this->client->request($method, $endpoint, [
            'json' => $data
        ]);
        $code = $this->response->getStatusCode();
        if ($code < 200 || $code > 399) {
            throw new \Exception('Porichoy API Error: ' . $this->response->getBody()->getContents());
        }
        return json_decode($this->response->getBody()->getContents(), true);
    }
}
