(function ($) {

    var methods = {
        init: function (options) {
            return this.each(function () {
                var $this = $(this);
                var data = $this.data('table');

                // Если плагин ещё не проинициализирован
                if (!data) {
                    $(this).data('table', {
                        target: $this,
                        settings: options
                    });
                    console.log($this);
                    $(document).on('click', '#' + $this.attr('id') + ' tbody tr', $this, methods.click);
                }
            });
        },
        click: function (e) {
            var $this = e.data;
            $this.find("tr").removeClass('current');
            $(e.currentTarget).addClass('current');
        }
    };
    $.fn.table = function (method) {
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return methods.init.apply(this, arguments);
        } else {
            $.error('Метод с именем ' + method + ' не существует для jQuery.table');
        }
    };
})(jQuery);