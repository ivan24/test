/*inherits 6*/
/*
function inherit(C, P) {
    var F = function () {};
    F.prototype = P.prototype;
    C.prototype = new F();
    C.uber = P.prototype;
    C.prototype.constructor = C;
}
function Parent() {}
function Child() {}
inherit(Child, Parent);
var kid = new Child();
console.log(kid.constructor.name);*/


/*
var one = {
    name: 'one',
    say: function (greet) {
        console.log(greet + " " + this.name);
    }
};
one.say('Hi,');

var ivan = {
    name: 'Ivan'
};
one.say.call(ivan, ['hello']);
var test= function(thisArg) {
    debugger;
    var fn = this,
        slice = Array.prototype.slice,
        args = slice.call(arguments, 1);
    return function () {
        return fn.apply(thisArg, args.concat(slice.call(arguments)));
    };
}

var ts = test(ivan);
*/
