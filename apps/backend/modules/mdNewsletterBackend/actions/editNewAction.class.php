<?php

class editNewAction extends sfAction {
    
  public function execute($request)
  {
      if($request->isMethod(sfRequest::POST))
      {
          $postParameters = $request->getParameter('md_newsletter_content');
          if(is_numeric($postParameters["id"]))
          {
            $this->forward404Unless($mdNewsletterContent = Doctrine::getTable('mdNewsletterContent')->find(array($postParameters['id'])), sprintf('Object md_product does not exist (%s).', $postParameters["id"]));
          }
          else
          {
            $mdNewsletterContent = new mdNewsletterContent();
          }
          $this->form = new mdNewsletterContentForm($mdNewsletterContent);
          $this->form->bind($postParameters);
          if($this->form->isValid())
          {
            $mdNewsletterContent = $this->form->save();
            // Hago el redirect.
            $this->getUser()->setFlash('notice', 'Mensaje de newsletter actualizado con exito');
            $this->redirect('mdNewsletterBackend/editNew?id='.$mdNewsletterContent->getId());
        }
      }
      else
      {
        $id = $request->getParameter('id');
        $this->forward404Unless($mdNewsletterContent = Doctrine::getTable('mdNewsletterContent')->find(array($id)), sprintf('Object newsletter does not exist (%s).', $id));
        $this->form = new mdNewsletterContentForm($mdNewsletterContent);
      }
  }
      
}
