<?php
class sfWeather
{
    protected
        $url = 'http://xoap.weather.com/weather/local/',
        $cityCode = null,
        $unit = 'm',
        $forecast = 0,
        $partnerID = null,
        $licenseKey = null;
        
    public function __construct($cityCode)
    {
        $this->cityCode = $cityCode;
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
        $ret.= $this->cityCode . '?prod=xoap&link=xoap&';
        $ret.= 'cc=*&';
        $ret.= 'dayf=' . $this->forecast . '&';
        $ret.= 'unit=' . $this->unit . '&';
        $ret.= 'par=' . sfConfig::get('app_weather_partner') . '&';
        $ret.= 'key=' . sfConfig::get('app_weather_licence');

        return $ret;
    }
    
    public function retrieve()
    {
        $cache = new sfFileCache(array('cache_dir' => sfConfig::get('sf_config_cache_dir')));
        
        //if(!$cache->has('sfWeatherPlugin'))
        //{
            $xml = new sfXmlToArray();
            $xmlContentArray = $xml->parse(file_get_contents($this->buildUrlRequest()));
            
            $xmlContentArray = $xmlContentArray['weather'];
            $xmlContentArray = $this->array_remove_key($xmlContentArray, 'lnks');
            
            $cache->set('sfWeatherPlugin', serialize($xmlContentArray), 900); // 15 minutes of cache
            
            return $xmlContentArray;
	    //}
	    //else
	    //{
            //return unserialize($cache->get('sfWeatherPlugin'));
	    //}       
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
?>