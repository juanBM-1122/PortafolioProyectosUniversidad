import json
from datetime import date, datetime, timedelta
from django.shortcuts import redirect, render, reverse
from django.test import TransactionTestCase
from modulo_general.forms import PartidaDiarioForm
from modulo_general.models import *
from django_filters.views import FilterView
from modulo_general.partidasFilter import PartidaListaFilter
import modulo_general.models as modelo
#libreria para trabajar con vistas basadas en clases
from django.views.generic import View, TemplateView

# Create your views here.

class Inicio(TemplateView):
    #cuando no se mandan parametros a la redifinicion de get
    # se tienen que pasar los parametros como se muestran 
    #en la firma de la función abaja
    template_name= 'modulo_general/index.html'


#clase temporal para guardara los registros de las cuentas T
class CuentatTemporal():
    def __init__(self,transacciones,saldo_cuenta_t,nombre_cuenta) -> None:
        self.transacciones=transacciones
        self.saldo_cuenta_t= saldo_cuenta_t
        self.nombre_cuenta= nombre_cuenta

#=======================================#

#funcion que obtiene el id de un libro mayor y muestar la informacion relacionada con el#
def mostrar_libro_mayor(request,id_libro_mayor):
    libro_mayor= modelo.LibroMayor.objects.get(id_libro_mayor=int(id_libro_mayor))
    cuentasT_del_libro= CuentaT.objects.filter(libro_mayor=libro_mayor.id_libro_mayor)
    cuentas_T=[]
    print(cuentasT_del_libro)
    for cuenta_T in cuentasT_del_libro :
        cuentas_T.append(CuentatTemporal(Registro.objects.filter(libro_mayor=cuenta_T.id_cuenta_T),cuenta_T.saldo_cuenta_T,cuenta_T.cuenta.nombre_cuenta))
    contexto={"registros_cuenta_t":cuentas_T,'id_libro_mayor':libro_mayor.id_libro_mayor}
    return render(request,'modulo_general/vista-libro-mayor.html',contexto)



