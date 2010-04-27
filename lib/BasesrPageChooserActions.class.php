<?php

/**
 * Base actions for the srPageChooserPlugin srPageChooser module.
 * 
 * @package     srPageChooserPlugin
 * @subpackage  srPageChooser
 * @author      Alexander "Spike" Brehm <ocelot@gmail.com>
 * @version     SVN: $Id: BaseActions.class.php 12534 2008-11-01 13:38:27Z Kris.Wallsmith $
 */
abstract class BasesrPageChooserActions extends sfActions
{
  /**
   * Executes index action
   *
   * @param sfRequest $request A request object
   */
   public function executeChoose(sfWebRequest $request)
   {
     // manually disable the web debug toolbar cause it screws up the small screen real estate
     sfConfig::set('sf_web_debug', false);

     if ( ! $this->getUser()->hasCredential('cms_admin'))
     {
       return 'InvalidCredentials';
     }

     $root = aPageTable::retrieveBySlug('/');

     $this->treeData = $root->getTreeJSONReadySR(false);
   }
}
