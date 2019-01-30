<?php

namespace Tests\WakeOnWeb\SalesforceClient\REST;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Psr\Log\LoggerInterface;
use WakeOnWeb\SalesforceClient\DTO\SalesforceObject;
use WakeOnWeb\SalesforceClient\DTO\SalesforceObjectResults;
use WakeOnWeb\SalesforceClient\Model\Account;
use WakeOnWeb\SalesforceClient\Model\Contact;
use WakeOnWeb\SalesforceClient\Model\Npe5__Affiliation__c;
use WakeOnWeb\SalesforceClient\Query\QueryBuilder;
use WakeOnWeb\SalesforceClient\REST\Client as SUT;
use WakeOnWeb\SalesforceClient\REST\Client;
use WakeOnWeb\SalesforceClient\Repository\ModelRepository;

class ModelRepositoryTest extends AbstractClientTest
{
    public function testFindRequiredContact()
    {
        $loggerMock           = $this->createMock(LoggerInterface::class);
        $salesforceClientMock = $this->createMock(Client::class);
        $salesforceObjectMock = $this->createMock(SalesforceObject::class);
        $json                 = $this->getNormalizedContact();
        $responseData         = json_decode($json, true);

        $salesforceClientMock
            ->expects($this->once())
            ->method('getById')
            ->with(Contact::TABLE_NAME, '0031q000007cOUXAA2')
            ->willReturn($salesforceObjectMock)
        ;

        $salesforceObjectMock
            ->expects($this->once())
            ->method('getObject')
            ->willReturn($this->getContact())
        ;

        $repo    = new ModelRepository($salesforceClientMock, $loggerMock);
        $contact = $repo->findRequiredContact('0031q000007cOUXAA2');

        $this->assertEquals($contact, $this->getContact());
    }

    public function testFindAffiliation()
    {
        $loggerMock           = $this->createMock(LoggerInterface::class);
        $salesforceClientMock = $this->createMock(Client::class);
        $salesforceObjectMock = $this->createMock(SalesforceObject::class);
        $json                 = $this->getNormalizedNpe5__Affiliation__c();
        $responseData         = json_decode($json, true);

        $salesforceClientMock
            ->expects($this->once())
            ->method('getById')
            ->with(Npe5__Affiliation__c::TABLE_NAME, 'a0H1q000001sx0IEAQ')
            ->willReturn($salesforceObjectMock)
        ;

        $salesforceObjectMock
            ->expects($this->once())
            ->method('getObject')
            ->willReturn($this->getNpe5__Affiliation__c())
        ;

        $repo                 = new ModelRepository($salesforceClientMock, $loggerMock);
        $npe5__Affiliation__c = $repo->findAffiliation('a0H1q000001sx0IEAQ');

        $this->assertEquals($npe5__Affiliation__c, $this->getNpe5__Affiliation__c());
    }

    public function testFindAffiliationEvenDeletedAndOneFound()
    {
        $loggerMock           = $this->createMock(LoggerInterface::class);
        $salesforceClientMock = $this->createMock(Client::class);
        $json                 = $this->getNormalizedNpe5__Affiliation__c();
        $responseData         = json_decode($json, true);
        $salesforceResponse   = [
            'totalSize' => 1,
            'done'      => true,
            'records'   => [$responseData]
        ];

        $salesforceObjectResults = SalesforceObjectResults::createFromArray(
            $salesforceResponse
        );

        $salesforceClientMock
            ->expects($this->once())
            ->method('search')
            ->willReturn($salesforceObjectResults)
        ;

        $repo                 = new ModelRepository($salesforceClientMock, $loggerMock);
        $npe5__Affiliation__c = $repo->findAffiliationEvenDeleted('a0H1q000001sx0IEAQ');

        $this->assertEquals($npe5__Affiliation__c, $this->getNpe5__Affiliation__c());
    }

    public function testFindAffilationFromContact()
    {
        $loggerMock           = $this->createMock(LoggerInterface::class);
        $salesforceClientMock = $this->createMock(Client::class);
        $json                 = $this->getNormalizedNpe5__Affiliation__cList();
        $salesforceResponse   = json_decode($json, true);

        $salesforceObjectResults = SalesforceObjectResults::createFromArray(
            $salesforceResponse
        );

        $salesforceClientMock
            ->expects($this->once())
            ->method('search')
            ->willReturn($salesforceObjectResults)
        ;

        $repo                     = new ModelRepository($salesforceClientMock, $loggerMock);
        $npe5__Affiliation__cList = $repo->findAffilationFromContact('a0H1q000001sx0IEAQ');

        $this->assertEquals($npe5__Affiliation__cList, $salesforceObjectResults);
    }

    public function testFindMainAffiliationForContactAndFoundOne()
    {
        $loggerMock           = $this->createMock(LoggerInterface::class);
        $salesforceClientMock = $this->createMock(Client::class);
        $json                 = $this->getNormalizedNpe5__Affiliation__c();
        $responseData         = json_decode($json, true);
        $salesforceResponse   = [
            'totalSize' => 1,
            'done'      => true,
            'records'   => [$responseData]
        ];

        $salesforceObjectResults = SalesforceObjectResults::createFromArray(
            $salesforceResponse
        );

        $salesforceClientMock
            ->expects($this->once())
            ->method('search')
            ->willReturn($salesforceObjectResults)
        ;

        $repo                 = new ModelRepository($salesforceClientMock, $loggerMock);
        $npe5__Affiliation__c = $repo->findMainAffiliationForContact('a0H1q000001sx0IEAQ');

        $this->assertEquals($npe5__Affiliation__c, $this->getNpe5__Affiliation__c());
    }

    public function testFindAccount()
    {
        $loggerMock           = $this->createMock(LoggerInterface::class);
        $salesforceClientMock = $this->createMock(Client::class);
        $salesforceObjectMock = $this->createMock(SalesforceObject::class);
        $json                 = $this->getNormalizedAccount();
        $responseData         = json_decode($json, true);

        $salesforceClientMock
            ->expects($this->once())
            ->method('getById')
            ->with(Account::TABLE_NAME, '0011q000008K2BBAA0')
            ->willReturn($salesforceObjectMock)
        ;

        $salesforceObjectMock
            ->expects($this->once())
            ->method('getObject')
            ->willReturn($this->getAccount())
        ;

        $repo    = new ModelRepository($salesforceClientMock, $loggerMock);
        $account = $repo->findAccount('0011q000008K2BBAA0');

        $this->assertEquals($account, $this->getAccount());
    }
}
