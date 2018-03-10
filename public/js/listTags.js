$(document).ready(function () {
    $('.addBadWord').click(function (callback) {
        const name = $(this).data('name');
        const links = $(this).data('links');
        AjaxUrl(name, links);
        $(this).parent().remove()

    });
});

function AjaxUrl(tag, links) {
    return $.ajax({
        type: 'POST',
        url: "?route=addBadWord",
        dataType: 'json',
        timeout: 5000,
        data: {
            tag: tag,
            links: links
        },
        success: function (response) {
            return response
        },
        error: function () {
            return "Erreur"
        }
    })
}