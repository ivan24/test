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
            queryString[pair[0]] = [ queryString[pair[0]], pair[1] ];
            // If third or later entry with this name
        } else {
            queryString[pair[0]].push(pair[1]);
        }
    }
    return queryString;
};


$(".drop").click(function () {
    var base = $(this),
        nextUl = base.nextAll("ul"),
        position = '-11px 0';

    if (nextUl.css('display') === 'none') {
        nextUl.slideDown(400);
    } else {
        nextUl.slideUp(400);
        position = "0 0";
    }
    base.css({'background-position': position});
});

$("#expose").on('click', function () {
    var base = $(this),
        isExpose = (base.text() == "Раскрыть"),
        tree = $(".ul-treeFree.ul-dropFree").find("ul"),
        buttonMsg = 'Закрыть',
        position = "-11px 0";

    if (isExpose) {
        tree.slideDown(400);
    } else {
        buttonMsg ='Раскрыть';
        position = "0 0";
        tree.slideUp(400);
    }
    tree.parents("li").children("div.drop").css({'background-position': position});
    base.text(buttonMsg);
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
        var text = $(this).clone().children('').remove().end().text();
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
