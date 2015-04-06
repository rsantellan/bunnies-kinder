<?php

/**
 * BasemdNewsletterSend
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $md_news_letter_user_id
 * @property integer $md_newsletter_content_sended_id
 * @property timestamp $sending_date
 * @property mdNewsLetterUser $mdNewsLetterUser
 * @property mdNewsletterContentSended $mdNewsletterContentSended
 * 
 * @method integer                   getId()                              Returns the current record's "id" value
 * @method integer                   getMdNewsLetterUserId()              Returns the current record's "md_news_letter_user_id" value
 * @method integer                   getMdNewsletterContentSendedId()     Returns the current record's "md_newsletter_content_sended_id" value
 * @method timestamp                 getSendingDate()                     Returns the current record's "sending_date" value
 * @method mdNewsLetterUser          getMdNewsLetterUser()                Returns the current record's "mdNewsLetterUser" value
 * @method mdNewsletterContentSended getMdNewsletterContentSended()       Returns the current record's "mdNewsletterContentSended" value
 * @method mdNewsletterSend          setId()                              Sets the current record's "id" value
 * @method mdNewsletterSend          setMdNewsLetterUserId()              Sets the current record's "md_news_letter_user_id" value
 * @method mdNewsletterSend          setMdNewsletterContentSendedId()     Sets the current record's "md_newsletter_content_sended_id" value
 * @method mdNewsletterSend          setSendingDate()                     Sets the current record's "sending_date" value
 * @method mdNewsletterSend          setMdNewsLetterUser()                Sets the current record's "mdNewsLetterUser" value
 * @method mdNewsletterSend          setMdNewsletterContentSended()       Sets the current record's "mdNewsletterContentSended" value
 * 
 * @package    jardin
 * @subpackage model
 * @author     Rodrigo Santellan
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasemdNewsletterSend extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('md_newsletter_send');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('md_news_letter_user_id', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => 4,
             ));
        $this->hasColumn('md_newsletter_content_sended_id', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => 4,
             ));
        $this->hasColumn('sending_date', 'timestamp', null, array(
             'type' => 'timestamp',
             ));

        $this->option('symfony', array(
             'form' => false,
             'filter' => false,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('mdNewsLetterUser', array(
             'local' => 'md_news_letter_user_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('mdNewsletterContentSended', array(
             'local' => 'md_newsletter_content_sended_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}