/*inherits 7*/
/*
 function Universe() {
 if (typeof Universe.instance === 'object') {
 return Universe.instance;
 }
 this.startTime = 0;
 this.bang = "Big";
 Universe.instance = this;
 }

 var uni1 = new Universe();
 var uni2 = new Universe();
 console.log(uni1 === uni2);
 function Universe() {
 var instance;
 Universe = function () {
 return instance;
 };
 Universe.prototype = this;
 instance = new Universe();
 instance.constructor = Universe;
 instance.startTime = 0;
 instance.bang = "Big";
 return instance;
 }
 Universe.prototype.nothing = true;
 var uni = new Universe();
 Universe.prototype.everything = true;
 var uni1 = new Universe();

 console.log(uni);
 console.log(uni1);
 console.log(uni === uni1);*/

/*Fabric*/
/*function CarMaker() {}
 CarMaker.prototype.drive = function () {
 console.log("Vroom, I have " + this.doors + " doors");
 };

 CarMaker.factory = function (type) {
 var constructor = type,
 newcar;
 if (typeof CarMaker[constructor] !== 'function') {
 throw {
 name: "Error",
 message: constructor + " doesn't exist"
 };
 }
 if (typeof CarMaker[constructor].prototype.drive !== 'function') {
 CarMaker[constructor].prototype = new CarMaker();
 }

 newcar = new CarMaker[constructor]();
 return newcar;
 };

 CarMaker.Compact = function () {
 this.doors = 4;
 };

 CarMaker.Convertible = function () {
 this.doors = 2;
 };

 CarMaker.SUV = function () {
 this.doors = 24;
 };

 var comp  = CarMaker.factory('Compact');
 var car2 = CarMaker.factory('Convertible');
 var car3  = CarMaker.factory('SUV');
 comp.drive();
 car2.drive();
 car3.drive();*/

/* Object*/
/*
 var o = new Object(),
 n = new Object(1),
 s = new Object('s'),
 n1 = Object(12),
 b = new Object(true);

 console.log(o,n,s,n1,b);
 */

/*iterator */
/*
 var agg = (function () {
 var index = 0,
 data = [1, 2, 3, 4, 5],
 length = data.length;
 return {
 next: function () {
 var element;
 if (!this.hasNext()) {
 return null;
 }
 element = data[index];
 index  = index + 2;
 return element;
 },
 hasNext: function () {
 return index < length;
 },
 current: function () {
 return data[index];
 },
 rewind: function () {
 index = 0;
 }
 };
 }());
 while (agg.hasNext()) {
 console.log(agg.current());
 console.log(agg.next());
 }
 agg.rewind();
 console.log(agg.current());*/

/* Decorator */
/*function Sale(price) {
 this.price = price || 100;
 }
 Sale.prototype.getPrice = function () {
 return this.price;
 };
 Sale.decorators = {};
 Sale.decorators.fedTax = {
 getPrice: function () {
 var price = this.uber.getPrice();
 price += price * 5 / 100;
 return price;
 }
 };
 Sale.decorators.money = {
 getPrice: function () {
 return "$" + this.uber.getPrice().toFixed(2);
 }
 };


 Sale.prototype.decorate = function (decorator) {
 var F = function () {},
 overrides = this.constructor.decorators[decorator],
 i,
 newObj;
 F.prototype = this;
 newObj = new F();
 newObj.uber = F.prototype;
 for (i in overrides) {
 if (overrides.hasOwnProperty(i)) {
 newObj[i] = overrides[i];
 }
 }
 return newObj;
 };
 var sale = new Sale(121);
 fedTax = sale.decorate('fedTax');
 money = fedTax.decorate('money');
 console.log(money.getPrice());
 */
/* Decorator wia list*/

/*
 function Sale(price) {
 this.price = price || 100;
 this.decorates_list = [];
 }

 Sale.decorates = {};

 Sale.decorates.fedTax = {
 getPrice: function (price) {
 return price + price * 5 / 100;
 }
 };
 Sale.decorates.money = {
 getPrice: function (price) {
 return "$" + price;
 }
 };

 Sale.prototype.decorate = function (decorator) {
 this.decorates_list.push(decorator);
 };


 Sale.prototype.getPrice = function () {
 var price = this.price,
 i,
 max = this.decorates_list.length,
 name;
 for (i = 0; i < max; i += 1) {
 name = this.decorates_list[i];
 price = Sale.decorates[name].getPrice(price);
 }
 return price;
 };

 var sale = new Sale(1200);
 sale.decorate('fedTax');
 sale.decorate('money');
 console.log(sale.getPrice());
 */

/*Strategy*/
/*

var data = {
    fistName: 'Super',
    lastName: "Man",
    age: "unknow",
    username: "o_O"
};
var validator = {
    types: {},
    messages: [],
    config: {},
    validate: function (data) {
        var i, msg, type, checker, resultOk;
        this.messages = [];
        for (i in data) {
            if (data.hasOwnProperty(i)) {
                type = this.config[i];
                checker = this.types[type];
                if (!type) {
                    continue;
                }
                if (!checker) {
                    throw {
                        name: "ValidationError",
                        message: "No hanler to validation type" + type
                    };
                }

                resultOk = checker.validate(data[i]);
                if (!resultOk) {
                    msg = "Invalid value for " + i + ", " + checker.message;
                    this.messages.push(msg);
                }
            }
        }
        return this.hasErrors();
    },
    hasErrors: function () {
        return this.messages.length !== 0;
    }
};

validator.config = {
    firstName: 'isNotEmpty',
    age: 'isNumber',
    username: 'isAlphaNum'
};
validator.types.isNotEmpty = {
    validate: function (value) {
        return value !== "";
    },
    message: 'is empty'
};

validator.types.isNumber = {
    validate: function (value) {
        return !isNaN(value);
    },
    message: 'is not a number'
};

validator.types.isAlphaNum = {
    validate: function (value) {
        return !/[^a-z0-9]/i.test(value);
    },
    message: 'is not a alpha or Num'
};

validator.validate(data);
if (validator.hasErrors()) {
    console.log(validator.messages.join("\n"));
}
*/