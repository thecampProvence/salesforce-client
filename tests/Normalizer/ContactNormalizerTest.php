<?php

namespace Tests\WakeOnWeb\SalesforceClient\Normalizer;

/* Imports */
use WakeOnWeb\SalesforceClient\Model\Contact;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;
use WakeOnWeb\SalesforceClient\Normalizer\ContactNormalizer;
use Symfony\Component\Finder\Finder;
use PHPUnit\Framework\TestCase;

/**
 * Class ContactNormalizerTest.
 */
class ContactNormalizerTest extends TestCase
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
            new ContactNormalizer()
        ], [
            new JsonEncoder()
        ]);
    }

    /**
     * Deserialize json to Contact object and normalize it
     */
    public function testNormalizerDenormalizer()
    {
        $finder = new Finder();
        $finder->files()->in(__DIR__ . '/../fixtures/Contact')->name('GetObject.json');

        foreach ($finder as $file) {
            /**
             * @var Contact $object
             */
            $object = $this->serializer->deserialize($file->getContents(), Contact::class, 'json');

            $this->assertInstanceOf('WakeOnWeb\SalesforceClient\Model\Contact', $object, 'Contact should be of type WakeOnWeb\SalesforceClient\Model\Contact');
            $this->assertEquals($object->getId(), '0031q000007cOUXAA2');
            $this->assertEquals($object->getRecordTypeId(), Contact::RECORD_TYPE_ID);
            $this->assertEquals($object->getSalutation(), 'Mr.');
            $this->assertEquals($object->getFirstName(), 'FulFilled');
            $this->assertEquals($object->getLastName(), 'Super');
            $this->assertEquals($object->getNickname__c(), 'la kékette qui colle');
            $this->assertEquals($object->getOrigin_of_member__c(), Contact::ORIGIN_OF_MEMBER_INPUT_BACK_OFFICE);
            $this->assertEquals($object->getCamper__c(), true);

            $this->assertEquals($object->getCountry__c(), '1');
            $this->assertEquals($object->getPhone(), '644885533');
            $this->assertEquals($object->getCountryWork__c(), '1');
            $this->assertEquals($object->getNpe01__WorkPhone__c(), '442244224');

            $this->assertEquals($object->getNpe01__Preferred_Email__c(), Contact::PREFERRED_EMAIL_WORK);
            $this->assertEquals($object->getNpe01__WorkEmail__c(), 'super.work@yopmail.com');
            $this->assertEquals($object->getNpe01__HomeEmail__c(), 'super.personam@yopmail.com');
            $this->assertEquals($object->getNpe01__AlternateEmail__c(), 'super.alternate@yopmail.com');

            $this->assertEquals($object->getPersonal_Website__c(), 'urldemonsiteperso');
            $this->assertEquals($object->getTwitter_profile__c(), 'monurltwitter');
            $this->assertEquals($object->getLinkedin_profile__c(), 'monurllinkedin');
            $this->assertEquals($object->getSkype_profile__c(), 'moncompteskype');

            $this->assertEquals($object->getLanguage_new__c(), ['8', '13', '19']);
            $this->assertEquals($object->getPreferred_Language_new__c(), '1');
            $this->assertEquals($object->getNationality_new__c(), ['19', '34']);
            $this->assertEquals($object->getInterests_new__c(), ['8', '1', '28', '20', '27', '11', '31']);

            $this->assertEquals($object->getMailingStreet(), '550 Rue Denis Papin');
            $this->assertEquals($object->getMailingCity(), 'Aix-en-Provence');
            $this->assertEquals($object->getMailingPostalCode(), '13290');
            $this->assertEquals($object->getMailingCountryCode(), 'FR');

            $this->assertEquals($object->getAccountId(), '0011q000008K1PfAAK');
            $this->assertEquals($object->getRelations_with_thecamp__c(), ['4', '13', '14']);

            $data = $this->serializer->normalize($object);

            $this->assertEquals($data['id'], '0031q000007cOUXAA2');
            $this->assertEquals($data['recordtypeid'], Contact::RECORD_TYPE_ID);
            $this->assertEquals($data['salutation'], 'Mr.');
            $this->assertEquals($data['firstname'], 'FulFilled');
            $this->assertEquals($data['lastname'], 'Super');
            $this->assertEquals($data['nickname__c'], 'la kékette qui colle');
            $this->assertEquals($data['origin_of_member__c'], Contact::ORIGIN_OF_MEMBER_INPUT_BACK_OFFICE);
            $this->assertEquals($data['camper__c'], true);

            $this->assertEquals($data['country__c'], '1');
            $this->assertEquals($data['phone'], '644885533');
            $this->assertEquals($data['countrywork__c'], '1');
            $this->assertEquals($data['npe01__workphone__c'], '442244224');

            $this->assertEquals($data['npe01__preferred_email__c'], Contact::PREFERRED_EMAIL_WORK);
            $this->assertEquals($data['npe01__workemail__c'], 'super.work@yopmail.com');
            $this->assertEquals($data['npe01__homeemail__c'], 'super.personam@yopmail.com');
            $this->assertEquals($data['npe01__alternateemail__c'], 'super.alternate@yopmail.com');

            $this->assertEquals($data['personal_website__c'], 'urldemonsiteperso');
            $this->assertEquals($data['twitter_profile__c'], 'monurltwitter');
            $this->assertEquals($data['linkedin_profile__c'], 'monurllinkedin');
            $this->assertEquals($data['skype_profile__c'], 'moncompteskype');

            $this->assertEquals($data['language_new__c'], '8;13;19');
            $this->assertEquals($data['preferred_language_new__c'], '1');
            $this->assertEquals($data['nationality_new__c'], '19;34');
            $this->assertEquals($data['interests_new__c'], '8;1;28;20;27;11;31');

            $this->assertEquals($data['mailingstreet'], '550 Rue Denis Papin');
            $this->assertEquals($data['mailingcity'], 'Aix-en-Provence');
            $this->assertEquals($data['mailingpostalcode'], '13290');
            $this->assertEquals($data['mailingcountrycode'], 'FR');

            $this->assertEquals($data['accountid'], '0011q000008K1PfAAK');
            $this->assertEquals($data['relations_with_thecamp__c'], '4;13;14');
        }
    }
}
