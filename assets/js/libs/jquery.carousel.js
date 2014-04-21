(function($) {

  function Carousel(container, opts) {
    container = this.container = $(container);
    this.opts = opts;
    this.ul = container.find(this.opts.carousel);
    this.items = this.ul.children("li");
    this.init();
    this.itemIndex = 0;
    this.offset = 0;
  }

  Carousel.prototype = {
    init: function() {
      $(this.container).find(this.opts.next).bind("click", $.proxy(this.next, this));
      $(this.container).find(this.opts.prev).bind("click", $.proxy(this.prev, this));
    },

    next: function(event) {
      event && event.preventDefault();
      this.itemIndex = this.itemIndex + this.opts.itemsPerTransition;
      this.animate();
    },

   /* prev: function(event) {
      event && event.preventDefault();
      this.itemIndex = this.itemIndex - this.opts.itemsPerTransition;
      this.animate();
    },*/
    
    prev: function(event) {
            event && event.preventDefault();
            this.itemIndex = (this.itemIndex || this.items.length) - this.opts.itemsPerTransition;
            this.animate();
        },

    animate: function() {
      if (this.itemIndex < 0) {
        this.itemIndex = this.items.length - 1;
      } else if (this.itemIndex > this.items.length - 1) {
        this.itemIndex = 0;
      }

      var nextItem = this.items.eq(this.itemIndex);
      var offset = nextItem.position().left * -1;

      var callback = $.proxy(function(){
        this.opts.onScrollEnd.call(this, {
          page: Math.round(this.itemIndex / this.opts.itemsPerTransition) + 1
        });
      }, this);

      this.ul.animate({
        left: offset
      }, this.opts.speed, this.opts.easing, callback);
    }
  };

  $.fn.carousel = function(opts) {
    return this.each(function() {
      opts = $.extend({}, $.fn.carousel.defaults, opts);
      $.data(this, "carousel", new Carousel(this, opts));
    });
  };

  $.fn.carousel.defaults = {
    next: ".next",
    prev: ".prev",
    carousel: ".grid",
    speed: 200,
    easing: "swing",
    itemsPerTransition: 4,
    onScrollEnd: $.noop
  };

})(jQuery);

