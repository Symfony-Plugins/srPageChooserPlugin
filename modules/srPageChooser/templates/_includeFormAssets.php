<?php if ($form): ?>
<script type="text/javascript" charset="utf-8">
  (function($){
    $(document).ready(function(){
      <?php // To prevent a set of assets from being loaded once for each widget on the page. ?>
      <?php // Tt would be even better to explicitly check if the script is loaded, in case it ?>
      <?php // was first loaded by something else than this partial ?>
      if (typeof _includedFormAssets == 'undefined') {
        _includedFormAssets = {
          js: [],
          css: []
        }
      }
      
  <?php // load javascripts ?>
  <?php $javascripts = $form->getJavaScripts() ?>
  <?php if (count($javascripts)): ?>
    <?php foreach ($javascripts as &$js): ?>
      <?php $js = javascript_path($js) ?>
    <?php endforeach ?>
      var scripts = ['<?php echo join($javascripts, "','") ?>'];
        $.each(scripts, function(i,e){
          if ($.inArray(e, _includedFormAssets.js) === -1) {
            $.getScript(e);
            _includedFormAssets.js.push(e);            
          }
        })
  <?php endif ?>
  <?php // load stylesheets ?>
  <?php $stylesheets = $form->getStylesheets() ?>
  <?php if (count($stylesheets)): ?>
    <?php foreach ($stylesheets as &$css): ?>
      <?php $css = stylesheet_path($css) ?>
    <?php endforeach ?>
      var stylesheets = ['<?php echo join($stylesheets, "','") ?>'];
      $.each(stylesheets, function(i,e){
        if ($.inArray(e, _includedFormAssets.css) === -1) {
          $('<link>').appendTo('head').attr({
            rel: 'stylesheet',
            type: 'text/css',
            href: e
          });
          _includedFormAssets.css.push(e);            
        }
      })
    })
  <?php endif ?>
  })(jQuery);
</script>
<?php endif ?>