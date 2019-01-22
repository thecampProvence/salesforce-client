<?php

namespace WakeOnWeb\SalesforceClient\Normalizer;

use WakeOnWeb\SalesforceClient\Model\On_site_presence__c;

/**
 * Class On_site_presence__cNormalizer.
 */
class On_site_presence__cNormalizer extends AbstractNormalizer
{
    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof On_site_presence__c;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return On_site_presence__c::class === $type;
    }
}
