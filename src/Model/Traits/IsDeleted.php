<?php

namespace WakeOnWeb\SalesforceClient\Model\Traits;

/**
 * Trait IsDeleted
 */
trait IsDeleted
{
    /**
     * @var bool
     */
    protected $isDeleted;

    /**
     * @return bool | null
     */
    public function getIsDeleted(): ?bool
    {
        return $this->isDeleted;
    }

    /**
     * @param bool $isDeleted
     *
     * @return self
     */
    public function setIsDeleted(bool $isDeleted): self
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }
}