class LibroMayor(View):
    def get(self,request,*args,**kwargs):
        libros_mayores= modelo.LibroMayor.objects.all()    
        return render(request,'modulo_general/libro_mayor.html',{'libros':libros_mayores})
    

    def post(self,request,*args,**kwargs):
        fecha_inicio= request.POST.get("fecha_inicio","no estaba la fecha de inicio")
        fecha_fin= request.POST.get("fecha_fin","no estaba la fecha de fin")
        partidas_del_periodo=self.obtener_partidas_periodo(fecha_inicio,fecha_fin)
        registros_del_periodo= self.obtener_registros(partidas_del_periodo)
        self.mayorizar(registros_del_periodo, fecha_inicio, fecha_fin)
        #contexto={'fecha_inicio':fecha_inicio,'fecha_fin':fecha_fin}
        #return render(request,"modulo_general/mayorizacion.html",contexto)
        return redirect('modulo_general:libro_mayor')


    def obtener_partidas_periodo(self,fecha_inicio,fecha_fin):
        print(fecha_inicio)
        print(fecha_fin)
        dt_inicial= datetime.strptime(fecha_inicio,'%Y-%m-%d')
        dt_final= datetime.strptime(fecha_fin,'%Y-%m-%d')
        dia= timedelta(1)
        registro_partidas=Partida.objects.filter(fecha_partida__range=[dt_inicial-dia,dt_final+dia])
        return registro_partidas

    def obtener_registros(self,registros_partidas):
        id_registro_partidas=[]
        registros_del_periodo={}
        registro_por_cuenta=[]
        registro_por_partida=[]
        transacciones= Registro.objects.all();
        cuentas=Cuenta.objects.all()
        for partida in registros_partidas:
            id_registro_partidas.append(partida.id_partida)
        for idpartida in id_registro_partidas:
            registro_por_partida.append(Registro.objects.filter(partida=idpartida))
        for cuenta in cuentas:
            for registro in registro_por_partida:
                temp_registro= registro.filter(cuenta=cuenta.id_cuenta)
                if temp_registro.exists():
                    registro_por_cuenta.append(temp_registro)
            if registro_por_cuenta:
                registros_del_periodo[str(cuenta.nombre_cuenta)]=registro_por_cuenta
            registro_por_cuenta=[]
        return registros_del_periodo


    def obtener_saldo_cuenta_deudora(self,registro):
        if registro.tipo_registro.nombre_tipo_registro=="Debe":
            return registro.monto
        elif registro.tipo_registro.nombre_tipo_registro=="Haber":
            return registro.monto*-1

    def obtener_saldo_cuenta_acreedora(self,registro):
        if registro.tipo_registro.nombre_tipo_registro=="Debe":
            return registro.monto*-1
        elif registro.tipo_registro.nombre_tipo_registro=="Haber":
            return registro.monto

    def mayorizar(self,registros_del_periodo,fecha_inicio,fecha_fin):
        cuentas= Cuenta.objects.all()
        temp_saldo=0
        libro_mayor= self.crear_libro_mayor(fecha_inicio,fecha_fin)
        print("Los registros del periodo son: {}".format(registros_del_periodo))
        for cuenta in cuentas:
            temp_registros = registros_del_periodo.get(cuenta.nombre_cuenta,"")
            if temp_registros!= "":
                temp_cuenta_t = CuentaT(saldo_cuenta_T=temp_saldo,libro_mayor=libro_mayor,cuenta=cuenta)
                temp_cuenta_t.save()
                for query_registro in temp_registros:
                    for transaccion in query_registro:
                        clase_cuenta = transaccion.cuenta.grupo_cuenta.clase_cuenta.nombre_clase_cuenta
                        if transaccion.cuenta.grupo_cuenta.clase_cuenta.nombre_clase_cuenta=="Activo" or transaccion.cuenta.grupo_cuenta.clase_cuenta.nombre_clase_cuenta=="Cuentas de resultado deudor":
                            temp_saldo+= self.obtener_saldo_cuenta_deudora(transaccion)
                        elif clase_cuenta == "Pasivo" or clase_cuenta=="Cuentas de resultado acreedor" or clase_cuenta=="Capital":
                            temp_saldo+= self.obtener_saldo_cuenta_acreedora(transaccion)
                        transaccion.libro_mayor=temp_cuenta_t
                        #este save daba error en las fechas tambien creo =D
                        transaccion.save()
                temp_cuenta_t.saldo_cuenta_T=temp_saldo
                temp_cuenta_t.save()
                temp_saldo=0
                temp_cuenta_t=None

    def crear_libro_mayor(self,fecha_inicio,fecha_fin):
        dt_inicio= datetime.strptime(fecha_inicio,"%Y-%m-%d")
        dt_fin= datetime.strptime(fecha_fin,"%Y-%m-%d")
        libro_mayor= modelo.LibroMayor(fecha_de_inicio_periodo=dt_inicio,fecha_fin_periodo=dt_fin)
        libro_mayor.save()
        return libro_mayor

    #cambiar la evaluacion de los if dependiendo del nombre de las clases de las cuentas
    def evaluar_saldo_registro(self,transaccion):
        clase_cuenta = transaccion.cuenta.grupo_cuenta.clase_cuenta.nombre_clase_cuenta
        if transaccion.cuenta.grupo_cuenta.clase_cuenta.nombre_clase_cuenta=="Activo" or transaccion.cuenta.grupo_cuenta.clase_cuenta.nombre_clase_cuenta=="Cuentas de resultado deudor":
            return self.obtener_saldo_cuenta_deudora(transaccion)
        elif clase_cuenta == "Pasivo" or clase_cuenta=="Cuentas de resultado acreedor" or clase_cuenta=="Capital":
            return self.obtener_saldo_cuenta_acreedora(transaccion)
            


    #Balance de comprobacion#


        #===================libro diario=================0#
class LibroDiario(View):
    lista_cuentas= Cuenta.objects.all()
    lista_tipo_movimiento= TipoRegistro.objects.all()
    contexto={'cuentas':lista_cuentas,'movimientos':lista_tipo_movimiento} 

    def get(self,request,*args,**kwargs):
        for arg in args:
            print(arg)
        return render(request,'modulo_general/registro_diario.html',self.contexto)

    def post(self,request,*args,**kwargs):
        json_data=json.loads(request.body)
        es_partida_ajuste=False
        #numero_partida= json_data[""]
        print("El valor del body es: {}".format(json_data))
        descripcion_partida=json_data["descripcionPartida"]
        numero_partida= json_data["numeroPartida"]
        registros= json_data["registros"]
        #creacion de la partida para el ejercicio
        partida= self.crear_partida(descripcion_partida,numero_partida,es_partida_ajuste)
        print("si llegamos al metodo para crear la partida")
        #asi sacamos los valores del objeto json
        for valores in registros:
            monto=valores["monto"]
            monto= self.obtenerMontoTransaccion(monto)
            cuenta=valores["cuenta"]
            tempCuenta=Cuenta.objects.get(nombre_cuenta=cuenta)
            tiporegistro=valores["tipoRegistro"]["nombreTipoRegistro"]
            temp_tipo_registro= TipoRegistro.objects.get(nombre_tipo_registro=tiporegistro)
            self.crear_registro(monto,partida,tempCuenta,temp_tipo_registro)
        return redirect('modulo_general:mostrar_inicio')

    def crear_partida(self,descripcion_partida,numero_partida,es_partida_ajuste):
        partida= Partida(fecha_partida=datetime.now(),descripcion_partida=descripcion_partida,numero_partida=numero_partida,es_partida_ajuste=es_partida_ajuste)
        partida.save()
        return partida
    def crear_registro(self,monto,partida,cuenta,tipoRegistro):
        registro=Registro(monto=monto,partida=partida,cuenta=cuenta,tipo_registro=tipoRegistro)
        registro.save()
    
    #convertir el numero que viene de la pantalla a valor normal
    def obtenerMontoTransaccion(self,numeroCadena):
        return float(numeroCadena.replace("$",""))




