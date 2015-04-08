<?php

require_once dirname(__FILE__).'/../lib/vendor/symfony/lib/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

require_once dirname(__FILE__).'/../lib/autoloader/SplClassLoader.php';
 
$classLoader = new SplClassLoader('Imagine', dirname(__FILE__).'/../lib/vendor');
$classLoader->register();

class ProjectConfiguration extends sfProjectConfiguration
{
  public function setup()
  {
    $this->enableAllPluginsExcept(array('sfPropelPlugin'));      
  }
}
