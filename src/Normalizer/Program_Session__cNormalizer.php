<?php

namespace WakeOnWeb\SalesforceClient\Normalizer;

use WakeOnWeb\SalesforceClient\Model\Program_Session__c;

/**
 * Class Program_Session__cNormalizer.
 */
class Program_Session__cNormalizer extends AbstractNormalizer
{
    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof Program_Session__c;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return Program_Session__c::class === $type;
    }
}
