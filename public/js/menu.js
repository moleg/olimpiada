/**
 * Created by Anton on 25.10.2017.
 */
const modal = document.getElementById('myModal');
const btn = document.getElementById("myBtn");
const span = document.getElementsByClassName("close")[0];

span.addEventListener("click",function() {
    modal.style.display = "none";
});

window.addEventListener("click",function(event) {
    if (event.target === modal) {
        modal.style.display = "none";
    }
});


/*function marks(obj) {
    const marksOwner = document.getElementById("marks-owner");
    const name = obj.parentNode.parentNode.childNodes;
    console.log(name);
    marksOwner.innerText = "Оценки "+ name[1].innerText+" "+name[3].innerText;
    const token = document.getElementsByName("csrf-token")[0].content;
    const data = new FormData();
    const tr = document.getElementById("modal-table-tr");
    tr.setAttribute("data-id",obj.dataset.id);
    data.append("id", obj.dataset.id);
    var url = document.getElementById("url");
    sendRequest("POST",url.dataset.getMarks,token,setMarks,data,true);
}
function setMarks(data) {
    const marksInput = document.getElementsByClassName("marks");
    var iterator = 0;
    var sum = 0;
    for (var key in data) {
        marksInput[iterator].value = data[key];
        sum += data[key];
        iterator++;
    }
    marksInput[iterator].innerText = sum;
    modal.style.display = "block";
}
function sendMarks(obj) {
    const data = new FormData();
    const marks = document.getElementsByClassName("marks");
    data.append("id",marks[0].parentNode.parentNode.dataset.id);
    var sum = 0;
    for(var i=0;i<marks.length-1;i++)
    {
        sum += parseInt(marks[i].value);
        data.append("test"+(i+1),parseInt(marks[i].value))
    }
    marks[marks.length-1].innerText = sum;
    const token = document.getElementsByName("csrf-token")[0].content;
    const url = document.getElementById("url");
    sendRequest("POST",url.dataset.updateMarks,token,test,data,true);
}*/
function additional(obj) {
    const additionalOwner = document.getElementById("additional-owner");
    const name = obj.parentNode.parentNode.childNodes;
    additionalOwner.innerText = "Данные "+ name[3].innerText+" "+name[5].innerText;
    const token = document.getElementsByName("csrf-token")[0].content;
    const data = new FormData();
    const tr = document.getElementById("modal-table-tr");
    tr.setAttribute("data-id",obj.dataset.id);
    data.append("id", obj.dataset.id);
    var url = document.getElementById("url");
    sendRequest("POST",url.dataset.getAdditional,token,setAdditional,data,true);
}
function setAdditional(data) {
    const additionalInput = document.getElementsByClassName("additional");
    var iterator = 0;
    for (var key in data) {
        additionalInput[iterator].value = data[key];
        iterator++;
    }
    modal.style.display = "block";
}
function sendAdditional(obj) {
    const data = new FormData();
    const additional = document.getElementsByClassName("additional");
    data.append("id",additional[0].parentNode.parentNode.dataset.id);
    for(var i=0;i<additional.length;i++)
    {
        data.append(additional[i].dataset.name,additional[i].value)
    }
    const token = document.getElementsByName("csrf-token")[0].content;
    const url = document.getElementById("url");
    sendRequest("POST",url.dataset.updateAdditional,token,null,data,true);
}



