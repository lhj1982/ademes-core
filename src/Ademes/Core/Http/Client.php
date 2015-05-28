<?php
namespace Ademes\Core\Http;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use GuzzleHttp\Post\PostFile;
use Ademes\Core\Exception\ClientException as ClientException;
use Ademes\Core\Exception\RequestException as RequestException;
class Client {

    private $client;

    public function __construct() {
        $base_url = \Config::get('core::core.base_url');
        $this->client = new \GuzzleHttp\Client(['base_url'=>$base_url]);
    }

    public function get($uri, array $option=null) {
    	try {
    		return $this->client->get($uri, $option);
    	} catch (GuzzleHttp\Exception\ClientException $exception) {
    		throw new ClientException($exception->getStatusCode(), $exception->getMessage());
    	} catch (GuzzleHttp\Exception\RequestException $exception) {
    		throw new RequestException($exception->getMessage());
    	}
    }

    public function post($uri, array $option=null) {
    	try {
    		return $this->client->post($uri, $option);
    	} catch (GuzzleHttp\Exception\ClientException $exception) {
    		throw new ClientException($exception->getStatusCode(), $exception->getMessage());
    	} catch (GuzzleHttp\Exception\RequestException $exception) {
    		throw new RequestException($exception->getMessage());
    	}
    }

    public function postFile($field_name, $content)
    {
        return new PostFile($field_name, $content);
    }
}