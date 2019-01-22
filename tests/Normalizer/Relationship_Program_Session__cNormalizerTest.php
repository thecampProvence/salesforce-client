<?php

namespace Tests\WakeOnWeb\SalesforceClient\Normalizer;

/* Imports */
use WakeOnWeb\SalesforceClient\Model\Relationship_Program_Session__c;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;
use WakeOnWeb\SalesforceClient\Normalizer\Relationship_Program_Session__cNormalizer;
use Symfony\Component\Finder\Finder;
use PHPUnit\Framework\TestCase;

/**
 * Class Relationship_Program_Session__cNormalizerTest.
 */
class Relationship_Program_Session__cNormalizerTest extends TestCase
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
            new Relationship_Program_Session__cNormalizer()
        ], [
            new JsonEncoder()
        ]);
    }

    /**
     * Deserialize json to Relationship_Program_Session__c object and normalize it
     */
    public function testNormalizerDenormalizer()
    {
        $finder = new Finder();
        $finder->files()->in(__DIR__ . '/../fixtures/Relationship_Program_Session__c')->name('GetObject.json');

        foreach ($finder as $file) {
            /**
             * @var Relationship_Program_Session__c $object
             */
            $object = $this->serializer->deserialize($file->getContents(), Relationship_Program_Session__c::class, 'json');

            $this->assertInstanceOf('WakeOnWeb\SalesforceClient\Model\Relationship_Program_Session__c', $object, 'Relationship_Program_Session__c should be of type WakeOnWeb\SalesforceClient\Model\Relationship_Program_Session__c');
            $this->assertEquals($object->getId(), 'a0p1n000007AZD8AAO');
            $this->assertEquals($object->getSession__c(), 'a0r1n00000gTKOPAA4');
            $this->assertEquals($object->getProgram__c(), '0031n00001pPQ79AAG');

            $data = $this->serializer->normalize($object);

            $this->assertEquals($data['id'], 'a0p1n000007AZD8AAO');
            $this->assertEquals($data['session__c'], 'a0r1n00000gTKOPAA4');
            $this->assertEquals($data['program__c'], '0031n00001pPQ79AAG');
        }
    }
}
