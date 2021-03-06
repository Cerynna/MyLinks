$(document).on('mouseover', '.click', function () {
    $('#' + $(this).data('share')).fadeIn("fast");
}).on('mouseleave', '.share', function () {
    $(this).fadeOut("fast");
}).on('mouseenter', '.share', function () {
    $(this).fadeIn("fast");
}).on('click', '.myLink', function () {
    const slugLink = $(this).data('slug');
    AjaxAddClick(slugLink);
    window.open($(this).data('link'), '_blank');
}).on('click', '.myLinkPopup', function () {
    const size = $(this).data('size').split(',');
    MyLinkPopup($(this).data('link'), size, $(this).data('name'))
}).on('click', '#filtres .submit', function () {
    $( "#filtres" ).submit();
});


$(document).ready(function () {

    const modalTag = $('#modalTag');
    const modalEdit = $('#modalEdit');
    const allModal = $('.modal');
    const closeModal = $('.closeModal');

    scrollTags();


    $('.tags').mouseover(function () {
        $('body').addClass('modal-open');
    }).mouseleave(function () {
        $('body').removeClass('modal-open');
    });
    $('.desc').mouseover(function () {
        $('body').addClass('modal-open');
    }).mouseleave(function () {
        $('body').removeClass('modal-open');
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


    $('.submitEdit').click(function () {
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
            AjaxUrl(slugLink, inputValue);
        }
        location.reload();

    });

    /*$('.addTag').click(function () {
        $('.submitTag').attr('data-link', $(this).data('link'));
        modalTag.fadeIn();
        $('#newTag').focus();
        $('body').addClass('modal-open');
    });
    $('.editLink').click(function () {
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
    $('.deleteLink').click(function () {
        const slugLink = $(this).data('link');
        AjaxDeleteLink(slugLink);
        location.reload();
    });*/
    $('.changeView').click(function () {
        const idDiv = $(this).data("link");
        $('#' + idDiv + ' .desc').toggle();
        $('#' + idDiv + ' .tags').toggle();
        $('#' + idDiv + ' .name').css("max-height", "34px");
        $('#' + idDiv + ' .deleteTagToLink').get().forEach(function (tag) {
            $(tag).removeClass('hidden')
        })
    });

    $('#listLinks').on('click', '.changeView', function () {
        const idDiv = $(this).data("link");
        $('#link_' + idDiv + ' .desc').toggle();
        $('#link_' + idDiv + ' .tags').toggle();
        $('#link_' + idDiv + ' .name').css("max-height", "34px");
        $('#link_' + idDiv + ' .deleteTagToLink').get().forEach(function (tag) {
            $(tag).removeClass('hidden')
        });
        return false;
    }).on('click', '.deleteLink', function () {

        const slugLink = $(this).data('link');
        AjaxDeleteLink(slugLink);
        location.reload();
        return false;
    }).on('click', '.addTag', function () {
        $('.submitTag').attr('data-link', $(this).data('link'));
        modalTag.fadeIn();
        $('#newTag').focus();
        $('body').addClass('modal-open');
        return false;
    }).on('click', '.editLink', function () {
        const inputTitleLink = $('#titleLink');
        const inputDescLink = $('#descLink');
        console.log($(this).data('link'));
        const title = $('#link_' + $(this).data('link') + ' .name').text();
        const desc = $('#link_' + $(this).data('link') + ' .desc').text();
        $('.submitEdit').attr('data-link', $(this).data('slug'));
        inputTitleLink.val(title);
        inputDescLink.val(desc);
        modalEdit.fadeIn();
        inputTitleLink.focus();
        $('body').addClass('modal-open');
        return false;
    });


    $('.content').hover(function () {
        const idDiv = $(this)[0].id;
        $('#' + idDiv + ' .desc').removeAttr('style');
        $('#' + idDiv + ' .tags').removeAttr('style');
        $('#' + idDiv + ' .name').removeAttr('style');
        $('#' + idDiv + ' .deleteTagToLink').get().forEach(function (tag) {
            $(tag).addClass('hidden')
        })
    });
    $(window).scroll(function () {

        if ($(window).scrollTop() + $(window).height() >= $(document).height() - 1) {

            let actualScroll = $('body').data("scroll");
            AjaxGetListLinks(actualScroll + 1);
            $('body').data('scroll', actualScroll + 12);
            $(".push").stop().animate({
                opacity: 0.25,
                height: "hide"
            }, 5000, function () {
                // Animation complete.
            });
        }
    });

});


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
    $(".push").stop().animate({
        opacity: 0.25,
        height: "hide"
    }, 5000, function () {
        // Animation complete.
    });
}

