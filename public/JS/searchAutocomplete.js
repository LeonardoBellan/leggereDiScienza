let values = JSON.parse(document.querySelector('meta[name="data"]').content);
let ce = values.caseEditrici;
let pc = values.paroleChiave;
let au = values.autori;
let tp = values.tipologie;

//reference
let inputs = document.getElementsByClassName("input-text");

//Execute function on keyup
//inputs.forEach((inputField) => {
for(let inputField of inputs){
    inputField.addEventListener("keyup", (e) => {assignEvent(findType(inputField))});
    console.log("inside:  inputs.foreach");
};

function assignEvent(type) {
    console.log("inside:  assignEvent");
    //loop through above array
    //Initially remove all elements ( so if user erases a letter or adds new letter then clean previous outputs)
    removeElements(type);
    getVarByType(type).forEach(entry => {
        if (entry[1].toLowerCase.startsWith(inputField.value.toLowerCase()) &&
            input.value != "") {
            
            //create li element
            let listItem = document.createElement("li");
            //One common class name
            listItem.classList.add("list-items");
            listItem.style.cursor = "pointer";

            listItem.setAttribute("onclick", "displayNames('" + entry[1] + "')");
            //Display matched part in bold
            let word = "<b>" + i.substr(0, input.value.length) + "</b>";
            word += i.substr(input.value.length);
            //display the value in array
            listItem.innerHTML = word;
            document.querySelector("." + type + "-list").appendChild(listItem);
            alert("Added <li>");
        }
    });
}
function findType(input) {
    console.log("inside:  findtype");
    return (input.id).split('-')[0];
}
function getVarByType(type) {
    switch (type) {
        case "ce":
            return ce;
        case "pc":
            return pc;
        case "au":
            return au;
        case "tp":
            return tp;
    }
}
function displayNames(value) {
    input.value = value;
    removeElements();
}
function removeElements(type) {
    //clear all the items
    let items = document.querySelectorAll(type + "-input .list-items");
    items.forEach((item) => {
        item.remove();
    });
}