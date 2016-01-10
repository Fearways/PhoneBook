<?php

namespace Models\ViewModels\PhoneNumberController;

class IndexViewModel
{
    private $phoneNumber;

    public function __construct($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

    public function getPhoneNumber() {
        return $this->phoneNumber;
    }
}