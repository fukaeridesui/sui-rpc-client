<?php

namespace Fukaeridesui\SuiRpcClient\Interface;

interface HttpClientInterface
{
    /**
     * Send JSON-RPC request
     *
     * @param string $method Method name
     * @param array $params Parameters
     * @return mixed Response result
     * @throws \Fukaeridesui\SuiRpcClient\Exception\SuiRpcException
     */
    public function request(string $method, array $params = []);

    /**
     * Get RPC URL
     *
     * @return string RPC URL
     */
    public function getRpcUrl(): string;
}
