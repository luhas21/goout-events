jQuery(document).ready(function() {
    jQuery.post(ajax_object.ajax_url, {'action': 'is_user_logged_in'})
        .done(function(response) {
            if (response.trim() == '1') {
                jQuery("[data-edit-on-title-id]").each(function() {
                    jQuery(this).css("position", "relative");
                    jQuery('<a>', {"class": "edit-on-title-button", "target": "_blank", "href": "/wp-admin/post.php?action=edit&post=" + jQuery(this).attr("data-edit-on-title-id")})
                        .text('edit')
                        .appendTo(this);
                });
            }
        })
        .fail(function() {
            console.log('fail');
        });
});