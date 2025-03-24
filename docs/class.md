classDiagram
    class SuiRpcClient {
        -HttpClientInterface httpClient
        -ReadApiInterface readApi
        -CoinQueryApiInterface coinQueryApi
        +constructor(rpcUrl, httpClient)
        +createWithPsr18Client()
        +read()
        +coin()
        +getObject()
        +getMultipleObjects()
        +getAllBalances()
        +getAllCoins()
        +getCoins()
        +getBalance()
        +getCoinMetadata()
        +getRpcUrl()
        +getHttpClient()
    }

    class ReadApiInterface {
        <<interface>>
        +getObject()
        +getMultipleObjects()
    }

    class CoinQueryApiInterface {
        <<interface>>
        +getAllBalances()
        +getAllCoins()
        +getCoins()
        +getBalance()
        +getCoinMetadata()
    }

    class HttpClientInterface {
        <<interface>>
        +request()
        +getRpcUrl()
    }

    class ReadApi {
        -HttpClientInterface httpClient
        +constructor(httpClient)
        +getObject()
        +getMultipleObjects()
    }

    class CoinQueryApi {
        -HttpClientInterface httpClient
        +constructor(httpClient)
        +getAllBalances()
        +getAllCoins()
        +getCoins()
        +getBalance()
        +getCoinMetadata()
    }

    class GuzzleHttpClient {
        -Client httpClient
        -string rpcUrl
        +constructor(rpcUrl, clientOptions)
        +request()
        +getRpcUrl()
    }

    class Psr18HttpClient {
        -ClientInterface httpClient
        -RequestFactoryInterface requestFactory
        -StreamFactoryInterface streamFactory
        -string rpcUrl
        +constructor()
        +request()
        +getRpcUrl()
    }

    class BaseOptions {
        +constructor(options)
        +toArray()
    }

    class GetObjectOptions {
        +bool showType
        +bool showOwner
        +bool showContent
        +bool showDisplay
    }

    class PaginationOptions {
        +string cursor
        +int limit
    }

    class SuiRpcException {
        -int code
        -string message
        -array data
        +constructor(response, message)
        +getData()
    }
    
    SuiRpcClient --> ReadApiInterface : uses
    SuiRpcClient --> CoinQueryApiInterface : uses
    SuiRpcClient --> HttpClientInterface : uses
    ReadApi --> ReadApiInterface : implements
    CoinQueryApi --> CoinQueryApiInterface : implements
    GuzzleHttpClient --> HttpClientInterface : implements
    Psr18HttpClient --> HttpClientInterface : implements
    
    BaseOptions <-- GetObjectOptions : extends
    BaseOptions <-- PaginationOptions : extends
    
    ReadApi --> SuiRpcException : throws
    CoinQueryApi --> SuiRpcException : throws
    GuzzleHttpClient --> SuiRpcException : throws
    Psr18HttpClient --> SuiRpcException : throws