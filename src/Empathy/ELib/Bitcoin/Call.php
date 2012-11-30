<?php

namespace Empathy\ELib\Bitcoin;

use Empathy\ELib\JSONRPC;

class Call
{
    private $url;
    private $username;
    private $auth;
    private $method;
    private $params;
    private $format;
    private $timeout;
    private $timestamp;
    private $json;
    private $ouput;
    private $output_arr;

    public function __construct($url, $username, $password, $auth, $signature, $timeout, $format, $method, $params)
    {
        $this->url = $url;
        $this->username = $username;
        $this->password = $password;
        $this->auth = $auth;
        $this->method = $method;
        $this->params = $params;
        $this->format = $format;
        $this->timeout = $timeout;

        $this->timestamp = time();

        $this->call();

        $this->json = $this->output;
        $this->output_arr = json_decode($this->json);
    }

    public function call()
    {
        $post_fields_arr = array(
        'jsonrpc' => '1.0',
        'id' => 'EBitcoin',
        'method' => $this->method,
        'params' => $this->params);
        $post_fields = json_encode($post_fields_arr);

        $r = new JSONRPC($this->url, array(), $post_fields, $this->username,
                         $this->password, $this->auth);
        if ($r->fetch()) {
            $this->output = $r->getResponse();
        }

        return $r->getSuccess();
    }

    public function getOutput()
    {
        return $this->output;
    }

    public function getJSON()
    {
        return $this->json;
    }

    public function getOutputArray()
    {
        return $this->output_arr;
    }
}
