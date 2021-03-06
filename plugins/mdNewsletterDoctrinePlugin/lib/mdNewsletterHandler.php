<?php

class mdNewsletterHandler
{
    public static function registerUser($email)
    {
        if(!mdBasicFunction::validEmail($email))
        {
          return false;
        }
        $mdUser = Doctrine::getTable("mdUser")->findOneBy("email", $email);
        if(!$mdUser)
        {
            $mdUser = new mdUser();
            $mdUser->setEmail($email);
            $mdUser->save();
        }
        $mdNewsLetterUser = Doctrine::getTable("mdNewsLetterUser")->findOneBy("md_user_id", $mdUser->getId());
        if(!$mdNewsLetterUser)
        {
            $mdNewsLetterUser = new mdNewsLetterUser();
            $mdNewsLetterUser->setMdUserId($mdUser->getId());
            $mdNewsLetterUser->save();
        }
        return $mdNewsLetterUser;
    }

    public static function retriveAll()
    {
      return Doctrine::getTable("mdNewsLetterUser")->findAll();
    }
    
    public static function retrieveAllForBox()
    {
        //$sql = "SELECT mnlu.id, mnlu.md_user_id, mu.email, p.mail, p.nombre FROM md_news_letter_user mnlu left join md_user mu on mu.id = mnlu.md_user_id  left join progenitor p on mu.id = p.md_user_id WHERE mu.id in (select md_user_id from md_news_letter_user) ORDER BY p.mail ASC";
        $sql = "select 
    usuario.horario as u_horario, usuario.clase as u_clase, usuario.id as u_id, usuario.nombre as u_nombre, usuario.apellido as u_apellido, progenitor.nombre as p_nombre, md_news_letter_user.id as mn_id, md_news_letter_user.md_user_id as mn_user_id, md_user.email as mn_email
              from
                  usuario
              left join usuario_progenitor on usuario.id = usuario_progenitor.usuario_id
              left join progenitor on progenitor.id = usuario_progenitor.progenitor_id
              left join md_user ON md_user.id = progenitor.md_user_id
              left join md_news_letter_user ON md_news_letter_user.md_user_id = md_user.id
              where usuario.egresado = 0 and usuario.anio_ingreso <= ?
              order by usuario.horario, usuario.clase";
        
        $q = Doctrine_Manager::getInstance()->getCurrentConnection();
        return $q->fetchAssoc($sql, array(date('Y')));
    }
    
    public static function retrieveAllEgresadosForBox()
    {
        //$sql = "SELECT mnlu.id, mnlu.md_user_id, mu.email, p.mail, p.nombre FROM md_news_letter_user mnlu left join md_user mu on mu.id = mnlu.md_user_id  left join progenitor p on mu.id = p.md_user_id WHERE mu.id in (select md_user_id from md_news_letter_user) ORDER BY p.mail ASC";
        $sql = "select 
    usuario.horario as u_horario, usuario.clase as u_clase, usuario.id as u_id, usuario.nombre as u_nombre, usuario.apellido as u_apellido, progenitor.nombre as p_nombre, md_news_letter_user.id as mn_id, md_news_letter_user.md_user_id as mn_user_id, md_user.email as mn_email
              from
                  usuario
              left join usuario_progenitor on usuario.id = usuario_progenitor.usuario_id
              left join progenitor on progenitor.id = usuario_progenitor.progenitor_id
              left join md_user ON md_user.id = progenitor.md_user_id
              left join md_news_letter_user ON md_news_letter_user.md_user_id = md_user.id
              where usuario.egresado = 1
              order by usuario.horario, usuario.clase";
        
        $q = Doctrine_Manager::getInstance()->getCurrentConnection();
        return $q->fetchAssoc($sql);
    }
    
    public static function retrieveUsers($page = null, $limit = null)
    {
        return Doctrine::getTable("mdNewsLetterUser")->retrieveAllUsersOfNewsLetter($page, $limit);
    }

    public static function retrieveNewsletters($page = null, $limit = null)
    {
        return Doctrine::getTable("mdNewsLetterUser")->retrieveNewsletters($page, $limit);
    }

    public static function retrieveNumberOfUserInNewsLetter()
    {
        $list = Doctrine::getTable("mdNewsLetterUser")->retrieveAllNewsLettersIds();
        return count($list);
    }
    
