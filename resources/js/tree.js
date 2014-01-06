$(".drop").click(function() {
    var base = $(this),
        nextUl = base.nextAll("ul");

    if (nextUl.css('display') === 'none') {
        nextUl.slideDown(400);
        base.css({'background-position':"-11px 0"});
    } else {
        nextUl.slideUp(400);
        base.css({'background-position':"0 0"});
    }
});
$(".ul-dropfree").find("ul").slideUp(400).parents("li").children("div.drop").css({'background-position':"0 0"});

$("#expose").on('click', function () {
    var base = $(this),
        isExpose = (base.text() == "Раскрыть");
    if (isExpose) {
        base.text('Закрыть');
        $(".ul-treefree.ul-dropfree").find("ul").slideDown(400).parents("li").children("div.drop").css({'background-position': "-11px 0"});
    } else {
        base.text('Раскрыть');
        $(".ul-treefree.ul-dropfree").find("ul").slideUp(400).parents("li").children("div.drop").css({'background-position': "0 0"});
    }
});


$("#button-execute").on('click', function () {
    var base = $(this);
    if (base.hasClass('active')) {
        base.text('Смотреть Код');
        base.removeClass('active')
    } else {
        base.text('Запустить');
        base.addClass('active')
    }
});
$('.dev-file').on('click', function () {
    var base = this,
        overlay = document.getElementById('overlay'),
        namespace = [],
        data = {
            'type': "POST",
            'url': '/ajax.php',
            dataType: "html"
        },
        execButton = $("#button-execute").hasClass('active');

    namespace.push($(base).text())
    $(base).parents('li').each(function(){
        var text = $(this).clone().children().remove().end().text();
        if(text !== '') {
            namespace.unshift (text)
        }
    });
    if (!overlay) {
        $("body").append("<div id='overlay'></div>");
    }
    if(!execButton) {
        data.data = { class: namespace.join('\\') }
    } else {
        data.data = {file: namespace.join('/')}
    }
    $.ajax(data).done(function (msg) {
            $("#dev-insert-code").html(msg);
        }).always(function () {
            setTimeout(function () {
                $('#overlay').remove();
            }, 400);
        });
});
