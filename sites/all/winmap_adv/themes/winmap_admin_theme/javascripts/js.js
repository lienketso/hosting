/**
 * Created by VDP on 11/04/2017.
 */

(function ($, AdminLTE) {
    $(document).ready(function () {
        if ($(".sidebar-menu .treeview .treeview-menu a.active").size()) {
            $(".sidebar-menu .treeview .treeview-menu a.active").parents('.treeview-menu').prev().trigger('click');
        }
        if($('#edit-field-c-adv-html-code .form-textarea-wrapper').find('textarea.wysiwyg')) {
            $_chenge_element = $('#edit-field-c-adv-html-code .form-textarea-wrapper').find('textarea.wysiwyg').parent();
            if ($_chenge_element) {
                $_chenge_element.each(function (index,element) {
                    $(element).bind("DOMNodeInserted",function(){
                        // var edit_body = $(this).find('#edit-field-ctype-facilitie-form-des-und-0-value_ifr').contents().find("body");
                        // $(edit_body).css('background', '#272822');
                        // var edit_body = $(this).find('#edit-field-c-adv-html-code-und-0-value_ifr').contents().find("body");
                        // $(edit_body).css('background', '#272822');
                        //
                        var edit_body = $(this).find('.mceIframeContainer > iframe').contents().find("body");
                        $(edit_body).css('background', '#272822');

                    });
                })
            }
        }

        $('#edit-field-c-adv-html-code .mceIframeContainer > iframe').each(function (index , el) {
            var edit_body  = $(el).contents().find("body");
            $(edit_body).css('background', '#272822');
        });

    });

    window.onload = function(e){
        // var edit_body = $("#edit-field-c-adv-html-code-und-0-value_ifr").contents().find("body");
        // $(edit_body).css('background', '#272822');

        $('#edit-field-c-adv-html-code .mceIframeContainer > iframe').each(function (index , el) {
            var edit_body  = $(el).contents().find("body");
            $(edit_body).css('background', '#272822');
        });
    };
})(jQuery, jQuery.AdminLTE);
