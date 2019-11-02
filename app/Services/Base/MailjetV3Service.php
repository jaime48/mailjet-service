<?php

namespace App\Services\Base;

use App\Contracts\MailCommonContract;
use App\Contracts\MailTransactionalContract;
use Mailjet\Client;

class MailjetV3Service implements MailCommonContract
{
    private $client;

    /**
     * Create a new controller instance.
     *
     * @param $key
     * @param $secret
     * @param bool $call
     * @param array $settings
     */
    public function __construct($key, $secret, $call = true, array $settings = [])
    {
        $this->client = new Client($key, $secret, $call, $settings);
        $this->configClient();
    }

    public function configClient()
    {
        $this->client->setTimeout(100);
        $this->client->setConnectionTimeout(100);
    }

    public function getClient()
    {
        return $this->client;
    }

    public function post($resource, array $args = [], array $options = [])
    {
        try{
            $response = $this->client->post($resource, $args, $options);
        }catch(\Exception $e){
            return [false, $e->getMessage()];
        }
        return [true, $response];
    }

    public function get($resource, array $args = [], array $options = [])
    {
        try{
            $response = $this->client->get($resource, $args, $options);
        }catch(\Exception $e){
            return [false, $e->getMessage()];
        }
        return [true, $response];
    }

    public function put($resource, array $args = [], array $options = [])
    {
        try{
            $response = $this->client->put($resource, $args, $options);
        }catch(\Exception $e){
            return [false, $e->getMessage()];
        }
        return [true, $response];
    }


}
