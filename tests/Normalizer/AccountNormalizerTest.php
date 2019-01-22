<?php

namespace Tests\WakeOnWeb\SalesforceClient\Normalizer;

/* Imports */
use WakeOnWeb\SalesforceClient\Model\Account;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;
use WakeOnWeb\SalesforceClient\Normalizer\AccountNormalizer;
use Symfony\Component\Finder\Finder;
use PHPUnit\Framework\TestCase;

/**
 * Class AccountNormalizerTest.
 */
class AccountNormalizerTest extends TestCase
{
    /**
     * @var Symfony\Component\Serializer\Serializer
     */
    protected $serializer;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->serializer = new Serializer([
            new AccountNormalizer()
        ], [
            new JsonEncoder()
        ]);
    }

    /**
     * Deserialize json to Account object and normalize it
     */
    public function testNormalizerDenormalizer()
    {
        $finder = new Finder();
        $finder->files()->in(__DIR__ . '/../fixtures/Account')->name('GetObject.json');

        foreach ($finder as $file) {
            /**
             * @var Account $object
             */
            $object = $this->serializer->deserialize($file->getContents(), Account::class, 'json');

            $this->assertInstanceOf('WakeOnWeb\SalesforceClient\Model\Account', $object, 'Account should be of type WakeOnWeb\SalesforceClient\Model\Account');
            $this->assertEquals($object->getId(), '0011q000008K2BBAA0');
            $this->assertEquals($object->getName(), 'TEST QUOTE SUITE REFRESH');
            $this->assertEquals($object->getInactive__c(), false);
            $this->assertEquals($object->getRecordTypeId(), Account::RECORD_TYPE_ID_ORGANIZATION);
            $this->assertEquals($object->getRelations_with_thecamp__c(), ['2', '7']);
            $this->assertFalse($object->isHouseHold());
            $this->assertTrue($object->isOrganization());

            $data = $this->serializer->normalize($object);

            $this->assertEquals($data['id'], '0011q000008K2BBAA0');
            $this->assertEquals($data['name'], 'TEST QUOTE SUITE REFRESH');
            $this->assertEquals($data['inactive__c'], false);
            $this->assertEquals($data['recordtypeid'], Account::RECORD_TYPE_ID_ORGANIZATION);
            $this->assertEquals($data['relations_with_thecamp__c'], '2;7');
        }
    }
}
