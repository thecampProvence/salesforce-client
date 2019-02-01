<?php

namespace Tests\WakeOnWeb\SalesforceClient\REST;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use WakeOnWeb\SalesforceClient\DTO\SalesforceObject;
use WakeOnWeb\SalesforceClient\DTO\SalesforceObjectCreation;
use WakeOnWeb\SalesforceClient\DTO\SalesforceObjectResults;

class ClientTest extends AbstractClientTest
{
    public function test_get_available_resources()
    {
        $sut = $this->createSUT(
            new Request('GET', 'https://domain.tld', ['Authorization' => 'Bearer access_token']),
            new Response(200, [], '{"foo": "bar"}')
        );
        $this->assertEquals($sut->getAvailableResources(), ['foo' => 'bar']);
    }

    public function test_get_all_objects()
    {
        $sut = $this->createSUT(
            new Request('GET', 'https://domain.tld', ['Authorization' => 'Bearer access_token']),
            new Response(200, [], '{"foo": "bar"}')
        );
        $this->assertEquals($sut->getAllObjects(), ['foo' => 'bar']);
    }

    public function test_get_object_metadata()
    {
        $sut = $this->createSUT(
            new Request('GET', 'https://domain.tld', ['Authorization' => 'Bearer access_token']),
            new Response(200, [], '{"foo": "bar"}')
        );
        $this->assertEquals($sut->getObjectMetadata('foo'), ['foo' => 'bar']);


        $since = new \DateTimeImmutable();
        $sut = $this->createSUT(
            new Request('GET', 'https://domain.tld', [
                'Authorization' => 'Bearer access_token',
                'IF-Modified-Since' => $since->format('D, j M Y H:i:s e')
            ]),
            new Response(200, [], '{"foo": "bar"}')
        );
        $this->assertEquals($sut->getObjectMetadata('foo', $since), ['foo' => 'bar']);
    }

    public function test_describe_object_metadata()
    {
        $sut = $this->createSUT(
            new Request('GET', 'https://domain.tld', ['Authorization' => 'Bearer access_token']),
            new Response(200, [], '{"foo": "bar"}')
        );
        $this->assertEquals($sut->describeObjectMetadata('foo'), ['foo' => 'bar']);


        $since = new \DateTimeImmutable();
        $sut = $this->createSUT(
            new Request('GET', 'https://domain.tld', [
                'Authorization' => 'Bearer access_token',
                'IF-Modified-Since' => $since->format('D, j M Y H:i:s e')
            ]),
            new Response(200, [], '{"foo": "bar"}')
        );
        $this->assertEquals($sut->describeObjectMetadata('foo', $since), ['foo' => 'bar']);
    }

    public function test_create_object()
    {
        $response = [
            'id' => 1337,
            'success' => true,
            'errors' => [],
            'warnings' => [],
        ];

        $sut = $this->createSUT(null, new Response(200, [], json_encode($response)));
        // we can't test the request since stream are different ...
        // let's find a way to fix that.
        $this->assertEquals($sut->createObject('foo', []), SalesforceObjectCreation::createFromArray($response));
    }

    public function test_patch_object()
    {
        $sut = $this->createSUT(null, new Response(204));
        // we can't test the request since stream are different ...
        // let's find a way to fix that.
        $this->assertNull($sut->patchObject('foo', 1234, []));
    }

    public function test_delete_object()
    {
        $sut = $this->createSUT(
            new Request('DELETE', 'https://domain.tld', ['Authorization' => 'Bearer access_token']),
            new Response(204)
        );
        $this->assertNull($sut->deleteObject('foo', 1234));
    }

    public function test_get_object()
    {
        $response = [
            'attributes' => [
                'type' => 'Account',
                'url' => ''
            ],
            'Id'=> 1337
        ];

        $sut = $this->createSUT(
            new Request('GET', 'https://domain.tld', ['Authorization' => 'Bearer access_token']),
            new Response(200, [], json_encode($response))
        );
        $this->assertEquals($sut->getObject('foo', 1234), SalesforceObject::createFromArray($response));

        $response = [
            'attributes' => [
                'type' => 'Account',
                'url' => ''
            ],
            'Id'=> 1337
        ];

        $sut = $this->createSUT(
            new Request('GET', 'https://domain.tld?fields=foo,bar', ['Authorization' => 'Bearer access_token']),
            new Response(200, [], json_encode($response))
        );
        $this->assertEquals($sut->getObject('foo', 1234, ['foo', 'bar']), SalesforceObject::createFromArray($response));
    }

    public function test_search_soql()
    {
        $response = [
            'totalSize' => 0,
            'done' => true,
            'records' => []
        ];

        $sut = $this->createSUT(
            new Request('GET', 'https://domain.tld?q=MY QUERY', ['Authorization' => 'Bearer access_token']),
            new Response(200, [], json_encode($response))
        );
        $this->assertEquals($sut->searchSOQL('MY QUERY'), SalesforceObjectResults::createFromArray($response));
    }

    public function test_explain_soql()
    {
        $sut = $this->createSUT(
            new Request('GET', 'https://domain.tld?explain=MY QUERY', ['Authorization' => 'Bearer access_token']),
            new Response(200, [], '[]')
        );
        $this->assertEquals($sut->explainSOQL('MY QUERY'), []);
    }
}
