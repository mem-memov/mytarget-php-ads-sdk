<?php

namespace MyTarget\Mapper\Exception;

use MyTarget\Exception\MyTargetException;

class ClassNotFoundException extends \LogicException
    implements MyTargetException, ContextUnawareException
{
    /**
     * @var string
     */
    public $class;

    /**
     * @param string $class
     */
    public function __construct($class)
    {
        parent::__construct(sprintf("Class %s not found", $class));

        $this->class = $class;
    }
}
