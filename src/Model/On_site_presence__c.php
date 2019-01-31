<?php

namespace WakeOnWeb\SalesforceClient\Model;

/**
 * Class On_site_presence__c
 *
 * Represent a Salesforce object
 */
class On_site_presence__c
{
    // use Traits\ConstantMethods;
    use Traits\IsDeleted;
    // use Traits\RecordTypeId;

    CONST TABLE_NAME = 'On_site_presence__c';

    /**
     * @var string
     */
    protected $id;

    /**
     * @var string  Contact id
     */
    protected $member__c;

    /**
     * @var string  External key
     */
    protected $on_site_presence_key__c;

    /**
     * @var \DateTime
     */
    protected $on_site_start_date__c;

    /**
     * @var \DateTime
     */
    protected $on_site_end_date__c;

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
    public function getMember__c(): string
    {
        return $this->member__c;
    }

    /**
     * @param string $member__c
     *
     * @return self
     */
    public function setMember__c(string $member__c): self
    {
        $this->member__c = $member__c;

        return $this;
    }

    /**
     * @return string
     */
    public function getOn_site_presence_key__c(): ?string
    {
        return $this->on_site_presence_key__c;
    }

    /**
     * @param string $on_site_presence_key__c
     *
     * @return self
     */
    public function setOn_site_presence_key__c(string $on_site_presence_key__c): self
    {
        $this->on_site_presence_key__c = $on_site_presence_key__c;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getOn_site_start_date__c(): \DateTime
    {
        return $this->on_site_start_date__c;
    }

    /**
     * @param \DateTime $on_site_start_date__c
     *
     * @return self
     */
    public function setOn_site_start_date__c(\DateTime $on_site_start_date__c): self
    {
        $this->on_site_start_date__c = $on_site_start_date__c;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getOn_site_end_date__c(): \DateTime
    {
        return $this->on_site_end_date__c;
    }

    /**
     * @param \DateTime $on_site_end_date__c
     *
     * @return self
     */
    public function setOn_site_end_date__c(\DateTime $on_site_end_date__c): self
    {
        $this->on_site_end_date__c = $on_site_end_date__c;

        return $this;
    }
}
