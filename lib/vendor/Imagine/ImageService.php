<?php

namespace Imagine;


use Imagine\Imagick\Imagine as mImagick;
use Imagine\Gd\Imagine as gdImagine;
use Imagine\Gmagick\Imagine as gMagick;
use Imagine\Image\Box;
use Imagine\Image\Point;
use Imagine\Image\Palette\RGB as mPalette;

/**
 * Description of MyImageManager
 *
 * @author rodrigo
 */
class ImageService {
  
  private $imageInterface = null;
  private $cache_dir = NULL;
  private $root_dir = NULL;
  
  public function __construct() {
    if (class_exists('Imagick'))
    {
        $this->imageInterface = new mImagick();
    }
    else
    {
        if (class_exists('Gmagick'))
        {
            $this->imageInterface = new gMagick();
        }
        else 
        {
            $this->imageInterface = new gdImagine();
        }
    }
    
    
    $cachePath = \sfConfig::get('sf_cache_dir') . '/images/web';
    //$cacheDir = str_replace(\sfConfig::get ( 'sf_web_dir' ), $cachePath);
    
    $this->root_dir = \sfConfig::get ( 'sf_web_dir' ) ;
    $this->cache_dir = $cachePath ;
  }
  
  public function doResizeCropExact($image_path, $width, $height)
  {
    if(!is_file($image_path)){
      throw new \Exception("No file in that path", 10005);
    }
    $mesures = "b".$height."x".$width;
    $tmp_file = $this->retrieveCachePath($image_path, 'rce', array('r', $mesures));
    if(is_file($tmp_file))
    {
      return $tmp_file;
    }
    
    $image = $this->imageInterface->open($image_path);
    $originalWidth = $image->getSize()->getWidth();
    $originalHeight = $image->getSize()->getHeight();
    
    $width_ratio = $originalWidth / (float)$width;
    $height_ratio = $originalHeight / (float)$height;
    $resize_width = 0;
    $resize_height = 0;
    /*
    var_dump("wr:".$width_ratio);
    var_dump("hr:".$height_ratio);
    var_dump("ow:".$originalWidth);
    var_dump("oh:".$originalHeight);
    var_dump("w:".$width);
    var_dump("h:".$height);
    */
    if(($originalWidth <= $width) && ($originalHeight <= $height))
    {
      //Dont do nothing
    }
    else
    {
      $crop_x = 0;
      $crop_y = 0;
      if($height_ratio < $width_ratio)
      {
        $resize_height = $height;
        //$resize_width = ceil(($width * $originalHeight) / $originalWidth);
        $resize_width = ceil(($height * $originalWidth) / $originalHeight);
        $crop_x = abs(ceil(($resize_width - $width) / 2));
      }
      else
      {
        //
        //$resize_height = ceil(($height * $originalWidth) / $originalHeight);
        $resize_height = ceil(($width * $originalHeight) / $originalWidth);
        $resize_width = $width;
        $crop_y = abs(ceil(($resize_height - $height) / 2));
      }
      /*var_dump("crop x:".ceil(($resize_width - $width) / 2));
      var_dump("crop y:".ceil(($resize_height - $height) / 2));
      var_dump("final crop x:".$crop_x);
      var_dump("final crop y:".$crop_y);
      var_dump("rw:".$resize_width);
      var_dump("rh:".$resize_height);*/
      $image->resize(new Box($resize_width, $resize_height));
      $image->crop(new Point($crop_x,$crop_y), new Box($width, $height));
      
    }
    //die;
    $image->save($tmp_file);
    return $tmp_file;
  }
  
