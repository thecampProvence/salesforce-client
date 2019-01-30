<?php

namespace WakeOnWeb\SalesforceClient\Model\Traits;

/**
 * Trait RecordTypeId
 *
 * @internal Works with constants prefixed with RECORD_TYPE_ID
 */
trait RecordTypeId
{
    /**
     * @var string
     */
    protected $recordTypeId;

    /**
     * @return string | null
     */
    public function getRecordTypeId(): ?string
    {
        return $this->recordTypeId;
    }

    /**
     * @param string $recordTypeId
     *
     * @return self
     *
     * @throws InvalidArgumentException
     */
    public function setRecordTypeId(string $recordTypeId): self
    {
        if (false === in_array($recordTypeId, static::getRecordTypeIdList())) {
            throw new \InvalidArgumentException(
                sprintf('Unknown RecordTypeId "%s"', $recordTypeId)
            );
        }

        $this->recordTypeId = $recordTypeId;

        return $this;
    }

    /**
     * Get list of available recordTypeId
     *
     * @return array
     */
    public static function getRecordTypeIdList(): array
    {
        return static::getClassConstantsFromPrefix('RECORD_TYPE_ID');
    }
}
