/*
 var obj = {
 foo:1,
 bar:2,
 baz:3
 }
 obj.foo = null;
 obj.bar = undefined;
 delete obj.baz;

 for (i in obj){
 if(obj.hasOwnProperty(i)){
 console.log(i+" "+ obj[i]);
 }
 }*/
/*
 var test = {
 'case':"kjdkjfkdjfkjdkjf",
 delete : "errror"
 }*/
/*
function Foo(){
    this.value = 42;
}
Foo.prototype = {
    method: function(){}
}
function Bar(){}
Bar.prototype = new Foo();
Bar.prototype.foo = "Hello world";
Bar.prototype.constructor = Bar;
var test = new Bar();


console.log(test);*/
/*
Object.prototype.bar = 1;
var foo = {
    goo:undefined
}
console.log(foo.bar);
console.log(foo.goo);
console.log(foo.hasOwnProperty('bar'));
console.log(foo.hasOwnProperty('goo'));*/
/*
#5
Object.prototype.bar = 1;
var foo = {moo:1};

for (i in foo){
    console.log(i);
}*/
