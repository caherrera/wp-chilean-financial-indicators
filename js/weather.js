(function ($) {
    $.chileanWeather = function (el) {

        var base = this;

        base.ajaxurl = window.ajaxurl || '/wp-admin/admin-ajax.php';

        // Access to jQuery and DOM versions of element
        base.$el = $(el);
        base.el = el;

        // Add a reverse reference to the DOM object
        base.$el.data("chileanWeather", base);

        base.init = function () {
            base.$el.addClass('jquery-chileanIndicators');
            base.weather= base.$el.find('>li.weather');
        };

        base.weatherForecast = function (city) {
            $.get(
                base.ajaxurl,
                {'action': 'wp_chilean_financial_indicators', 'data': {'widget': base.widget,'city':city}}).done(function (data) {
                base.data = data;
                base.draw();
            });
        };

        base.draw = function () {
            base.$box.html(base.drawList(base.members));
            base.show();
        }

        // Run initializer
        base.init();
    };


    $.fn.branches = function () {
        return this.each(function () {
            (new $.branches(this));
        });
    };

    $.fn.hideBranch = function () {
        return this.each(function () {
            var branch = $(this).data('branches');
            if (branch instanceof Object) {
                branch.hide();
            }

        });
    };

})(jQuery);
//
// if (jQuery('.pods_branch').length) {
//     jQuery('.pods_branch').branches();
//     setTimeout(function () {
//         jQuery('.pods_branch .flexslider').each(function () {
//             var $this = jQuery(this);
//             if ($this.find('li>img').length > 1) {
//                 $this.flexslider({});
//                 $this.flexslider('pause');
//             }else{
//                 $this.removeClass('flexslider');
//             }
//         });
//     }, 1000);
// }
