<?php

namespace WakeOnWeb\SalesforceClient\Model;

/**
 * Class Contact
 *
 * Represent a Salesforce object
 */
class Contact implements SalesforceModelInterface,ContactMappingConstantsInterface
{
    use Traits\ConstantMethods;
    use Traits\IsDeleted;
    use Traits\RecordTypeId;
    use Traits\RelationsWithThecamp;

    CONST TABLE_NAME     = 'Contact';
    CONST RECORD_TYPE_ID = '0120Y000000E9BvQAK';

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $salutation;

    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $lastName;

    /**
     * @var string
     */
    private $nickname__c;

    /**
     * @var int     Workflow that has created this Contact
     */
    private $origin_of_member__c;

    /**
     * @var bool    Is this contact considered as a camper (regarding Stay length)
     */
    private $camper__c;

    /**
     * @var string Mobile phone country code
     */
    private $country__c;

    /**
     * @var string Mobile phone
     */
    private $phone;

    /**
     * @var string Work phone country code
     */
    private $countryWork__c;

    /**
     * @var string Work phone
     */
    private $npe01__WorkPhone__c;

    /**
     * @var string
     */
    private $npe01__Preferred_Email__c;

    /**
     * @var string
     */
    private $npe01__WorkEmail__c;

    /**
     * @var string
     */
    private $npe01__HomeEmail__c;

    /**
     * @var string
     */
    private $npe01__AlternateEmail__c;

    /**
     * @var string
     */
    private $personal_Website__c;

    /**
     * @var string
     */
    private $twitter_profile__c;

    /**
     * @var string
     */
    private $linkedin_profile__c;

    /**
     * @var string
     */
    private $skype_profile__c;

    /**
     * @var array Spoken languages
     */
    private $language_new__c = [];

    /**
     * @var string
     */
    private $preferred_Language_new__c = 1;

    /**
     * @var array Nationalities
     */
    private $nationality_new__c = [];

    /**
     * @var array
     */
    private $interests_new__c = [];

    /**
     * @var string
     */
    private $mailingStreet;

    /**
     * @var string
     */
    private $mailingCity;

    /**
     * @var string
     */
    private $mailingPostalCode;

    /**
     * @var string Mailing country code
     */
    private $mailingCountryCode;

    /**
     * @var string External id to link Contact to an Account
     */
    private $accountId;


    /**
     * __construct
     */
    public function __construct()
    {
        $this->npe01__Preferred_Email__c = self::PREFERRED_EMAIL_WORK;

        /**
         * @internal only on Contact creation
         */
        // $this->origin_of_member__c = self::ORIGIN_OF_MEMBER_SUBSCRIPTION;
    }

    /**
     * @return string
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string $id
     *
     * @return self
     */
    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getSalutation(): ?string
    {
        return $this->salutation;
    }

    /**
     * @param string $salutation
     *
     * @return self
     *
     * @throws InvalidArgumentException
     */
    public function setSalutation(string $salutation = null): self
    {
        if (is_null($salutation)) {
            $this->salutation = null;

            return $this;
        }

        if (false === in_array($salutation, self::getSalutationList())) {
            throw new \InvalidArgumentException(
                sprintf('Unknown Salutation "%s"', $salutation)
            );
        }

        $this->salutation = $salutation;

        return $this;
    }

    /**
     * Get list of salutation
     *
     * @return array
     */
    public static function getSalutationList(): array
    {
        return static::getClassConstantsFromPrefix('SALUTATION');
    }

