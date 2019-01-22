<?php

namespace Tests\WakeOnWeb\SalesforceClient\Normalizer;

/* Imports */
use WakeOnWeb\SalesforceClient\Model\On_site_presence__c;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;
use WakeOnWeb\SalesforceClient\Normalizer\On_site_presence__cNormalizer;
use Symfony\Component\Finder\Finder;
use PHPUnit\Framework\TestCase;

/**
 * Class On_site_presence__cNormalizerTest.
 */
class On_site_presence__cNormalizerTest extends TestCase
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
            new On_site_presence__cNormalizer()
        ], [
            new JsonEncoder()
        ]);
    }

    /**
     * Deserialize json to On_site_presence__c object and normalize it
     */
    public function testNormalizerDenormalizer()
    {
        $finder = new Finder();
        $finder->files()->in(__DIR__ . '/../fixtures/On_site_presence__c')->name('GetObject.json');

        foreach ($finder as $file) {
            /**
             * @var On_site_presence__c $object
             */
            $object = $this->serializer->deserialize($file->getContents(), On_site_presence__c::class, 'json');

            $this->assertInstanceOf('WakeOnWeb\SalesforceClient\Model\On_site_presence__c', $object, 'On_site_presence__c should be of type WakeOnWeb\SalesforceClient\Model\On_site_presence__c');
            $this->assertEquals($object->getId(), 'a0q1q0000007W62AAE');
            $this->assertEquals($object->getMember__c(), '0031q00000A9bcwAAB');
            $this->assertEquals($object->getOn_site_presence_key__c(), 'digitickTicketingIds - 277458336');
            $this->assertEquals($object->getOn_site_start_date__c(), new \DateTime('2019-01-29T16:00:00.000+0000'));
            $this->assertEquals($object->getOn_site_end_date__c(), new \DateTime('2019-01-29T18:00:00.000+0000'));

            $data = $this->serializer->normalize($object);

            $this->assertEquals($data['id'], 'a0q1q0000007W62AAE');
            $this->assertEquals($data['member__c'], '0031q00000A9bcwAAB');
            $this->assertEquals($data['on_site_presence_key__c'], 'digitickTicketingIds - 277458336');
            $this->assertEquals($data['on_site_start_date__c'], '2019-01-29T16:00:00.000+0000');
            $this->assertEquals($data['on_site_end_date__c'], '2019-01-29T18:00:00.000+0000');
        }
    }
}
