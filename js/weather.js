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
            base.weather = base.$el.find('li');
            setInterval(base.weatherForecast, 1000 * 60 * 10);
            base.weatherForecast();
        };

        base.weatherForecast = function () {
            $.get(
                base.ajaxurl,
                {'action': 'wp_chilean_financial_indicators', 'data': {'widget': base.widget}}).done(function (data) {
                base.data = data;
                base.draw();
            });
        };

        base.draw = function () {
            base.weather.html(base.data);
        }

        // Run initializer
        base.init();
    };


    $.fn.chileanWeather = function () {
        return this.each(function () {
            (new $.chileanWeather(this));
        });
    };



})(jQuery);

jQuery(document).ready(function () {
    jQuery('.WP_Widget_Chilean_Weather_Indicators').chileanWeather();
});