#==========Esto no lo vamo a ocupar===========#

def mostrar_partida_diario(request):
    registrodiario = Registro.objects.all()
    if request.method == 'POST':
        form = PartidaDiarioForm(request.POST)
        if form.is_valid():
            form.save()
        return redirect('../index')
    else:
        form = PartidaDiarioForm()
    form = PartidaDiarioForm()
    return render(request,'modulo_general/partida_diario.html',{'form':form,'registrodiario':registrodiario})

def control_mayorizacion(request):
        libro_mayor= LibroMayor()
        if request.method=="POST":
         fecha_inicio= request.POST["fecha_inicio"]
         fecha_fin= request.POST["fecha_fin"]
         vista_mayor= libro_mayor.get(fecha_fin,fecha_inicio)
         return vista_mayor
        else:
            return render(request,"modulo_general/index.html")

#====================Inicio de balance de comprobacion=================================#

class BalanceComprobacion(View):

    def get(self,request,*args,**kwargs):
        balancear= request.GET.get("balancear_libro","")
        mostrar_libro=request.GET.get("id_balance","")
        ajustar= request.GET.get("id_balance","")
        es_ajuste= request.GET.get("ajustar_balance","")
        if balancear!= "":
            #Usar este metodo despues de comer XD
            datos_balance=self.crear_balance_comprobacion(balancear)
            balance_de_comprobacion=modelo.BalanceComprobacion(saldo_debe=datos_balance["saldo_debe"],saldo_haber=datos_balance["saldo_haber"],
                                                        libro_mayor=datos_balance["temp_libro_mayor"],esta_ajustado=False)
            balance_de_comprobacion.save()
            return redirect("modulo_general:balance_comprobacion")
        elif mostrar_libro!="":
            datos_balance=self.crear_balance_comprobacion(mostrar_libro)
            balance_comprobacion= modelo.BalanceComprobacion.objects.get(libro_mayor=mostrar_libro)
            datos_balance["balance_comprobacion"]=balance_comprobacion
            return render(request,"modulo_general/balance-comprobacion.html",datos_balance)
        elif es_ajuste=="ok":
            self.ajustar_balance()
            balances= modelo.BalanceComprobacion.objects.all()
            return render(request,"modulo_general/listado-balances.html",{"datos_balance":balances})
        else:
            balances= modelo.BalanceComprobacion.objects.all()
            return render(request,"modulo_general/listado-balances.html",{"datos_balance":balances})

    # def ajustar_balance(self):
    #     utilidades_libro_mayor= LibroMayor()
    #     balance_sin_ajustar= modelo.BalanceComprobacion.objects.get(esta_ajustado=False)
    #     libro_mayor= modelo.LibroMayor.objects.get(id_libro_mayor=balance_sin_ajustar.libro_mayor.id_libro_mayor)
    #     partidas_de_ajuste= Partida.objects.filter(es_partida_ajuste=False)
    #     registros_partida= Registro.objects.all()
    #     cuentas_t_libro_mayor= modelo.CuentaT.objects.filter(libro_mayor=libro_mayor.id_libro_mayor)
    #     cuentas= Cuenta.objects.all()
    #     diccionario_registros= self.obtener_registros_por_cuenta(cuentas,registros_partida,partidas_de_ajuste)
    #     temp_saldo=0
    #     for cuenta in cuentas:
    #         temp_registro_cuentas=diccionario_registros.get(cuenta.nombre_cuenta,"")
    #         if temp_registro_cuentas!="":
    #             temp_cuenta_t = cuentas_t_libro_mayor.filter(cuenta=cuenta.id_cuenta)
    #             if temp_cuenta_t.exists():
    #                 for transaccion in temp_registro_cuentas:
    #                     for registro in transaccion:
    #                         print(registro)
    #                         temp_saldo+= utilidades_libro_mayor.evaluar_saldo_registro(registro)
    #                         registro.libro_mayor= temp_cuenta_t[0]
    #                         registro.save()
    #                 temp_cuenta_t[0].saldo_cuenta_T+=temp_saldo
    #                 temp_cuenta_t[0].save()
    #                 temp_saldo=0
    #             else:
    #                 for transaccion in temp_registro_cuentas:
    #                     for registro in transaccion:
    #                         temp_saldo+= utilidades_libro_mayor.evaluar_saldo_registro(registro)
    #                 temp_cuenta_t_guardar = CuentaT(saldo_cuenta_T=temp_saldo,libro_mayor=libro_mayor,cuenta=cuenta)
    #                 temp_cuenta_t_guardar.save()
    #                 temp_saldo=0
    #     balance_sin_ajustar.esta_ajustado=True

    def obtener_registros_por_cuenta(self,cuentas,registros_partida,partidas):
       pass

    def obtener_registros_de_ajuste(self):
        registros_de_ajuste = []
        partidas= Partida.objects.filter(es_partida_ajuste=True)
        for partida in partidas:
            registros_de_ajuste.append(Registro.objects.filter(partida=partida.id_partida))
        return registros_de_ajuste

    def ordenar_registro_por_nombre_cuenta(self,registros):
        temp_registros_por_cuenta=[]
        diccionario_registros= {}
        cuentas= Cuenta.objects.all()
        for cuenta in cuentas:
            for registro in registros:
                temp_transaccion_por_cuenta= registro.filter(cuenta=cuenta.id_cuenta)
                print(temp_transaccion_por_cuenta)
                if temp_transaccion_por_cuenta.exists():
                    temp_registros_por_cuenta.append(temp_transaccion_por_cuenta)
            if temp_registros_por_cuenta:
                diccionario_registros[cuenta.nombre_cuenta]=temp_registros_por_cuenta
                temp_registros_por_cuenta=[]
        return diccionario_registros

    def obtener_saldo_por_cuenta_ajuste(self,diccionario_registros):
        utilidades_libro= LibroMayor()
        cuentas = Cuenta.objects.all()
        saldos_cuenta={}
        temp_saldo_cuenta=0
        for cuenta in cuentas:
            transacciones= diccionario_registros.get(cuenta.nombre_cuenta,"")
            if transacciones:
                for transaccion in transacciones:
                    for registro in transaccion:
                        print("El valor es: ",utilidades_libro.evaluar_saldo_registro(registro))
                        temp_saldo_cuenta+=utilidades_libro.evaluar_saldo_registro(registro)
            if temp_saldo_cuenta!=0:
                saldos_cuenta[cuenta.nombre_cuenta]=temp_saldo_cuenta
                temp_saldo_cuenta=0
        return saldos_cuenta

    def ajustar_balance(self):
        registro_ajustes= self.obtener_registros_de_ajuste()
        registros_ajustados_by_cuenta=self.ordenar_registro_por_nombre_cuenta(registro_ajustes)
        saldos_por_cuenta= self.obtener_saldo_por_cuenta_ajuste(registros_ajustados_by_cuenta)
        ajuste= self.obtener_cuentas_t_ajuste()
        cuentas_t_ajuste=ajuste["cuentas_T"]
        cuentas= Cuenta.objects.all()
        for cuenta in cuentas:
            temp_registro= registros_ajustados_by_cuenta.get(cuenta.nombre_cuenta,"")
            if temp_registro!="":
                temp_cuenta_t = cuentas_t_ajuste.filter(cuenta=cuenta.id_cuenta)
                if temp_cuenta_t:
                    for registros in temp_registro:
                        for transaccion in registros:
                            transaccion.libro_mayor=temp_cuenta_t[0]
                            transaccion.libro_mayor.save()
                    temp_cuenta_t[0].saldo_cuenta_T+=saldos_por_cuenta[cuenta.nombre_cuenta]
                    temp_cuenta_t[0].save()
                else:
                    cuenta_t= modelo.CuentaT(saldo_cuenta_T=saldos_por_cuenta[cuenta.nombre_cuenta],libro_mayor=ajuste["libro_mayor"],cuenta=cuenta)
                    cuenta_t.save()
                    for registros in temp_registro:
                        for transaccion in registros:
                            transaccion.libro_mayor = cuenta_t
                            transaccion.save()
        datos_ajuste=self.crear_balance_comprobacion(ajuste["libro_mayor"].id_libro_mayor)
        ajuste["balance"].esta_ajustado = True
        ajuste["balance"].saldo_debe = datos_ajuste["saldo_debe"]
        ajuste["balance"].saldo_haber = datos_ajuste["saldo_haber"]
        ajuste["balance"].save()


    def obtener_cuentas_t_ajuste(self):
        balance= modelo.BalanceComprobacion.objects.filter(esta_ajustado=False)
        libro_mayor= modelo.LibroMayor.objects.get(id_libro_mayor=balance[0].libro_mayor.id_libro_mayor)
        cuentas_T=  CuentaT.objects.filter(libro_mayor=libro_mayor.id_libro_mayor)
        ajuste={"cuentas_T":cuentas_T,"libro_mayor":libro_mayor,'balance':balance[0]}
        return ajuste

    def crear_balance_comprobacion(self,libro_mayor_id):
        cuentas_activo=[]
        cuentas_pasivos_capital=[]
        saldo_debe=0
        saldo_haber=0
        temp_libro_mayor= modelo.LibroMayor.objects.get(id_libro_mayor=int(libro_mayor_id))
        print("EL libro mayor {}".format(temp_libro_mayor))
        cuentasT_libro_mayor= self.cuentas_t_libro_mayor(temp_libro_mayor.id_libro_mayor)
        print("Las cuentas t {}".format(cuentasT_libro_mayor))
        for cuenta_t in cuentasT_libro_mayor:
            if cuenta_t.cuenta.grupo_cuenta.clase_cuenta.nombre_clase_cuenta == "Activo" or cuenta_t.cuenta.grupo_cuenta.clase_cuenta.nombre_clase_cuenta=="Cuentas de resultado deudor":
                if cuenta_t.saldo_cuenta_T < 0:
                    cuentas_pasivos_capital.append(cuenta_t)
                    saldo_haber+= cuenta_t.saldo_cuenta_T*-1
                else: 
                    cuentas_activo.append(cuenta_t)
                    saldo_debe+= cuenta_t.saldo_cuenta_T
            else :
                cuentas_pasivos_capital.append(cuenta_t)
                saldo_haber+= cuenta_t.saldo_cuenta_T
        return {"temp_libro_mayor":temp_libro_mayor,"saldo_debe":saldo_debe,"saldo_haber":saldo_haber,
                'cuentas_activo':cuentas_activo,"cuentas_pasivos_capital":cuentas_pasivos_capital}

    def cuentas_t_libro_mayor(self,id_libro_mayor):
        return CuentaT.objects.filter(libro_mayor=id_libro_mayor)

