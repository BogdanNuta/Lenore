(function($){

  function MenuItem(elem) {
    var elem = this.elem = $(elem);
    var menu = this.menu = elem.children(".subnav");
    this.panels = menu.find(".subnav-panel");
    this.isOpen = false;
    this.speed = 50;
    this.listeners();

    // show the first one by default
    this.panels.eq(0).show();
  }

  MenuItem.prototype = {
    listeners: function() {
      this.elem.bind("mouseenter", $.proxy(this.open, this));
      this.menu.delegate(".subnav-nav li", "mouseenter", $.proxy(this.toggleGrid, this));
    },

    open: function() {
      this.elem.addClass("open")
      this.menu.fadeIn(this.speed);
      this.isOpen = true;
      menu.closeOthers(this);
    },

    close: function() {
      this.elem.removeClass("open");
      this.menu.fadeOut(this.speed);
      this.isOpen = false;
    },

    isMouseInside: function(target) {
      var $target = $(target);

      if($.contains(this.menu[0], target)
        || $.contains(this.elem[0], target) 
        || $target.is(this.elem) 
        || $target.is(this.menu)
      ) {
        return true;
      }

      return false;
    },

    toggleGrid: function(event) {
      var target = $(event.currentTarget);
      this.panels.hide().eq( target.index() ).show();
    }
  };

  function Menu() {
    var elem = this.elem = $("#nav");
    var elems = this.elems = elem.children("li");
    var instances = [];

    // create item instances for each sub menu
    elems.each(function(){
      if(!$(this).children(".subnav").length) {
        return;
      }

      instances[instances.length ] = new MenuItem(this);
    });

    $(document).bind("mousemove", throttle(function(event){
      if(!(instance = getOpen())) {
        return;
      }
      
      if(instance.isMouseInside(event.target) === false) {
        instance.close();
      }
    }, 50));

    // returns the open MenuItem instance
    function getOpen() {
      for(var i = -1, len = instances.length; ++i < len; ) {
        var obj = instances[i];

        if( obj && obj.isOpen ) {
          return obj;
        }
      }
    }

    // Closes all MenuIem instances except for the one passed in.
    this.closeOthers = function(instance) {
      $.each(instances, function(i, obj){
        if(obj.elem[0] !== instance.elem[0]) {
          obj.close();
        }
      });
    };

    function throttle(fn, delay) {
      var timer = null;
      return function () {
        var context = this, args = arguments;
        clearTimeout(timer);
        timer = setTimeout(function () {
          fn.apply(context, args);
        }, delay);
      };
    }
  }

  var menu = new Menu();

})(jQuery);
