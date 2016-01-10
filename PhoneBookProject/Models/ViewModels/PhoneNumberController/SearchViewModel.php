<?php

namespace Models\ViewModels\PhoneNumberController;

class SearchViewModel
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