    public static function retrieveAllMdNewsletterContents()
    {
      return Doctrine::getTable("mdNewsletterContent")->retrieveAdminQuery();
    }
    
    public static function retrieveNewsLetterUserByEmail($email)
    {
      return Doctrine::getTable("mdNewsLetterUser")->retrieveNewsLetterUserByEmail($email);
    }
    
    public static function sendEmailToSomeUsers($mdNewsletterContentSendedId, $listOfUsersIds)
    {
      foreach($listOfUsersIds as $userId)
      {
        if(!empty($userId))
        {
          $mdNewsletterSend = new mdNewsletterSend();
          $mdNewsletterSend->setMdNewsLetterUserId($userId);
          $mdNewsletterSend->setMdNewsletterContentSendedId($mdNewsletterContentSendedId);
          $mdNewsletterSend->save();
        }
        
      }      
    }
    
    public static function sendEmailToGroups($mdNewsletterContentSendedId, $groupsIds)
    {
      foreach($groupsIds as $groupId)
      {
        $groupUserList = Doctrine::getTable("mdNewsLetterGroupUser")->findBy("md_newsletter_group_id", $groupId);
        foreach($groupUserList as $user)
        {
          $mdNewsletterSend = new mdNewsletterSend();
          $mdNewsletterSend->setMdNewsLetterUserId($user->getMdNewsletterUserId());
          $mdNewsletterSend->setMdNewsletterContentSendedId($mdNewsletterContentSendedId);
          $mdNewsletterSend->save();          
        }
        $mdNewsLetterGroupSended = new mdNewsLetterGroupSended();
        $mdNewsLetterGroupSended->setMdNewsletterContendSendedId($mdNewsletterContentSendedId);
        $mdNewsLetterGroupSended->setMdNewsletterGroupId($groupId);
        $mdNewsLetterGroupSended->save();
      }      
    }
    
    public static function sendEmailToAllUsers($mdNewsletterContentSendedId)
    {
      $users = self::retriveAll();
      foreach($users as $user)
      {
        $mdNewsletterSend = new mdNewsletterSend();
        $mdNewsletterSend->setMdNewsLetterUserId($user->getId());
        $mdNewsletterSend->setMdNewsletterContentSendedId($mdNewsletterContentSendedId);
        $mdNewsletterSend->save();
      }
      
    }
    
    public static function retrieveNotSendedMails()
    {
      return Doctrine::getTable("mdNewsletterContentSended")->retrieveNotSended();
    }
    
    public static function retrieveAllMdNewsletterContentSendedOfId($id)
    {
      return Doctrine::getTable("mdNewsletterContentSended")->retrieveAllMdNewsletterContentSendedOfId($id);
    }
    
    public static function sendAllNotSendedMails()
    {
        $list = self::retrieveNotSendedMails();
        
        foreach($list as $notSended)
        {
          $users = $notSended->getMdNewsletterSend();
          $count = 0;
          
          foreach($users as $user)
          {
            
            $email = $user->getMdNewsLetterUser()->getMdUser()->getEmail();
            mdMailHandler::sendSwiftMail("noreply@mastodonte.com", $email, $notSended->getSubject(), $notSended->getBody(), false, "", array(), false);
            $count++;
          }
          $notSended->setSendCounter($notSended->getSendCounter() + $count);
          $notSended->setSended(true);
          $notSended->save();
        }
        
    }
    
  public static function importUsers($file, $extension)
  {
    if($extension == ".xls")
    {
      $index = 0;
      $row = 2;
      $return = 1;
      $return = self::proccessExcelBulkImport($file, $row);
    }
  }
  
  private static function proccessExcelBulkImport($file, $row, $quantity_of_processing = 20) {
      $data = new Spreadsheet_Excel_Reader();
      $data->setOutputEncoding('CP1251'); // Set output Encoding.
      
      $data->read($file);
      
      $index = 0;
      for ($i = $row; $i <= count($data->sheets[0]['cells']); $i++) {
          $index++;
          
          $my_data = $data->sheets[0]['cells'][$i];
          if(isset($my_data[1]))
          {
            self::registerUser($my_data[1]);
          }
          //self::processRow($data->sheets[0]['cells'][$i],$index);
          if ($index == $quantity_of_processing) {
              break;
          }
      }
      return $index;
  }  
  
  
}
