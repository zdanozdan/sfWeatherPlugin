<?php

class sfWeatherRouting
{
 static public function listenToRoutingLoadConfigurationEvent(sfEvent $event)
 {
   $r = $event->getSubject();
   
   // preprend our routes
   $r->prependRoute('sf_weather_autocomplete', new sfRoute('/weather/autocomplete', array('module' => 'sfWeatherPlugin', 'action' => 'autocomplete')));
 }
}