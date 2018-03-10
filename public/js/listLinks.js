$(document).ready(function () {

    const modalTag = $('#modalTag');
    const modalEdit = $('#modalEdit');
    const allModal = $('.modal');
    const closeModal = $('.closeModal');

    scrollTags();

    $('.click').mouseover(function (callback) {
        $('#' + $(this).data('share')).fadeIn("fast");
    });
    $('.share').mouseleave(function (callback) {
        $(this).fadeOut("fast");
    }).mouseenter(function (callback) {
        $(this).fadeIn("fast");
    });
    $('.myLink').click(function (callback) {
        console.log($(this));
        const slugLink = $(this).data('slug');
        AjaxAddClick(slugLink);
        window.open($(this).data('link'), '_blank');
    });
    $('.myLinkPopup').click(function (callback) {
        console.log("TU CLICK");
        const size = $(this).data('size').split(',');
        MyLinkPopup($(this).data('link'), size, $(this).data('name'))
    });


    $('.addTag').click(function (callback) {
        $('.submitTag').attr('data-link', $(this).data('link'));
        modalTag.fadeIn();
        $('#newTag').focus();
        $('body').addClass('modal-open');
    });
    $('.editLink').click(function (callback) {
        const inputTitleLink = $('#titleLink');
        const inputDescLink = $('#descLink');
        const title = $('#' + $(this).data('link') + ' .name').text();
        const desc = $('#' + $(this).data('link') + ' .desc').text();
        $('.submitEdit').attr('data-link', $(this).data('slug'));
        inputTitleLink.val(title);
        inputDescLink.val(desc);
        modalEdit.fadeIn();
        inputTitleLink.focus();
        $('body').addClass('modal-open');
    });
    $(document).keyup(function (e) {
        if (e.keyCode === 27) {
            closeModal.click();
        }
    });
    closeModal.click(function (calllback) {
        allModal.fadeOut();
        $('body').removeClass('modal-open');
    });
    $('.submitEdit').click(function (callback) {
        const inputTitleLink = $('#titleLink');
        const inputDescLink = $('#descLink');
        const slugLink = $(this).data('link');
        const data = {
            "title": inputTitleLink.val(),
            "desc": inputDescLink.val()
        };

        AjaxUpdateLink(slugLink, data);
        location.reload();

    });

    $('.submitTag').click(function (calllback) {
        const inputValue = $('#newTag').val();
        const slugLink = $(this).data('link');
        if (inputValue !== "") {
            console.log("NEW TAG");
            AjaxUrl(slugLink, inputValue);

        }
        location.reload();

    });

    $('.deleteLink').click(function (callback) {
        console.log("delete link");
        const slugLink = $(this).data('link');
        AjaxDeleteLink(slugLink);
        location.reload();
    })

    $('.changeView').click(function (callback) {

        $('#' + $(this).data("link") + ' .desc').toggle();
        $('#' + $(this).data("link") + ' .tags').toggle();
    })

});

/* $('.content').hover(function (callback) {
     const idDiv = $(this)[0].id;
     $("#" + idDiv + " .tags").animate({
         scrollTop: 0
     });
     scrollTags();
 })*/

function MyLinkPopup(url, size, name) {
    width = size[0];
    height = size[1];
    if (window.innerWidth) {
        var left = (window.innerWidth - width) / 2;
        var top = (window.innerHeight - height) / 2;
    }
    else {
        var left = (document.body.clientWidth - width) / 2;
        var top = (document.body.clientHeight - height) / 2;
    }
    window.open(url, name, 'menubar=no, scrollbars=no, top=' + top + ', left=' + left + ', width=' + width + ', height=' + height + '');
}


function scrollTags() {
    $('.tags').stop().animate({
        scrollTop: 500
    }, 5000, function (callback) {
        console.log("END SCOLL");
        $( ".push" ).animate({
            opacity: 0.25,
            height: "toggle"
        }, 5000, function() {
            // Animation complete.
        });

    });
}

function AjaxUrl(slug, tag) {
    return $.ajax({
        type: 'POST',
        url: "?route=addTagToLink",
        dataType: 'json',
        timeout: 5000,
        data: {
            slug: slug,
            tag: tag
        },
        success: function (response) {
            return response
        },
        error: function () {
            return "Erreur"
        }
    })
}

function AjaxAddClick(slug) {
    return $.ajax({
        type: 'POST',
        url: "?route=addClick",
        dataType: 'json',
        timeout: 5000,
        data: {
            slug: slug
        }
    })
}

function AjaxDeleteLink(slug) {
    return $.ajax({
        type: 'POST',
        url: "?route=deleteLink",
        dataType: 'json',
        timeout: 5000,
        data: {
            slug: slug,
        },
        success: function (response) {
            return response
        },
        error: function () {
            return "Erreur"
        }
    })
}

function AjaxUpdateLink(slug, data) {
    return $.ajax({
        type: 'POST',
        url: "?route=updateLink",
        dataType: 'json',
        timeout: 5000,
        data: {
            slug: slug,
            data: data
        },
        success: function (response) {
            return response
        },
        error: function () {
            return "Erreur"
        }
    })
}

function AjaxDeleteTagToLink(slug, data) {
    return $.ajax({
        type: 'POST',
        url: "?route=updateLink",
        dataType: 'json',
        timeout: 5000,
        data: {
            slug: slug,
            data: data
        },
        success: function (response) {
            return response
        },
        error: function () {
            return "Erreur"
        }
    })
}
