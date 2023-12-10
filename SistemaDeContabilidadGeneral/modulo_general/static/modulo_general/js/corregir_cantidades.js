let tabla= document.getElementsByClassName("table");
let td= tabla.item(0).getElementsByTagName("td");

for (let i=0; i< td.length; i++){
    if (typeof(Number(td.item(i).textContent))=="number"){
        if(parseFloat(td.item(i).textContent)<0){
            console.log(td.item(i).value= parseFloat(td.item(i).textContent)*-1)
            td.item(i).value= parseFloat(td.item(i).textContent)*-1
        }
    }
}