<?php

/**
 * mdWebImage actions.
 *
 * @package    mdMediaManagerPlugin
 * @subpackage mdWebImage
 * @author     Gaston Caldeiro
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class mdWebImageActions extends sfActions
{

 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {

    try{

        $param = $request->getParameter ( 'i' );
        $response = $this->getResponse();

        list($route, $options) = mdWebImage::getParametersFromQueryString($param);
        
        if ($route)
        {
            /*
            var_dump($route);
            var_dump($options);
            var_dump($options[mdWebOptions::CODE]);
            die;
            */
            $handler = new Imagine\ImageService();
            
            $filePath = '';
            
            switch($options[mdWebOptions::CODE])
            {
                
                case mdWebCodes::RESIZE:

                    list($width, $height, $exactDimentions) = self::processParameters($options);
                    
                    $filePath = $handler->doOutboundThumbnail($route, $width, $height);
                    //$mdMagick->resize($width, $height, $exactDimentions);

                    break;
                case mdWebCodes::RESIZECROP:

                    list($width, $height) = self::processParameters($options);

                    //$mdMagick->resizeExactly($width, $height);
                    $filePath = $handler->doResizeCropExact($route, $width, $height);
                    break;

                  case mdWebCodes::CROPRESIZE:
                  
                  
                       list($width, $height) = self::processParameters($options);
                        
                       //$mdMagick->cropresize($width, $height);
                       $filePath = $handler->doResizeCenterCropExact($route, $width, $height);
                       
                       break;

                case mdWebCodes::PERSPECTIVE:

                    throw new Exception('operation not implemented yet', 102);

                    break;
                case mdWebCodes::ROUND_CORNERS:

                        list($round) = self::processParameters($options);
                        $filePath = $handler->doResizeCenterCropExact($route, $width, $height);
                        
                    break;
                case mdWebCodes::CROP:

                        list($width, $height, $top, $left, $gravity) = self::processParameters($options);

                        $filePath = $handler->doResizeCenterCropExact($route, $width, $height);

                   break;
                case mdWebCodes::ORIGINAL:

                        //list($width, $height, $top, $left, $gravity) = self::processParameters($options);

                        $filePath = $handler->retrieveOriginal($route);

                   break;   
                default:

                    throw new Exception('operation not implemented yet', 102);

                    break;
            }
            
            //var_dump($filePath);die;
            //$filePath = mdFileMagickHandler::process($route, $options);

            $last_modified_time = @filemtime($filePath);

            if($last_modified_time)
            {
                $response->setContentType('image/jpeg'); //Tipo de contenido imagen
                $response->setHttpHeader('Last-Modified', $response->getDate($last_modified_time)); //Fecha de ultima modificacion de la imagen
                $response->addCacheControlHttpHeader('max_age=2592000'); //Maximo de vida en cache de 30 dias
                $response->addCacheControlHttpHeader('private=True'); //contenido cacheado localmente en el navegador del usuario
            }

            if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && @strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) == $last_modified_time )
            {
                $response->setStatusCode(304); //304 Not Modified
            }
            else
            {
                //Status Code por default 200 OK
                $response->setContent ( mdFileMagickHandler::getFileGetContents($filePath) );
            }
        }
        else
        {
            $response->setStatusCode(404); //404 Not Found
        }
    }catch(Exception $e){
        
        $response->setStatusCode(404); //404 Not Found

    }

    $this->setLayout ( false );
    return sfView::NONE;
  }
  
  private static function processParameters($options)
    {
        $values = array();
        switch($options[mdWebOptions::CODE])
        {
            case mdWebCodes::RESIZE:

                if (isset($options[mdWebOptions::WIDTH])) $width = $options[mdWebOptions::WIDTH];
                else throw new Exception('no width given', 100);

                $height = (isset($options[mdWebOptions::HEIGHT]) ? $options[mdWebOptions::HEIGHT] : 0);

                $exactDimentions = ((isset($options[mdWebOptions::EXACT_DIMENTIONS]) && $options[mdWebOptions::EXACT_DIMENTIONS] == 'true') ? true : false);

                $values = array($width, $height, $exactDimentions);
                
                break;
            case mdWebCodes::RESIZECROP:

                if (isset($options[mdWebOptions::WIDTH])) $width = $options[mdWebOptions::WIDTH];
                else throw new Exception('no width given', 100);

                if(isset($options[mdWebOptions::HEIGHT])) $height = $options[mdWebOptions::HEIGHT];
                else throw new Exception('no height given', 101);

                $values = array($width, $height);

                break;
          	case mdWebCodes::CROPRESIZE:

                if (isset($options[mdWebOptions::WIDTH])) $width = $options[mdWebOptions::WIDTH];
                else $width = null; //throw new Exception('no width given', 100);

                if(isset($options[mdWebOptions::HEIGHT])) $height = $options[mdWebOptions::HEIGHT];
                else $height = null; //throw new Exception('no height given', 101);

                $values = array($width, $height);

                break;
            case mdWebCodes::PERSPECTIVE:

                throw new Exception('operation not implemented yet', 102);

                break;
            case mdWebCodes::ORIGINAL:

                break;
            case mdWebCodes::ROUND_CORNERS:

                if(isset($options[mdWebOptions::ANGLE_ROUND]))
									$angle = $options[mdWebOptions::ANGLE_ROUND];
								else
									$angle = 50;
								
								$values = array($angle);                    
                break;
            case mdWebCodes::CROP:
            
                if (isset($options[mdWebOptions::WIDTH])) $width = $options[mdWebOptions::WIDTH];
                else throw new Exception('no width given', 100);

                if(isset($options[mdWebOptions::HEIGHT])) $height = $options[mdWebOptions::HEIGHT] ;
                else throw new Exception('no height given', 101);
                    
                $top = ((isset($options[mdWebOptions::TOP])) ? $options[mdWebOptions::TOP] : 0);
                $left = ((isset($options[mdWebOptions::LEFT])) ? $options[mdWebOptions::LEFT] : 0);
                $gravity = ((isset($options[mdWebOptions::GRAVITY])) ? $options[mdWebOptions::GRAVITY] : mdMagickGravity::None);
                
                $values = array($width, $height, $top, $left, $gravity);
                
                break;
            default:
                    throw new Exception('operation not implemented yet', 102);
                break;
        }
        return $values;
    }

}
