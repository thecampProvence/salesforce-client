<?php

namespace Tests\WakeOnWeb\SalesforceClient\REST;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;
use WakeOnWeb\SalesforceClient\DTO\SalesforceObject;
use WakeOnWeb\SalesforceClient\DTO\SalesforceObjectCreation;
use WakeOnWeb\SalesforceClient\DTO\SalesforceObjectResults;
use WakeOnWeb\SalesforceClient\Model\Account;
use WakeOnWeb\SalesforceClient\Normalizer\AccountNormalizer;
use WakeOnWeb\SalesforceClient\Query\QueryBuilder;

class AccountClientTest extends AbstractClientTest
{
    protected $modelClassName = 'Account';

    public function test_create_account()
    {
        $account  = $this->getAccount();
        $response = [
            'id'       => '0011q000008K2BBAA0',
            'success'  => true,
            'errors'   => [],
            'warnings' => [],
        ];

        $sut = $this->createSUT(null, new Response(200, [], json_encode($response)));
        // we can't test the request since stream are different ...
        // let's find a way to fix that.
        $salesforceObjectCreation = $sut->create($account);
        $this->assertEquals($salesforceObjectCreation, SalesforceObjectCreation::createFromArray($response));
    }

    public function test_patch_account()
    {
        $sut     = $this->createSUT(null, new Response(204));
        $account = $this->getAccount();

        // $serializer = new Serializer([
        //     new AccountNormalizer()
        // ], [
        //     new JsonEncoder()
        // ]);

        // $sut = $this->createSUT(
        //     new Request(
        //         'PATCH',
        //         'https://domain.tld',
        //         [
        //             'Authorization' => 'Bearer access_token',
        //             'content-type'  => 'application/json',
        //         ],
        //         $serializer->serialize($account, 'json')
        //     ),
        //     new Response(204)
        // );

        $result = $sut->patch($account);

        // we can't test the request since stream are different ...
        // let's find a way to fix that.
        $this->assertNull($result);
    }

    public function test_delete_account()
    {
        $sut = $this->createSUT(
            new Request('DELETE', 'https://domain.tld', ['Authorization' => 'Bearer access_token']),
            new Response(204)
        );
        $account = $this->getAccount();
        $result  = $sut->delete($account);
        $this->assertNull($result);
    }

    public function test_get_account()
    {
        $json       = $this->getNormalizedAccount();
        $serializer = new Serializer([
            new AccountNormalizer()
        ], [
            new JsonEncoder()
        ]);
        $account = $serializer->deserialize($json, Account::class, 'json');

        $responseData = json_decode($json, true);
        $sut          = $this->createSUT(
            new Request('GET', 'https://domain.tld', ['Authorization' => 'Bearer access_token']),
            new Response(200, [], $json)
        );
        $result           = $sut->getById('Account', '0011q000008K2BBAA0');
        $salesforceObject = SalesforceObject::createFromArray($responseData);
        $this->assertEquals($result, $salesforceObject);
        $this->assertEquals($result->getObject(), $account);
    }

    public function test_search_accounts()
    {
        $queryBuilder = new QueryBuilder(Account::class);
        $queryBuilder
            ->select(['Id', 'Name', 'Inactive__c', 'RecordTypeId', 'Relations_with_thecamp__c'])
            ->where('Inactive__c = false')
            ;
        $json = $this->getNormalizedAccountList();
        $responseData = json_decode($json, true);

        $sut = $this->createSUT(
            new Request('GET', 'https://domain.tld?q='.$queryBuilder->getQuery(), ['Authorization' => 'Bearer access_token']),
            new Response(200, [], $json)
        );
        $results = $sut->search($queryBuilder);

        $this->assertEquals($results, SalesforceObjectResults::createFromArray($responseData));
    }

}
