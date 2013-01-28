/*
console.log(this);*/
/*
#2
Foo ={}
Foo.method = function(){
    function test(){
        console.log(this);
    }
    test();
}
Foo.method();*/
/*
 function Counter(start){
 var count = start;
 return {
 increment: function(){
 count++
 },
 get:function(){return count}
 }
 }

 var foo = new Counter(4);
 foo.hack = function(){count=44444}
 foo.increment();
 console.log(foo.get());*/
/*
 for(var i=0;i<10;i++){
 (function(e){
 setInterval(function(){
 console.log(e);
 },1000);
 })(i);

 }*/
/*
function foo(){
    this.bla = 1;
}
foo.prototype.test = function(){
    console.log(this.bla);
}
var test = new foo();
console.log(test,{});*/
/*
function Bar(){
    return 2;
}
new Bar();
function Test(){
    this.value = 2;
    return {
        foo:3
    }
}
new Test();*/
/*
function Bar(){
    var value = 2;
    return {
        method:function(){ return value}
    }
}
Bar.prototype = {
    foo:function(){}
}
new Bar();
Bar();*/
function Foo(){
    var obj = {};
    obj.value = "bla bla";
    var private = 2;
    obj.someMethod = function(value){
        this.value = value;
    };
    obj.getPrivate = function(){
       return private;
    }
    return obj;
}
ivan = Foo();
ivan.someMethod('Class Ivan');
console.log(ivan);