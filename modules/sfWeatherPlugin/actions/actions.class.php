<?php
/**
 * sfWeatherPlugin actions.
 *
 * @package    sfWeatherPlugin
 * @subpackage sfWeatherPlugin
 * @author     David Zeller <zellerda01@gmail.com>, Tomasz Zdanowski <tomasz@mikran.pl>
 */
class sfWeatherPluginActions extends sfActions
{
  public function setPopupMode() {}

  public function executeAutocomplete(sfWebRequest $request)
  {
    $w = new sfWeather('');
    //    $i18n = $this->getContext()->geti18n();
    $message = $this->getContext()->geti18n()->__('WEATHER_LOOKUP_FAILED_I18N');
    return $this->renderText(json_encode($w->lookupName($request->getParameter('q'),$message)));
  }

  public function executeIndex(sfWebRequest $request)
  {
    $w = new sfWeather('SZXX0022');
    $w->setForecast(5);
    
    $this->w = $w->retrieve();
  }
  
  public function executeSmall(sfWebRequest $request)
  {
    $w = new sfWeather('SZXX0022');
    $w->setForecast(5);
    
    $this->w = $w->retrieve();
  }
}
