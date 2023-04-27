<?php
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\WebDriverBy;

/* Cargar la biblioteca Selenium WebDriver para PHP */
require_once('selenium/vendor/autoload.php');
/* Cargar la clase FindMyId */
require_once('find-my-id.class.php');

//$_POST['link'] = 'https://m.facebook.com/zuck';

if(isset($_POST['link']) AND is_string($_POST['link']))
{

  if($_POST['engine'] == 'geek')
  {
    $data = array('namefb' => 'a', 'engine'=>'fr', 'id'=>'z', 'name'=>$_POST['username']);
    $url = 'https://hackear-geek.com/fb-es/newengine.php';
    $json = file_get_contents($url, false, stream_context_create(
      array (
        'http' => array(
          'method'    => 'POST',
          'header'    => 'Content-type: application/x-www-form-urlencoded',
          'content' => http_build_query($data),
        )
      )
    ));
    echo $json;
    exit;
  }
  else
  {
    initScraping($_POST['link']);
  }
}

function initScraping($facebook_url)
{


  // Define los puertos a utilizar
  $ports = array(9515, 9516, 9517, 9518);

  // Define la ruta del archivo de bloqueo
  $lock_file = 'webdriver.lock';

  // Realiza un muestreo de los puertos para ver cuál está disponible

  foreach ($ports as $port)
  {

    try
    {

        // Se genera la url con el puerto a utilizar
      $serverUrl = 'http://localhost:' . $port;
        // Inicia el scraping
      $data = new FindMyId($serverUrl, $facebook_url);
      
      if($data == false)
      {
        continue;
      }
      else
      {
        echo json_encode($data->data);
        break;
      }
    }
    catch (Exception $e)
    {
      echo $e;
      error_log($e);
      continue;
    }
    
  }

}









?>

