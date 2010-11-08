<?php
/**
 * sfweatherplugin actions.
 *
 * @package    sfWeatherPlugin
 * @subpackage sfweatherplugin
 * @author     David Zeller <zellerda01@gmail.com>
 */
class sfweatherpluginActions extends sfActions
{
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