  public function doResizeCenterCropExact($image_path, $width, $height)
  {
    if(!is_file($image_path)){
      throw new \Exception("No file in that path", 10005);
    }
    $mesures = "b".$height."x".$width;
    $tmp_file = $this->retrieveCachePath($image_path, 'rcce', array('r', $mesures));
    if(is_file($tmp_file))
    {
      return $tmp_file;
    }
    
    $image = $this->imageInterface->open($image_path);
    $originalWidth = $image->getSize()->getWidth();
    $originalHeight = $image->getSize()->getHeight();
    
    $width_ratio = $originalWidth / (float)$width;
    $height_ratio = $originalHeight / (float)$height;
    $resize_width = 0;
    $resize_height = 0;
    /*
    var_dump("wr:".$width_ratio);
    var_dump("hr:".$height_ratio);
    var_dump("ow:".$originalWidth);
    var_dump("oh:".$originalHeight);
    var_dump("w:".$width);
    var_dump("h:".$height);
    */
    if(($originalWidth <= $width) && ($originalHeight <= $height))
    {
      //Dont do nothing
    }
    else
    {
      $crop_x = 0;
      $crop_y = 0;
      if($height_ratio < $width_ratio)
      {
        $resize_height = $height;
        //$resize_width = ceil(($width * $originalHeight) / $originalWidth);
        $resize_width = ceil(($height * $originalWidth) / $originalHeight);
        $crop_x = abs(ceil(($resize_width - $width) / 2));
      }
      else
      {
        //
        //$resize_height = ceil(($height * $originalWidth) / $originalHeight);
        $resize_height = ceil(($width * $originalHeight) / $originalWidth);
        $resize_width = $width;
        $crop_y = abs(ceil(($resize_height - $height) / 2));
      }
      /*var_dump("crop x:".ceil(($resize_width - $width) / 2));
      var_dump("crop y:".ceil(($resize_height - $height) / 2));
      var_dump("final crop x:".$crop_x);
      var_dump("final crop y:".$crop_y);
      var_dump("rw:".$resize_width);
      var_dump("rh:".$resize_height);*/
      $image->resize(new Box($resize_width, $resize_height));
      $image->crop(new Point($crop_x,$crop_y), new Box($width, $height));
      
    }
    //die;
    $image->save($tmp_file);
    return $tmp_file;
  }
  
  public function doMaximunPosibleResize($image_path, $width, $height, $background = 'ffffff')
  {
    if(!is_file($image_path)){
      throw new \Exception("No file in that path", 10005);
    }
    $mesures = "b".$height."x".$width;
    $tmp_file = $this->retrieveCachePath($image_path, 'mpr', array('r', $mesures));
    if(is_file($tmp_file))
    {
      return $tmp_file;
    }
    
    $image = $this->imageInterface->open($image_path);
    $originalWidth = $image->getSize()->getWidth();
    $originalHeight = $image->getSize()->getHeight();
    
    $width_ratio = $originalWidth / (float)$width;
    $height_ratio = $originalHeight / (float)$height;
    $resize_width = 0;
    $resize_height = 0;
    if(($originalWidth <= $width) && ($originalHeight <= $height))
    {
      //Dont do nothing
    }
    else
    {
      $crop_x = 0;
      $crop_y = 0;
      if($height_ratio > $width_ratio)
      {
        $resize_height = $height;
        $resize_width = ceil(($height * $originalWidth) / $originalHeight);
        $crop_x = abs(ceil(($resize_width - $width) / 2));
      }
      else
      {
        $resize_height = ceil(($width * $originalHeight) / $originalWidth);
        $resize_width = $width;
        $crop_y = abs(ceil(($resize_height - $height) / 2));
      }
      $image->resize(new Box($resize_width, $resize_height));
    }
    $pallete = new mPalette();
    $collage = $this->imageInterface->create(new Box($width, $height), $pallete->color($background, 100));
    $pointX = 0;
    $pointY = 0;
    if($width > $height)
    {
      $pointX = abs(ceil(($resize_width - $width)/2));;
    }
    else
    {
      $pointY = abs(ceil(($resize_height - $height)/2));
    }
    $collage->paste($image, new Point($pointX, $pointY));
    
    $collage->save($tmp_file);
    return $tmp_file;
  }
  
  public function doThumbnail($image_path, $width, $height)
  {
    if(!is_file($image_path)){
      throw new \Exception("No file in that path", 10005);
    }
    $mesures = "b".$height."x".$width;
    $tmp_file = $this->retrieveCachePath($image_path, 'thumbnail', array('r', $mesures));
    if(is_file($tmp_file))
    {
      return $tmp_file;
    }
    $this->imageInterface->open($image_path)->thumbnail(new Box($width, $height))->save($tmp_file);
    return $tmp_file;
  }
  
