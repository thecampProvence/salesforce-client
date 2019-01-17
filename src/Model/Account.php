<?php

namespace WakeOnWeb\SalesforceClient\Model;

/**
 * Class Account
 *
 * Represent a Salesforce object
 */
class Account
{
    use \WakeOnWeb\SalesforceClient\Model\Traits\ConstantMethods;
    use \WakeOnWeb\SalesforceClient\Model\Traits\RecordTypeId;
    use \WakeOnWeb\SalesforceClient\Model\Traits\RelationsWithThecamp;

    CONST TABLE_NAME                  = 'Account';
    CONST RECORD_TYPE_ID_HOUSEHOLD    = '0120Y000000E9BtQAK';
    CONST RECORD_TYPE_ID_ORGANIZATION = '0120Y000000E9BuQAK';

    /**
     * @var int Salesforce relations with thecamp list mapping
     */
    CONST RELATION_WITH_THECAMP_BUSINESS = 2;
    CONST RELATION_WITH_THECAMP_BUYER    = 1;
    // const TYPE_OF_RELATIONSHIP_BUSINESS = 2;
    // const TYPE_OF_RELATIONSHIP_BUYER    = 1;

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
