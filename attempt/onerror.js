window.onerror = function(msg,url,line){
    if(onerror.num++ <onerror.max){
        alert("Error"+ msg+"\n url"+url+"\n line"+line);
    }
}
onerrr.max = 0
onerror.num = 4;