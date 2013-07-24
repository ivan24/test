/*object 5*/

/*var myarray;
(function () {
    var astr = "[object Array]",
        toStr = Object.prototype.toString;
    function isArray(a) {
        return toStr.call(a) === astr;
    }
    function indexOf(haystack, needle) {
        var i = 0,
            max = haystack.length;
        for(;i < max; i += 1) {
            if(haystack[i] === needle) {
                return 1;
            }
        }
        return -1;
    }
    myarray = {
        isArray: isArray,
        indexOf: indexOf,
        inArray: indexOf
    };
}());
myarray.indexOf = function(){};
console.log(myarray.isArray([1]));
console.log(myarray.isArray({}));
console.log(myarray.isArray([1,0]));
console.log(myarray.isArray(["a","b"]));
console.log(myarray.indexOf(["a","b"],"a"));
console.log(myarray.indexOf(["a","b"],"x"));*/

//patern namespace
var app = app || {};
app.namespace = function (ns) {
    var parts = ns.split('.'),
        parent = app,
        i;
    if (parts[0] === 'app') {
        parts = parts.slice(1);
    }
    for (i = 0; i < parts.length; i += 1) {
        if (typeof parent[parts[i]] === "undefined") {
            parent[parts[i]] = {};
        }
        parent  = parent[parts[i]];
    }
    return parent;
};
//patern module
/*app.namespace('app.utilities.array');
app.utilities.array = (function () {
    return {
        inArray: function (needle, haystack) {
            console.log('inArray');
        },
        isArray: function (a) {
            console.log('isArray');
        }
    };
}());
app.utilities.array.inArray();*/
//