  public function doOutboundThumbnail($image_path, $width, $height)
  {
    if(!is_file($image_path)){
      throw new \Exception("No file in that path", 10005);
    }
    $mesures = "b".$height."x".$width;
    $tmp_file = $this->retrieveCachePath($image_path, 'thumbnail', array('r', $mesures));
    if(is_file($tmp_file))
    {
      return $tmp_file;
    }
    $this->imageInterface->open($image_path)->thumbnail(new Box($width, $height), \Imagine\Image\ManipulatorInterface::THUMBNAIL_OUTBOUND)->save($tmp_file);
    return $tmp_file;
  }
  
  public function retrieveOriginal($image_path)
  {
    if(!is_file($image_path)){
      throw new \Exception("No file in that path", 10005);
    }
    $tmp_file = $this->retrieveCachePath($image_path, 'original', array());
    if(is_file($tmp_file))
    {
      return $tmp_file;
    }
    $this->imageInterface->open($image_path)->save($tmp_file);
    return $tmp_file;
  }
  
  public function retrieveCachePath($path, $type, $parameters = array())
  {
//      var_dump(strpos($path, $this->root_dir) !== FALSE);die;
    if(strpos($path, $this->root_dir) !== FALSE)
    {
      //El archivo original es de la aplicacion
      $aux_string = $path;
      //Reviso si el archivo tiene el ../web
      if(strpos($path, "../web") !== FALSE)
      {
        $aux_string = str_replace("../web", "web", $aux_string);
      }
      $cache_string = str_replace($this->root_dir, $this->cache_dir, $aux_string);
      //var_dump($cache_string);
      $cache_path_info = pathinfo($cache_string);
      //var_dump($cache_path_info);
      //$cache_path_info["extension"];
      $file_extension = "png";
      if($this->validateFileExtension($cache_path_info["extension"]))
      {
        $file_extension = $cache_path_info["extension"];
      }
      $cache_file_name =  $cache_path_info["filename"].".".$cache_path_info["extension"];
      return $this->checkDirectoryPath($cache_path_info["dirname"].DIRECTORY_SEPARATOR.$type.DIRECTORY_SEPARATOR.implode("", $parameters).DIRECTORY_SEPARATOR). $cache_file_name;
    }
	else
	{
	  $aux_root_dir = dirname($this->root_dir);
	  if(strpos($path, $aux_root_dir) !== FALSE)
	  {
		return $this->actualRetriveCachePath($path, $aux_root_dir, $this->cache_dir, $type, $parameters);
	  }
	}
    throw new \Exception("No funca con cosas de afuera (por lo menos por ahora....)");
    //return $path;
  }
  
  private function actualRetriveCachePath($path, $base_path, $cache_dir, $type, $parameters)
  {
      $cache_string = str_replace($base_path, $cache_dir, $path);
      //var_dump($cache_string);
      $cache_path_info = pathinfo($cache_string);
      //var_dump($cache_path_info);
      //$cache_path_info["extension"];
      $file_extension = "png";
      if($this->validateFileExtension($cache_path_info["extension"]))
      {
        $file_extension = $cache_path_info["extension"];
      }
      $cache_file_name =  $cache_path_info["filename"].".".$cache_path_info["extension"];
      return $this->checkDirectoryPath($cache_path_info["dirname"].DIRECTORY_SEPARATOR.$type.DIRECTORY_SEPARATOR.implode("", $parameters).DIRECTORY_SEPARATOR). $cache_file_name;	
  }
  
  private function validateFileExtension($file_extension)
  {
    //Deberia de chequear que la extension sea valida para que la libreria la procese.
    return $file_extension;
  }
  
  private function checkDirectoryPath($directory_path)
  {
    //var_dump($directory_path);
    if(!is_dir($directory_path))
    {
      mkdir($directory_path, 0755, true);
    }
    return $directory_path;
  }

}


