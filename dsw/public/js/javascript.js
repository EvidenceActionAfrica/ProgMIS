

function autoColumn(num_cols, container, childItem, childClass) {

    var num_cols = num_cols,
    container = $(container),
    childItem = childItem,
    childClass = childClass;

    container.each(function() {
        var items_per_col = new Array(),
        items = $(this).find(childItem),
        min_items_per_col = Math.floor(items.length / num_cols),
        difference = items.length - (min_items_per_col * num_cols);
        for (var i = 0; i < num_cols; i++) {
            if (i < difference) {
                items_per_col[i] = min_items_per_col + 1;
            } else {
                items_per_col[i] = min_items_per_col;
            }
        }
        for (var i = 0; i < num_cols; i++) {
            $(this).append($('<ul ></ul>').addClass(childClass));
            for (var j = 0; j < items_per_col[i]; j++) {
                var pointer = 0;
                for (var k = 0; k < i; k++) {
                    pointer += items_per_col[k];
                }
                $(this).find('.' + childClass).last().append(items[j + pointer]);
            }
        }
    });        

}

