<?php

namespace Fukaeridesui\SuiRpcClient\Contracts;

interface HttpClientInterface
{
    /**
     * Execute JSON-RPC request
     *
     * @param string $method RPC method name
     * @param array $params RPC parameters
     * @return array Response result
     * @throws \Fukaeridesui\SuiRpcClient\Exception\SuiRpcException
     */
    public function request(string $method, array $params = []): array;

    /**
     * Get RPC URL
     *
     * @return string RPC URL
     */
    public function getRpcUrl(): string;
}
