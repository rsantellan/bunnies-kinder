<?php

/**
 * Basecuentapadre
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $cuenta_id
 * @property integer $progenitor_id
 * @property cuenta $cuenta
 * @property progenitor $progenitor
 * 
 * @method integer     getCuentaId()      Returns the current record's "cuenta_id" value
 * @method integer     getProgenitorId()  Returns the current record's "progenitor_id" value
 * @method cuenta      getCuenta()        Returns the current record's "cuenta" value
 * @method progenitor  getProgenitor()    Returns the current record's "progenitor" value
 * @method cuentapadre setCuentaId()      Sets the current record's "cuenta_id" value
 * @method cuentapadre setProgenitorId()  Sets the current record's "progenitor_id" value
 * @method cuentapadre setCuenta()        Sets the current record's "cuenta" value
 * @method cuentapadre setProgenitor()    Sets the current record's "progenitor" value
 * 
 * @package    jardin
 * @subpackage model
 * @author     Rodrigo Santellan
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class Basecuentapadre extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('cuentapadre');
        $this->hasColumn('cuenta_id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'length' => 4,
             ));
        $this->hasColumn('progenitor_id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'length' => 4,
             ));

        $this->option('symfony', array(
             'form' => false,
             'filter' => false,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('cuenta', array(
             'local' => 'cuenta_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('progenitor', array(
             'local' => 'progenitor_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));
    }
}