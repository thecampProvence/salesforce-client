<?php

namespace WakeOnWeb\SalesforceClient\Model\Traits;

/**
 * Trait ConstantMethods
 */
trait ConstantMethods
{
    /**
     * Get all constants values from current class that matches prefix
     *
     * @param string $prefix
     *
     * @return array
     *
     * @throws \ReflectionException
     */
    protected static function getClassConstantsFromPrefix($prefix): array
    {
        $oClass    = new \ReflectionClass(__CLASS__);
        $aConstant = $oClass->getConstants();
        $result    = [];

        foreach ($aConstant as $key =>  $value) {
            if (0 === strpos($key, $prefix)) {
                $result[] = $value;
            }
        }

        return $result;
    }
}
