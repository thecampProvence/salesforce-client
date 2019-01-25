<?php

namespace WakeOnWeb\SalesforceClient\Model;

/**
 * Class Account
 *
 * Represent a Salesforce object
 */
class Account
{
    use Traits\ConstantMethods;
    use Traits\IsDeleted;
    use Traits\RecordTypeId;
    use Traits\RelationsWithThecamp;

    CONST TABLE_NAME                  = 'Account';
    CONST RECORD_TYPE_ID_HOUSEHOLD    = '0120Y000000E9BtQAK';
    CONST RECORD_TYPE_ID_ORGANIZATION = '0120Y000000E9BuQAK';

    /**
     * @var int Salesforce relations with thecamp list mapping
     */
    // const TYPE_OF_RELATIONSHIP_BUSINESS = 2;
    // const TYPE_OF_RELATIONSHIP_BUYER    = 1;
    CONST RELATION_WITH_THECAMP_FOUNDING_PARTNER          = 1;
    CONST RELATION_WITH_THECAMP_BUSINESS                  = 2;
    CONST RELATION_WITH_THECAMP_PUBLIC_RELATIONSHIP_MEDIA = 3;
    CONST RELATION_WITH_THECAMP_CO_DESIGNER               = 4;
    CONST RELATION_WITH_THECAMP_LOCAL_ECOSYSTEM           = 5;
    CONST RELATION_WITH_THECAMP_DIGITIAL_ECOSYSTEM        = 6;
    CONST RELATION_WITH_THECAMP_BUILDING_SITE             = 7;
    CONST RELATION_WITH_THECAMP_PROVIDER                  = 8;
    CONST RELATION_WITH_THECAMP_ACCELERATED               = 9;
    CONST RELATION_WITH_THECAMP_PROSPECT_PARTNER          = 10;
    CONST RELATION_WITH_THECAMP_PROSPECT_PROVIDER         = 11;
    CONST RELATION_WITH_THECAMP_GOVERNING                 = 12;
    CONST RELATION_WITH_THECAMP_PROSPECT_EXPERIMENTATION  = 13;
    CONST RELATION_WITH_THECAMP_OTHERS                    = 14;
    CONST RELATION_WITH_THECAMP_NEW_PARTNER               = 15;
    CONST RELATION_WITH_THECAMP_KNOWLEDGE_PARTNER         = 16;
    CONST RELATION_WITH_THECAMP_FOUNDATION_RELATIONSHIP   = 17;

    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var bool
     */
    protected $inactive__c = false;

    /**
     * @return string
     */
    public function getId(): string
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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return bool
     */
    public function getInactive__c(): bool
    {
        return $this->inactive__c;
    }

    /**
     * @param bool $inactive__c
     *
     * @return self
     */
    public function setInactive__c(bool $inactive__c): self
    {
        $this->inactive__c = $inactive__c;

        return $this;
    }

    /**
     * @return bool
     */
    public function isHouseHold()
    {
        return self::RECORD_TYPE_ID_HOUSEHOLD === $this->getRecordTypeId();
    }

    /**
     * @return bool
     */
    public function isOrganization()
    {
        return self::RECORD_TYPE_ID_ORGANIZATION === $this->getRecordTypeId();
    }
}
