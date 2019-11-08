<?php

namespace Azonmedia\Patterns\Interfaces;

interface WrapperInterface
{

    public function __get(string $property) /* mixed */ ;

    public function __set(string $property, /* mixed */ $value) : void ;

    public function __isset(string $property) : bool ;

    public function __unset(string $property) : void ;

    public function __call(string $method, array $args) /* mixed */ ;

}