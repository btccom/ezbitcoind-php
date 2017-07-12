<?php

namespace Btccom\BitcoindRPC;

use Btccom\BitcoindRPC\Exceptions\BitcoindDetailedRPCException;
use Btccom\BitcoindRPC\Exceptions\BitcoindRPCException;
use Nbobtc\Command\Command;
use Nbobtc\Http\Client;
use Nbobtc\Http\Message\Response;

class BitcoindRPC
{

    /**
     * @var Client
     */
    private $client;

    /**
     * @param string $dsn
     */
    public function __construct($dsn)
    {
        $this->client = new Client($dsn);
    }

    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param Response $response
     * @return mixed
     * @throws BitcoindRPCException
     */
    private function handleResponse(Response $response)
    {
        if ($response->getStatusCode() !== 200) {
            throw new BitcoindRPCException($response->getBody()->getContents(), $response->getStatusCode());
        }

        try {
            $res = json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            throw new BitcoindRPCException("Failed to decode JSON response");
        }

        if (isset($res['error']) && $res['error']) {
            throw new BitcoindDetailedRPCException($res['error']);
        }

        return isset($res['result']) ? $res['result'] : null;
    }

    public function help($command = null)
    {
        $response = $this->client->sendCommand(new Command('help', $command));
        return $this->handleResponse($response);
    }

    public function abandonTransaction($txid)
    {
        $response = $this->client->sendCommand(new Command('abandontransaction', [$txid]));
        return $this->handleResponse($response);
    }

    public function addMultisigAddress($nrequired, $keys, $account = null)
    {
        $response = $this->client->sendCommand(new Command('addmultisigaddress', [$keys, $account]));
        return $this->handleResponse($response);
    }

    public function backupWallet($destination)
    {
        $response = $this->client->sendCommand(new Command('backupwallet', $destination));
        return $this->handleResponse($response);
    }

    public function createMultisig($nrequired, array $keys)
    {
        $response = $this->client->sendCommand(new Command('createmultisig', [$nrequired, $keys]));
        return $this->handleResponse($response);
    }

    public function createRawTransaction(array $transactions, $addresses)
    {
        $response = $this->client->sendCommand(new Command('createrawtransaction', [$transactions, $addresses]));
        return $this->handleResponse($response);
    }

    public function decodeRawTransaction($hex)
    {
        $response = $this->client->sendCommand(new Command('decoderawtransaction', $hex));
        return $this->handleResponse($response);
    }

    public function dumpPrivkey($address)
    {
        $response = $this->client->sendCommand(new Command('dumpprivkey', $address));
        return $this->handleResponse($response);
    }

    public function encryptWallet($passphrase)
    {
        $response = $this->client->sendCommand(new Command('encryptwallet', $passphrase));
        return $this->handleResponse($response);
    }

    public function getAccount($address)
    {
        $response = $this->client->sendCommand(new Command('getaccount', $address));
        return $this->handleResponse($response);
    }

    public function getAccountAddress($account)
    {
        $response = $this->client->sendCommand(new Command('getaccountaddress', (string)$account));
        return $this->handleResponse($response);
    }

    public function getAddressesByAccount($account)
    {
        $response = $this->client->sendCommand(new Command('getaddressesbyaccount', $account));
        return $this->handleResponse($response);
    }

    public function getBalance($account = null, $minconf = 1)
    {
        $response = $this->client->sendCommand(new Command('getbalance', [(string)$account, (integer)$minconf]));
        return $this->handleResponse($response);
    }

    public function getBlock($hash, $verbose = true)
    {
        $response = $this->client->sendCommand(new Command('getblock', [$hash, $verbose]));
        return $this->handleResponse($response);
    }

    public function getBlockCount()
    {
        $response = $this->client->sendCommand(new Command('getblockcount'));
        return $this->handleResponse($response);
    }

    public function getBlockHash($index)
    {
        $response = $this->client->sendCommand(new Command('getblockhash', $index));
        return $this->handleResponse($response);
    }

    public function getBlockTemplate($options = null)
    {
        $response = $this->client->sendCommand(new Command('getblocktemplate', $options));
        return $this->handleResponse($response);
    }

    public function getConnectionCount()
    {
        $response = $this->client->sendCommand(new Command('getconnectioncount'));
        return $this->handleResponse($response);
    }

    public function getDifficulty()
    {
        $response = $this->client->sendCommand(new Command('getdifficulty'));
        return $this->handleResponse($response);
    }

