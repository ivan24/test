/*object 5*/
/*
var obj = {
    myprop: 1,
    getProp: function () {
        return this.myprop;
    }
};
*/
/*
 function Gadget() {
 var name = 'iPod';
 this.stretch = function () {
 return name;
 };
 }
 var toy = new Gadget();
 console.log(toy.name);
 console.log(toy.stretch());*/
/*
function Gadget() {
    var specs = {
        width: 320,
        height: 480,
        color: "white"
    };
    this.getSpecs = function () {
        return specs;
    };
}
var toy = new Gadget(),
    specs = toy.getSpecs();
specs.color = "black";
console.dir(toy.getSpecs());*/
/*
var obj = {};
(function () {
    var naqme = 'secret property';
    obj = {
        getName: function () {
            return naqme;
        }
    };
}());
console.log(obj.getName(), typeof naqme);*/
/*
var obj = (function () {
    var name = 'my, oh my';
    return {
        getName: function () {
            return name;
        }
    };
}());

console.log(obj.getName(), name.length);*/
/*
function Gadget() {
    var name = 'iPod';
    this.getName = function () {
        return name;
    };
}
Gadget.prototype = (function () {
    var browser = "Mobile Webkit";
    return {
        getB: function () {
           return browser;
        }
    };
}());
Gadget.prototype.ti = function () {
    console.log('tsss');
};
var toy = new Gadget();
console.log(toy.getB());
toy.ti();*/
var app = app  || {};

app.namespace = function (ns_string) {
    var parts = ns_string.split('.'),
        parent = app,
        i;
    if (parts[0] === 'app') {
        parts = parts.slice(1);
    }
    for (i = 0; i < parts.length; i += 1) {
        if (typeof parent[parts[i]] === 'undefined') {
            parent[parts[i]] = {};
        }
        parent = parent[parts[i]];
    }
    return parent;
};

app.namespace('app.modules.array');
/*
app.modules.array = (function () {
    //private property
    var array_string = "[object Array]",
        ops = Object.prototype.toString;
    return {
        inArray: function (needle, haystack) {
            for (var i = 0, max = haystack.length; i < max; i += 1) {
                if(haystack[i] === needle) {
                    return true;
                }
            }
            return false;
        },
        isArray: function (arr) {
            return ops.call(arr) === array_string;
        }
    };
}());
var arr = app.modules.array;
console.log(arr.isArray([1]));
console.log(arr.isArray({}));
console.log(arr.isArray('dfdf'));
console.log(arr.isArray(1));
console.log(arr.isArray(true));
console.log(arr.inArray(1, [2,3,4]));
console.log(arr.inArray(2, [2,3,4]));*/

/*
app.modules.array = (function () {
    var Con;
    Con = function (o) {
        this.elements = this.toArray(o);
    };
    Con.prototype = {
        constructor: app.modules.array,
        version: "2.0",
        toArray: function (obj) {
            return 1;
        }
    };
    return Con;
}());
app.modules.array({});*/

/*var Gadget = function (price) {
    this.price = price;
};
Gadget.isShiny = function () {
    var msg = 'you bet';
    if (this instanceof Gadget) {
        msg += ', it cost $' + this.price + "!";
    }
    return msg;
};
Gadget.prototype.isShiny = function () {
    return Gadget.isShiny.call(this);
}
console.log(Gadget.isShiny());
var iphone = new Gadget(500);
console.log(iphone.isShiny());*/
/*
var Gadget = (function () {
    var counter = 0;
    return function () {
        console.log(counter += 1);
    }
}());
var g1 = new Gadget();
var g2 = new Gadget();
var g3 = new Gadget();
var g4 = new Gadget();
var g5 = new Gadget();
var g6 = new Gadget();*/
/*
var Gadget = (function () {
    var counter = 0,
        newG;
    newG = function () {
        counter += 1;
    };
    newG.prototype.getLastId = function () {
        return counter;
    };
    return newG;
}());
var a = new Gadget();
console.log(a.getLastId());
var b = new Gadget();
console.log(b.getLastId());
*/
var constant = (function () {
    var constants = {},
        ownProp = Object.prototype.hasOwnProperty,
        allowed = {
            string: 1,
            number: 1,
            boolean: 1
        },
        prefix = (Math.random() + "_").slice(2);
    return {
        set: function (name, value) {
            if (this.isDefined(name)) {
                return false;
            }
            if (!ownProp.call(allowed, typeof value)) {
                return false;
            }
            constants[prefix + name] = value;
            return true;
        },
        isDefined: function (name) {
            return ownProp.call(constants, prefix + name);
        },
        get: function (name) {
            if (this.isDefined(name)) {
                return constants[prefix+name];
            }
            return null;
        }
    };
}());
console.log(constant.isDefined('test'));
console.log(constant.set('test', '333'));
console.log(constant.get('test'));
console.log(constant.isDefined('test'));
