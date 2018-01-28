$(document).ready(function(){
    var tabs = document.getElementsByClassName("tab");
    var tabButton = document.getElementsByClassName("tab-button")[0];
    if(tabs[0].style.display==="none" && tabs[1].style.display==="none")
    {
        tabs[0].style.display = "block";
        tabButton.style.backgroundColor = "#b4c8c8";
    }
});

const city = document.getElementById("city");

if (city.addEventListener) {
    city.addEventListener("change" , setSchools , false);
} else if (city.attachEvent)  {
    city.attachEvent("onchange" , setSchools);
}
function setSchools() {
    if(this.value.toUpperCase()==="КИЕВ"||this.value.toUpperCase()==="КИЇВ") {
        const options = {

            url: "city.json",

            //getValue: "name",

            list: {
                maxNumberOfElements: 10,
                match: {
                    enabled: true
                }
            },

            theme: "square"
        };

        $("#school").easyAutocomplete(options);

        //var token = document.getElementsByName("_token")[0].value;
        //sendRequest("POST", "/cityjson", token, displaySchools,true);
    }else {
        const school = document.getElementsByClassName("school")[0];
        school.innerHTML = '<label for="school">Школа</label>' +
            '<input class="form-control" type="text" name="school"  id="school" required/>'
    }

}

function showOne() {
    const tab = document.getElementsByClassName("tab");
    const button = document.getElementsByClassName("tab-button");
    button[0].style.backgroundColor = "#b4c8c8";
    button[1].style.background = "none";
    tab[0].style.display = "block";
    tab[1].style.display = "none";
}
function showTeam() {
    const tab = document.getElementsByClassName("tab");
    const button = document.getElementsByClassName("tab-button");
    button[1].style.backgroundColor = "#b4c8c8";
    button[0].style.background = "none";
    tab[0].style.display = "none";
    tab[1].style.display = "block";
}

function setUA() {

    document.cookie = "LANG=ua";

    location.reload(true);
}
function setRU() {
    document.cookie = "LANG=ru";
    location.reload(true);
}


