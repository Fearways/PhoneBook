<?php
declare(strict_types=1);

namespace Framework\Annotations;

interface IAnnotation
{
    function dispatch();
}