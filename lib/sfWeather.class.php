<?php

class sfWeather
{
  protected
    $url = 'http://xoap.weather.com/weather/local/',
    $lookup_url = 'http://xoap.weather.com/search/search?where=%s',
    $today_url = '<a href="http://www.weather.com/weather/today/%s">%s</a>',
    $cityCode = null,
    $unit = 'm',
    $forecast = 5,
    $partnerID = null,
    $licenseKey = null,
    $errorMessage = null,
    $hasError = false;    

  public function __construct($cityCode)
  {
    $this->cityCode = $cityCode;
  }

  public function hasError()
  {
    return $this->hasError;
  }

  public function getErrorMessage()
  {
    return $this->errorMessage;
  }
    
  public function setUnit($unit)
  {
    switch($unit)
      {
      case 'f':
	$this->unit = 's';
       
      default:
	$this->unit = 'm';
      }
  }
    
  public function setForecast($nbdays)
  {
    if(is_numeric($nbdays))
      {
	$this->forecast = $nbdays;
      }
    else
      {
	throw new InvalidArgumentException('The forecast must be numeric');
      }
  }
    
  public function buildUrlRequest()
  {
    $ret = $this->url;
    $ret.= urlencode($this->cityCode) . '?prod=xoap&link=xoap&';
    $ret.= 'cc=*&';
    $ret.= 'dayf=' . $this->forecast . '&';
    $ret.= 'unit=' . $this->unit . '&';
    $ret.= 'par=' . sfConfig::get('app_weather_partner') . '&';
    $ret.= 'key=' . sfConfig::get('app_weather_licence');

    return $ret;
  }

  public function lookupName($name, $empty_message, $full_info = true)
  {
    $result = array();
    $url = sprintf($this->lookup_url,$name);

    $b = new sfWebBrowser();
    $b->get($url);

    if ($b->responseIsError())
      {
	$result['error'] = sprintf('weather.com returned an error (%s)',$b->getResponseCode());
	return $result;
      }

    $res = $b->getResponseXml();

    //full info for use in sfWeather autocompleter, otherwise must use standard autocompleter from sfFormExtraPlugin
    if($full_info)
      {
	foreach($res as $element)
	  {
	    $href = sprintf($this->today_url,$element['id'],$element['id']);
	    $result[(string)$element['id']] = array('value'=>(string)$element,'display'=>(string)$element .' => '.$href);
	  }
	if(count($result) == 0)
	  {
	    $result['LOOKUP_ERROR'] = array('value'=>$empty_message,'display'=>$empty_message);
	  }
      }
    else
      {
	foreach($res as $element)
	  {
	    $result[(string)$element['id']] = (string)$element;
	  }
	if(count($result) == 0)
	  {
	    $result['LOOKUP_ERROR'] = $empty_message;
	  }
      }

    return $result;
  }
    
  public function retrieve()
  {
    $cache = new sfFileCache(array('cache_dir' => sfConfig::get('sf_config_cache_dir')));
   
    if(!$cache->has('sfWeatherPlugin_'.$this->cityCode))
      {
	$xml = new sfXmlToArray();
	$xmlContentArray = array();

	$b = new sfWebBrowser();
	$b->get($this->buildUrlRequest());

	if ($b->responseIsError())
	  {
	    $this->hasError = true;
	    $this->errorMessage = $b->getResponseCode();
	 
	    return $xmlContentArray;
	  }

	$xmlContentArray = $xml->parse($b->getResponseText());
     
	if(count($xmlContentArray) == 0) 
	  {
	    $this->hasError = true;
	    $this->errorMessage = 'unknown error';
	    return $xmlContentArray;
	  }		
     
	if(isset($xmlContentArray['weather']))
	  {
	    $xmlContentArray = $xmlContentArray['weather'];
	  }
	else if(isset($xmlContentArray['error']))
	  {
	    $xmlContentArray = $xmlContentArray['error'];
	 
	    $this->hasError = true;
	    $this->errorMessage = $xmlContentArray['err'];
	  }
   
	$xmlContentArray = $this->array_remove_key($xmlContentArray, 'lnks');
     
	$cache->set('sfWeatherPlugin_'.$this->cityCode, serialize($xmlContentArray), 900); // 15 minutes of cache
     
	return $xmlContentArray;
      }
    else
      {
	return unserialize($cache->get('sfWeatherPlugin_'.$this->cityCode));
      }   
  }
 
  protected function array_remove_key($array, $key)
  {
    $output = array();
   
    foreach($array as $k => $v)
      {
	if ( $key != $k )
	  {
	    $output[$k] = $v;
	  }
      }
   
    return $output;
  }
}