function trameLinks(link, offset) {
    html = '<div class="col col-md-4 col-xs-1">\n' +
        '                <div class="myCard"\n' +
        '                     style="background-size: cover;\n';
    if (link.meta !== null && link.meta.image.length !== undefined && link.meta.image.length !== 0) {
        html += '                             background: #FFF url(\'' + link.meta.image + '\') center no-repeat;">\n';
    } else {
        html += '                             background: #FFF center no-repeat;">\n';
    }


    html += '                    <div class="content" id="link_' + offset + '">\n' +
        '                        <div class="click" data-share="share_' + offset + '">\n';
    if (link.click === undefined) {
        html += '0'
    }
    else {
        html += link.click;
    }
    html += '                        </div>\n' +
        '                        <div class="share" id="share_' + offset + '">\n' +
        '                            <div class="share_link myLinkPopup"\n' +
        '                                 data-size="580,680"\n' +
        '                                 data-name="Share Facebook"\n' +
        '                                 data-link="https://www.facebook.com/sharer/sharer.php?u=' + encodeURI(link.link) + '">\n' +
        '                                <i class="fab fa-facebook-square icons"></i>\n' +
        '                            </div>\n' +
        '                            <div class="share_link myLinkPopup"\n' +
        '                                 data-size="580,300"\n' +
        '                                 data-name="Share Twitter"\n' +
        '                                 data-link="https://twitter.com/home?status=' + encodeURI(link.link) + '">\n' +
        '                                <i class="fab fa-twitter-square icons"></i>\n' +
        '                            </div>\n' +
        '                            <div class="share_link myLinkPopup"\n' +
        '                                 data-size="580,530"\n' +
        '                                 data-name="Share Linkedin"\n' +
        '                                 data-link="https://www.linkedin.com/shareArticle?mini=true&url=' + encodeURI(link.link) + '&title=' + encodeURI(link.nom) + '&summary=&source=">\n' +
        '                                <i class="fab fa-linkedin icons "></i>\n' +
        '                            </div>\n' +
        '                        </div>\n' +
        '                        <div class="name">' + link.nom + '</div>\n' +
        '                        <div class="desc myLink"\n' +
        '                             data-slug="' + encodeURI(link.slug) + '"\n' +
        '                             data-link="' + encodeURI(link.link) + '">';
    if (link.meta !== null) {
        html += link.meta.description;
    }
    html += '                        </div>\n' +
        '                        <div class="tags">\n';
    /*'                            <div class="push"></div>\n';*/
    if (link.tags !== null && link.tags.length !== undefined && link.tags.length !== 0) {

        link.tags.forEach(function (tag) {
            html += '                                <span class="tag">\n' +
                '                                    <div class="deleteTagToLink hidden"\n' +
                '                                         data-tag="' + tag + '"\n' +
                '                                         data-slug="' + encodeURI(link.link) + '">\n' +
                '                                            <i class="fas fa-times-circle icons-mini"></i>\n' +
                '                                    </div>\n' +
                '                                    ' + tag + '\n' +
                '                                </span>\n';
        });
    }


    html += '                        </div>\n' +
        '                        <div class="tools">\n' +
        '                            <div class="row">\n' +
        '                                <div class="col button changeView"\n' +
        '                                     data-link="' + offset + '">\n' +
        '                                    <i class="fas fa-tags icons"></i>\n' +
        '                                </div>\n' +
        '                                <div class="col button addTag"\n' +
        '                                     data-link="' + encodeURI(link.slug) + '"\n' +
        '                                     data-name="' + encodeURI(link.nom) + '">\n' +
        '                                    <i class="fas fa-plus-square icons"></i>\n' +
        '                                </div>\n' +
        '                                <div class="col">\n' +
        '\n' +
        '                                </div>\n' +
        '\n' +
        '                                <!--\n' +
        '                                Pouvoir changer la miniature soit via API google pour le screen\n' +
        '                                Soit utilisé Croppie avec image perso\n' +
        '                                <i class="fas fa-image icons"></i>-->\n' +
        '\n' +
        '                                <div class="col button editLink"\n' +
        '                                     data-link="' + offset + '"\n' +
        '                                     data-slug="' + encodeURI(link.slug) + '">\n' +
        '                                    <i class="fas fa-pen-square icons"></i>\n' +
        '                                </div>\n' +
        '                                <div class="col button deleteLink"\n' +
        '                                     data-link="' + encodeURI(link.slug) + '">\n' +
        '                                    <i class="fas fa-trash-alt icons"></i>\n' +
        '                                </div>\n' +
        '                            </div>\n' +
        '                        </div>\n' +
        '                    </div>\n' +
        '\n' +
        '                </div>\n' +
        '            </div>'
    return html;
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

function AjaxGetListLinks(offset) {
    $.ajax({
        type: 'POST',
        url: "?route=getLinks",
        dataType: 'json',
        timeout: 5000,
        data: {
            offset: offset,
        },
        success: function (response) {
            i = 1;
            response.forEach(function (link) {
                $("#listLinks").append(trameLinks(link, offset + i));
                i++;
            })

        }
    });

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
        url: "?route=deleteTagToLink",
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
