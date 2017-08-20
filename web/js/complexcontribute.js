function contribute() { 
    var xhr = new XMLHttpRequest();
    xhr.open("GET","/api/job/"+getJobId()+"/mapreduce", true);
    xhr.setRequestHeader('Content-Type', 'application/json; charset=UTF-8');
    xhr.send("");
    xhr.onloadend = function () {
        console.log(xhr.response);
        var data = JSON.parse(xhr.response);
        if(data.state<2) {
            console.log("Project not started, nothing to do");
        } else if (data.state==2) {
            console.log("Map job received");
            var table = document.getElementById("mapjobtable");
            var row = table.insertRow(-1);
            row.id="map-"+data.mapjobid;
            row.insertCell(0).innerHTML=data.mapjobid;
            row.insertCell(1).innerHTML=data.chunk;
            row.insertCell(2).innerHTML="in progress...";
            mapsolve(data);
        } else if (data.state==3) {
            console.log("Shuffling in progress, let's wait a little");
        } else if (data.state==4) {
            console.log("Reduce job received");
            var table = document.getElementById("reducejobtable");
            var row = table.insertRow(-1);
            row.id="reduce-"+data.reducejobid;
            row.insertCell(0).innerHTML=data.reducejobid;
            row.insertCell(1).innerHTML=data.reducekey;
            row.insertCell(2).innerHTML=data.values;
            row.insertCell(3).innerHTML="in progress...";
            reducesolve(data);
        } else if(data.state==5) {
            console.log("Job finished, redirect to statistics");
        }
    };
}



function mapsolve(data) {    
    var results=map(data.chunk);
    var json = {
        jobid : data.jobid, 
        mapjobid : data.mapjobid, 
        worker : 'me',
        results : results
        };
    document.getElementById("map-"+data.mapjobid).children[2].innerHTML=pairdecoder(results);
    console.log(json);
    
    var xhr = new XMLHttpRequest();
    xhr.open("POST","/api/mapresult/"+json.jobid+"/"+json.mapjobid, true);
    xhr.setRequestHeader('Content-Type', 'application/json; charset=UTF-8');
    xhr.send(JSON.stringify(json));
    xhr.onloadend = function () {
        console.log(xhr.response);
    };
}

function pairdecoder(pairs){
    var toReturn ="";
    for(var pair in pairs) 
        toReturn+="("+pairs[pair].key+"->"+pairs[pair].value+") ";
    return toReturn;
}

function reducesolve(data) {    
    var result=reduce(data.key,data.values);
    var json = {
        jobid : data.jobid, 
        reducejobid : data.reducejobid, 
        worker : 'me',
        result : result
        };
    document.getElementById("reduce-"+data.reducejobid).children[3].innerHTML=result.value;
    console.log(json);
    
    
    var xhr = new XMLHttpRequest();
    xhr.open("POST","/api/reduceresult/"+json.jobid+"/"+json.reducejobid, true);
    xhr.setRequestHeader('Content-Type', 'application/json; charset=UTF-8');
    xhr.send(JSON.stringify(json));
    xhr.onloadend = function () {
        console.log(xhr.response);
    };    
}
    
