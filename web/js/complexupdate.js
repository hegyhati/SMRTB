function update() {
    var xhr = new XMLHttpRequest();
    xhr.open("GET","/complex/update/"+getJobId(), true);
    xhr.setRequestHeader('Content-Type', 'application/json; charset=UTF-8');
    xhr.send("");
    xhr.onloadend = function (){
            var data=JSON.parse(xhr.response);
            var mappb=document.getElementById("map-progressbar");
            var mapprogress=""+data.mapprogress.toString()+"%";
            mappb.style.width=mapprogress;
            mappb.innerHTML = ""+data.mapdone+"/"+data.mapcount;
            var reducepb=document.getElementById("reduce-progressbar");
            var reduceprogress=""+data.reduceprogress.toString()+"%";
            reducepb.style.width=reduceprogress;
            reducepb.innerHTML = ""+data.reducedone+"/"+data.reducecount;
            
        };
    
    
    setTimeout(update, 333)
}
