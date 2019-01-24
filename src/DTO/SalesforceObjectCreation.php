<?php

namespace WakeOnWeb\SalesforceClient\DTO;

/**
 * SalesforceObject.
 *
 * @author Stephane PY <s.py@wakeonweb.com>
 */
class SalesforceObjectCreation
{
    private $id;
    private $success;
    private $errors   = [];
    private $warnings = [];
    // private $object;

    private function __construct(string $id, bool $success, array $errors = [], array $warnings = []) //, object $object = null
    {
        $this->id       = $id;
        $this->success  = $success;
        $this->errors   = $errors;
        $this->warnings = $warnings;
        // $this->object   = $object;
    }

    public static function createFromArray(array $data) //, object $object = null
    {
        return new self(
            (string) $data['id'],
            (bool) $data['success'],
            array_key_exists('errors', $data) ? (array) $data['errors'] : [],
            array_key_exists('warnings', $data) ? (array) $data['warnings'] : []
            // $object
        );
    }

    public function getId()
    {
        return $this->id;
    }

    public function isSuccess()
    {
        return $this->success;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function getWarnings()
    {
        return $this->warnings;
    }

    // public function getObject()
    // {
    //     return $this->object;
    // }
}
