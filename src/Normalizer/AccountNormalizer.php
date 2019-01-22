<?php

namespace WakeOnWeb\SalesforceClient\Normalizer;

use WakeOnWeb\SalesforceClient\Model\Account;

/**
 * Class AccountNormalizer.
 */
class AccountNormalizer extends AbstractNormalizer
{
    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof Account;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return Account::class === $type;
    }
}