    /**
     * @return string
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     *
     * @return self
     */
    public function setFirstName($firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @return string
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     *
     * @return self
     */
    public function setLastName($lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return string
     */
    public function getNickname__c(): ?string
    {
        return $this->nickname__c;
    }

    /**
     * @param string $nickname__c
     *
     * @return self
     */
    public function setNickname__c(string $nickname__c = null): self
    {
        $this->nickname__c = $nickname__c;

        return $this;
    }

    /**
     * @return int
     */
    public function getOrigin_of_member__c(): ?int
    {
        return $this->origin_of_member__c;
    }

    /**
     * @param int $origin_of_member__c
     *
     * @return self
     *
     * @throws InvalidArgumentException
     */
    public function setOrigin_of_member__c(int $origin_of_member__c): self
    {
        if (false === in_array($origin_of_member__c, self::getOrigin_of_member__cList())) {
            throw new \InvalidArgumentException(
                sprintf('Unknown Origin_of_member__c "%s"', $origin_of_member__c)
            );
        }

        $this->origin_of_member__c = $origin_of_member__c;

        return $this;
    }

    /**
     * Get list of origin_of_member__c
     *
     * @return array
     */
    public static function getOrigin_of_member__cList(): array
    {
        return static::getClassConstantsFromPrefix('ORIGIN_OF_MEMBER');
    }

    /**
     * @return bool
     */
    public function getCamper__c(): ?bool
    {
        return $this->camper__c;
    }

    /**
     * @param bool $camper__c
     *
     * @return self
     */
    public function setCamper__c(bool $camper__c): self
    {
        $this->camper__c = $camper__c;

        return $this;
    }

    /**
     * @return string
     */
    public function getCountry__c(): ?string
    {
        return $this->country__c;
    }

    /**
     * @param string $country__c
     *
     * @return self
     *
     * @throws InvalidArgumentException
     */
    public function setCountry__c(string $country__c = null): self
    {
        if (is_null($country__c)) {
            $this->country__c = null;

            return $this;
        }

        if (false === in_array($country__c, self::getCountry__cList())) {
            throw new \InvalidArgumentException(
                sprintf('Unknown Country__c "%s"', $country__c)
            );
        }

        $this->country__c = $country__c;

        return $this;
    }

    /**
     * Get list of country__c
     *
     * @return array
     */
    public static function getCountry__cList(): array
    {
        return self::PHONE_COUNTRY_CODES;
    }

    /**
     * @return string
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     *
     * @return self
     */
    public function setPhone(string $phone = null): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return string
     */
    public function getCountryWork__c(): ?string
    {
        return $this->countryWork__c;
    }

    /**
     * @param string $countryWork__c
     *
     * @return self
     *
     * @throws InvalidArgumentException
     */
    public function setCountryWork__c(string $countryWork__c = null): self
    {
        if (is_null($countryWork__c)) {
            $this->countryWork__c = null;

            return $this;
        }

        if (false === in_array($countryWork__c, self::getCountryWork__cList())) {
            throw new \InvalidArgumentException(
                sprintf('Unknown CountryWork__c "%s"', $countryWork__c)
            );
        }

        $this->countryWork__c = $countryWork__c;

        return $this;
    }

    /**
     * Get list of countryWork__c
     *
     * @return array
     */
    public static function getCountryWork__cList(): array
    {
        return self::PHONE_COUNTRY_CODES;
    }

    /**
     * @return string
     */
    public function getNpe01__WorkPhone__c(): ?string
    {
        return $this->npe01__WorkPhone__c;
    }

    /**
     * @param string $npe01__WorkPhone__c
     *
     * @return self
     */
    public function setNpe01__WorkPhone__c(string $npe01__WorkPhone__c = null): self
    {
        $this->npe01__WorkPhone__c = $npe01__WorkPhone__c;

        return $this;
    }

    /**
     * @return string
     */
    public function getNpe01__Preferred_Email__c(): string
    {
        return $this->npe01__Preferred_Email__c;
    }

    /**
     * @param string $npe01__Preferred_Email__c
     *
     * @return self
     *
     * @throws InvalidArgumentException
     */
    public function setNpe01__Preferred_Email__c(string $npe01__Preferred_Email__c): self
    {
        if (false === in_array($npe01__Preferred_Email__c, self::getNpe01__Preferred_Email__cList())) {
            throw new \InvalidArgumentException(
                sprintf('Unknown npe01__Preferred_Email__c "%s"', $npe01__Preferred_Email__c)
            );
        }

        $this->npe01__Preferred_Email__c = $npe01__Preferred_Email__c;

        return $this;
    }

    /**
     * Get list of npe01__Preferred_Email__c
     *
     * @return array
     */
    public static function getNpe01__Preferred_Email__cList(): array
    {
        return static::getClassConstantsFromPrefix('PREFERRED_EMAIL');
    }

    /**
     * @return string
     */
    public function getNpe01__WorkEmail__c(): ?string
    {
        return $this->npe01__WorkEmail__c;
    }

    /**
     * @param string $npe01__WorkEmail__c
     *
     * @return self
     */
    public function setNpe01__WorkEmail__c($npe01__WorkEmail__c): self
    {
        $this->npe01__WorkEmail__c = $npe01__WorkEmail__c;

        return $this;
    }

    /**
     * @return string
     */
    public function getNpe01__HomeEmail__c(): ?string
    {
        return $this->npe01__HomeEmail__c;
    }

    /**
     * @param string $npe01__HomeEmail__c
     *
     * @return self
     */
    public function setNpe01__HomeEmail__c($npe01__HomeEmail__c): self
    {
        $this->npe01__HomeEmail__c = $npe01__HomeEmail__c;

        return $this;
    }

    /**
     * @return string
     */
    public function getNpe01__AlternateEmail__c(): ?string
    {
        return $this->npe01__AlternateEmail__c;
    }

    /**
     * @param string $npe01__AlternateEmail__c
     *
     * @return self
     */
    public function setNpe01__AlternateEmail__c($npe01__AlternateEmail__c): self
    {
        $this->npe01__AlternateEmail__c = $npe01__AlternateEmail__c;

        return $this;
    }

    /**
     * @return string
     */
    public function getPersonal_Website__c(): ?string
    {
        return $this->personal_Website__c;
    }

    /**
     * @param string $personal_Website__c
     *
     * @return self
     */
    public function setPersonal_Website__c(string $personal_Website__c = null): self
    {
        $this->personal_Website__c = $personal_Website__c;

        return $this;
    }

    /**
     * @return string
     */
    public function getTwitter_profile__c(): ?string
    {
        return $this->twitter_profile__c;
    }

    /**
     * @param string $twitter_profile__c
     *
     * @return self
     */
    public function setTwitter_profile__c(string $twitter_profile__c = null): self
    {
        $this->twitter_profile__c = $twitter_profile__c;

        return $this;
    }

    /**
     * @return string
     */
    public function getLinkedin_profile__c(): ?string
    {
        return $this->linkedin_profile__c;
    }

    /**
     * @param string $linkedin_profile__c
     *
     * @return self
     */
    public function setLinkedin_profile__c(string $linkedin_profile__c = null): self
    {
        $this->linkedin_profile__c = $linkedin_profile__c;

        return $this;
    }

    /**
     * @return string
     */
    public function getSkype_profile__c(): ?string
    {
        return $this->skype_profile__c;
    }

    /**
     * @param string $skype_profile__c
     *
     * @return self
     */
    public function setSkype_profile__c(string $skype_profile__c = null): self
    {
        $this->skype_profile__c = $skype_profile__c;

        return $this;
    }

    /**
     * @return array
     */
    public function getLanguage_new__c(): ?array
    {
        return $this->language_new__c;
    }

    /**
     * @param array $language_new__c
     *
     * @return self
     *
     * @throws InvalidArgumentException
     */
    public function setLanguage_new__c(array $language_new__c): self
    {
        foreach ($language_new__c as $value) {
            if (false === in_array($value, self::getLanguage_new__cList())) {
                throw new \InvalidArgumentException(
                    sprintf('Unknown Language_new__c "%s"', $value)
                );
            }
        }

        $this->language_new__c = array_unique($language_new__c);

        return $this;
    }

    /**
     * @param int $language_new__c
     *
     * @return self
     *
     * @throws InvalidArgumentException
     */
    public function addLanguage_new__c($language_new__c): self
    {
        if (false === in_array($language_new__c, self::getLanguage_new__cList())) {
            throw new \InvalidArgumentException(
                sprintf('Unknown Language_new__c "%s"', $language_new__c)
            );
        }

        $this->language_new__c[] = $language_new__c;
        $this->language_new__c   = array_unique($this->language_new__c);

        return $this;
    }

    /**
     * Get Language_new__c list
     *
     * @return array
     */
    public static function getLanguage_new__cList(): array
    {
        return array_keys(self::LANGUAGES_LIST);
    }

    /**
     * @return string
     */
    public function getPreferred_Language_new__c(): ?int
    {
        return $this->preferred_Language_new__c;
    }

    /**
     * @param string $preferred_Language_new__c
     *
     * @return self
     *
     * @throws InvalidArgumentException
     */
    public function setPreferred_Language_new__c(int $preferred_Language_new__c): self
    {
        if (false === in_array($preferred_Language_new__c, self::getPreferred_Language_new__cList())) {
            throw new \InvalidArgumentException(
                sprintf('Unknown Preferred_Language_new__c "%s"', $preferred_Language_new__c)
            );
        }

        $this->preferred_Language_new__c = $preferred_Language_new__c;

        return $this;
    }

    /**
     * Get list of preferred_Language_new__c
     *
     * @return array
     */
    public static function getPreferred_Language_new__cList(): array
    {
        return array_keys(self::PREFERRED_LANGUAGES_LIST);
    }

    /**
     * @return array
     */
    public function getNationality_new__c(): ?array
    {
        return $this->nationality_new__c;
    }

    /**
     * @param array $nationality_new__c
     *
     * @return self
     *
     * @throws InvalidArgumentException
     */
    public function setNationality_new__c(array $nationality_new__c): self
    {
        foreach ($nationality_new__c as $value) {
            if (false === in_array($value, self::getNationality_new__cList())) {
                throw new \InvalidArgumentException(
                    sprintf('Unknown Nationality_new__c "%s"', $value)
                );
            }
        }

        $this->nationality_new__c = array_unique($nationality_new__c);

        return $this;
    }

    /**
     * @param int $nationality_new__c
     *
     * @return self
     *
     * @throws InvalidArgumentException
     */
    public function addNationality_new__c($nationality_new__c): self
    {
        if (false === in_array($nationality_new__c, self::getNationality_new__cList())) {
            throw new \InvalidArgumentException(
                sprintf('Unknown Nationality_new__c "%s"', $nationality_new__c)
            );
        }

        $this->nationality_new__c[] = $nationality_new__c;
        $this->nationality_new__c   = array_unique($this->nationality_new__c);

        return $this;
    }

    /**
     * Get Nationality_new__c list
     *
     * @return array
     */
    public static function getNationality_new__cList(): array
    {
        return array_keys(self::NATIONALITIES_LIST);
    }

    /**
     * @return array
     */
    public function getInterests_new__c(): ?array
    {
        return $this->interests_new__c;
    }

    /**
     * @param array $interests_new__c
     *
     * @return self
     *
     * @throws InvalidArgumentException
     */
    public function setInterests_new__c(array $interests_new__c): self
    {
        foreach ($interests_new__c as $value) {
            if (false === in_array($value, self::getInterests_new__cList())) {
                throw new \InvalidArgumentException(
                    sprintf('Unknown Interests_new__c "%s"', $value)
                );
            }
        }

        $this->interests_new__c = array_unique($interests_new__c);

        return $this;
    }

    /**
     * @param int $interests_new__c
     *
     * @return self
     *
     * @throws InvalidArgumentException
     */
    public function addInterests_new__c($interests_new__c): self
    {
        if (false === in_array($interests_new__c, self::getInterests_new__cList())) {
            throw new \InvalidArgumentException(
                sprintf('Unknown Interests_new__c "%s"', $interests_new__c)
            );
        }

        $this->interests_new__c[] = $interests_new__c;
        $this->interests_new__c   = array_unique($this->interests_new__c);

        return $this;
    }

    /**
     * Get Interests_new__c list
     *
     * @return array
     */
    public static function getInterests_new__cList(): array
    {
        return array_keys(self::INTERESTS_LIST);
    }

    /**
     * @return string
     */
    public function getMailingStreet(): ?string
    {
        return $this->mailingStreet;
    }

    /**
     * @param string $mailingStreet
     *
     * @return self
     */
    public function setMailingStreet(string $mailingStreet = null): self
    {
        $this->mailingStreet = $mailingStreet;

        return $this;
    }

    /**
     * @return string
     */
    public function getMailingCity(): ?string
    {
        return $this->mailingCity;
    }

    /**
     * @param string $mailingCity
     *
     * @return self
     */
    public function setMailingCity(string $mailingCity = null): self
    {
        $this->mailingCity = $mailingCity;

        return $this;
    }

    /**
     * @return string
     */
    public function getMailingPostalCode(): ?string
    {
        return $this->mailingPostalCode;
    }

    /**
     * @param string $mailingPostalCode
     *
     * @return self
     */
    public function setMailingPostalCode(string $mailingPostalCode = null): self
    {
        $this->mailingPostalCode = $mailingPostalCode;

        return $this;
    }

    /**
     * @return string
     */
    public function getMailingCountryCode(): ?string
    {
        return $this->mailingCountryCode;
    }

    /**
     * @param string $mailingCountryCode
     *
     * @return self
     *
     * @throws InvalidArgumentException
     */
    public function setMailingCountryCode(string $mailingCountryCode = null): self
    {
        if (is_null($mailingCountryCode)) {
            $this->mailingCountryCode = null;

            return $this;
        }

        $mailingCountryCode = strtoupper($mailingCountryCode);

        if (false === in_array($mailingCountryCode, self::getMailingCountryCodeList())) {
            throw new \InvalidArgumentException(
                sprintf('Unknown MailingCountryCode "%s"', $mailingCountryCode)
            );
        }

        $this->mailingCountryCode = $mailingCountryCode;

        return $this;
    }

    /**
     * Get mailingCountryCode list
     *
     * @return array
     */
    public static function getMailingCountryCodeList(): array
    {
        return array_keys(self::MAILING_COUNTRY_CODES_LIST);
    }

    /**
     * @return string
     */
    public function getAccountId(): ?string
    {
        return $this->accountId;
    }

    /**
     * @param string $accountId
     *
     * @return self
     */
    public function setAccountId(string $accountId): self
    {
        $this->accountId = $accountId;

        return $this;
    }
}
