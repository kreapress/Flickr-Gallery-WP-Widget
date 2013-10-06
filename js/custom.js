jQuery(document).ready(function($) {
    $('.js-jflickrfeed-fetch').each(function() {
        var $this = $(this);
        
        $this.jflickrfeed({
            limit: $this.data('number'),
            qstrings: {
                id: $this.data('userid')
            },
            itemTemplate: '<div class="picture">' +
                                '<a href="{{image}}" class="add-prettyphoto"> <img src="{{image_q}}" alt="{{title}}"> <span class="img-overlay"> <span class="plus"><i class="icon-plus"></i></span> </span> </a>' +
                          '</div>'
        }, function () {
            if( jQuery.prettyPhoto ) {
                $(this).find('.add-prettyphoto').prettyPhoto();
            }
        });
    });
});