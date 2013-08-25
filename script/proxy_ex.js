var $ = function (id) {
    return document.getElementById(id);
};

var http = {
    makeRequest: function (ids, callback) {
        var url = 'http://query.yahooapis.com/v1/public/yql?q=',
            sql = 'select * from music.video.id where ids IN ("%ID%")',
            format = "format=json",
            handler = "callback=" + callback,
            script = document.createElement('script');

        sql = sql.replace('%ID%', ids.join('","'));
        sql = encodeURIComponent(sql);

        url += sql + '&' + format + '&' + handler;
        script.src = url;

        document.body.appendChild(script);
    }
};

var proxy = {
    ids: [],
    delay: 50,
    timeout: null,
    callback: null,
    context: null,
    makeRequest: function (id, callback, context) {

        // add to the queue
        this.ids.push(id);

        this.callback = callback;
        this.context = context;

        // set up timeout
        if (!this.timeout) {
            this.timeout = setTimeout(function () {
                proxy.flush();
            }, this.delay);
        }
    },
    flush: function () {

        http.makeRequest(this.ids, "proxy.handler");

        // clear timeout and queue
        this.timeout = null;
        this.ids = [];

    },
    handler: function (data) {
        var i, max;

        // single video
        if (parseInt(data.query.count, 10) === 1) {
            proxy.callback.call(proxy.context, data.query.results.Video);
            return;
        }

// multiple videos
        for (i = 0, max = data.query.results.Video.length; i < max; i += 1) {
            proxy.callback.call(proxy.context, data.query.results.Video[i]);
        }
    }
};


var videos = {
    getPlayer: function (id) {
        return '' +
            '<object width="400" height="255" id="uvp_fop" allowFullScreen="true">' +
            '<param name="movie" value="http://d.yimg.com/m/up/fop/embedflv/swf/fop.swf"\/>' +
            '<param name="flashVars" value="id=v' + id + '&amp;eID=1301797&amp;lang=us&amp;enableFullScreen=0&amp;shareEnable=1"\/>' +
            '<param name="wmode" value="transparent"\/>' +
            '<embed ' +
            'height="255" ' +
            'width="400" ' +
            'id="uvp_fop" ' +
            'allowFullScreen="true" ' +
            'src="http://d.yimg.com/m/up/fop/embedflv/swf/fop.swf" ' +
            'type="application/x-shockwave-flash" ' +
            'flashvars="id=v' + id + '&amp;eID=1301797&amp;lang=us&amp;ympsc=4195329&amp;enableFullScreen=1&amp;shareEnable=1"' +
            '\/>' +
            '<\/object>';
    },

    updateList: function (data) {
        var id,
            html = '',
            info;

        if (data.query) {
            data = data.query.results.Video;
        }
        id = data.id;
        html += '<img src="' + data.Image[0].url + '" width="50" \/>';
        html += '<h2>' + data.title + '<\/h2>';
        html += '<p>' + data.copyrightYear + ', ' + data.label + '<\/p>';
        if (data.Album) {
            html += '<p>Album: ' + data.Album.Release.title + ', ' + data.Album.Release.releaseYear + '<br \/>';
        }
        html += '<p><a class="play" href="http://new.music.yahoo.com/videos/--' + id + '">&raquo; play<\/a><\/p>';
        info = document.createElement('div');
        info.id = "info" + id;
        info.innerHTML = html;
        $('v' + id).appendChild(info);

    },

    getInfo: function (id) {

        var info = $('info' + id);

        if (!info) {
            proxy.makeRequest(id, videos.updateList, videos);
            return;
        }

        if (info.style.display === "none") {
            info.style.display = '';
        } else {
            info.style.display = 'none';
        }
    }
};


$('vids').onclick = function (e) {
    var src, id;

    e = e || window.event;
    src = e.target || e.srcElement;

    if (src.nodeName.toUpperCase() !== "A") {
        return;
    }

    if (typeof e.preventDefault === "function") {
        e.preventDefault();
    }
    e.returnValue = false;

    id = src.href.split('--')[1];

    if (src.className === "play") {
        src.parentNode.innerHTML = videos.getPlayer(id);
        return;
    }

    src.parentNode.id = "v" + id;
    videos.getInfo(id);
};

$('toggle-all').onclick = function (e) {

    var hrefs,
        i,
        max,
        id;

    hrefs = $('vids').getElementsByTagName('a');
    for (i = 0, max = hrefs.length; i < max; i += 1) {
        // skip play links
        if (hrefs[i].className === "play") {
            continue;
        }
        // skip unchecked
        if (!hrefs[i].parentNode.firstChild.checked) {
            continue;
        }

        id = hrefs[i].href.split('--')[1];
        hrefs[i].parentNode.id = "v" + id;
        videos.getInfo(id);
    }
};

