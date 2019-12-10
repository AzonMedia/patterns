<?php
declare(strict_types=1);

namespace Azonmedia\Patterns;

/**
 * Class ScopeReference
 * To be used to invoke callbacks when the scope is abandoned (be it because of return statement or exception thrown in this or child scope).
 * An instance from this class is to be kept only in automatic variable in the local scope.
 * @package Azonmedia\Patterns
 */
class ScopeReference
{
    const DESTRUCTION_REASON_UNKNOWN = 0;//if it stays to this one it means the scope was left without being correctly destroyed (this would be reaching return)
    const DESTRUCTION_REASON_OVERWRITING = 1;
    const DESTRUCTION_REASON_EXCEPTION = 2;//in a cycle the reference got overwritten by another one before being explicitly and correctly destroyed
    const DESTRUCTION_REASON_EXPLICIT = 3;//intentionally and correctly destroyed

    public static $destruction_reason_map = [
        self::DESTRUCTION_REASON_UNKNOWN => 'unknown',
        self::DESTRUCTION_REASON_OVERWRITING => 'overwriting',
        self::DESTRUCTION_REASON_EXCEPTION => 'exception',
        self::DESTRUCTION_REASON_EXPLICIT => 'explicit',
    ];

    /**
     * These callbacks will be executed on object destruction
     * @var array Array of callbacks
     */
    protected $callbacks = [];

    /**
     * @var int
     */
    protected $destruction_reason;

    public function __construct(callable $callback = NULL)
    {
        if ($callback) {
            $this->add_callback($callback);
        }
    }

    public function __destruct()
    {
        $this->execute_callbacks();
    }

    public function add_callback(callable $callback): void
    {
        $this->callbacks[] = $callback;
    }

    private function execute_callbacks(): void
    {
        foreach ($this->callbacks as $callback) {
            $callback();
        }
    }

    /**
     *
     * @return int
     */
    public function get_destruction_reason()
    {
        return $this->destruction_reason;
    }

    /**
     *
     * @param int $reason
     */
    public function set_destruction_reason($reason)
    {
        // TODO validate
        $this->destruction_reason = $reason;
    }
}
