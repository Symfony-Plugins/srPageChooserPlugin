<?php

/**
 * srWidgetFormPageChooser pops up an iframe with CMS page tree for use with links
 *
 * @package    srPageChooserPlugin
 * @subpackage widget
 * @author     Alexander "Spike" Brehm <ocelot@gmail.com>
 * @version    SVN: $$
 */
class srWidgetFormPageChooser extends sfWidgetForm
{
  
  /**
   * Constructor.
   *
   * Available options:
   *
   *  * type: The widget type
   *
   * @param array $options     An array of options
   * @param array $attributes  An array of default HTML attributes
   *
   * @see sfWidgetForm
   */
  protected function configure($options = array(), $attributes = array())
  {
    parent::configure($options, $attributes);
        
    $this->addOption('type', 'hidden');
    $this->addOption('buttonText', 'Select a Link');
  }

  /**
   * @param  string $name        The element name
   * @param  string $value       The value displayed in this widget
   * @param  array  $attributes  An array of HTML attributes to be merged with the default HTML attributes
   * @param  array  $errors      An array of errors for the field
   *
   * @return string An HTML tag string
   *
   * @see sfWidgetForm
   */
  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    $attributes = array_merge(array('span' => array(), 'input' => array(), 'button' => array()), $attributes);
    
    $spanTag = $this->renderContentTag('span', $value, array_merge(array('class' => 'srwidgetformpagechooser'), $attributes['span']));
    
    $inputTag = $this->renderTag('input', array_merge(array('type' => $this->getOption('type'), 'name' => $name, 'value' => $value, 'class' => 'srwidgetformpagechooser'), $attributes['input']));
    
    $buttonTag = $this->renderContentTag('button', $this->getOption('buttonText'), array_merge(array('class' => 'srwidgetformpagechooser', 'type' => 'button'), $attributes['button']));
    
    $iframe = self::renderIframe();
    
    return '<div class="srwidgetformpagechooser-container">' . $spanTag . $inputTag . $buttonTag . $iframe . '</div>';
  }
  
  static public function renderIframe()
  {
    $url = url_for('@sr_page_chooser');
    
    return <<<EOT
<script type="text/javascript">
var sPageChooserWidgetUrl = '$url';
</script>
EOT;
    //return '<div class="srwidgetformpagechooser-iframe-container" style="display:none"><iframe frameborder="0" scrolling="no" src="'.$url.'" class="srwidgetformpagechooser"></iframe><p class="srwidgetformpagechooser-url"></p><button class="srwidgetformpagechooser-done" type="button">Ok</button></div>';
  }
  
  /**
   * Gets the stylesheet paths associated with the widget.
   *
   * The array keys are files and values are the media names (separated by a ,):
   *
   *   array('/path/to/file.css' => 'all', '/another/file.css' => 'screen,print')
   *
   * @return array An array of stylesheet paths
   */
  public function getStylesheets()
  {
    return array('/srPageChooserPlugin/css/srPageChooserPlugin.css');
  }

  /**
   * Gets the JavaScript paths associated with the widget.
   *
   * @return array An array of JavaScript paths
   */
  public function getJavaScripts()
  {
    return array('/srPageChooserPlugin/js/srPageChooserPlugin.js');
  }
}
