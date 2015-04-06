<?php

/**
 * cuentaTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class cuentaTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object cuentaTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('cuenta');
    }
    
    
    public function retrieveAllActive()
    {
      $q = $this->createQuery('q')
           ->select('q.*')   
           ->innerJoin('q.cuentausuario cu')
           ->innerJoin('cu.usuario u')
           ->where('u.egresado = 0');
      return $q->execute();
    }
    
    public function retrieveAllWithDebts()
    {
      return $this->createQuery('q')
              ->where('q.diferencia > 0')
              ->execute();
    }
    
    public function retrieveAllWithDebtsAndUsers()
    {
      return $this->createQuery('q')
              ->innerJoin('q.cuentausuario cu')
              ->innerJoin('cu.usuario u')
              ->where('q.diferencia > 0')
			  ->orderby('q.referenciabancaria desc')
              ->execute();
    }
    
    public function retrieveAllWithUsersAndParents()
    {
      $q = $this->createQuery('q')
              ->innerJoin('q.cuentausuario cu')
              ->innerJoin('cu.usuario u')
              ->innerJoin('q.cuentapadre cp')
              ->innerJoin('cp.progenitor p');
      return $q->execute();
    }
    
    public function findByUserId($userId)
    {
      $q = $this->createQuery('q')
              ->select('q.*')
              ->innerJoin('q.cuentausuario cu')
              ->where('cu.usuario_id = ?', $userId);
      return $q->fetchOne();
    }
    
}