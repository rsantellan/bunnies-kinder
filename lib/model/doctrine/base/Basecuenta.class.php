<?php

/**
 * Basecuenta
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $referenciabancaria
 * @property float $debe
 * @property float $pago
 * @property float $diferencia
 * @property Doctrine_Collection $cuentapadre
 * @property Doctrine_Collection $cuentausuario
 * @property Doctrine_Collection $facturaFinal
 * @property Doctrine_Collection $cobro
 * 
 * @method integer             getId()                 Returns the current record's "id" value
 * @method string              getReferenciabancaria() Returns the current record's "referenciabancaria" value
 * @method float               getDebe()               Returns the current record's "debe" value
 * @method float               getPago()               Returns the current record's "pago" value
 * @method float               getDiferencia()         Returns the current record's "diferencia" value
 * @method Doctrine_Collection getCuentapadre()        Returns the current record's "cuentapadre" collection
 * @method Doctrine_Collection getCuentausuario()      Returns the current record's "cuentausuario" collection
 * @method Doctrine_Collection getFacturaFinal()       Returns the current record's "facturaFinal" collection
 * @method Doctrine_Collection getCobro()              Returns the current record's "cobro" collection
 * @method cuenta              setId()                 Sets the current record's "id" value
 * @method cuenta              setReferenciabancaria() Sets the current record's "referenciabancaria" value
 * @method cuenta              setDebe()               Sets the current record's "debe" value
 * @method cuenta              setPago()               Sets the current record's "pago" value
 * @method cuenta              setDiferencia()         Sets the current record's "diferencia" value
 * @method cuenta              setCuentapadre()        Sets the current record's "cuentapadre" collection
 * @method cuenta              setCuentausuario()      Sets the current record's "cuentausuario" collection
 * @method cuenta              setFacturaFinal()       Sets the current record's "facturaFinal" collection
 * @method cuenta              setCobro()              Sets the current record's "cobro" collection
 * 
 * @package    jardin
 * @subpackage model
 * @author     Rodrigo Santellan
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class Basecuenta extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('cuenta');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('referenciabancaria', 'string', 64, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 64,
             ));
        $this->hasColumn('debe', 'float', 14, array(
             'type' => 'float',
             'default' => 0,
             'length' => 14,
             'scale' => '2',
             ));
        $this->hasColumn('pago', 'float', 14, array(
             'type' => 'float',
             'default' => 0,
             'length' => 14,
             'scale' => '2',
             ));
        $this->hasColumn('diferencia', 'float', 14, array(
             'type' => 'float',
             'default' => 0,
             'length' => 14,
             'scale' => '2',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('cuentapadre', array(
             'local' => 'id',
             'foreign' => 'cuenta_id'));

        $this->hasMany('cuentausuario', array(
             'local' => 'id',
             'foreign' => 'cuenta_id'));

        $this->hasMany('facturaFinal', array(
             'local' => 'id',
             'foreign' => 'cuenta_id'));

        $this->hasMany('cobro', array(
             'local' => 'id',
             'foreign' => 'cuenta_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}