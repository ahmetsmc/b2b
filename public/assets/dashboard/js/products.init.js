$(document).ready(function () {
    var variantItemContent = $('.default-variant-item').parent().html();
    var variantItem = variantItemContent.replaceAll('variant-item default-variant-item', 'variant-item');
    $('.default-variant-item').remove();

    $(document).on('click', '#createVariant', function () {
        createVariant(variantItem);
    });

    $(document).on('click', '.delete-variant', function () {
        deleteVariant($(this));
    });
});


function createVariant(defaultItem) {
    var id = 'new' + $('.variant-item').length;

    $('#productVariants').append(
        defaultItem.replaceAll(':id', id)
    );

    $('#productVariants .variant-item:last-child .price-input').inputmask({
        alias: "currency",
        groupSeparator: ".",
        decimalSeparator: ",",
        digits: 2,
        rightAlign: false,
        autoUnmask: true,
        removeMaskOnSubmit: true
    })
}

function deleteVariant(element) {
    var id = element.attr('data-id');

    if (!isNaN(parseInt(id))) {
        var action = $('meta[name="delete-variant-uri"]').attr('content').replace(':variantId', id);
        $.post(action, function (response) {
            if (response.status === true) {
                element.closest('.variant-item').remove();
                notify('success', 'Ürün varyantı başarıyla kaldırıldı');
            } else {
                notify('error', response.message);
            }
        });
    } else {
        element.closest('.variant-item').remove();
        notify('success', 'Ürün varyantı başarıyla kaldırıldı');
    }

}
