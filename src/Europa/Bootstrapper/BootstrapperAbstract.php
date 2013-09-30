<?php

namespace Europa\Bootstrapper;
use Europa\Reflection;

abstract class BootstrapperAbstract
{
  public function __invoke()
  {
    $that = new Reflection\ClassReflector($this);

    foreach ($that->getMethods() as $method) {
      if ($this->isValidMethod($method)) {
        $method->invokeArgs($this, func_get_args());
      }
    }

    return $this;
  }

  private function isValidMethod(Reflection\MethodReflector $method)
  {
    if ($method->getName() === 'bootstrap') {
      return false;
    }

    if ($method->isMagic()) {
      return false;
    }

    if (!$method->isPublic()) {
      return false;
    }

    return true;
  }
}