#============Fin balance de comprobacion#


#================================================
class EstadoDeResultadoVista(View):
    def get(self,request, *args,**kwargs):
        crear_estado= request.GET.get("crear_estado","")  #guarda el id del balance
        ver_estado= request.GET.get("ver_estado","")
        if crear_estado!="":
            balance= modelo.BalanceComprobacion.objects.get(id=int(crear_estado))
            diccionario_cuentas= self.obtener_cuentas_t_gastos_ingresos(crear_estado)
            utilidad= self.obtener_utilidad(diccionario_cuentas)
            estado_de_resultado=self.crear_estado_resultado(utilidad,balance)
            contexto={"gastos":diccionario_cuentas["gastos"],"ingresos":diccionario_cuentas["ingresos"],'resultado':estado_de_resultado}
            return render(request,"modulo_general/estado-resultado.html",contexto)
        elif ver_estado!="":
            estado_resultado= modelo.EstadoResultado.objects.get(id=int(ver_estado))
            diccionario_cuentas= self.obtener_cuentas_t_gastos_ingresos(estado_resultado.balance_comprobacion.id)
            diccionario_saldos= self.obtener_saldo(diccionario_cuentas)
            gastos= diccionario_saldos["saldo_gastos"]
            ingresos= diccionario_saldos["saldo_ingresos"]
            estado_de_resultado= modelo.EstadoResultado.objects.get(id=int(ver_estado))
            contexto={"gastos":diccionario_cuentas["gastos"],"ingresos":diccionario_cuentas["ingresos"],'resultado':estado_de_resultado,'saldo_gastos':gastos,'saldo_ingresos':ingresos}
            return render(request,"modulo_general/estado-resultado.html",contexto)
        else:    
            estados_de_resultado= EstadoResultado.objects.all()
            return render(request,"modulo_general/listado-resultado.html",{"resultado":estados_de_resultado})

    def obtener_utilidad(self,diccionario_cuentas):
        utilidad=0
        for gastos in diccionario_cuentas["gastos"]:
            utilidad-= gastos.saldo_cuenta_T
        for ingresos in diccionario_cuentas["ingresos"]:
            utilidad+= ingresos.saldo_cuenta_T
        return utilidad
    
    def obtener_saldo(self,diccionario_cuentas):
        saldo_gastos=0
        saldo_ingresos=0
        for gastos in diccionario_cuentas["gastos"]:
            saldo_gastos+=gastos.saldo_cuenta_T
        for ingresos in diccionario_cuentas["ingresos"]:
            saldo_ingresos+=ingresos.saldo_cuenta_T
        diccionario_saldo={'saldo_gastos':saldo_gastos,'saldo_ingresos':saldo_ingresos}
        return diccionario_saldo

    def obtener_cuentas_t_gastos_ingresos(self,id_balance):
        libros= self.obtener_libro_mayor(id_balance)
        cuentas_t=CuentaT.objects.filter(libro_mayor=libros["mayor"].id_libro_mayor)
        gastos=self.filtrar_cuentas_t_por_cuenta(cuentas_t,"Cuentas de resultado deudor")
        ingresos= self.filtrar_cuentas_t_por_cuenta(cuentas_t,"Cuentas de resultado acreedor")
        cuentas_resultado={"gastos":gastos,'ingresos':ingresos}
        return cuentas_resultado
    
    def crear_estado_resultado(self,utilidad,balance):
        libro_mayor= modelo.LibroMayor.objects.get(id_libro_mayor=balance.libro_mayor.id_libro_mayor)
        estado_resultado= EstadoResultado(fecha_de_inicio=libro_mayor.fecha_de_inicio_periodo,fecha_de_fin=libro_mayor.fecha_fin_periodo,utilidad=utilidad,balance_comprobacion=balance)
        estado_resultado.save()
        return estado_resultado
    
    def obtener_libro_mayor(self,id_balance):
        balance= modelo.BalanceComprobacion.objects.get(id=id_balance)
        libro_mayor= modelo.LibroMayor.objects.get(id_libro_mayor=balance.libro_mayor.id_libro_mayor )
        libros= {'balance':balance,'mayor':libro_mayor}
        return libros
    
    def filtrar_cuentas_t_por_cuenta(self,cuentas_t,nombre_cuenta):
        filtro_cuenta=[]
        for cuenta_t in cuentas_t:
            if cuenta_t.cuenta.grupo_cuenta.clase_cuenta.nombre_clase_cuenta==nombre_cuenta:
                filtro_cuenta.append(cuenta_t)
        return filtro_cuenta   

    def obtener_estado_de_resultado(self,id_balance):
        balance= modelo.BalanceComprobacion.objects.get(id=id_balance)
        return modelo.EstadoResultado.objects.get(balance_comprobacion = balance.id)

