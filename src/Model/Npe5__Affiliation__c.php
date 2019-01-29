<?php

namespace WakeOnWeb\SalesforceClient\Model;

/**
 * Class Npe5__Affiliation__c
 *
 * Affiliation between a Contact and an Account
 */
class Npe5__Affiliation__c implements Npe5__Affiliation__cMappingConstantsInterface
{
    use Traits\ConstantMethods;
    use Traits\IsDeleted;
    // use Traits\RecordTypeId;

    CONST TABLE_NAME     = 'npe5__Affiliation__c';
    // CONST RECORD_TYPE_ID = '0120Y000000E9C7QAK';


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
    protected $npe5__Organization__c;

    /**
     * @var string
     */
    protected $npe5__Contact__c;

    /**
     * @var string
     */
    protected $npe5__Status__c;

    /**
     * @var string
     */
    protected $npe5__Role__c;

    /**
     * @var bool
     */
    protected $npe5__Primary__c;

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
    public function getNpe5__Organization__c(): string
    {
        return $this->npe5__Organization__c;
    }

    /**
     * @param string $npe5__Organization__c
     *
     * @return self
     */
    public function setNpe5__Organization__c(string $npe5__Organization__c): self
    {
        $this->npe5__Organization__c = $npe5__Organization__c;

        return $this;
    }

    /**
     * @return string
     */
    public function getNpe5__Contact__c(): string
    {
        return $this->npe5__Contact__c;
    }

    /**
     * @param string $npe5__Contact__c
     *
     * @return self
     */
    public function setNpe5__Contact__c(string $npe5__Contact__c): self
    {
        $this->npe5__Contact__c = $npe5__Contact__c;

        return $this;
    }

    /**
     * @return string
     */
    public function getNpe5__Status__c(): string
    {
        return $this->npe5__Status__c;
    }

    /**
     * @param string $npe5__Status__c
     *
     * @return self
     *
     * @throws InvalidArgumentException
     */
    public function setNpe5__Status__c(string $npe5__Status__c): self
    {
        if (false === in_array($npe5__Status__c, self::getNpe5__Status__cList())) {
            throw new \InvalidArgumentException(
                sprintf('Unknown Npe5__Status__c "%s"', $npe5__Status__c)
            );
        }

        $this->npe5__Status__c = $npe5__Status__c;

        return $this;
    }

    /**
     * Get list of npe5__Status__c
     *
     * @return array
     */
    public static function getNpe5__Status__cList(): array
    {
        return static::getClassConstantsFromPrefix('STATUS');
    }

    /**
     * @return string
     */
    public function getNpe5__Role__c(): ?string
    {
        return $this->npe5__Role__c;
    }

    /**
     * @param string $npe5__Role__c
     *
     * @return self
     */
    public function setNpe5__Role__c(string $npe5__Role__c): self
    {
        $this->npe5__Role__c = $npe5__Role__c;

        return $this;
    }

    /**
     * @return bool
     */
    public function getNpe5__Primary__c(): bool
    {
        return $this->npe5__Primary__c;
    }

    /**
     * @param bool $npe5__Primary__c
     *
     * @return self
     */
    public function setNpe5__Primary__c(bool $npe5__Primary__c): self
    {
        $this->npe5__Primary__c = $npe5__Primary__c;

        return $this;
    }
}
