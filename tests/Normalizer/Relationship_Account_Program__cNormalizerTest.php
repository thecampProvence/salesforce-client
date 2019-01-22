<?php

namespace Tests\WakeOnWeb\SalesforceClient\Normalizer;

/* Imports */
use WakeOnWeb\SalesforceClient\Model\Relationship_Account_Program__c;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;
use WakeOnWeb\SalesforceClient\Normalizer\Relationship_Account_Program__cNormalizer;
use Symfony\Component\Finder\Finder;
use PHPUnit\Framework\TestCase;

/**
 * Class Relationship_Account_Program__cNormalizerTest.
 */
class Relationship_Account_Program__cNormalizerTest extends TestCase
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
            new Relationship_Account_Program__cNormalizer()
        ], [
            new JsonEncoder()
        ]);
    }

    /**
     * Deserialize json to Relationship_Account_Program__c object and normalize it
     */
    public function testNormalizerDenormalizer()
    {
        $finder = new Finder();
        $finder->files()->in(__DIR__ . '/../fixtures/Relationship_Account_Program__c')->name('GetObject.json');

        foreach ($finder as $file) {
            /**
             * @var Relationship_Account_Program__c $object
             */
            $object = $this->serializer->deserialize($file->getContents(), Relationship_Account_Program__c::class, 'json');

            $this->assertInstanceOf('WakeOnWeb\SalesforceClient\Model\Relationship_Account_Program__c', $object, 'Relationship_Account_Program__c should be of type WakeOnWeb\SalesforceClient\Model\Relationship_Account_Program__c');
            $this->assertEquals($object->getId(), 'a0t0Y000000zoctQAA');
            $this->assertEquals($object->getProgram__c(), 'a0r0Y00000WnMScQAN');
            $this->assertEquals($object->getAccount_name__c(), '0010Y00000Kz4JZQAZ');
            $this->assertEquals($object->getAccount_program_key__c(), 'digitickTicketingIds - 277458342');
            $this->assertEquals($object->getSubscription_date__c(), new \DateTime('2019-01-20T15:10:37.000+0000'));
            $this->assertEquals($object->getType_of_relationship_new__c(), ['1']);

            $data = $this->serializer->normalize($object);

            $this->assertEquals($data['id'], 'a0t0Y000000zoctQAA');
            $this->assertEquals($data['program__c'], 'a0r0Y00000WnMScQAN');
            $this->assertEquals($data['account_name__c'], '0010Y00000Kz4JZQAZ');
            $this->assertEquals($data['account_program_key__c'], 'digitickTicketingIds - 277458342');
            $this->assertEquals($data['subscription_date__c'], '2019-01-20T15:10:37.000+0000');
            $this->assertEquals($data['type_of_relationship_new__c'], '1');
        }
    }
}