#==================================================


#=============================Estado de capital==================
class VistaEstadoCapital(View):
    def get(self,request, *args,**kwargs):
        crear_estado = request.GET.get("crear_estado","")
        ver_estado = request.GET.get("ver_estado","")
        if crear_estado!="":
            contexto = self.crear_estado_de_capital(crear_estado)
            return render(request,'modulo_general/vista-estado-capital.html',contexto)
        elif ver_estado!="":
            utilidades_estado_resultado = EstadoDeResultadoVista()
            estado_de_capital= EstadoCapital.objects.get(id=int(ver_estado))
            resultado= utilidades_estado_resultado.obtener_estado_de_resultado(estado_de_capital.balance_comprobacion.id)
            libro_mayor= utilidades_estado_resultado.obtener_libro_mayor(resultado.balance_comprobacion.id)
            cuentas_t_capital = utilidades_estado_resultado.filtrar_cuentas_t_por_cuenta(modelo.CuentaT.objects.filter(libro_mayor=libro_mayor['mayor'].id_libro_mayor),"Capital")
            estado_de_resultado = utilidades_estado_resultado.obtener_estado_de_resultado(resultado.balance_comprobacion.id)
            contexto= {'estado_capital':estado_de_capital,'cuentas_t':cuentas_t_capital,'utilidad':estado_de_resultado.utilidad}
            
            return render(request,'modulo_general/vista-estado-capital.html',contexto)
        else:
            resultado = modelo.EstadoCapital.objects.all()
            return render(request,"modulo_general/lista-estado-capital.html",{'resultado':resultado})
    
    def crear_estado_de_capital(self,id_balance):
        balance= modelo.BalanceComprobacion.objects.get(id=int(id_balance))
        utilidades_estado_resultado = EstadoDeResultadoVista()
        libro_mayor= utilidades_estado_resultado.obtener_libro_mayor(id_balance)
        cuentas_t_capital = utilidades_estado_resultado.filtrar_cuentas_t_por_cuenta(modelo.CuentaT.objects.filter(libro_mayor=libro_mayor['mayor'].id_libro_mayor),"Capital")
        estado_de_resultado = utilidades_estado_resultado.obtener_estado_de_resultado(id_balance)
        #modificar esta parte si existe utilidad a reinvertir
        nuevo_capital = self.calcular_saldo_del_capital_social(cuentas_t_capital,estado_de_resultado)
        estado_capital= modelo.EstadoCapital(
            fecha_de_inicio= libro_mayor["mayor"].fecha_de_inicio_periodo,
            fecha_de_fin=libro_mayor["mayor"].fecha_fin_periodo,
            reservas=0,
            capital_social=nuevo_capital,
            balance_comprobacion=balance
        )
        estado_capital.save()
        elementos_de_estado = {'estado_capital':estado_capital,'cuentas_t':cuentas_t_capital,'utilidad':estado_de_resultado.utilidad}
        return elementos_de_estado

    def calcular_saldo_del_capital_social(self,cuentas_t_capital,estado_de_resultado):
        #aqui tenemos que definir la utilidad que tenemos que reinvertir o algo asi XD
        saldo_cuenta_capital=0
        for cuenta_capital in cuentas_t_capital:
            saldo_cuenta_capital+= cuenta_capital.saldo_cuenta_T
        if estado_de_resultado.existe_utilidad:
            saldo_cuenta_capital+= estado_de_resultado.utilidad
        else:
            saldo_cuenta_capital-= estado_de_resultado.utilidad

        return saldo_cuenta_capital
