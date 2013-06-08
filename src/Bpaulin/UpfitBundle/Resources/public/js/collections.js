(function($)
{
    $.fn.collectionForm=function(options)
    {
        //On dÃ©finit nos parametres par défaut
        var defauts=
        {
            "addTagLink" : '<a href="#" class="add__link">Add an item</a>',
            "delTagLink" : '<a href="#">delete this item</a>',
            "sortable" : true,
            "positionField" : 'input:first',
            "sortLink" : '<a href="#">sort</a>',
        };

        parametres = $.extend(defauts, options);

        var $addTagLink = $(parametres["addTagLink"]);
        var $newLinkLi = $('<div></div>').append($addTagLink);

        return this.each(function()
        {
            function addTagForm(collectionHolder, $newLinkLi)
            {
                // Get the data-prototype explained earlier
                var prototype = collectionHolder.data('prototype');

                // get the new index
                var index = collectionHolder.data('index');

                // Replace '__name__' in the prototype's HTML to
                // instead be a number based on how many items we have
                var newForm = prototype.replace(/__name__/g, index);

                // increase the index with one for the next item
                collectionHolder.data('index', index + 1);

                // Display the form in the page in an li, before the "Add a tag" link li
                var $newFormLi = $('<div class="collection-item"></div>').append(newForm);
                collectionHolder.append($newFormLi);
                $newFormLi.find(parametres["positionField"]).val(index);
                addTagFormDeleteLink($newFormLi);
            }

            function addTagFormDeleteLink($tagFormLi)
            {
                if ($(parametres["sortable"])) {
                    var $sortFormA = $(parametres["sortLink"]);
                    $tagFormLi.find('.form-inline').prepend($sortFormA);
                }

                var $removeFormA = $(parametres["delTagLink"]);
                $tagFormLi.find('.form-inline').append($removeFormA);

                $removeFormA.on('click', function(e) {
                    // prevent the link from creating a "#" on the URL
                    e.preventDefault();

                    // remove the li for the tag form
                    $tagFormLi.remove();
                    reorder(collectionHolder);
                });
            }

            function reorder(collectionHolder) {
                collectionHolder.find('div.collection-item div.form-inline').each(function( index ) {
                    $(this).find(parametres["positionField"]).val(index);
                });
            }

            var collectionHolder = $(this);

            if (parametres['sortable']) {
                $(this).sortable({
                    cursor: "move",
                    update: function( event, ui ) {reorder($(this))},
                    handle: ".label-sort",
                    placeholder: "placeholder"
                });
            }

            $(this).find('div.collection-item').each(function() {
                addTagFormDeleteLink($($(this)));
            });

            // add the "add a tag" anchor and li to the tags ul
            $(this).parent().append($newLinkLi);

            // count the current form inputs we have (e.g. 2), use that as the new
            // index when inserting a new item (e.g. 2)
            $(this) .data('index', collectionHolder.find('div.collection-item div.form-inline').length);

            $addTagLink.on('click', function(e) {
                // prevent the link from creating a "#" on the URL
                e.preventDefault();

                // add a new tag form (see next code block)
                addTagForm(collectionHolder , $newLinkLi);
            });
        });
    };
})(jQuery);
