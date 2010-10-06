<?php

/**
 * srPageChooserPlugin configuration.
 * 
 * @package     srPageChooserPlugin
 * @subpackage  config
 * @author      Alexander "Spike" Brehm <ocelot@gmail.com>
 * @version     SVN: $Id: PluginConfiguration.class.php 17207 2009-04-10 15:36:26Z Kris.Wallsmith $
 */
class srPageChooserPluginConfiguration extends sfPluginConfiguration
{
  const VERSION = '1.0.2';

  /**
   * @see sfPluginConfiguration
   */
  public function initialize()
  {
    $this->dispatcher->connect('routing.load_configuration', array('srPageChooserRouting', 'listenToRoutingLoadConfigurationEvent'));
  }
}
