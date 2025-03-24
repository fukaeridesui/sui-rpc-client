classDiagram
    class SuiRpcClient {
        -HttpClientInterface httpClient
        -ReadApiInterface readApi
        -CoinQueryApiInterface coinQueryApi
        +constructor(rpcUrl, httpClient)
        +createWithPsr18Client(rpcUrl, httpClient, requestFactory, streamFactory)
        +read()
        +coin()
        +getObject(objectId, options)
        +getMultipleObjects(objectIds, options)
        +getAllBalances(owner)
        +getAllCoins(owner, options)
        +getCoins(owner, options)
        +getBalance(owner, options)
        +getCoinMetadata(options)
        +getRpcUrl()
        +getHttpClient()
    }

    %% APIインターフェース
    class ReadApiInterface {
        <<interface>>
        +getObject(objectId, options)
        +getMultipleObjects(objectIds, options)
    }

    class CoinQueryApiInterface {
        <<interface>>
        +getAllBalances(owner)
        +getAllCoins(owner, options)
        +getCoins(owner, options)
        +getBalance(owner, options)
        +getCoinMetadata(options)
    }

    class HttpClientInterface {
        <<interface>>
        +request(method, params)
        +getRpcUrl()
    }

    %% API実装クラス
    class ReadApi {
        -HttpClientInterface httpClient
        +constructor(httpClient)
        +getObject(objectId, options)
        +getMultipleObjects(objectIds, options)
    }

    class CoinQueryApi {
        -HttpClientInterface httpClient
        +constructor(httpClient)
        +getAllBalances(owner)
        +getAllCoins(owner, options)
        +getCoins(owner, options)
        +getBalance(owner, options)
        +getCoinMetadata(options)
    }

    %% HTTPクライアント実装
    class GuzzleHttpClient {
        -Client httpClient
        -string rpcUrl
        +constructor(rpcUrl, clientOptions)
        +request(method, params)
        +getRpcUrl()
    }

    class Psr18HttpClient {
        -string rpcUrl
        -ClientInterface httpClient
        -RequestFactoryInterface requestFactory
        -StreamFactoryInterface streamFactory
        +constructor(rpcUrl, httpClient, requestFactory, streamFactory)
        +request(method, params)
        +getRpcUrl()
    }

    %% オプションクラス階層
    class BaseOptions {
        +constructor(options)
        +toArray()
    }

    class PaginationOptions {
        +?string cursor
        +?int limit
    }

    class GetAllCoinsOptions {
        %% PaginationOptionsから継承
    }

    class GetCoinsOptions {
        +?string coinType
    }

    class GetBalanceOptions {
        +?string coinType
    }

    class GetCoinMetadataOptions {
        +?string coinType
    }

    class GetObjectOptions {
        +bool showType
        +bool showOwner
        +bool showPreviousTransaction
        +bool showDisplay
        +bool showContent
        +bool showBcs
        +bool showStorageRebate
    }

    %% レスポンスクラス
    class ObjectResponseInterface {
        <<interface>>
        +getObjectId()
        +getOwner()
        +getType()
        +getContent()
        +getDigest()
        +getVersion()
        +getStorageRebate()
        +getPreviousTransaction()
        +getDisplay()
        +toArray()
    }

    class GetObjectResponse {
        -string objectId
        -string type
        -Owner owner
        -mixed content
        -string digest
        -string version
        -string storageRebate
        -string previousTransaction
        -mixed display
        +constructor(data)
        +getObjectId()
        +getOwner()
        +getType()
        +getContent()
        +getDigest()
        +getVersion()
        +getStorageRebate()
        +getPreviousTransaction()
        +getDisplay()
        +toArray()
    }

    class MultipleObjectsResponse {
        -ObjectResponseInterface[] objects
        -string[] objectIds
        +constructor(data, objectIds)
        +count()
        +getObjects()
        +getObjectIds()
        +getObjectAt(index)
        +findById(objectId)
        +toArray()
    }

    class BalanceResponse {
        -string coinType
        -int coinObjectCount
        -string totalBalance
        -array lockedBalance
        +constructor(data)
        +getCoinType()
        +getCoinObjectCount()
        +getTotalBalance()
        +getLockedBalance()
        +toArray()
    }

    class CoinMetadataResponse {
        -int decimals
        -string name
        -string symbol
        -string description
        -?string iconUrl
        -?string id
        +constructor(data)
        +getDecimals()
        +getName()
        +getSymbol()
        +getDescription()
        +getIconUrl()
        +getId()
        +toArray()
    }

    class GetAllCoinsResponse {
        -CoinObjectResponse[] data
        -?string nextCursor
        -bool hasNextPage
        +constructor(response)
        +getData()
        +getNextCursor()
        +hasNextPage()
        +count()
        +getCoinAt(index)
        +getCoinTypes()
        +getTotalBalanceForType(coinType)
        +toArray()
    }

    class CoinObjectResponse {
        -string coinType
        -string coinObjectId
        -string balance
        -string version
        -string digest
        +constructor(data)
        +getCoinType()
        +getCoinObjectId()
        +getBalance()
        +getVersion()
        +getDigest()
        +toArray()
    }

    %% 例外クラス
    class SuiRpcException {
        -?int code
        -?string message
        -?array data
        +constructor(response, message)
        +getData()
    }

    %% 関係性
    SuiRpcClient --> ReadApiInterface : uses
    SuiRpcClient --> CoinQueryApiInterface : uses
    SuiRpcClient --> HttpClientInterface : uses
    ReadApi ..|> ReadApiInterface : implements
    CoinQueryApi ..|> CoinQueryApiInterface : implements
    GuzzleHttpClient ..|> HttpClientInterface : implements
    Psr18HttpClient ..|> HttpClientInterface : implements
    GetObjectResponse ..|> ObjectResponseInterface : implements

    BaseOptions <|-- GetObjectOptions : extends
    BaseOptions <|-- PaginationOptions : extends
    PaginationOptions <|-- GetAllCoinsOptions : extends
    PaginationOptions <|-- GetCoinsOptions : extends
    BaseOptions <|-- GetBalanceOptions : extends
    BaseOptions <|-- GetCoinMetadataOptions : extends

    ReadApi --> GetObjectResponse : creates
    ReadApi --> MultipleObjectsResponse : creates
    CoinQueryApi --> BalanceResponse : creates
    CoinQueryApi --> CoinMetadataResponse : creates
    CoinQueryApi --> GetAllCoinsResponse : creates
    GetAllCoinsResponse --> CoinObjectResponse : contains

    HttpClientInterface ..> SuiRpcException : throws
    ReadApiInterface ..> SuiRpcException : throws
    CoinQueryApiInterface ..> SuiRpcException : throws