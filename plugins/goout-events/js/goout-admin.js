console.log('PLUGIN BACKEND SCRIPT');

(function($) {
    'use strict';
    var pagenow = window.pagenow || '';
    var arrowsSet = false;

    // Check if user has already changed sorting
    if (document.cookie.indexOf('sortingChanged=1') === -1) {
        arrowsSet = true;
    }

    if (pagenow === 'edit-dates') {
        $(document).ready(function() {
            if (!arrowsSet) {
                var defaultSortColumn = $('th.column-date_time');
                var originalSortColumn = $('th.column-date');
                defaultSortColumn.removeClass('sorted asc desc');
                originalSortColumn.removeClass('sorted asc desc');
                originalSortColumn.addClass('sortable');
                if (defaultSortColumn.length && originalSortColumn.length) {
                    defaultSortColumn.addClass('sorted asc');
                    // Set cookie to indicate initial sorting
                    document.cookie = 'sortingChanged=1';
                }
            }
        });
    }
})(jQuery);
