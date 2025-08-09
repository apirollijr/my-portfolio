(function($){
  wp.customize('hero_headline', function(value) {
    value.bind(function(to) { $('.hero__title').html(to); });
  });
  wp.customize('hero_subheadline', function(value) {
    value.bind(function(to) { $('.hero__subtitle').html(to); });
  });
  wp.customize('hero_button_text', function(value) {
    value.bind(function(to) { $('.hero__button').text(to); });
  });
})(jQuery);
