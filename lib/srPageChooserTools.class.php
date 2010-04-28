<?php

/**
 * Helper methods for srPageChooserPlugin.
 * 
 * @package     srPageChooserPlugin
 * @subpackage  lib
 * @author      Alexander "Spike" Brehm <ocelot@gmail.com>
 * @version     SVN: $Id: BaseActions.class.php 12534 2008-11-01 13:38:27Z Kris.Wallsmith $
 */
class srPageChooserTools
{
  static public function addSlugToTreeData(&$treeData, $hash = false)
  {
    if (!$hash)
    {
      $hash = self::getSlugHash();
    }

    foreach ($treeData as $pos => &$node)
    {    
      if (isset($node['children']) && count($node['children']))
      {
        self::addSlugToTreeData($node['children'], $hash);
      }

      // extract page id from i.e. 'tree-1'
      $id = self::getPageIdFromHtmlId($node['attributes']['id']);
      $node['slug'] = $hash[$id];
    }
    return $treeData;
  }
  
  static public function getPageIdFromHtmlId($htmlId)
  {
    $id = (int) substr($htmlId, strpos($htmlId, '-')+1);
    return $id;
  }
  
  static public function getSlugHash()
  {
    $query = Doctrine_Query::Create()->
      select("p.id, p.slug")->
      from("aPage p");
      
    $pages = $query->execute();
    
    $hash = array();
    foreach ($pages as $page)
    {
      $hash[$page->getId()] = $page->getSlug();
    }
    
    return $hash;
  }
}
