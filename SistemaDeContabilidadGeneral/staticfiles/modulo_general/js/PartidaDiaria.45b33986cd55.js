class TipoRegistro{
    constructor(nombreTipoRegistro){
        //this.idTipoRegistro= idTipoRegistro;
        this.nombreTipoRegistro= nombreTipoRegistro;
    }

}

class Registro{
    constructor(monto, tipoRegistro){
        this.monto= monto;
        this.tipoRegistro=  tipoRegistro;
    }
}


class Partida{
    constructor(descripcionPartida,numeroPartida){
        this.descripcionPartida= descripcionPartida;
        this.numeroPartida= numeroPartida;
        this.registros= [];
    }
}