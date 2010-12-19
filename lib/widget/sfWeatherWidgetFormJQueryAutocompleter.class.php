<?php

/**
 * sfWeatherWidgetFormJQueryAutocompleter is based on sfWidgetFormJQueryAutocompleter and represents autocompleter input widget rendered by JQuery. Extends autocompleter from sfFormExtraPlugin to support diffrent rendering of autocompleter  field
 *
 * It requires 2 extra parameters to work comparing to normal autocompleter: display and value encoded as json
 * json_encode($result['my_value'] = array('value'=>'my_value','display'=>'my value to display in autocompleter'));

 * This widget needs JQuery to work.
 *
 *
 * @package    sfWeatherPlugin
 * @subpackage sfWeatherPlugin
 * @author     Tomasz Zdanowski <tomasz@mikran.pl>
 * @version    SVN: $Id$
 */
class sfWeatherWidgetFormJQueryAutocompleter extends sfWidgetFormInput
{
  protected function configure($options = array(), $attributes = array())
  {
    $this->addRequiredOption('url');
    $this->addOption('value_callback');
    $this->addOption('config', '{ }');
    $this->addOption('display_field_name','display');
    $this->addOption('value_field_name','value');

    // this is required as it can be used as a renderer class for sfWidgetFormChoice
    $this->addOption('choices');

    parent::configure($options, $attributes);
  }

  /**
   * @param  string $name        The element name
   * @param  string $value       The date displayed in this widget
   * @param  array  $attributes  An array of HTML attributes to be merged with the default HTML attributes
   * @param  array  $errors      An array of errors for the field
   *
   * @return string An HTML tag string
   *
   * @see sfWidgetForm
   */
  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    $visibleValue = $this->getOption('value_callback') ? call_user_func($this->getOption('value_callback'), $value) : $value;
    return $this->renderTag('input', array('type' => 'hidden', 'name' => $name, 'value' => $value)).
      parent::render('autocomplete_'.$name, $visibleValue, $attributes, $errors).
      sprintf(<<<EOF
<script type="text/javascript">
  jQuery(document).ready(function() {
    jQuery("#%s")
    .autocomplete('%s', jQuery.extend({}, {
	dataType: 'json',
      parse: function(data) {
        var parsed = [];
        for (key in data) {
          parsed[parsed.length] = { data: [ data[key]['%s'], key ], value: data[key]['%s'], result: data[key]['%s'] };
        }
        return parsed;
	  }
    }, %s))
    .result(function(event, data) { jQuery("#%s").val(data[1]); });
  });
</script>
EOF
	      ,$this->generateId('autocomplete_'.$name),
	      $this->getOption('url'),
	      $this->getOption('display_field_name'),
	      $this->getOption('display_field_name'),
	      $this->getOption('value_field_name'),
	      $this->getOption('config'),
	      $this->generateId($name)
	      );
  }
}