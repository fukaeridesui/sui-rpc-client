<?php

namespace Fukaeridesui\SuiRpcClient\Api;

use Fukaeridesui\SuiRpcClient\Interface\CoinQueryApiInterface;
use Fukaeridesui\SuiRpcClient\Interface\HttpClientInterface;
use Fukaeridesui\SuiRpcClient\Options\GetAllCoinsOptions;
use Fukaeridesui\SuiRpcClient\Responses\Coin\BalanceResponse;
use Fukaeridesui\SuiRpcClient\Responses\Coin\GetAllCoinsResponse;
use Fukaeridesui\SuiRpcClient\Exception\SuiRpcException;

class CoinQueryApi implements CoinQueryApiInterface
{
    private HttpClientInterface $httpClient;

    /**
     * @param HttpClientInterface $httpClient HTTP client
     */
    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * {@inheritdoc}
     */
    public function getAllBalances(string $owner): array
    {
        $result = $this->httpClient->request('suix_getAllBalances', [$owner]);

        if (!is_array($result)) {
            throw new SuiRpcException(null, 'Invalid response: Expected array of balances');
        }

        $balances = [];
        foreach ($result as $balance) {
            $balances[] = new BalanceResponse($balance);
        }

        return $balances;
    }

    /**
     * {@inheritdoc}
     */
    public function getAllCoins(string $owner, ?GetAllCoinsOptions $options = null): GetAllCoinsResponse
    {
        $options ??= new GetAllCoinsOptions();
        $params = [$owner];

        // Add cursor if it exists
        if ($options->cursor !== null) {
            $params[] = $options->cursor;
        }

        // Add limit if it exists
        if ($options->limit !== null) {
            // If cursor is not set but limit is, add null for cursor
            if ($options->cursor === null && count($params) === 1) {
                $params[] = null;
            }
            $params[] = $options->limit;
        }

        $result = $this->httpClient->request('suix_getAllCoins', $params);

        if (!is_array($result)) {
            throw new SuiRpcException(null, 'Invalid response: Expected paginated coin data');
        }

        return new GetAllCoinsResponse($result);
    }
}
