<?php

namespace Models\BindingModels;


class PhoneNumberBindingModel
{
    private $name;
    private $number;

    public function __construct(array $params)
    {
        $this->setName($params['name']);
        $this->setNumber($params['number']);
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
    public function getNumber() {
        return $this->number;
    }

    /**
     * @param string $number
     */
    private function setNumber($number)
    {
        $this->number = $number;
    }
}