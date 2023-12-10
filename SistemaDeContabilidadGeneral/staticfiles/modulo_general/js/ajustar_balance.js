let btnAgregar= document.getElementById("btnAgregar");
let tempIdFrontEnd=1;
const fechaActual= new Date(Date.now());
let fechaPartida= document.getElementById('idFecha');
let btnGuardar = document.getElementById('btnGuardar');
fechaPartida.value= fechaActual.getDate()+"/"+fechaActual.getMonth()+"/"+fechaActual.getFullYear();
console.log(fechaActual.getDay());
fechaPartida.disabled=true;

//clases para el objeto parti
class TipoRegistro{
  constructor(nombreTipoRegistro){
      //this.idTipoRegistro= idTipoRegistro;
      this.nombreTipoRegistro= nombreTipoRegistro;
  }

}

class Registro{
  constructor(monto, tipoRegistro,cuenta){
      this.monto= monto;
      this.tipoRegistro=  tipoRegistro;
      this.cuenta=cuenta;
  }
}


class Partida{
  constructor(descripcionPartida,numeroPartida){
      this.descripcionPartida= descripcionPartida;
      this.numeroPartida= numeroPartida;
      this.registros= [];
  }
}

//fin de las clases para el objeto partida

btnAgregar.addEventListener(
    'click',()=>{
        let cuenta= document.getElementById("cuenta").value;
        let tipoMovimiento= document.getElementById("tipoMovimientoSelect").value;
        let montoTransaccion= parseFloat(document.getElementById("monto").value);
        let tablaRegistro= document.getElementById("tablaRegistro");
        if(validarRegistro(montoTransaccion)){
            let filaRegistro= document.createElement("tr");
            let tdMonto= document.createElement("td");
            let tdTipoRegistro= document.createElement("td");
            let tdCuentaElemento= document.createElement("td");
            let spanMoneda= document.createElement("span");
            filaRegistro.setAttribute("id",tempIdFrontEnd);
            tdMonto.setAttribute("class","montoElemento");
            tdTipoRegistro.setAttribute("class","tipoRegistroElemento");
            tdCuentaElemento.setAttribute("class","cuentaElemento");
            tdMonto.innerText="$"+montoTransaccion;
            tdTipoRegistro.innerText=tipoMovimiento;
            tdCuentaElemento.innerText=cuenta;
            filaRegistro.appendChild(tdMonto);
            filaRegistro.appendChild(tdTipoRegistro);
            filaRegistro.appendChild(tdCuentaElemento);
            filaRegistro.appendChild(crearBotonEliminar(tempIdFrontEnd));
            tablaRegistro.appendChild(filaRegistro);
            tempIdFrontEnd+=1;
            document.getElementById("monto").value="";
        }
        else{
              alert("El monto de la transaccion debe de ser un numero real positivo con dos decimales");
        }
    }
);


function validarRegistro(montoTransaccion){
  if (typeof(montoTransaccion)== "number" && montoTransaccion>0){
     return true
  }
}

function validarDetallePartida(){
  let numeroPartida= parseFloat(document.getElementById("idNumero"));
  let descripcionPartida= document.getElementById("idDescripcion");
  if (typeof(numeroPartida)=="number" && descripcionPartida!=""){
      return true;
  }
  else {
    alert("El numero de partida debe ser un numero entero y la descripcion no debe de estar vacia");
    return false;
  }
}

function eliminarElementoPartida(idFila){
  let tabla= document.getElementById("tablaRegistro");
  let registro= document.getElementById(String(idFila));
  tabla.removeChild(registro);
}

function crearBotonEliminar(idFila){
 let btnEliminar=document.createElement("button");
 btnEliminar.setAttribute("type",'button');
 btnEliminar.setAttribute("class","eliminar btn btn-secondary");
 btnEliminar.setAttribute("onclick","eliminarElementoPartida("+String(idFila)+")");
 btnEliminar.innerText="Eliminar";
 btnEliminar.style.marginTop="5px";
 return btnEliminar;
}

function getCookie(name) {
  let cookieValue = null;
  if (document.cookie && document.cookie !== '') {
      const cookies = document.cookie.split(';');
      for (let i = 0; i < cookies.length; i++) {
          const cookie = cookies[i].trim();
          // Does this cookie string begin with the name we want?
          if (cookie.substring(0, name.length + 1) === (name + '=')) {
              cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
              break;
          }
      }
  }
  return cookieValue;
}



function enviarFormularioDjango(partida){
  let formulario= new FormData(document.getElementById('formulario-registro-diario'));
  console.log(partida)
  fetch("/ajustar_balance/",{
    method:"POST",
    body:JSON.stringify(partida),
    headers:{
      "X-CSRFToken": getCookie('csrftoken'),
      'Accept': 'application/json',
      'Content-type': 'application/json; charset=UTF-8',
    }
  });
}

btnGuardar.addEventListener(
  'click',()=>{
    if (validarDetallePartida()){
      let partida=crearPartida();
      enviarFormularioDjango(partida);
      window.location.href="/ajustar_balance/";
    }
    else{
      alert("revise los detalles de la partida");
    }
  }
)



function crearPartida(){
  let montos= document.getElementsByClassName("montoElemento");
  let tipoRegistros= document.getElementsByClassName("tipoRegistroElemento");
  let cuentas= document.getElementsByClassName("cuentaElemento");
  let numeroPartida= document.getElementById("idNumero");
  let descripcioPartida= document.getElementById("idDescripcion");
  let partida= new Partida(descripcioPartida.value,numeroPartida.value);
  let tipoRegistroObjeto;
  let registroObjeto;
  let tempMonto;
  for (i=1; i< montos.length; i++){
      tempMonto= montos.item(i).firstChild.textContent;
      //console.log(tipoRegistros.item(1).getAttribute('data-idTipoRegistro'));
      tipoRegistroObjeto= new TipoRegistro(tipoRegistros.item(i).firstChild.textContent);
      //console.log(cuentas.item(i).getAttribute('data-idCuenta'));
      registroObjeto= new Registro(document.getElementsByClassName("montoElemento")[i].textContent,tipoRegistroObjeto,cuentas.item(i).firstChild.textContent);
      partida.registros[i-1]=registroObjeto;
  }
  return partida;
}

function obtener_montos_tabla(){
  let montos= document.getElementsByClassName("montoElemento");
  for (i=1; i< montos.length; i++){
    console.log(montos[i].textContent);
  }
}