function edit(obj) {
    const parent = obj.parentNode.parentNode.childNodes;
    console.log(parent);
    console.log(document.getElementsByClassName("controls"));
    const count = document.getElementsByClassName("controls").length*2;
    for (var i = 1;i<parent.length-count;i+=2)
    {
        const data = parent[i].dataset.type.split(":");
        if(data[0] === "enum")
        {
            const enumerable = data[1].split(",");
            const fragment = document.createDocumentFragment();
            const select = document.createElement("select");
            const val = parent[i].innerText;
            var option = document.createElement("option");
            for(j = 0;j<enumerable.length;j++)
            {
                option = document.createElement("option");
                option.value = enumerable[j];
                option.innerText = enumerable[j];
                fragment.appendChild(option);
            }
            select.appendChild(fragment);
            parent[i].innerText = "";
            parent[i].appendChild(select);
            select.value = val;
        }
        else if(data[0] === "tree")
        {
            const root = parent[i];

            const table = findElementByName(root,"table");
            table.style.display ="block";
            const tbody = findElementByName(table,"tbody");
            const tr = findElementsByName(tbody,"tr");
            for(var j=1;j<tr.length;j++)
            {
                var th = findElementsByName(tr[j],"th");
                for(var n=0;n<th.length;n++)
                {
                    var input = document.createElement("input");
                    input.type="text";
                    input.value = th[n].innerText;
                    th[n].innerText="";
                    th[n].append(input);
                }
            }
        }
        else if(data[0] === "integer")
        {
            const input = document.createElement("input");
            input.type = "number";
            input.min = "0";
            input.max = "20";
            input.value = parent[i].innerText;
            input.size = parent[i].innerText.length;
            parent[i].innerText = "";
            parent[i].appendChild(input);
        }
        else if(data[0] === "id"||data[0] === "sum") {}
        else {
            const input = document.createElement("input");
            input.type = "text";
            input.value = parent[i].innerText;
            input.size = parent[i].innerText.length;
            parent[i].innerText = "";
            parent[i].appendChild(input);
        }
    }
    const logo = document.createElement("i");
    logo.className ="fa fa-check fa-lg send ";
    logo.setAttribute("data-id",obj.dataset.id);
    logo.setAttribute("onclick","send(this)");
    logo.setAttribute("aria-hidden","true");
    obj.parentNode.replaceChild(logo,obj);
}

function send(obj) {
    const data = new FormData();
    const tests = new FormData();
    data.append('id', obj.dataset.id);
    tests.append('id', obj.dataset.id);
    const parent = obj.parentNode.parentNode.childNodes;
    const count = document.getElementsByClassName("controls").length*2;
    var sum = 0;
    for (var i = 1;i<parent.length-count;i+=2)
    {
        if(parent[i].dataset.type === "tree")
        {
            const table = findElementsByName(parent[i],"table");
            const members = tableToArray(table);
            data.append(parent[i].dataset.name,members);
        }
        else if(parent[i].className ==="test")
        {
            const intValue = parseInt(parent[i].childNodes[0].value);
            if(intValue>20||intValue<0)
            {
                //TODO Добавить отображение ошибок
                return;
            }
            else {
                tests.append(parent[i].dataset.name, parent[i].childNodes[0].value);
                sum+=parseInt(parent[i].childNodes[0].value);
            }
        }
        else if(parent[i].dataset.type === "sum")
        {
            parent[i].innerText = sum;
        }
        else if(parent[i].dataset.type === "id"){}
        else {
                data.append(parent[i].dataset.name, parent[i].childNodes[0].value);
        }

    }
    tests.append("sum",sum);
    const token = document.getElementsByName("csrf-token")[0].content;
    const url = document.getElementById("url");
    sendRequest("POST",url.dataset.update,token,reverse.bind(obj),data,true);
    sendRequest("POST",url.dataset.updateMarks,token,null,tests,true);

}
function deleting(obj) {
    const token = document.getElementsByName("csrf-token")[0].content;
    const url = document.getElementById("url");
    sendRequest("DELETE", url.dataset.delete.replace("param",obj.dataset.id),token,reload,true)
}
function reload() {
    location.reload(true);
}

