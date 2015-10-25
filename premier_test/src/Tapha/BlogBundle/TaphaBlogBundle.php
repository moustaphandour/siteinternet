<?php

namespace Tapha\BlogBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\HttpFoundation\Request;

class TaphaBlogBundle extends Bundle
{
  public function boot() {
    parent::boot();
    
    if((int)\Symfony\Component\HttpKernel\Kernel::MINOR_VERSION > 1)
      Request::enableHttpMethodParameterOverride(); // READ CHANGELOG Symfony 2.2.0
  }
}