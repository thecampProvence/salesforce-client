<?php

namespace WakeOnWeb\SalesforceClient\REST;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use Symfony\Component\Serializer\SerializerInterface;
use WakeOnWeb\SalesforceClient\ClientInterface;
use WakeOnWeb\SalesforceClient\DTO;
use WakeOnWeb\SalesforceClient\Exception;
use WakeOnWeb\SalesforceClient\Exception\SalesforceClientException;
use WakeOnWeb\SalesforceClient\Model;
use WakeOnWeb\SalesforceClient\Query\QueryBuilder;
use WakeOnWeb\SalesforceClient\REST\GrantType\StrategyInterface as GrantTypeStrategyInterface;

class Client implements ClientInterface
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    private $gateway;

    private $grantTypeStrategy;

    private $accessToken;

    const OBJECT_PATH = 'sobjects';

    public function __construct(
        SerializerInterface $serializer,
        Gateway $gateway,
        GrantTypeStrategyInterface $grantTypeStrategy,
        HttpClient $httpClient = null
    ){
        $this->serializer        = $serializer;
        $this->gateway           = $gateway;
        $this->grantTypeStrategy = $grantTypeStrategy;
        $this->httpClient        = $httpClient ?: new HttpClient();
    }

    public function getAvailableResources(): array
    {
        return $this->doAuthenticatedRequest(
            new Request(
                'GET',
                $this->gateway->getServiceDataUrl()
            )
        );
    }

    public function getAllObjects(): array
    {
        return $this->doAuthenticatedRequest(
            new Request(
                'GET',
                $this->gateway->getServiceDataUrl(static::OBJECT_PATH)
            )
        );
    }

    public function getObjectMetadata(string $endpoint, \DateTimeInterface $since = null): array
    {
        $headers = [];
        if ($since) {
            $headers['IF-Modified-Since'] = $since->format('D, j M Y H:i:s e');
        }

        return $this->doAuthenticatedRequest(
            new Request(
                'GET',
                $this->gateway->getServiceDataUrl(static::OBJECT_PATH.'/'.$endpoint),
                $headers
            )
        );
    }

    public function describeObjectMetadata(string $endpoint, \DateTimeInterface $since = null): array
    {
        $headers = [];
        if ($since) {
            $headers['IF-Modified-Since'] = $since->format('D, j M Y H:i:s e');
        }

        return $this->doAuthenticatedRequest(
            new Request(
                'GET',
                $this->gateway->getServiceDataUrl(static::OBJECT_PATH.'/'.$endpoint.'/describe'),
                $headers
            )
        );
    }

    /**
     * Trigger a POST request to Salesforce with given model object
     *
     * @param object $object Model object
     *
     * @return DTO\SalesforceObjectCreation
     */
    public function create(object $object): DTO\SalesforceObjectCreation
    {
        $reflectedClass = new \ReflectionClass($object);
        $endpoint       = $reflectedClass->getConstant('TABLE_NAME');
        $request        = new Request(
            'POST',
            $this->gateway->getServiceDataUrl(static::OBJECT_PATH.'/'.$object::TABLE_NAME),
            ['content-type' => 'application/json'],
            $this->serializer->serialize($object, 'json')
        );

        return DTO\SalesforceObjectCreation::createFromArray(
            $this->doAuthenticatedRequest($request)
        );
    }

    /**
     * @deprecated
     */
    public function createObject(string $endpoint, array $data): DTO\SalesforceObjectCreation
    {
        $data = $this->doAuthenticatedRequest(
            new Request(
                'POST',
                $this->gateway->getServiceDataUrl(static::OBJECT_PATH.'/'.$endpoint),
                ['content-type' => 'application/json'],
                json_encode($data)
            )
        );

        return DTO\SalesforceObjectCreation::createFromArray($data);
    }

    /**
     * Trigger a PATCH request to Salesforce with given model object
     *
     * @param object $object Model object
     */
    public function patch(object $object)
    {
        $reflectedClass = new \ReflectionClass($object);
        $endpoint       = $reflectedClass->getConstant('TABLE_NAME');
        $request        = new Request(
            'PATCH',
            $this->gateway->getServiceDataUrl(static::OBJECT_PATH.'/'.$endpoint.'/'.$object->getId()),
            ['content-type' => 'application/json'],
            $this->serializer->serialize($object, 'json')
        );

        /**
         * @internal Patch request return 204 status
         */
        $this->doAuthenticatedRequest($request);
    }

    /**
     * @deprecated
     */
    public function patchObject(string $endpoint, string $id, array $data)
    {
        $this->doAuthenticatedRequest(
            new Request(
                'PATCH',
                $this->gateway->getServiceDataUrl(static::OBJECT_PATH.'/'.$endpoint.'/'.$id),
                ['content-type' => 'application/json'],
                json_encode($data)
            )
        );
    }

    /**
     * Trigger a DELETE request to Salesforce with given model object
     *
     * @param object $object Model object
     */
    public function delete(object $object)
    {
        $reflectedClass = new \ReflectionClass($object);
        $endpoint       = $reflectedClass->getConstant('TABLE_NAME');
        $request        = new Request(
            'DELETE',
            $this->gateway->getServiceDataUrl(static::OBJECT_PATH.'/'.$endpoint.'/'.$object->getId())
        );

        /**
         * @internal Delete request return 204 status
         */
        $this->doAuthenticatedRequest($request);
    }

    /**
     * @deprecated
     */
    public function deleteObject(string $endpoint, string $id)
    {
        $this->doAuthenticatedRequest(
            new Request(
                'DELETE',
                $this->gateway->getServiceDataUrl(static::OBJECT_PATH.'/'.$endpoint.'/'.$id)
            )
        );
    }

    /**
     * Trigger a GET request to Salesforce with given model object
     *
     * @param string $endpoint API endpoint (equivalent to object name)
     *
     * @return DTO\SalesforceObject
     */
    public function getById(string $endpoint, string $id): DTO\SalesforceObject
    {
        $endpoint = ucfirst($endpoint);
        $request  = new Request(
            'GET',
            $this->gateway->getServiceDataUrl(static::OBJECT_PATH.'/'.$endpoint.'/'.$id)
        );
        $responseData = $this->doAuthenticatedRequest($request);

        return DTO\SalesforceObject::createFromArray(
            $responseData,
            $endpoint
        );
    }

    /**
     * @deprecated
     */
    public function getObject(string $endpoint, string $id, array $fields = []): DTO\SalesforceObject
    {
        $url = $this->gateway->getServiceDataUrl(static::OBJECT_PATH.'/'.$endpoint.'/'.$id);

        if (false === empty($fields)) {
            $url .= '?fields='.implode(',', $fields);
        }

        return DTO\SalesforceObject::createFromArray(
            $this->doAuthenticatedRequest(new Request('GET', $url))
        );
    }

    /**
     * Search records in SF using SOQL query
     *
     * @param QueryBuilder $queryBuilder
     *
     * @return DTO\SalesforceObjectResults
     */
    public function search(QueryBuilder $queryBuilder): DTO\SalesforceObjectResults
    {
        $endpoint = $queryBuilder->includeSoftDeleted() ? 'queryAll' : 'query';
        $request  = new Request(
            'GET',
            $this->gateway->getServiceDataUrl($endpoint).'?q='.$queryBuilder->getQuery()
        );
        $responseData = $this->doAuthenticatedRequest($request);

        return DTO\SalesforceObjectResults::createFromArray(
            $responseData,
            $queryBuilder->getModelClassName()
        );
    }

    /**
     * @deprecated
     */
    public function searchSOQL(string $query, bool $all = self::NOT_ALL): DTO\SalesforceObjectResults
    {
        $url = $this->gateway->getServiceDataUrl($all ? 'queryAll' : 'query').'?q='.$query;

        return DTO\SalesforceObjectResults::createFromArray(
            $this->doAuthenticatedRequest(
                new Request('GET', $url)
            )
        );
    }

    public function explainSOQL(string $query, bool $all = self::NOT_ALL): array
    {
        $url = $this->gateway->getServiceDataUrl($all ? 'queryAll' : 'query').'?explain='.$query;

        return $this->doAuthenticatedRequest(
            new Request('GET', $url)
        );
    }

    private function doAuthenticatedRequest(Request $request)
    {
        $this->connectIfAccessTokenIsEmpty();

        $request = $request->withAddedHeader('Authorization', 'Bearer '.$this->accessToken);

        try {
            $response = $this->httpClient->send($request);
        } catch (RequestException $e) {
            throw Exception\ExceptionFactory::generateFromRequestException($e, $request->getBody());
        } catch (\Exception $e) {
            throw new SalesforceClientException($e->getMessage(), 0, $e);
        }

        $body = '[]';

        // Check if response has content
        if ($response->getStatusCode() !== 204) {
            $body = (string) $response->getBody();
        }

        return json_decode($body, true);
    }

    private function connectIfAccessTokenIsEmpty()
    {
        if (null !== $this->accessToken) {
            return;
        }

        $this->accessToken = $this->grantTypeStrategy->buildAccessToken($this->gateway);
    }
}
