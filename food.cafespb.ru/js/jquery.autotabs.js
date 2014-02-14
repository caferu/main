/**
 * Autotabs from fieldsets.
 *
 * <script type="text/javascript">
 *     $(function () {
 *         $('#tabs').fieldsetTabs();
 *     });
 * </script>
 *
 * <div id="tabs">
 *     <fieldset>
 *         <legend>tab1</legend>
 *             ...
 *     </fieldset>
 *
 *     <fieldset>
 *         <legend>tab2</legend>
 *             ...
 *     </fieldset>
 * </div>
 */
(function($) {
    $.fn.fieldsetTabs = function() {
        this.each(function() {
            var tabs = $(this);
            var tabsHtml = '<div class="tabs-content"><ul class="tabs">';
            var tabsIndexes = new Array;
            var tabErrors = 0;

            tabs.addClass('menu-tabs-wrapper');
            tabs.find('fieldset').each(function(index) {
                tabsIndexes.push(index);

                $(this).attr('id', 'tab_content_' + index).attr('class', 'tab-content');
                if (index > 0) {
                    $(this).attr('style', 'display:none;');
                }

                var legend = $(this).find('legend');
                if (index == 0) {
                    tabsHtml += '<li class="tab_li active">';
                } else {
                    tabsHtml += '<li class="tab_li">';
                }

                tabsHtml += '<a href="#tab' + index + '" id="tab_li_' + index + '">' + legend.text();
                tabErrors = $('#tab_content_' + index + ' div.row div.errorMessage').length;
                if (tabErrors > 0) {
                    tabsHtml += ' <span class="label important">' + tabErrors + '</span>';
                }
                tabsHtml += '</a>';

                tabsHtml += '</li>';
                legend.remove();
            });

            tabsHtml += '</ul></div><div class="cb"></div>';

            tabs.prepend(tabsHtml);

            $(tabsIndexes).each(function(index) {
                $('#tab_li_' + index).click(function() {
                    $.fn.fieldsetTabSelect(index);
                });
            });

            var hash = window.location.hash;
            if (hash != '') {
                $.fn.fieldsetTabSelect(parseInt(hash.match(/\d+/)[0]));
            }
        });
    }

    $.fn.fieldsetTabSelect = function(index) {
        $('.tab_li').removeClass('active');
        $('#tab_li_' + index).parent('li').addClass('active');
        $('.tab-content').hide();
        $('#tab_content_' + index).show();
    }
})(jQuery);
