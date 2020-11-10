<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Arr;
use Torann\GeoIP\Support\HttpClient;
use Torann\GeoIP\Services\AbstractService;

class FreeGeoIpService extends AbstractService
{
    /**
     * Http client instance.
     *
     * @var HttpClient
     */
    protected $client;

    /**
     * An array of continents.
     *
     * @var array
     */
    protected $continents;

    /**
     * The "booting" method of the service.
     *
     * @return void
     */
    public function boot()
    {
        $base = [
            'base_uri' => 'https://freegeoip.app/',
            'headers' => [
                'User-Agent' => 'Laravel-GeoIP',
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ],
            'query' => [
                'lang' => $this->config('lang', ['en']),
            ],
        ];

        $this->client = new HttpClient($base);

        // Set continents
        if (file_exists($this->config('continent_path'))) {
            $this->continents = json_decode(file_get_contents($this->config('continent_path')), true);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function locate($ip)
    {
        // Get data from client
        $data = $this->client->get('json/' . $ip);

        // Verify server response
        if ($this->client->getErrors() !== null) {
            throw new Exception('Request failed (' . $this->client->getErrors() . ')');
        }

        // Parse body content
        $json = json_decode($data[0]);

        return $this->hydrate([
            'ip' => $ip,
            'iso_code' => $json->country_code,
            'country' => $json->country_name,
            'city' => $json->city,
            'state' => $json->region,
            'state_name' => $json->region_name,
            'postal_code' => $json->zip_code,
            'lat' => $json->latitude,
            'lon' => $json->longitude,
            'timezone' => $json->time_zone,
            'continent' => $this->getContinent($json->country_code),
        ]);
    }

    /**
     * Update function for service.
     *
     * @return string
     * @throws Exception
     */
    public function update()
    {

    }

    /**
     * Get continent based on country code.
     *
     * @param string $code
     *
     * @return string
     */
    private function getContinent($code)
    {
        return Arr::get($this->continents, $code, 'Unknown');
    }
}
