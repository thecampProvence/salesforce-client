<?php

namespace WakeOnWeb\SalesforceClient\Normalizer;

use WakeOnWeb\SalesforceClient\Model\Program_session__c;

/**
 * Class Program_session__cNormalizer.
 */
class Program_session__cNormalizer extends AbstractNormalizer
{
    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof Program_session__c;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return Program_session__c::class === $type;
    }
}
