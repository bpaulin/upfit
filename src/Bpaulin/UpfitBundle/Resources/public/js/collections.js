(function($) {
    $.fn.sf2FormCollection=function(options)
    {

        var container = $(this);

        /** Load params */
        var defauts=
        {
            'addItem': '<a href="#">Add an item</a>',
            'removeItem': '',
            'tokenIndex': '__NAME__'
        };
        params = $.extend(defauts, options);

        /** Move Original items */
        items = $('<div class="sf2fc-items"></div>');
        container.children('*').each( function() {
            item = $('<div class="sf2fc-item"></div>');
            $(this).detach().appendTo(item);
            item.appendTo(items);
        })
        items.appendTo(container);
        container.data('index', items.contents().length);

        /** RemoveElement */
        if (params['removeItem'] != '') {
            container.find('.sf2fc-items').children('*').each(function () {
                link = $(params['removeItem'])
                link.addClass('sf2fc-remove');
                $(this).append(link);
                link.click(function() {
                    $(this).parent().remove();
                });
            })
        };

        /** AddElement */
        var containerAddElement = $("<div class='sf2fc-add'></div>");
        var addElement = $(params['addItem']);
        addElement.appendTo(containerAddElement);
        containerAddElement.appendTo($(this));

        /** Click on AddElement */
        containerAddElement.on('click', function(e) {
            e.preventDefault();
            var prototype = container.data('prototype');
            var index = container.data('index');
            var re = new RegExp(params['tokenIndex'], 'g');
            prototype = prototype.replace(re, index);
            item = $('<div class="sf2fc-item"></div>');
            item.append(prototype)

            link = $(params['removeItem'])
            link.addClass('sf2fc-remove');
            link.click(function() {
                $(this).parent().remove();
            });
            item.append(link);

            container.find('.sf2fc-items').append(item);

            container.data('index', index+1);
        });

        /** return */
        return $(this);
    };
})(jQuery);
