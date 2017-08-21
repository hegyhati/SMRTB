function testMap(){
    var code="var pairs=[];\n"+document.getElementById("mapfunction").value+"\nreturn pairs;";        
    console.log(code);
    var map = Function("inputchunk", code);
    var pairs=map(document.getElementById("chunk").value);
    document.getElementById("mapoutput").innerHTML=JSON.stringify(pairs,null,2);    
}
function testReduce(){
    var code="var result;\n"+document.getElementById("reducefunction").value+"\nreturn {key: key, value: result};";        
    console.log(code);
    var reduce = Function("key", "values", code);
    var result=reduce(document.getElementById("key").value,document.getElementById("values").value.split(","));
    document.getElementById("reduceoutput").value=JSON.stringify(result,null,2);  
}

function finalize() {
    var json = {jobid : getJobId()};
    json.name =             document.getElementById('jobname').value;
    json.mapfunction =      document.getElementById('mapfunctionstart').value+document.getElementById('mapfunction').value+"\n"+document.getElementById('mapfunctionend').value;
    json.reducefunction =   document.getElementById('reducefunctionstart').value+document.getElementById('reducefunction').value+"\n"+document.getElementById('reducefunctionend').value;
    json.input =             document.getElementById('input').value;
    
    console.log(json);
    
    var xhr = new XMLHttpRequest();
    xhr.open("POST","/complex/"+json.jobid+"/finalize", true);
    xhr.setRequestHeader('Content-Type', 'application/json; charset=UTF-8');
    xhr.send(JSON.stringify(json));
    xhr.onloadend = function () {
        console.log(xhr.response);
        location.reload();
    };    
}
