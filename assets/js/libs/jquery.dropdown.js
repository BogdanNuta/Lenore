(function($){
  var instances = [];

  function Dropdown(elem) {
    elem = this.elem = $(elem);
    this.menu = elem.children("ul");

    if(!this.menu.length) {
      return;
    }

    this.trigger = elem.children("a");
    this.isOpen = false;
    this.setMenuWidth();
    this.position();
    this.listeners();

    instances[ instances.length ] = this;
  }

  Dropdown.prototype = {
    listeners: function() {
      this.trigger.bind("click", $.proxy(this.toggle, this));
      this.menu.delegate("a", "click", $.proxy(this.close, this));
    },

    toggle: function(event) {
      event && event.preventDefault();
      this[ this.isOpen ? "close" : "open" ]();
    },

    open: function(event) {
      this.menu.slideDown(40);
      this.isOpen = true;
      this.trigger.addClass("active");
      Dropdown.closeOthers(this);
    },

    close: function() {
      this.menu.slideUp(40);
      this.isOpen = false;
      this.trigger.removeClass("active");
    },

    position: function() {
      var pos = this.trigger.parent().position();

      this.menu.css({
        top: pos.top + this.trigger.height(),
        left: pos.left
      });
    },

    setMenuWidth: function() {
      this.menu.width( this.trigger.parent().outerWidth(true) - 1 );
    }
  };

  Dropdown.closeOthers = function(exclude) {
    for(var i = -1, len = instances.length; ++i < len; ) {
      var instance = instances[i];
      instance && instance.elem !== exclude.elem && instance.close();
    }
  };

  Dropdown.closeAll = function() {
    for(var i = -1, len = instances.length; ++i < len; ) {
      var instance = instances[i];
      instance && instance.close();
    }
  };

  $(document).bind("click", function(event) {
    var target = $(event.target);

    if(target.closest(".dropdown").length === 0) {
      Dropdown.closeAll();
    }
  });

  $.fn.dropdown = function() {
    return this.each(function(){
      $.data(this, "dropdown", new Dropdown(this));
    });
  };

})(jQuery);