    public function getGenerate()
    {
        $response = $this->client->sendCommand(new Command('getgenerate'));
        return $this->handleResponse($response);
    }

    public function generate($nblocks)
    {
        $response = $this->client->sendCommand(new Command('generate', $nblocks));
        return $this->handleResponse($response);
    }

    public function getHashesPerSec()
    {
        $response = $this->client->sendCommand(new Command('gethasespersec'));
        return $this->handleResponse($response);
    }

    public function getInfo()
    {
        $response = $this->client->sendCommand(new Command('getinfo'));
        return $this->handleResponse($response);
    }

    public function getMemorypool($data = null)
    {
        $response = $this->client->sendCommand(new Command('getmemorypool', $data));
        return $this->handleResponse($response);
    }

    public function getMiningInfo()
    {
        $response = $this->client->sendCommand(new Command('getmininginfo'));
        return $this->handleResponse($response);
    }

    public function getNewAddress($account = null)
    {
        $response = $this->client->sendCommand(new Command('getnewaddress', (string)$account));
        return $this->handleResponse($response);
    }

    public function getPeerInfo()
    {
        $response = $this->client->sendCommand(new Command('getpeerinfo'));
        return $this->handleResponse($response);
    }

    public function getRawMempool($verbose = false)
    {
        $response = $this->client->sendCommand(new Command('getrawmempool', $verbose));
        return $this->handleResponse($response);
    }

    public function getRawTransaction($txid, $verbose = false)
    {
        $response = $this->client->sendCommand(new Command('getrawtransaction', [$txid, (integer)$verbose]));
        return $this->handleResponse($response);
    }

    public function getReceivedByAccount($account = null, $minconf = 1)
    {
        $response = $this->client->sendCommand(new Command('getreceivedbyaccount', [(string)$account, $minconf]));
        return $this->handleResponse($response);
    }

    public function getReceivedByAddress($address = null, $minconf = 1)
    {
        $response = $this->client->sendCommand(new Command('getreceivedbyaddress', [$address, $minconf]));
        return $this->handleResponse($response);
    }

    public function getTransaction($txid)
    {
        $response = $this->client->sendCommand(new Command('gettransaction', $txid));
        return $this->handleResponse($response);
    }

    public function getTxout($txid, $n, $includemempool = true)
    {
        $response = $this->client->sendCommand(new Command('gettxout', [$txid, $n, $includemempool]));
        return $this->handleResponse($response);
    }

    public function getTxoutsetInfo()
    {
        $response = $this->client->sendCommand(new Command('gettxoutsetinfo'));
        return $this->handleResponse($response);
    }

    public function getWork($data = null)
    {
        $response = $this->client->sendCommand(new Command('getwork', $data));
        return $this->handleResponse($response);
    }

    public function importPrivkey($privkey, $label = null, $rescan = true)
    {
        $response = $this->client->sendCommand(new Command('importprivkey', [$privkey, (string)$label, (bool)$rescan]));
        return $this->handleResponse($response);
    }

    public function invalidateBlock($hash)
    {
        $response = $this->client->sendCommand(new Command('invalidateblock', $hash));
        return $this->handleResponse($response);
    }

    /**
     * NOTE: Must run walletPassphrase method before this
     *
     * @return null
     */
    public function keypoolRefill()
    {
        $response = $this->client->sendCommand(new Command('keypoolrefill'));
        return $this->handleResponse($response);
    }

    public function listAccounts($minconf = 1)
    {
        $response = $this->client->sendCommand(new Command('listaccounts', (integer)$minconf));
        return $this->handleResponse($response);
    }

    public function listAddressGroupings()
    {
        $response = $this->client->sendCommand(new Command('listaddressgroupings'));
        return $this->handleResponse($response);
    }

    public function listLockUnspent()
    {
        $response = $this->client->sendCommand(new Command('listlockunspent'));
        return $this->handleResponse($response);
    }

    public function listReceivedByAccount($minconf = 1, $includeempty = false)
    {
        $response = $this->client->sendCommand(new Command('listreceivedbyaccount', [$minconf, $includeempty]));
        return $this->handleResponse($response);
    }

    public function listReceivedByAddress($minconf = 1, $includeempty = false)
    {
        $response = $this->client->sendCommand(new Command('listreceivedbyaddress', [(int)$minconf, $includeempty]));
        return $this->handleResponse($response);
    }

