/*! http://mths.be/placeholder v1.8.5 by @mathias */
(function(g,a,$){var f='placeholder' in a.createElement('input'),b='placeholder' in a.createElement('textarea');if(f&&b){$.fn.placeholder=function(){return this};$.fn.placeholder.input=$.fn.placeholder.textarea=true}else{$.fn.placeholder=function(){return this.filter((f?'textarea':':input')+'[placeholder]').bind('focus.placeholder',c).bind('blur.placeholder',e).trigger('blur.placeholder').end()};$.fn.placeholder.input=f;$.fn.placeholder.textarea=b;$(function(){$('form').bind('submit.placeholder',function(){var h=$('.placeholder',this).each(c);setTimeout(function(){h.each(e)},10)})});$(g).bind('unload.placeholder',function(){$('.placeholder').val('')})}function d(i){var h={},j=/^jQuery\d+$/;$.each(i.attributes,function(l,k){if(k.specified&&!j.test(k.name)){h[k.name]=k.value}});return h}function c(){var h=$(this);if(h.val()===h.attr('placeholder')&&h.hasClass('placeholder')){if(h.data('placeholder-password')){h.hide().next().show().focus().attr('id',h.removeAttr('id').data('placeholder-id'))}else{h.val('').removeClass('placeholder')}}}function e(){var l,k=$(this),h=k,j=this.id;if(k.val()===''){if(k.is(':password')){if(!k.data('placeholder-textinput')){try{l=k.clone().attr({type:'text'})}catch(i){l=$('<input>').attr($.extend(d(this),{type:'text'}))}l.removeAttr('name').data('placeholder-password',true).data('placeholder-id',j).bind('focus.placeholder',c);k.data('placeholder-textinput',l).data('placeholder-id',j).before(l)}k=k.removeAttr('id').hide().prev().attr('id',j).show()}k.addClass('placeholder').val(k.attr('placeholder'))}else{k.removeClass('placeholder')}}}(this,document,jQuery));

  $.fn.ifExists = function(callback) {
    if(!this.length) {
      return;
    }

    callback.apply($(this));
    return this;
  };


  // tabs plugin
  $.fn.tabs = function() {
    function Tabs(elem) {
      this.elem = $(elem);
      this.panels = this.elem.find(".panel");
      this.navs = this.elem.children("ul").find("li");
      this.selectedIndex = this.navs.filter(".selected").index();
      this.init();
    }

    Tabs.prototype = {
      init: function() {
        this.elem.delegate(".nav a", "click", $.proxy(this.click, this));
        this._update();
      },

      click: function(event) {
        var li = $(event.currentTarget).parent();
        this.selectedIndex = li.index();
        this._update();
        event.preventDefault();
      },

      _update: function() {
        this._updatePanels();
        this._updateNav();
      },

      _updateNav: function() {
        this.navs.removeClass("selected").eq(this.selectedIndex).addClass("selected");
      },

      _updatePanels: function() {
        this.panels.hide().eq(this.selectedIndex).show();
      }
    };

    return this.each(function(i, elem){
      new Tabs(elem);
    });
  };

  $('li.selected a').children().filter(':last-child').attr('src',base_url + 'assets/images/selected-thumb-118x66.png');
  $('li.selected a').mouseover(function(){
	  $(this).children().filter(':last-child').attr('src',base_url + 'assets/images/selected-rollover-118x66.png');
  }).mouseout(function(){
	  $(this).children().filter(':last-child').attr('src',base_url + 'assets/images/selected-thumb-118x66.png');
  });

  var app = {
    init: function() {

      // global tooltip options
      $.fn.tooltip.defaults = {
        offsetX: 10,
        offsetY: 10,
        delay: 100
      };

      // carousel opts
      var opts = {
        onScrollEnd: function(data) {
          var pagination = this.container.find("li.pages span");
          pagination.removeClass("on").eq(data.page - 1).addClass("on");
        }
      };

      // html5 placeholder shim
      $("input, textarea").placeholder();
      
      // init tooltips
      $(".thumb[title]").tooltip();

      // carousels
      $("#content .carousel").carousel(opts);
      $("#sidebar-right .carousel, .tabs .carousel").carousel($.extend(true, {}, opts, {
        itemsPerTransition: 1
      }));

      // tabs
     
          $(".tabs").ifExists(function(){
            this.tabs();
          });
      

      // 5 star rating
      $("#rating-active").ifExists(function(){
        this.raty({
          path: base_url + "assets/images/",
          starOn: "star-on.gif",
          starOff: "star-off.gif",
          width: 91,
          start: rating,
          hintList: lang_ratings_text.split(',')
        });
      });

	  // filters dropdown
      $(".filters").ifExists(function(){
        this.children().dropdown();
      });

      // make submit button links work.
      $("form a.submit").bind("click", function(event){
        event.preventDefault();
        $(this).closest("form").submit();
      });


      // fix width of player tabs across translations.
      $("#player-tabs").ifExists(function(){
        var lis = this.find(".nav li");
        var totalwidth = lis.parent().outerWidth();
        var width = 0;
        
        lis.slice(0, 2).each(function(){
          width += $(this).outerWidth(true);
        });

        lis.last().width(totalwidth - width - 1);
      });

      // init some moar junk
      app.collapsableNav.init();
      app.sharePanel.init();
    },
    // re-bindings for the ajax video grids
    ajaxComplete: function() {
      $("#content .grid .thumb[title]").tooltip();
    }
    
  };

  // sidebar navigation
  app.collapsableNav = {
    init: function() {
      var elem = this.elem = $("#sidebar-left");
      elem.find("> li:has(ul) > a").bind("click", $.proxy(this.toggle, this));
    },

    toggle: function(event) {
      event.preventDefault();
      var target = $(event.currentTarget);
      var menu = target.next();
      var li = target.parent().toggleClass("active");
      menu[ li.hasClass("active") ? "show" : "hide" ]();
      this.closeOthers(menu);
    },

    closeOthers: function(not) {
      this.elem.find("ul").not(not).hide().closest("li").removeClass("active");
    }
  };


  // share panel thing
  app.sharePanel = {
    init: function(){
      this.panel = $("#share-panel");
      $("#player-container").delegate(".button.arrow", "click", $.proxy(this.click, this));
    },

    click: function(event) {
      event.preventDefault();
      var target = $(event.currentTarget).toggleClass("active");
      this.panel[ target.hasClass("active") ? "slideDown" : "slideUp" ](100);
    }
  };

  app.overlay = (function(){
    var overlay, grid;

    function show() {
      grid = $("#content .grid");
      overlay = $(".grid-overlay");

      var pos = grid.position();

      overlay.width(grid.width()).height(grid.height()).css({
        left: pos.left,
        top: pos.top + 10
      });

      overlay.show();
    }

    return {
      show: show
    }
  })();

 $(document).ready(function () { 
  app.init();
});


