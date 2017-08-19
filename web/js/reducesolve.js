function reducesolve() {
    var json = {jobid : getJobId(), reducejobid : getReduceJobId(), worker : 'me'};
    console.log(document.getElementById("values").value);
    console.log(document.getElementById("values").value.split("|"));
    json.result=reduce(getReduceKey(),document.getElementById("values").value.split("|"));
    console.log(json);
    
    var xhr = new XMLHttpRequest();
    xhr.open("POST","/api/reduceresult/"+json.jobid+"/"+json.reducejobid, true);
    xhr.setRequestHeader('Content-Type', 'application/json; charset=UTF-8');
    xhr.send(JSON.stringify(json));
    xhr.onloadend = function () {
        console.log(xhr.response);
        location.reload();
    };
}
