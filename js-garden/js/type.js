function is(obj){
    alert(Object.prototype.toString.call(obj).slice(8,-1));

}
var foo = 'd';
alert(typeof foo !== 'undefined');
/*
is(new Array(3));
is([1,2]);
is('string');
is(new String('dfdfd'));
is(true);
is(new Boolean(false));*/
