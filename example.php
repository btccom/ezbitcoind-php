<?php

require __DIR__ . "/vendor/autoload.php";

$rpc = new Btccom\BitcoindRPC\BitcoindRPC("http://rpcuser:rpcpassword@localhost:18332");

var_dump($rpc->getInfo()['blocks']);
var_dump($rpc->getBlockCount());
var_dump($rpc->getBlockHash($rpc->getBlockCount()));
var_dump(count($rpc->getBlock($rpc->getBlockHash($rpc->getBlockCount()))['tx']));
