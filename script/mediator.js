function Player(name) {
    this.points = 0;
    this.name = name;
}

Player.prototype.play = function () {
    this.points += 1;
    mediator.played();
};

var scoreboard = {
    element: document.getElementById('results'),
    update: function (score) {
        var i, msg = '';
        for (i in score) {
            if (score.hasOwnProperty(i)) {
                msg += '<p><b>' + i + '</b> ';
                msg += score[i];
                msg += '</p>';
            }
        }
        this.element.innerHTML = msg;
    }
};
var timeLeft = {
    update: function (time) {
        var sec = document.getElementById('sec');
        sec.innerHTML = time;
    }
};

var mediator = {
    players: {},
    time: 0,
    setup: function () {
        var players = this.players;
        players.home = new Player('Home');
        players.guest = new Player('Guest');
    },
    played: function () {
        var players = this.players,
            score = {
                Home: players.home.points,
                Guest: players.guest.points
            };
        console.log(score);
        scoreboard.update(score);
    },
    keypress: function (e) {
        e = e || window.event;
        if (e.which === 49) {
            mediator.players.home.play();
            return;
        }

        if (e.which === 48) {
            mediator.players.guest.play();
            return;
        }
    },
    left: function () {
        this.time += 1;
        var update = function (time) {
            timeLeft.update(time);
        };
        update(this.time);
    }
};

mediator.setup();
window.onkeypress = mediator.keypress;
var interval = setInterval(function () {
    mediator.left();
}, 1000);

setTimeout(function () {
    window.onkeypress = null;
    alert('Game Over');
    clearInterval(interval);
}, 30000);