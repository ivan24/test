/*function js*/
function foo() {
 alert('global foo');
 }

 function bar() {
 alert('global bar');
 }
 function hostMe() {
 "use strict";
 console.log(typeof foo);
 console.log(typeof bar);
 foo();
 bar();
 function foo() {
 alert('local foo');
 }
 var bar = function() {
 alert('local bar');
 };

 }
 hostMe();
 var myapp = {};
 myapp.color = "green";
 myapp.paint = function (node) {
 console.log(this);
 node.color = this.color;
 };
 var findNode = function (obj,callback) {
 var found = {};
 if (typeof callback === "function") {
 callback.call(obj, found);
 }
 };
 findNode(myapp, myapp.paint);
 var theTimer = function () {
 console.log('500ms later...');
 };
 setInterval(theTimer, 500);
 var setup = function () {
 var count = 0;
 return function () {
 return (count += 1);
 };
 };
 var next = setup();
 console.log(next());
 console.log(next());
var scareMe = function () {
    alert('Boo');
    scareMe = function () {
        alert("Doble boo");
    };
};

scareMe();
scareMe();
scareMe();


(function (who, when, global) {
    console.log(global);
    console.log('I met ' + who + " on " + when);
}("Ivan", new Date(),this));

var myFunc = function (p, v, c) {
    console.log(arguments);
    if (!myFunc.cache[p]) {
        var i,
            result = [];
        for (i = 0; i < p; i += 1) {
            result[1] = 'test ' + i;
        }
        myFunc.cache[p] = result;
    }
    return myFunc.cache[p];
};
myFunc.cache = {};
console.time('test');
myFunc(10000000,'two','third');
console.timeEnd('test');

console.time('test1');
myFunc(10000000,'two','third');
console.timeEnd('test1');


var sayHi = function (who) {
    console.log("Hello" + (who ? ", " + who : "") + "!");
};
sayHi();
sayHi("Ivan");
sayHi.apply(null, ["hello"]);

var ivan = {
    sayHi: function (who) {
        console.log(this);
        console.log("Hello" + (who ? ", " + who : "") + "!");
    }
};
ivan.sayHi('world');
ivan.sayHi.apply(ivan, ['test']);



function add(x, y) {
    var oldx = x, oldy = y;
    if(typeof oldy === "undefined") {
        return function (newy) {
            console.log(oldx + newy);
        };
    }
    console.log(x + y);
}
add(5);

