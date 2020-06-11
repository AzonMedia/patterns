<?php
declare(strict_types=1);

namespace Azonmedia\Patterns\Traits;

use Guzaba2\Base\Exceptions\RunTimeException;
use Guzaba2\Translator\Translator as t;

trait ReadonlyOverloadingTrait
{
    public function __get(string $property) /* mixed */
    {
        if (!array_key_exists($property, $this->data)) {
            throw new RunTimeException(sprintf(t::_('The objects of class %s do not have a property %s.'), get_class($this), $property));
        }
        return $this->data[$property];
    }

    /**
     * Changes are not allowed. The properties can be set only in the constructor.
     * @param string $property
     * @param $value
     * @throws RunTimeException
     * @throws \Azonmedia\Exceptions\InvalidArgumentException
     * @throws \Guzaba2\Coroutine\Exceptions\ContextDestroyedException
     * @throws \ReflectionException
     */
    public function __set(string $property, /* mixed */ $value) : void
    {
        throw new RunTimeException(sprintf(t::_('It is not allowed to change the properties on objects of class %s.'), get_class($this) ));
    }

    public function __isset(string $property): bool
    {
        return array_key_exists($property, $this->data);
    }

    public function __unset(string $property): void
    {
        throw new RunTimeException(sprintf(t::_('It is not allowed to unset properties on objects of class %s.'), get_class($this) ));
    }

    public function get_data(): array
    {
        return $this->data;
    }
}