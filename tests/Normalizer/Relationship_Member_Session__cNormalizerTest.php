<?php

namespace Tests\WakeOnWeb\SalesforceClient\Normalizer;

/* Imports */
use WakeOnWeb\SalesforceClient\Model\Relationship_Member_Session__c;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;
use WakeOnWeb\SalesforceClient\Normalizer\Relationship_Member_Session__cNormalizer;
use Symfony\Component\Finder\Finder;
use PHPUnit\Framework\TestCase;

/**
 * Class Relationship_Member_Session__cNormalizerTest.
 */
class Relationship_Member_Session__cNormalizerTest extends TestCase
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
            new Relationship_Member_Session__cNormalizer()
        ], [
            new JsonEncoder()
        ]);
    }

    /**
     * Deserialize json to Relationship_Member_Session__c object and normalize it
     */
    public function testNormalizerDenormalizer()
    {
        $finder = new Finder();
        $finder->files()->in(__DIR__ . '/../fixtures/Relationship_Member_Session__c')->name('GetObject.json');

        foreach ($finder as $file) {
            /**
             * @var Relationship_Member_Session__c $object
             */
            $object = $this->serializer->deserialize($file->getContents(), Relationship_Member_Session__c::class, 'json');

            $this->assertInstanceOf('WakeOnWeb\SalesforceClient\Model\Relationship_Member_Session__c', $object, 'Relationship_Member_Session__c should be of type WakeOnWeb\SalesforceClient\Model\Relationship_Member_Session__c');
            $this->assertEquals($object->getId(), 'a0p1n000007AZD8AAO');
            $this->assertEquals($object->getSession__c(), 'a0r1n00000gTKOPAA4');
            $this->assertEquals($object->getMember__c(), '0031n00001pPQ79AAG');
            $this->assertEquals($object->getTransaction_digitick_id__c(), 'digitickTicketingIds - 112490779 - 5992351');
            $this->assertEquals($object->getTicket_digitick_id__c(), null);
            $this->assertEquals($object->getSubscription_date__c(), new \DateTime('2019-01-15T13:35:37.000+0000'));
            $this->assertEquals($object->getType_of_relationship_new__c(), ['1']);

            $data = $this->serializer->normalize($object);

            $this->assertEquals($data['id'], 'a0p1n000007AZD8AAO');
            $this->assertEquals($data['session__c'], 'a0r1n00000gTKOPAA4');
            $this->assertEquals($data['member__c'], '0031n00001pPQ79AAG');
            $this->assertEquals($data['transaction_digitick_id__c'], 'digitickTicketingIds - 112490779 - 5992351');
            $this->assertTrue(!isset($data['ticket_digitick_id__c']));
            $this->assertEquals($data['subscription_date__c'], '2019-01-15T13:35:37.000+0000');
            $this->assertEquals($data['type_of_relationship_new__c'], '1');
        }
    }
}
