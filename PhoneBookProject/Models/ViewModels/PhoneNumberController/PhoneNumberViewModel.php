<?php

namespace Models\ViewModels\PhoneNumberController;

class PhoneNumberViewModel
{
    private $id;
    private $name;
    private $phoneNumber;

    public function __construct($id, $name, $phoneNumber)
    {
        $this->id = $id;
        $this->name = $name;
        $this->phoneNumber = $phoneNumber;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getPhoneNumber() {
        return $this->phoneNumber;
    }
}