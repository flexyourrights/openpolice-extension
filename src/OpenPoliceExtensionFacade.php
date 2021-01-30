<?php
/**
  * OpenPoliceExtensionFacade in Laravel is a class which redirects static 
  * method calls to the dynamic methods of an underlying class
  *
  * OpenPolice.org
  * @package  flexyourrights/openpolice-extension
  * @author  Morgan Lesko <morgan@flexyourrights.org>
  * @since  v0.3.0
  */
namespace FlexYourRights\OpenPoliceExtension;

use Illuminate\Support\Facades\Facade;

class OpenPoliceExtensionFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'openpoliceextension';
    }
}
