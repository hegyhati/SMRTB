function mapsolve() {
    var json = {jobid : getJobId(), mapjobid : getMapJobId(), worker : 'me'};
    json.results=map(document.getElementById("chunk").value);
    console.log(json);
    
    var xhr = new XMLHttpRequest();
    xhr.open("POST","/api/mapresult/"+json.jobid+"/"+json.mapjobid, true);
    xhr.setRequestHeader('Content-Type', 'application/json; charset=UTF-8');
    xhr.send(JSON.stringify(json));
    xhr.onloadend = function () {
        console.log(xhr.response);
        location.reload();
    };
}
