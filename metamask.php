<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
header('Content-Type: application/json');

static $config = [
    'chain_id' => 845621,
    'address' => '0xd5Cb5efB99e5C9C55109D64b72ccb92B01A00F7b',
    'balance' => 10.0
];

$data = json_decode(file_get_contents('php://input'), true);

$result = match ($data['method']) {
    'eth_chainId' => hex($config['chain_id']),
    'net_version' => $config['chain_id'],
    'eth_blockNumber' => '0x0',
    'eth_getBalance' => strtolower($config['address']) == $data['params'][0] ? hex($config['balance'] * 1000000000000000000) : '0x0',
    default => 'Error',
};

echo json_encode([
    'jsonrpc' => 2.0,
    'id' => 1,
    'result' => $result
], JSON_PRESERVE_ZERO_FRACTION);


function hex(int|float $var): string {
    return '0x' . dechex($var);
}