"use strict";
jQuery(function($){
    if ($('.templaza-portfolio .tz-portfolio-items').length) {
        var canBeLoaded = true, // this param allows to initiate the AJAX call only if necessary
            bottomOffset = 2000; // the distance (in px) from the page bottom when you want to load more posts

        $(window).scroll(function(){
            var data = {
                'action': 'charity_portfolio_loadmore',
                'query': charity_portfolio_loadmore_params.posts,
                'page' : charity_portfolio_loadmore_params.current_page,
                'category' : charity_portfolio_loadmore_params.category
            };
            if( $(document).scrollTop() > ( $(document).height() - bottomOffset ) && canBeLoaded == true ){
                $.ajax({
                    url : charity_portfolio_loadmore_params.ajaxurl,
                    data:data,
                    type:'POST',
                    beforeSend: function( xhr ){
                        // you can also add your own preloader here
                        // you see, the AJAX call is in process, we shouldn't run it again until complete
                        canBeLoaded = false;
                    },
                    success:function(data){
                        if( data ) {
                            $('.templaza-portfolio .tz-portfolio-items').append( data ); // where to insert posts
                            canBeLoaded = true; // the ajax is completed, now we can run it again
                            charity_portfolio_loadmore_params.current_page++;
                        }else{
                            $('.templaza-loading').addClass('endpost');
                        }
                    }
                });
            }
        });
    }
});