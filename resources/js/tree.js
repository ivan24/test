var queryString = function () {

    var queryString = {},
        query = window.location.search.substring(1),
        vars = query.split("&");
    for (var i = 0; i < vars.length; i++) {
        var pair = vars[i].split("=");
        // If first entry with this name
        if (typeof queryString[pair[0]] === "undefined") {
            queryString[pair[0]] = pair[1];
            // If second entry with this name
        } else if (typeof queryString[pair[0]] === "string") {
            var arr = [ queryString[pair[0]], pair[1] ];
            queryString[pair[0]] = arr;
            // If third or later entry with this name
        } else {
            queryString[pair[0]].push(pair[1]);
        }
    }
    return queryString;
}


$(".drop").click(function () {
    var base = $(this),
        nextUl = base.nextAll("ul");

    if (nextUl.css('display') === 'none') {
        nextUl.slideDown(400);
        base.css({'background-position': "-11px 0"});
    } else {
        nextUl.slideUp(400);
        base.css({'background-position': "0 0"});
    }
});
$(".ul-dropfree").find("ul").slideUp(400).parents("li").children("div.drop").css({'background-position': "0 0"});

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
    var base = $(this),
        overlay = document.getElementById('overlay'),
        namespace = [base.text()],
        execButton = $("#button-execute").hasClass('active');

    base.parents('li').each(function () {
        var text = $(this).clone().children().remove().end().text();
        if (text !== '') {
            namespace.unshift(text)
        }
    });

    if (!overlay) {
        $("body").append("<div id='overlay'></div>");
    }
    $.ajax({
        type: "POST",
        url: '/ajax.php',
        data: $.extend({}, {file: namespace.join('/'), exec: execButton}, queryString()),
        dataType: "html"
    }).done(function (msg) {
            var html = msg;
            if (!execButton) {
                html = '<pre><code class="php" >' + msg + '</code></pre>'
            }
            $("#dev-insert-code").html(html);
        }).always(function () {
            setTimeout(function () {
                $('#overlay').remove();
            }, 400);
        });
});
