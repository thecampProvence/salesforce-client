<?php

namespace Tests\WakeOnWeb\SalesforceClient\Normalizer;

/* Imports */
use WakeOnWeb\SalesforceClient\Model\Program_session__c;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;
use WakeOnWeb\SalesforceClient\Normalizer\Program_session__cNormalizer;
use Symfony\Component\Finder\Finder;
use PHPUnit\Framework\TestCase;

/**
 * Class Program_session__cNormalizerTest.
 */
class Program_session__cNormalizerTest extends TestCase
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
            new Program_session__cNormalizer()
        ], [
            new JsonEncoder()
        ]);
    }

    /**
     * Deserialize json to Program_session__c object and normalize it
     */
    public function testSessionNormalizerDenormalizer()
    {
        $finder = new Finder();
        $finder->files()->in(__DIR__ . '/../fixtures/Program_session__c')->name('GetObjectSession.json');

        foreach ($finder as $file) {
            /**
             * @var Program_session__c $object
             */
            $object = $this->serializer->deserialize($file->getContents(), Program_session__c::class, 'json');

            $this->assertInstanceOf('WakeOnWeb\SalesforceClient\Model\Program_session__c', $object, 'Program_session__c should be of type WakeOnWeb\SalesforceClient\Model\Program_session__c');
            $this->assertEquals($object->getId(), 'a0r1q000000Tbe3AAC');
            $this->assertEquals($object->getRecordTypeId(), Program_session__c::RECORD_TYPE_ID_ACTIVITY);
            $this->assertEquals($object->getName(), 'Conférence : l\'oeuf ou la poule ?');
            $this->assertEquals($object->getDescription__c(), null);
            $this->assertEquals($object->getSession_id__c(), 'digitickTicketingIds - 5887111');
            $this->assertEquals($object->getProgram_id__c(), null);
            $this->assertEquals($object->getStart_date__c(), new \DateTime('2019-01-29T16:00:00.000+0000'));
            $this->assertEquals($object->getEnd_date__c(), new \DateTime('2019-01-29T18:00:00.000+0000'));
            $this->assertEquals($object->getStatus__c(), '1');

            $data = $this->serializer->normalize($object);

            $this->assertEquals($data['id'], 'a0r1q000000Tbe3AAC');
            $this->assertEquals($data['recordtypeid'], Program_session__c::RECORD_TYPE_ID_ACTIVITY);
            $this->assertEquals($data['name'], 'Conférence : l\'oeuf ou la poule ?');
            $this->assertTrue(!isset($data['description__c']));
            $this->assertEquals($data['session_id__c'], 'digitickTicketingIds - 5887111');
            $this->assertTrue(!isset($data['program_id__c']));
            $this->assertEquals($data['start_date__c'], '2019-01-29T16:00:00.000+0000');
            $this->assertEquals($data['end_date__c'], '2019-01-29T18:00:00.000+0000');
            $this->assertEquals($data['status__c'], '1');
        }
    }

    /**
     * Deserialize json to Program_session__c object and normalize it
     */
    public function testProgramNormalizerDenormalizer()
    {
        $finder = new Finder();
        $finder->files()->in(__DIR__ . '/../fixtures/Program_session__c')->name('GetObjectProgram.json');

        foreach ($finder as $file) {
            /**
             * @var Program_session__c $object
             */
            $object = $this->serializer->deserialize($file->getContents(), Program_session__c::class, 'json');

            $this->assertInstanceOf('WakeOnWeb\SalesforceClient\Model\Program_session__c', $object, 'Program_session__c should be of type WakeOnWeb\SalesforceClient\Model\Program_session__c');
            $this->assertEquals($object->getId(), 'a0r1q000000Tbe3AAC');
            $this->assertEquals($object->getRecordTypeId(), Program_session__c::RECORD_TYPE_ID_PROGRAM);
            $this->assertEquals($object->getName(), 'Conférences');
            $this->assertEquals($object->getDescription__c(), 'Program description');
            $this->assertEquals($object->getSession_id__c(), null);
            $this->assertEquals($object->getProgram_id__c(), 'digitickTicketingIds - 5887111');
            $this->assertEquals($object->getStart_date__c(), new \DateTime('2019-01-29T16:00:00.000+0000'));
            $this->assertEquals($object->getEnd_date__c(), new \DateTime('2019-01-29T18:00:00.000+0000'));
            $this->assertEquals($object->getStatus__c(), '1');

            $data = $this->serializer->normalize($object);

            $this->assertEquals($data['id'], 'a0r1q000000Tbe3AAC');
            $this->assertEquals($data['recordtypeid'], Program_session__c::RECORD_TYPE_ID_PROGRAM);
            $this->assertEquals($data['name'], 'Conférences');
            $this->assertEquals($data['description__c'], 'Program description');
            $this->assertTrue(!isset($data['session_id__c']));
            $this->assertEquals($data['program_id__c'], 'digitickTicketingIds - 5887111');
            $this->assertEquals($data['start_date__c'], '2019-01-29T16:00:00.000+0000');
            $this->assertEquals($data['end_date__c'], '2019-01-29T18:00:00.000+0000');
            $this->assertEquals($data['status__c'], '1');
        }
    }
}
