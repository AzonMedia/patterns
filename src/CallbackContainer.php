<?php
declare(strict_types=1);

namespace Azonmedia\Patterns;


use Azonmedia\Exceptions\InvalidArgumentException;
use Azonmedia\Translator\Translator as t;

class CallbackContainer
{

    private array $callables = [];

    public function __construct(array $callables = [])
    {
        foreach ($callables as $key=>$callable) {
            if (!is_callable($callable)) {
                throw new InvalidArgumentException(sprintf(t::_('The %1$s element in the provided $callables is not a valid callable.'), $key));
            }
        }
        $this->callables = $callables;
    }

    /**
     * Executes the callables (in the order they were added)
     *
     */
    public function __invoke() : void
    {
        $args = func_get_args();
        foreach ($this->callables as $callable) {
            if ($callable) { //it may be null if the object got destroyed in the mean time (this is a way to remove a callable from the array)
                //call_user_func_array($callable, $args);
                $callable(...$args);
            }
        }
    }

    public function get_callables() : array
    {
        return $this->callables;
    }

    public function add_callable(callable $callable) : void
    {
        $this->callables[] = $callable;
    }
}