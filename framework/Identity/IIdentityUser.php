<?php
declare(strict_types=1);

namespace Framework\Identity;

interface IIdentityUser
{
    function isLogged();
    function getId();
    function getUsername();
    function getPass();
    function getFullName();
}