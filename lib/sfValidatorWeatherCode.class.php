<?php

class sfValidatorWeatherCode extends sfValidatorBase
{
  protected function configure($options = array(), $messages = array())
  {
    $this->setMessage('invalid', 'City with code "%address%" could not be found in weather.com database');
  }

  /**
   * @see sfValidatorBase
   */
  protected function doClean($value)
  {
    $w = new sfWeather($value);
    if(count($w->retrieve()))
      {
	return $value;
      }

    throw new sfValidatorError($this, 'invalid',array('city_code'=>$value));
  }
}