<?php

class reloadUsersTask extends sfBaseTask
{
  protected function configure()
  {
    // // add your own arguments here
    // $this->addArguments(array(
    //   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
    // ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
      // add your own options here
    ));

    $this->namespace        = 'rsantellan';
    $this->name             = 'reloadUsers';
    $this->briefDescription = 'Hace un refresh de los usuarios';
    $this->detailedDescription = <<<EOF
The [reloadUsers|INFO] task does things.
Call it with:

  [php symfony reloadUsers|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

    // add your code here
    $usuarios = Doctrine::getTable('usuario')->retrieveAllFutureStudents();
    var_dump(count($usuarios));
    foreach($usuarios as $usuario)
    {
      var_dump($usuario->getId());
      $usuario->save();
      $usuario->updateNewsletter();
    }
  }
}
