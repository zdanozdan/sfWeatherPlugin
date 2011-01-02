<?php

class sfValidatorWeatherCode extends sfValidatorBase
{
  const CITY_CODE_REGEX = '/[a-zA-Z0-9:]+/';

  protected function configure($options = array(), $messages = array())
  {
    $this->setMessage('invalid', 'City with code "%city_code%" could not be found in weather.com database');
  }

  /**
   * @see sfValidatorBase
   */
  protected function doClean($value)
  {
    $w = new sfWeather($value);
    $w->retrieve();
    
    if($w->hasError() == false)
    {
      return $value;
    }

    throw new sfValidatorError($this, 'invalid',array('city_code'=>$value));
  }
}