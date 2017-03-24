(function($){
  Drupal.behaviors.FlagRefreshView = {
    attach: function(context, settings) {
      var viewName = 'autocamioane-rulate';

      // Your views should be Ajax enabled,
      // then it will be available as a property of the Drupal object
      // like so...
      if (typeof Drupal.views != 'undefined') {
        var instances = Drupal.views.instances;
        // then you simply need to iterate thru the various
        // views instances name to find your views
        $.each( instances , function getInstance( index, element){
          yourViews = '.view-dom-id-' + element.settings.view_dom_id;
        });
      }
      
      filters = 'form[id^="views-exposed-form-autocamioane-rulate-page"]';
      
      $('.flag-link-toggle', context).click( function(){
        if($(filters).length && $('body.not-front').length) {
          //$(filters).submit();
          $(filters + ' .views-submit-button .form-submit').click();
        } else if(typeof yourViews !== 'undefined'){
          $(yourViews).trigger('RefreshView'); 
        }
      }); 
    }
  }; 
})(jQuery);