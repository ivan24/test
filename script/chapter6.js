/*inherits 6*/
/*

function Article() {
    this.tagas = ['js','css'];
}

var article = new Article();
function BlogPost() {

}
BlogPost.prototype = article;
var blog = new BlogPost();
function StaticPage() {
    Article.call(this);
}
var page = new StaticPage();
console.log(article, blog, page);
console.log(article.tagas, blog.tagas, page.tagas);
blog.tagas.push('php');
page.tagas.push('java');
console.log(article.tagas, blog.tagas, page.tagas);
*/

/*
function Parent(name) {
    this.name = name || "Adam";
}
Parent.prototype.say = function () {
    return this.name;
};

function Child(name) {
    Parent.apply(this, arguments);
}
var kid = new Child('Patric');
var parent = new Parent('Ivan');
console.log(kid.name);
//console.log(kid.say());
console.log(typeof kid.say);
*/

function Cat() {
    this.legs = 4;
    this.say = function () {return 'mmmmm'};
}
function Bird() {
    this.wings = 2;
    this.fly = true;
}
function CatWings() {
    Cat.apply(this);
    Bird.apply(this);
}

var jane = new CatWings();
console.dir(jane);
