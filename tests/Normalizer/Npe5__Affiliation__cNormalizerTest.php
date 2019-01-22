<?php

namespace Tests\WakeOnWeb\SalesforceClient\Normalizer;

/* Imports */
use WakeOnWeb\SalesforceClient\Model\Npe5__Affiliation__c;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;
use WakeOnWeb\SalesforceClient\Normalizer\Npe5__Affiliation__cNormalizer;
use Symfony\Component\Finder\Finder;
use PHPUnit\Framework\TestCase;

/**
 * Class Npe5__Affiliation__cNormalizerTest.
 */
class Npe5__Affiliation__cNormalizerTest extends TestCase
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
            new Npe5__Affiliation__cNormalizer()
        ], [
            new JsonEncoder()
        ]);
    }

    /**
     * Deserialize json to Npe5__Affiliation__c object and normalize it
     */
    public function testNormalizerDenormalizer()
    {
        $finder = new Finder();
        $finder->files()->in(__DIR__ . '/../fixtures/Npe5__Affiliation__c')->name('GetObject.json');

        foreach ($finder as $file) {
            /**
             * @var Npe5__Affiliation__c $object
             */
            $object = $this->serializer->deserialize($file->getContents(), Npe5__Affiliation__c::class, 'json');

            $this->assertInstanceOf('WakeOnWeb\SalesforceClient\Model\Npe5__Affiliation__c', $object, 'Npe5__Affiliation__c should be of type WakeOnWeb\SalesforceClient\Model\Npe5__Affiliation__c');
            $this->assertEquals($object->getId(), 'a0H1q000001sx0IEAQ');
            $this->assertEquals($object->getNpe5__Organization__c(), '0011q00000ANsR4AAL');
            $this->assertEquals($object->getNpe5__Contact__c(), '0031q000008SViQAAW');
            $this->assertEquals($object->getNpe5__Status__c(), 'Current');
            $this->assertEquals($object->getNpe5__Role__c(), 'CEO');
            $this->assertEquals($object->getNpe5__Primary__c(), true);

            $data = $this->serializer->normalize($object);

            $this->assertEquals($data['id'], 'a0H1q000001sx0IEAQ');
            $this->assertEquals($data['npe5__organization__c'], '0011q00000ANsR4AAL');
            $this->assertEquals($data['npe5__contact__c'], '0031q000008SViQAAW');
            $this->assertEquals($data['npe5__status__c'], 'Current');
            $this->assertEquals($data['npe5__role__c'], 'CEO');
            $this->assertEquals($data['npe5__primary__c'], true);
        }
    }
}
