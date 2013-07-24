function getR() {
    var re = /[a-z]/;
    re.bar = 'foo';
    return re;
}

var a = getR();
var b = getR();
console.log(a === b);
b.bar = 'test';
console.log(a.bar, b.bar);