<?php

namespace Tests\WakeOnWeb\SalesforceClient\REST;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;
use WakeOnWeb\SalesforceClient\Model\Account;
use WakeOnWeb\SalesforceClient\Model\Contact;
use WakeOnWeb\SalesforceClient\Model\Npe5__Affiliation__c;
use WakeOnWeb\SalesforceClient\Normalizer\AccountNormalizer;
use WakeOnWeb\SalesforceClient\Normalizer\ContactNormalizer;
use WakeOnWeb\SalesforceClient\Normalizer\Npe5__Affiliation__cNormalizer;
use WakeOnWeb\SalesforceClient\REST\Client as SUT;
use WakeOnWeb\SalesforceClient\REST\Gateway;
use WakeOnWeb\SalesforceClient\REST\GrantType\StrategyInterface;

abstract class AbstractClientTest extends TestCase
{
    protected $modelClassName;

    protected function createSUT(Request $requestExpected = null, Response $httpClientResponse)
    {
        $gateway = $this->createMock(Gateway::class);
        $gateway->expects($this->once())
            ->method('getServiceDataUrl')
            ->willReturn('https://domain.tld');

        $grantTypeStrategy = $this->createMock(StrategyInterface::class);
        $httpClient = $this->createMock(\GuzzleHttp\Client::class);

        if ($requestExpected) {
            $httpClient->expects($this->once())
                ->method('send')
                ->with($requestExpected)
                ->willReturn($httpClientResponse);
        } else {
            $httpClient->expects($this->once())
                ->method('send')
                ->willReturn($httpClientResponse);
        }

        $grantTypeStrategy
            ->expects($this->once())
            ->method('buildAccessToken')
            ->willReturn('access_token');

        if (false === is_null($this->modelClassName)) {
            $normalizerName = 'WakeOnWeb\SalesforceClient\Normalizer\\'.$this->modelClassName.'Normalizer';
            $serializer     = new Serializer([new $normalizerName()], [new JsonEncoder()]);
        } else {
            $serializer = new Serializer([], [new JsonEncoder()]);
        }

        return new SUT($serializer, $gateway, $grantTypeStrategy, $httpClient);
    }

    /**
     * Get normalized Account from json file
     *
     * @return string json
     */
    protected function getNormalizedAccount()
    {
        return $this->getNormalizedModelObject('Account');
    }

    /**
     * Get normalized Account list from json file
     *
     * @return string json
     */
    protected function getNormalizedAccountList()
    {
        return $this->getNormalizedModelObjectsList('Account');
    }

    /**
     * Get normalized Contact from json file
     *
     * @return string json
     */
    protected function getNormalizedContact()
    {
        return $this->getNormalizedModelObject('Contact');
    }

    /**
     * Get normalized Npe5__Affiliation__c list from json file
     *
     * @return string json
     */
    protected function getNormalizedNpe5__Affiliation__cList()
    {
        return $this->getNormalizedModelObjectsList('Npe5__Affiliation__c');
    }

    /**
     * Get normalized Npe5__Affiliation__c from json file
     *
     * @return string json
     */
    protected function getNormalizedNpe5__Affiliation__c()
    {
        return $this->getNormalizedModelObject('Npe5__Affiliation__c');
    }

    /**
     * Get normalized Model object from json file
     *
     * @param string $modelClassName
     *
     * @return string json
     */
    private function getNormalizedModelObject(string $modelClassName)
    {
        $finder = new Finder();
        $finder->files()->in(__DIR__ . '/../fixtures/'.$modelClassName)->name('GetObject.json');
        $iterator = $finder->getIterator();
        $iterator->rewind();
        $file = $iterator->current();

        return $file->getContents();
    }

    /**
     * Get normalized Model object from json file
     *
     * @param string $modelClassName
     *
     * @return string json
     */
    private function getNormalizedModelObjectsList(string $modelClassName)
    {
        $finder = new Finder();
        $finder->files()->in(__DIR__ . '/../fixtures/'.$modelClassName)->name('GetObjectsList.json');
        $iterator = $finder->getIterator();
        $iterator->rewind();
        $file = $iterator->current();

        return $file->getContents();
    }

    /**
     * Get Contact model object from json file
     *
     * @return Model Object
     */
    // private function getModelObject($modelClassName)
    // {
    //     $normalizedGetter = 'getNormalized'.$modelClassName;
    //     $normalizerClass = $modelClassName.'Normalizer';
    //     $json       = $this->getNormalizedContact();
    //     $serializer = new Serializer([
    //         new ContactNormalizer()
    //     ], [
    //         new JsonEncoder()
    //     ]);

    //     return $serializer->deserialize($json, Contact::class, 'json');
    // }

    /**
     * Get Account model object from json file
     *
     * @return Account
     */
    protected function getAccount(): Account
    {
        $json       = $this->getNormalizedAccount();
        $serializer = new Serializer([
            new AccountNormalizer()
        ], [
            new JsonEncoder()
        ]);

        return $serializer->deserialize($json, Account::class, 'json');
    }

    /**
     * Get Contact model object from json file
     *
     * @return Contact
     */
    protected function getContact(): Contact
    {
        $json       = $this->getNormalizedContact();
        $serializer = new Serializer([
            new ContactNormalizer()
        ], [
            new JsonEncoder()
        ]);

        return $serializer->deserialize($json, Contact::class, 'json');
    }

    /**
     * Get Npe5__Affiliation__c model object from json file
     *
     * @return Npe5__Affiliation__c
     */
    protected function getNpe5__Affiliation__c(): Npe5__Affiliation__c
    {
        $json       = $this->getNormalizedNpe5__Affiliation__c();
        $serializer = new Serializer([
            new Npe5__Affiliation__cNormalizer()
        ], [
            new JsonEncoder()
        ]);

        return $serializer->deserialize($json, Npe5__Affiliation__c::class, 'json');
    }
}
