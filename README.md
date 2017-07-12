BitcoindRPC
===========

This is a very basic wrapper around https://github.com/nbobtc/bitcoind-php 
to simply add convenient methods for the available RPC commands.

Much credit and thanks to https://github.com/JoshuaEstes for writing `nbobtc/bitcoind-php`, 
unfortunately in `v2` he decided to keep things clean and testable and require a rather verbose syntax to use the lib.  
Most of the code in this lib is taken from his `v1` where he still had a method for each command.

Example
-------

```php
require __DIR__ . "/vendor/autoload.php";

$rpc = new Btccom\BitcoindRPC\BitcoindRPC("http://rpcuser:rpcpassword@localhost:18332");

var_dump($rpc->getInfo()['blocks']);
var_dump($rpc->getBlockCount());
var_dump($rpc->getBlockHash($rpc->getBlockCount()));
var_dump(count($rpc->getBlock($rpc->getBlockHash($rpc->getBlockCount()))['tx']));
```
