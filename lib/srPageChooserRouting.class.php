<?php

/**
 * Routing rules for the srPageChooserPlugin.
 * 
 * @package     srPageChooserPlugin
 * @subpackage  routing
 * @author      Alexander "Spike" Brehm <ocelot@gmail.com>
 */
class srPageChooserRouting extends sfPatternRouting
{
  static public function listenToRoutingLoadConfigurationEvent(sfEvent $event)
  {
    $r = $event->getSubject();

    $r->prependRoute('sr_page_chooser', 
      new sfRoute('/admin/srPageChooser', 
        array('module' => 'srPageChooser', 'action' => 'choose')
      ));
  }
}