#====================Fin de estado de capital====================


#=================class filterview with partida model=====================#
class PartidaFilterView(FilterView):
    model= Partida
    template_name= 'modulo_general/listado_partida.html'
    context_object_name= 'partidas'
    filterset_class= PartidaListaFilter
    paginate_by= 3

    def get_context_data(self,**kwargs):
        context= super().get_context_data(**kwargs)
        context['registros']= Registro.objects.all()
        return context

#==================ajustar balance de comprobacion==========00
def ajustar_balance(request):
    if request.method=="POST":
        libro_diario= LibroDiario()
        json_data=json.loads(request.body)
        es_partida_ajuste=True
        #numero_partida= json_data[""]
        print("El valor del body es: {}".format(json_data))
        descripcion_partida=json_data["descripcionPartida"]
        numero_partida= json_data["numeroPartida"]
        registros= json_data["registros"]
        #creacion de la partida para el ejercicio
        partida= libro_diario.crear_partida(descripcion_partida,numero_partida,es_partida_ajuste)
        print("si llegamos al metodo para crear la partida")
        #asi sacamos los valores del objeto json
        for valores in registros:
            monto=valores["monto"]
            monto= libro_diario.obtenerMontoTransaccion(monto)
            cuenta=valores["cuenta"]
            tempCuenta=Cuenta.objects.get(nombre_cuenta=cuenta)
            tiporegistro=valores["tipoRegistro"]["nombreTipoRegistro"]
            temp_tipo_registro= TipoRegistro.objects.get(nombre_tipo_registro=tiporegistro)
            libro_diario.crear_registro(monto,partida,tempCuenta,temp_tipo_registro)
        return redirect('modulo_general:ajustar_balance')
    else:
        lista_cuentas= Cuenta.objects.all()
        lista_tipo_movimiento= TipoRegistro.objects.all()
        contexto={'cuentas':lista_cuentas,'movimientos':lista_tipo_movimiento} 
        return render(request,"modulo_general/ajustar_balance.html",contexto)


