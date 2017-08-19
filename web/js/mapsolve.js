function mapsolve() {
    var json = {jobid : getJobId(), mapjobid : getMapJobId(), worker : 'me'};
    json.results=map(document.getElementById("chunk").value);
    console.log(json);
}
