<?php

namespace WakeOnWeb\SalesforceClient\Model;

/**
 * Class Program_session__c
 *
 * Represent a Salesforce object
 */
class Program_session__c
{
    use \WakeOnWeb\SalesforceClient\Model\Traits\ConstantMethods;
    use \WakeOnWeb\SalesforceClient\Model\Traits\RecordTypeId;

    CONST TABLE_NAME              = 'Program_Session__c';
    CONST RECORD_TYPE_ID_ACTIVITY = '0120Y000000E9C5QAK';
    CONST RECORD_TYPE_ID_PROGRAM  = '0120Y000000E9C4QAK';

    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $description__c;

    /**
     * @var string
     */
    protected $session_id__c;

    /**
     * @var string
     */
    protected $program_id__c;

    /**
     * @var \DateTime
     */
    protected $start_date__c;

    /**
     * @var \DateTime
     */
    protected $end_date__c;

    /**
     * @var bool
     */
    protected $status__c;

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
     * @return string
     */
    public function getDescription__c(): ?string
    {
        return $this->description__c;
    }

    /**
     * @param string $description__c
     *
     * @return self
     */
    public function setDescription__c(string $description__c): self
    {
        $this->description__c = $description__c;

        return $this;
    }

    /**
     * @return string
     */
    public function getSession_id__c(): ?string
    {
        return $this->session_id__c;
    }

    /**
     * @param string $session_id__c
     *
     * @return self
     */
    public function setSession_id__c(string $session_id__c): self
    {
        $this->session_id__c = $session_id__c;

        return $this;
    }

    /**
     * @return string
     */
    public function getProgram_id__c(): ?string
    {
        return $this->program_id__c;
    }

    /**
     * @param string $program_id__c
     *
     * @return self
     */
    public function setProgram_id__c(string $program_id__c): self
    {
        $this->program_id__c = $program_id__c;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getStart_date__c(): \DateTime
    {
        return $this->start_date__c;
    }

    /**
     * @param \DateTime $start_date__c
     *
     * @return self
     */
    public function setStart_date__c(\DateTime $start_date__c): self
    {
        $this->start_date__c = $start_date__c;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getEnd_date__c(): \DateTime
    {
        return $this->end_date__c;
    }

    /**
     * @param \DateTime $end_date__c
     *
     * @return self
     */
    public function setEnd_date__c(\DateTime $end_date__c): self
    {
        $this->end_date__c = $end_date__c;

        return $this;
    }

    /**
     * @return bool
     */
    public function getStatus__c(): ?bool
    {
        return $this->status__c;
    }

    /**
     * @param bool $status__c
     *
     * @return self
     */
    public function setStatus__c(bool $status__c): self
    {
        $this->status__c = $status__c;

        return $this;
    }
}