    public function listSinceBlock($hash = null, $minconf = 1)
    {
        $response = $this->client->sendCommand(new Command('listsinceblock', [$hash, $minconf]));
        return $this->handleResponse($response);
    }

    public function listTransactions($account = null, $count = 10, $from = 0)
    {
        $response = $this->client->sendCommand(new Command('listtransactions', [(string)$account, $count, $from]));
        return $this->handleResponse($response);
    }

    public function listUnspent($minconf = 1, $maxconf = 999999, array $addresses = [])
    {
        $response = $this->client->sendCommand(new Command('listunspent', [$minconf, $maxconf, $addresses]));
        return $this->handleResponse($response);
    }

    public function lockUnspent()
    {
        $response = $this->client->sendCommand(new Command('lockunspent'));
        return $this->handleResponse($response);
    }


    public function move($fromaccount, $toaccount, $amount, $minconf = 1, $comment = null)
    {
        $response = $this->client->sendCommand(new Command('move', [
            (string)$fromaccount,
            (string)$toaccount,
            (float)$amount,
            (integer)$minconf,
            (string)$comment,
        ]));
        return $this->handleResponse($response);
    }

    public function sendFrom($account, $address, $amount, $minconf = 1, $comment = null, $commentto = null)
    {
        $response = $this->client->sendCommand(new Command('sendfrom', [
            $account,
            $address,
            (float)$amount,
            $minconf,
            $comment,
            $commentto,
        ]));
        return $this->handleResponse($response);
    }

    public function sendMany($fromaccount, array $addresses, $minconf = 1, $comment = null)
    {
        $response = $this->client->sendCommand(new Command('sendmany', [
            $fromaccount,
            $addresses,
            $minconf,
            $comment,
        ]));
        return $this->handleResponse($response);
    }

    public function sendRawTransaction($hex, $allowhighfees = false)
    {
        $response = $this->client->sendCommand(new Command('sendrawtransaction', [$hex, $allowhighfees]));
        return $this->handleResponse($response);
    }

    public function sendToAddress($address, $amount, $comment = null, $commentto = null)
    {
        $response = $this->client->sendCommand(new Command('sendtoaddress', [
            $address,
            $amount,
            $comment,
            $commentto,
        ]));
        return $this->handleResponse($response);
    }

    public function setAccount($address, $account)
    {
        $response = $this->client->sendCommand(new Command('setaccount', [$address, $account]));
        return $this->handleResponse($response);
    }

    public function setGenerate($generate, $genproclimit = -1)
    {
        $response = $this->client->sendCommand(new Command('setgenerate', [$generate, $genproclimit]));
        return $this->handleResponse($response);
    }

    public function setTxFee($amount)
    {
        $response = $this->client->sendCommand(new Command('settxfee', $amount));
        return $this->handleResponse($response);
    }

    public function signMessage($address, $message)
    {
        $response = $this->client->sendCommand(new Command('signmessage', [$address, $message]));
        return $this->handleResponse($response);
    }

    public function signRawTransaction($hex, array $txinfo = [], array $keys = [], $sighashtype = 'ALL')
    {
        $response = $this->client->sendCommand(new Command('signrawtransaction', [$hex, $txinfo, $keys, $sighashtype]));
        return $this->handleResponse($response);
    }

    public function stop()
    {
        $response = $this->client->sendCommand(new Command('stop'));
        return $this->handleResponse($response);
    }

    public function submitBlock()
    {
        $response = $this->client->sendCommand(new Command('submitblock'));
        return $this->handleResponse($response);
    }

    public function validateAddress($address)
    {
        $response = $this->client->sendCommand(new Command('validateaddress', $address));
        return $this->handleResponse($response);
    }

    public function verifyMessage($address, $signature, $message)
    {
        $response = $this->client->sendCommand(new Command('verifymessage', [$address, $signature, $message]));
        return $this->handleResponse($response);
    }

    public function walletLock()
    {
        $response = $this->client->sendCommand(new Command('walletlock'));
        return $this->handleResponse($response);
    }

    public function walletPassphrase($passphrase, $timeout)
    {
        $response = $this->client->sendCommand(new Command('walletpassphrase', [$passphrase, $timeout]));
        return $this->handleResponse($response);
    }

    public function walletPassphraseChange($oldpassphrase, $newpassphrase)
    {
        $response = $this->client->sendCommand(new Command('walletpassphrasechange', [$oldpassphrase, $newpassphrase]));
        return $this->handleResponse($response);
    }
}