#=========================Clase temporal para los registros del balance general=======
class TempCuentaT():
    def __init__(self,saldo_cuenta , nombre_cuenta, codigo_cuenta) -> None:
        self.saldo_cuenta = saldo_cuenta
        self.nombre_cuenta = nombre_cuenta
        self.codigo_cuenta = codigo_cuenta
    

#=================Balance de general==================

class VistaBalanceGeneral(View):
    def get(self,request,*args,**kwargs):
        crear_balance = request.GET.get("crear_balance","")
        ver_balance =  request.GET.get("ver_balance","")
        if crear_balance!="":
            balance = modelo.BalanceComprobacion.objects.get(id = int(crear_balance))
            diccionario_activos_pasivos = self.obtener_registros_balance(int(crear_balance))
            cuentas_vista = self.ordenar_cuentas_para_mostrar(diccionario_activos_pasivos)  # esta parametro es para la vista 
            saldo_balance = self.obtener_saldo_de_balance(diccionario_activos_pasivos, int(crear_balance))
            saldo_balance['debe'] = cuentas_vista['debe']
            saldo_balance['haber'] =  cuentas_vista['haber']
            balance_general =  modelo.BalanceGeneral(
                fecha_de_inicio = balance.libro_mayor.fecha_de_inicio_periodo,
                fecha_de_fin = balance.libro_mayor.fecha_fin_periodo,
                saldo_debe = saldo_balance["saldo_debe"],
                saldo_haber = saldo_balance["saldo_haber"],
                balance_comprobacion =  balance
            )
            balance_general.save()
            saldo_balance["balance_general"] = balance_general
            return render(request,'modulo_general/balance_general.html',saldo_balance)
        elif ver_balance!="":
            balance_general = modelo.BalanceGeneral.objects.get(id = int(ver_balance))
            diccionario_activos_pasivos = self.obtener_registros_balance(balance_general.balance_comprobacion.id)
            cuentas_vista = self.ordenar_cuentas_para_mostrar(diccionario_activos_pasivos)  # esta parametro es para la vista 
            saldo_balance = self.obtener_saldo_de_balance(diccionario_activos_pasivos, balance_general.balance_comprobacion.id)
            saldo_balance['debe'] = cuentas_vista['debe']
            saldo_balance['haber'] =  cuentas_vista['haber']
            saldo_balance["balance_general"] = balance_general
            return render(request,'modulo_general/balance_general.html',saldo_balance)
        else:
            balances = modelo.BalanceGeneral.objects.all()
            return render(request,"modulo_general/lista-balance-general.html",{'resultado':balances})

    def obtener_registros_balance(self,id_balance):
        diccionario_activos_pasivos = {}
        utilidades_estado_resultado = EstadoDeResultadoVista()
        diccionario_libros = utilidades_estado_resultado.obtener_libro_mayor(id_balance)
        cuentas_t_periodo = modelo.CuentaT.objects.filter(libro_mayor = diccionario_libros["mayor"].id_libro_mayor)
        print(cuentas_t_periodo)
        diccionario_activos_pasivos['activos'] = utilidades_estado_resultado.filtrar_cuentas_t_por_cuenta(cuentas_t_periodo,"Activo")
        diccionario_activos_pasivos['pasivos'] = utilidades_estado_resultado.filtrar_cuentas_t_por_cuenta(cuentas_t_periodo,'Pasivo')
        return diccionario_activos_pasivos

    def ordenar_cuentas_para_mostrar(self,diccionario_activo_pasivos):
        debe=[]
        haber=[]
        for key,values in diccionario_activo_pasivos.items():
            for cuenta_t in values:
                if key == 'activos' and cuenta_t.saldo_cuenta_T < 0:
                    haber.append(TempCuentaT(cuenta_t.saldo_cuenta_T * -1, cuenta_t.cuenta.nombre_cuenta, cuenta_t.cuenta.codigo_cuenta))
                elif key == 'activos' and cuenta_t.saldo_cuenta_T > 0:
                    debe.append(TempCuentaT(cuenta_t.saldo_cuenta_T, cuenta_t.cuenta.nombre_cuenta, cuenta_t.cuenta.codigo_cuenta))
                elif key == 'pasivo' and cuenta_t.saldo_cuenta_T < 0:
                    debe.append(TempCuentaT(cuenta_t.saldo_cuenta_T * -1, cuenta_t.cuenta.nombre_cuenta, cuenta_t.cuenta.codigo_cuenta))
                elif key == 'pasivo' and cuenta_t.saldo_cuenta_T > 0 :
                    haber.append(TempCuentaT(cuenta_t.saldo_cuenta_T*-1, cuenta_t.cuenta.nombre_cuenta,cuenta_t.cuenta.codigo_cuenta))
        return {'debe':debe,'haber':haber}

    def obtener_saldo_de_balance(self,diccionario_activos_pasivos,id_balance):
        estado_capital = modelo.EstadoCapital.objects.filter(balance_comprobacion = id_balance)
        saldo_debe = 0
        saldo_haber = 0
        for key,values in diccionario_activos_pasivos.items():
            for transaccion in values:
                if key == "activos":
                    saldo_debe+= transaccion.saldo_cuenta_T
                elif key == "pasivos":
                    saldo_haber+= transaccion.saldo_cuenta_T
        saldo_haber+= estado_capital[0].capital_social
        return {'saldo_debe':saldo_debe,'saldo_haber':saldo_haber,'capital':estado_capital[0].capital_social}