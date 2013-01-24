function urlArgs(){
    var args ={};
    var query = location.search.substring(1);
    var pairs = query.split('&');
    console.log(pairs);
    for (var i = 0;i<pairs.length; i++){
        var pos = pairs[i].indexOf('=');
        if(pos==-1) continue;
        var name = pairs[i].substring(0,pos);
        var value = pairs[i].substring(pos+1);
        value = encodeURIComponent(value);
        args[name] = value;
    }
    return args;
}
console.log(urlArgs());