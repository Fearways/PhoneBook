<?php

namespace Models\BindingModels;

class EditPhoneNumberBindingModel
{
    private $name;
    private $number;

    function __construct(array $params)
    {
        $this->setName($params['name']);
        $this->setPhoneNumber($params['number']);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * @param string
     */
    public function getPhoneNumber() {
        return $this->number;
    }

    /**
     * @param string $phoneNumber
     */
    private function setPhoneNumber($phoneNumber)
    {
        $this->number = $phoneNumber;
    }


}