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

//    public const DESTRUCTION_REASON = [
//        'RETURN'        => 'RETURN',//if it stays to this one it means the scope was left without being correctly destroyed (this would be reaching return)
//        'OVERWRITTEN'   => 'OVERWRITTEN',//in a cycle the reference got overwritten by another one before being explicitly and correctly destroyed
//        'EXCEPTION'     => 'EXCEPTION',//destroyed because the scope was destroyed due to an exception
//        'EXPLICIT'      => 'EXPLICIT',//intentionally and correctly destroyed
//    ];

    /**
     * These callbacks will be executed on object destruction
     * @var array Array of callbacks
     */
    protected array $callbacks = [];

//    /**
//     * @var string
//     */
//    protected string $destruction_reason = self::DESTRUCTION_REASON['RETURN'];

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

    /**
     * To be used when no callback should be executed on reference destruction.
     */
    public function remove_callbacks() : void
    {
        $this->callbacks = [];
    }

    private function execute_callbacks(): void
    {
        foreach ($this->callbacks as $callback) {
            $callback();
        }
    }

//    /**
//     *
//     * @return string
//     */
//    public function get_destruction_reason() : string
//    {
//        return $this->destruction_reason;
//    }
//
//    /**
//     *
//     * @param string $reason
//     */
//    public function set_destruction_reason(string $reason)
//    {
//        self::validate_destruction_reason($reason);
//        $this->destruction_reason = $reason;
//    }
//
//    protected static function validate_destruction_reason(string $reason) : void
//    {
//        if (!$reason) {
//            //
//        }
//        if (!ctype_upper($reason)) {
//
//        }
//        if (!isset(self::DESTRUCTION_REASON[$reason])) {
//            //
//        }
//    }
}