function reverse() {
    const obj = this;
    const parent = obj.parentNode.parentNode.childNodes;
    const count = document.getElementsByClassName("controls").length*2;
    for (var i = 1;i<parent.length-count;i+=2)
    {
        if(parent[i].dataset.type === "tree")
        {
            const root = parent[i];
            const table = findElementByName(root,"table");
            table.style.display ="none";
            const tbody = findElementByName(table,"tbody");
            const tr = findElementsByName(tbody,"tr");
            for(var j=1;j<tr.length;j++)
            {
                var th = findElementsByName(tr[j],"th");
                for(var n=0;n<th.length;n++)
                {
                    th[n].innerText = th[n].childNodes[0].value;
                }
            }
        }
        else if(parent[i].dataset.type !== "id" && parent[i].dataset.type !== "sum") {
            if(parent[i].childNodes[0].value !=="")
            {
                parent[i].innerText = parent[i].childNodes[0].value;
            }
            else
            {
                parent[i].innerText = "Значение не определено";
            }
        }
    }
    const logo = document.createElement("i");
    logo.className ="fa fa-pencil fa-lg edit ";
    logo.setAttribute("data-id",obj.dataset.id);
    logo.setAttribute("onclick","edit(this)");
    logo.setAttribute("aria-hidden","true");
    obj.parentNode.replaceChild(logo,obj);
}

function findElementByName(htmlObj,name) {
    const childNodes = htmlObj.childNodes;
    for (var i=0;i<childNodes.length;i++)
    {
        if(childNodes[i].nodeName === name.toUpperCase())
        {
            return childNodes[i];
        }
    }
}

function findElementsByName(htmlObj,name) {
    const childNodes = htmlObj.childNodes;
    var nodes = [];
    for (var i=0;i<childNodes.length;i++)
    {
        if(childNodes[i].nodeName === name.toUpperCase())
        {
            nodes.push(childNodes[i]);
        }
    }
    if(nodes.length === 1)
    {
        return nodes[0];
    }
    else if (nodes.length === 0)
    {
        return -1;
    }
    else
    {
        return nodes;
    }
}
//tableToArray(document.getElementsByClassName("tree")[0]);
function tableToArray(table) {
    var tr = findElementsByName(table.childNodes[1],"tr");
    var array = [];
    for (var i = 1;i<tr.length;i++)
    {
        var obj = {};
        obj.id = tr[i].dataset.id;
        var th = findElementsByName(tr[i],"th");
        th.map(function (el) {
            obj[el.dataset.name] = el.childNodes[0].value;
        });
        array.push(obj);
    }
    return JSON.stringify(array);
}
function generateExcel(math,puzzle,team) {
    const token = document.getElementsByName("csrf-token")[0].content;
    sendRequest('POST',math,token,null,null,true);
    sendRequest('POST',puzzle,token,null,null,true);
    sendRequest('POST',team,token,null,null,true);
}
function setState(url,obj)
{
    console.log(obj.checked);
    const data = new FormData();
    data.append("state",obj.checked);
    const token = document.getElementsByName("csrf-token")[0].content;
    sendRequest('POST',url,token,null,data,true);
}

function sendRequest(type, url, header , callback ,data,async) {
    var xhr  = null;
    if (window.XMLHttpRequest) {
        //Gecko-совместимые браузеры, Safari, Konqueror
        xhr  = new XMLHttpRequest();

    } else if (window.ActiveXObject) {
        //Internet explorer
        try {
            xhr  = new ActiveXObject("Microsoft.XMLHTTP");
        } catch (CatchException) {
            xhr  = new ActiveXObject("Msxml2.XMLHTTP");
        }
    }
    xhr.onreadystatechange = function(){
        if(this.readyState === 4){
            if(this.status === 200){
                if(callback != undefined || callback != null)
                {
                    try
                    {
                        callback(JSON.parse(this.responseText));
                    }
                    catch (e)
                    {
                        callback()
                    }

                    //JSON.parse(this.responseText) !== "" ? callback(JSON.parse(this.responseText)) : callback();
                }
            }
        }

    };
    xhr.open(type,url,async);
    xhr.setRequestHeader("X-CSRF-TOKEN", header);
    data !== undefined ? xhr.send(data) : xhr.send();
}