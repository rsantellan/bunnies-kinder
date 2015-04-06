<?php

/**
 * cobroTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class cobroTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object cobroTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('cobro');
    }
    
    public function retrieveOfAccount($accountId, $order = 'desc')
    {
      $q = $this->createQuery('c')
              ->addWhere('c.cuenta_id = ?', $accountId)
              ->orderBy('c.fecha '.$order);
      return $q->execute();
    }
    
    public function retrieveLastFromAccount($accountId)
    {
      $q = $this->createQuery('c')
              ->addWhere('c.cuenta_id = ?', $accountId)
              ->orderBy('c.fecha desc')
              ->limit(1);
      return $q->fetchOne();
    }
}