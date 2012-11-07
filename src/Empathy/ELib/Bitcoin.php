<?php

namespace Empathy\ELib;

use Empathy\ELib\Bitcoin\Call;

class Bitcoin
{
    private $username;
    private $password;
    private $format;
    private $methods;
    private $timeout;

    public function __construct($username, $format='JSON', $timeout=600, $password=null)
    {
        $this->username = $username;
        $this->password = $password;
        $this->timeout = $timeout;
        $this->format = $format;

        $this->initMethods();

        if ($format != 'JSON') {
            die('ELib Bitcoin library does not support return format other than JSON.');
        }
    }

    public function doCall($method, $params=array(), $raw=false)
    {
        $url = 'http://127.0.0.1:8332';
        $auth = true;
        $signature = '';
        $format = $this->format;

        if (!in_array($method, $this->methods)) {
            throw new \Exception('not a valid Bitcoin method.');
        }

        $c = new Call($url, $this->username, $this->password, $auth, $signature, $this->timeout, $this->format, $method, $params);

        if ($raw) {
            return $c->getOutput();
        } else {
            //return $c->getJSON();
            return $c->getOutputArray();
        }
    }

    public function getMethods()
    {
        return $this->methods;
    }

    public function initMethods()
    {
        $this->methods = array(
            'backupwallet', // <destination>
            'getaccount', // <bitcoinaddress>
            'getaccountaddress', // <account>
            'getaddressesbyaccount', // <account>
            'getbalance', // [account] [minconf=1]
            'getblockcount',
            'getblocknumber',
            'getconnectioncount',
            'getdifficulty',
            'getgenerate',
            'gethashespersec',
            'getinfo',
            'getnewaddress', // [account]
            'getreceivedbyaccount', // <account> [minconf=1]
            'getreceivedbyaddress', // <bitcoinaddress> [minconf=1]
            'gettransaction', // <txid>
            'getwork', // [data]
            'help', // [command]
            'listaccounts', // [minconf=1]
            'listreceivedbyaccount', // [minconf=1] [includeempty=false]
            'listreceivedbyaddress', // [minconf=1] [includeempty=false]
            'listtransactions', // [account] [count=10]
            'move', // <fromaccount> <toaccount> <amount> [minconf=1] [comment]
            'sendfrom', // <fromaccount> <tobitcoinaddress> <amount> [minconf=1] [comment] [comment-to]
            'sendtoaddress', // <bitcoinaddress> <amount> [comment] [comment-to]
            'setaccount', // <bitcoinaddress> <account>
            'setgenerate', // <generate> [genproclimit]
            'stop',
            'validateaddress' // <bitcoinaddress>
            );
    }
}
