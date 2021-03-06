jQuery(function($){
    "use strict";
    $(document).ready(function(){
        if ($("#templaza-column-breadcrumb-block").length){
            if ($('.templaza-item-heading').length) {
                $("#templaza-column-breadcrumb-block").append($('.templaza-item-heading'));
            }
        }
        if ($('.has-content-area').length) {
            let colReg = /col-lg-(.+)/i,
                contentColumn = $('.has-content-area > .templaza-content-column'),
                colContent = colReg.exec($('.has-content-area > .templaza-content-column').attr('class')),
                content_column = parseInt(colContent[1]);
            $('.has-content-area').find('>.templaza-column').each(function (i, el) {
                if ($(el).html().trim() === '') {

                    let colNum = colReg.exec($(el).attr('class'));
                    if (colNum !== null) {
                        content_column    +=  parseInt(colNum[1]);
                        contentColumn.addClass('col-lg-'+content_column);
                    }
                    $(el).remove();
                }
            });
        }
    });
});