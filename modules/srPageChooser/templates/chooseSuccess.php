<?php use_helper('a') ?>
<?php $treeData = isset($treeData) ? $sf_data->getRaw('treeData') : null ?>

<?php sfContext::getInstance()->getResponse()->addJavascript('/apostrophePlugin/js/jsTree/_lib/css.js') ?>
<?php sfContext::getInstance()->getResponse()->addJavascript('/apostrophePlugin/js/jsTree/source/tree_component.js') ?>
<?php sfContext::getInstance()->getResponse()->addStylesheet('/apostrophePlugin/js/jsTree/source/tree_component.css') ?>

<style type="text/css">
body {
  background: #fff none;
}
p, li {
  font-size: 11px;
  font-family: Verdana, Arial, Helvetica, sans-serif;
}
</style>

<div id="page-chooser-page-tree-container">

	<div id="tree"></div>
	
</div>

<script type="text/javascript">
var PageChooser = {
  
  treeData: <?php echo json_encode($treeData) ?>,
  
  baseUrl: false,
  
  extractPageInfo: function (targetId, node) {
    if (typeof(node) == 'undefined') {
      var node = PageChooser.treeData;
    }
    var pageInfo = null;

    if (node.attributes.id === targetId) {
      return { slug: node.slug, id: PageChooser.parseId(node.attributes.id), title: node.data };
    } else if (typeof(node.children) == 'undefined') {
      return null;
    } else {
      for (var index in node.children) {
        var pageInfo = PageChooser.extractPageInfo(targetId, node.children[index])
        if (pageInfo !== null) {
          return pageInfo;
        }
      }
    }
    return pageInfo;
  },
  
  parseId: function(treeId) {
    return treeId.split('-').pop();
  }
  
};

$(function() {
  $('#tree').tree({
    data: {
      type: 'json',
      <?php // Supports multiple roots so we have to specify a list ?>
      json: [ PageChooser.treeData ]
    },
		ui: {
			theme_path: "/apostrophePlugin/js/jsTree/source/themes/",
      theme_name: "punk",
			context: false
		},
    rules: {
      // Turn off most operations as we're only here to reorg the tree.
      // Allowing renames and deletes here is an interesting thought but
      // there's back end stuff that must exist for that.
      renameable: false,
      deletable: false,
      creatable: false,
      draggable: 'none',
      dragrules: 'all'
    },
    callback: {
      // move completed (TYPE is BELOW|ABOVE|INSIDE)
      onselect: function(node, refNode, type, treeObj, rb)
      {
        var pageInfo = PageChooser.extractPageInfo(node.id);
        
        try {
          var parentOnSelect = window.parent.PageChooserParent.onPageSelect;
          parentOnSelect(pageInfo, PageChooser.baseUrl);
        } catch (e) {
          if ( ! $('p#url').length) {
            $('<p id="url">Page: <strong></strong></p>').appendTo('body');
          }
          $('p#url').children('strong').text(pageInfo.title);
        }
      }
    }  
  });
});
</script>
