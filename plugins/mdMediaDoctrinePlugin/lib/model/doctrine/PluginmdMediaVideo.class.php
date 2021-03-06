<?php

/**
 * PluginmdMediaVideo
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
DEFINE('MDVIDEOAVATAR_PATH', sfConfig::get('app_mdVideoAvatar_path', sfConfig::get('sf_upload_dir') . '/media/mdVideoAvatar'));


abstract class PluginmdMediaVideo extends BasemdMediaVideo implements mdMediaContentInterface
{


    public $priority = -1;

    public $mdUserIdTmp = 0;

    const PATH = MDVIDEOAVATAR_PATH;

    /**
     * Devuelve el nombre de la clase: mdMediaImage
     * @return <string>
     */
    public function getObjectClass()
    {
        return get_class($this);
    }

    /**
     * Devuelve el src de la imagen
     * @return <string>
     */
    public function getObjectSource()
    {
        //return $this->getVideoPath();
        return '/mdMediaDoctrinePlugin/images/icono_video.jpg';
    }

    public function getObjectUrl($options = array())
    {
        return mdWebVideo::getUrl($this->getVideoPath(), $options);
    }

    public function getAvatarVideo($options){
        //levantar el avatar generado para el video
        if($this->getAvatar() == '' ){
            $url = '/mdMediaDoctrinePlugin/images/icono_video.jpg';
        } else {
            $url = mdWebImage::getUrl($this->getAvatarPath(), $options);
        }
        return $url;
    }

    public function getAvatarPath(){
        return '/media/mdVideoAvatar/'. $this->getAvatar();
    }

    public function getVideoPath()
    {
        return $this->getPath() . $this->getFilename();
    }

    public function preDelete($event) {
        $path = sfConfig::get('app_mdVideoFileHandler_path', sfConfig::get('sf_upload_dir'));
        $path .= $this->getPath();
        try{
            MdFileHandler::delete($this->getFilename(), $path);
        }catch(Exception $e)
        {
            sfContext::getInstance()->getLogger()->err("Error al borrar: ".$path.$this->getFilename());
            sfContext::getInstance()->getLogger()->err($e->getMessage());
        }
        
        
        try{
            $avatar_path = MDVIDEOAVATAR_PATH .'/';
            MdFileHandler::delete($this->getAvatar(), $avatar_path);
        } catch(Exception $e){
            sfContext::getInstance()->getLogger()->err("Errror al borrar: ".$avatar_path.$this->getAvatar());
            sfContext::getInstance()->getLogger()->err($e->getMessage());
        }
        
        
    }

    public function getDownloadSource()
    {
        return $this->getPath() . $this->getFilename();
    }
    
    public function getFileType()
    {
      return $this->getType();
    }
    
    public function isVideo()
    {
      return true;
    }    
}
