(function($){
	
	srPageChooserWidget = {
		
		elInput: 'input.srwidgetformpagechooser',
		elSpan: 'span.srwidgetformpagechooser',
		elButton: 'button.srwidgetformpagechooser',
		elIframeContainer: 'div.srwidgetformpagechooser-iframe-container',
		elIframe: 'iframe.srwidgetformpagechooser',
		elButtonDone: 'button.srwidgetformpagechooser-done',
		elPUrl: 'p.srwidgetformpagechooser-url',
		elWidgetContainer: 'div.srwidgetformpagechooser-container',
		
		isEnabled: false,
		
		frameId: 'sr-page-chooser-frame',
		
		currentContainer: null,
		
		init: function() {
			$(srPageChooserWidget.elButton).click(function(){
				srPageChooserWidget.clickHandler(this)
			});
			
			if (!$(srPageChooserWidget.elIframe).length) {
				srPageChooserWidget.createIframe();
			}
		},
		
		createIframe: function(){
			var ifrm = $('<div class="srwidgetformpagechooser-iframe-container" style="display:none"><iframe id="iPageChooser" frameborder="0" scrolling="no" src="" class="srwidgetformpagechooser"></iframe><p class="srwidgetformpagechooser-url"></p><button class="srwidgetformpagechooser-done" type="button">Ok</button></div>');
			ifrm.appendTo('body');
		},
		
		clickHandler: function(elButton) {
			// so we can have multiple page choosers on one page or one slot
			srPageChooserWidget.currentContainer = $(elButton).parents(srPageChooserWidget.elWidgetContainer);
			var c = $(srPageChooserWidget.elIframeContainer);
			var i = $(srPageChooserWidget.elIframe)
			var viewportHeight = window.innerHeight ? window.innerHeight : $(window).height();
			var h = viewportHeight/2 - c.height()/2;
			var w = $(window).width()/2 - c.width()/2;
			var offset = {
				top: $(window).scrollTop(), //h > 0 ? h : 0,
				left: w > 0 ? w : 0
			}
			if (i.attr('src') === '') {
				i.attr('src', sPageChooserWidgetUrl);
			}	
			c.css(offset).show();
			c.find(srPageChooserWidget.elButtonDone).click(function(){
				srPageChooserWidget.doneHandler(this)
			})
			return false;
		},
		
		doneHandler: function(elButtonDone) {
			$(srPageChooserWidget.elIframeContainer).css().hide();
		},
		
		pageSelectHandler: function(pageInfo, baseUrl) {
			var url = (typeof(baseUrl) !== 'undefined' && baseUrl) ? 'http://' + baseUrl + pageInfo.slug : pageInfo.title;
			var c = srPageChooserWidget.currentContainer;
			c.find(srPageChooserWidget.elPUrl).html('<span class="title">'+pageInfo.title+'</span>'+pageInfo.slug);
			c.find(srPageChooserWidget.elInput).val(pageInfo.slug);
			c.find(srPageChooserWidget.elSpan).html('<span class="title">'+pageInfo.title+'</span>'+pageInfo.slug);
		}
		
	}
	
	PageChooserParent = {
		onPageSelect: function(pageInfo, baseUrl) {
			srPageChooserWidget.pageSelectHandler(pageInfo, baseUrl)
		}
	}

	$(document).ready(function(){
		srPageChooserWidget.init();
	});
})(jQuery);