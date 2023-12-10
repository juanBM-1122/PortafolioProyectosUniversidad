from datetime import datetime
from xml.dom import ValidationErr
from django.contrib import messages
from django.forms import EmailField
from django.http import HttpResponseRedirect
from django.urls import reverse
from django.views.decorators.csrf import csrf_protect 
from django.shortcuts import redirect, render
from django.contrib.auth import login, logout,authenticate
from django.contrib.auth.decorators import login_required
from django.contrib import messages
from .models import *
from .forms import *

def index(request):
    return render(request, 'gestionTransporte/index.html')

@login_required
def registrarVehiculo(request):
    if request.user.rol=="empresa":
        empresaVehiculo = Empresa.objects.get(usuario_sistema=UsuarioSistema.objects.get(username=request.user))
        vehiculos = Vehiculo.objects.filter(empresa=empresaVehiculo)
        if(request.method == 'POST'):
            formularioVehiculo = FormularioVehiculo(request.POST)
            if formularioVehiculo.is_valid():
                formVehiculo = formularioVehiculo.cleaned_data
                if Vehiculo.objects.filter(placa=formVehiculo['placa']).exists():
                    messages.error(request,'La placa ya está registrada')
                else:
                    vehiculo = Vehiculo()
                    vehiculo.marca = formVehiculo['marca']
                    vehiculo.modelo = formVehiculo['modelo']
                    vehiculo.placa = formVehiculo['placa']
                    vehiculo.anio = formVehiculo['anio']
                    vehiculo.motor = formVehiculo['motor']
                    vehiculo.chasis= formVehiculo['chasis']
                    vehiculo.num_ejes = formVehiculo['num_ejes']
                    vehiculo.capacidad = formVehiculo['capacidad']
                    #vehiculo.estado = False
                    vehiculo.empresa = empresaVehiculo
                    vehiculo.save()
                return redirect('/registrarVehiculo')
            else:
                return render(request,'gestionTransporte/registrarVehiculo.html',{"formularioVehiculo":formularioVehiculo,"vehiculos":vehiculos})
        else:
            formularioVehiculo = FormularioVehiculo()
            return render(request, 'gestionTransporte/registrarVehiculo.html',{"formularioVehiculo":formularioVehiculo,"vehiculos":vehiculos})
    elif request.user.rol=="aduana":
        return redirect('/gestionAduana')

def eliminarVehiculo(request,id):
    vehiculo = Vehiculo.objects.get(id=id)
    vehiculo.delete()
    return redirect('/registrarVehiculo')

def edicionVehiculo(request,id):
    vehiculo = Vehiculo.objects.get(id=id)
    return render(request, 'gestionTransporte/vehiculo.html',{"vehiculo":vehiculo})

def editarVehiculo(request):
    marca = request.POST['txtMarca']
    motor= request.POST['txtmotor']
    modelo = request.POST['txtModelo']
    chasis = request.POST['txtChasis']
    placa = request.POST['txtPlaca']
    ejes = request.POST['txtEjes']
    anio = request.POST['txtYear']
    capacidad = request.POST['txtCapacidad']

    vehiculo = Vehiculo.objects.get(id=request.POST['txtId'])
    vehiculo.marca = marca
    vehiculo.motor = motor
    vehiculo.modelo = modelo
    vehiculo.chasis = chasis
    vehiculo.placa = placa
    vehiculo.num_ejes = ejes
    vehiculo.anio = anio
    vehiculo.capacidad = capacidad
    vehiculo.save()
    return redirect('/registrarVehiculo')

@login_required 
def registrarMotorista(request):
    empresaMotorista = Empresa.objects.get(usuario_sistema=UsuarioSistema.objects.get(username=request.user))
    motoristas = Motorista.objects.filter(empresa=empresaMotorista)
    #select_sexo= Sexo.objects.all()
    #empresaMotorista.objects.filter()
    if(request.method=='POST'):
        formularioMotorista = FormularioTransportista(request.POST)
        if formularioMotorista.is_valid():
            formMotorista = formularioMotorista.cleaned_data
            if Motorista.objects.filter(doc_identificacion=formMotorista['docIdentificacion']).exists():
                messages.error(request,'El transportista ya existe')
            elif Motorista.objects.filter(licencia = formMotorista['licencia']).exists():
                messages.error(request,'El transportista con esa licencia ya existe')
            else:
                motorista = Motorista()
                motorista.nombre = formMotorista['nombreTransportista']
                motorista.apellido = formMotorista['apellidoTransportista']
                motorista.doc_identificacion = formMotorista['docIdentificacion']
                motorista.licencia = formMotorista['licencia']
                motorista.sexo = formMotorista['sexo']
                motorista.empresa = empresaMotorista
                motorista.save()
            #return render(request, 'gestionTransporte/registrarMotorista.html')
            return redirect('/registrarMotorista')
        else:
            return render(request, 'gestionTransporte/registrarMotorista.html',{"formularioMotorista":formularioMotorista,"motoristas":motoristas}) 
    else:
        formularioMotorista = FormularioTransportista()
        return render(request, 'gestionTransporte/registrarMotorista.html',{"formularioMotorista":formularioMotorista,"motoristas":motoristas})

def eliminarMotorista(request,id):
    motorista= Motorista.objects.get(id=id)
    motorista.delete()
    return redirect('/registrarMotorista')

def edicionMotorista(request,id):
    motorista  = Motorista.objects.get(id=id)
    selectSexo = Sexo.objects.all()
    return render(request, 'gestionTransporte/motorista.html',{"selectSexo":selectSexo,"motorista":motorista})

def editarMotorista(request):
    motorista = Motorista.objects.get(id=request.POST['txtId'])
    
    nombre = request.POST['txtNombre']
    apellido = request.POST['txtApellido']
    documento = request.POST['txtDoc']
    licencia = request.POST['txtLic']
    sexo = Sexo.objects.get(id=request.POST['txtSexo'])

    motorista.nombre = nombre
    motorista.apellido= apellido
    motorista.doc_identificacion = documento
    motorista.licencia = licencia
    motorista.sexo = sexo
    motorista.save()
    return redirect('/registrarMotorista')


@csrf_protect 
@login_required
def registrarManifiestoCarga(request):
    mensaje_error=""
    fecha_ahora= datetime.today().strftime("%Y-%m-%d")
    registros_actuales=RegistroTransito.objects.all()
    numero_registro= len(registros_actuales)+1
    motoristas_disponibles= Motorista.objects.filter(empresa_id=
    Empresa.objects.get(usuario_sistema_id=request.user.id).id
    ).filter(estado_motorista=True)
    vehiculos_diponibles=Vehiculo.objects.filter(
        empresa_id= Empresa.objects.get(usuario_sistema_id= request.user.id).id
    ).filter(estado=True)
    empresa_dueña=Empresa.objects.get(usuario_sistema_id=request.user.id)
    pais_empresa=Pais.objects.get(id=empresa_dueña.pais_id)
    if request.method=='POST':
        formulario= FormularioRegistroTransito(request.POST)
        temp_motorista= request.POST['motorista']
        temp_vehiculo=request.POST['vehiculo']
        if temp_motorista!=" " and temp_vehiculo!=" ":
            motorista_temporal= Motorista.objects.get(id=temp_motorista)
            vehiculo_temporal= Vehiculo.objects.get(id=temp_vehiculo)
            if formulario.is_valid():
                datos_form= formulario.cleaned_data
                fecha_arribo= datos_form["fecha_destino"]
                if formulario.validar_fechas(datetime.now().date(),fecha_arribo):
                    pais_consignatario=datos_form["pais_consignatario"]
                    tipo_viaje= formulario.definir_tipo_viaje(pais_empresa,pais_consignatario)
                    carga_viaje= Carga(tipo=datos_form["tipo_carga"],
                                       descripcion=datos_form["descripcion_carga"],
                                       peso=datos_form["peso"])
                    carga_viaje.save()
                    motorista_temporal.estado_motorista=False
                    vehiculo_temporal.estado=False
                    motorista_temporal.save()
                    vehiculo_temporal.save()
                    registro_viaje= RegistroTransito(numero_registro=numero_registro,
                                                     origen=datos_form["origen"],
                                                     pais_consignatario=datos_form["pais_consignatario"],
                                                     fecha_destino=datos_form["fecha_destino"],
                                                     motorista=motorista_temporal,
                                                     vehiculo=vehiculo_temporal,
                                                     carga=carga_viaje,
                                                     aduana_destino=datos_form["aduana_destino"],
                                                     tipo_de_viaje=tipo_viaje,
                                                     empresa_dueña=empresa_dueña,
                                                     validacion_llave=None)
                    registro_viaje.save()
                    validacion_regsitro= Validacion(
                        estado_validacion='proceso',
                        fecha_validacion=None,
                        aduana= datos_form['aduana_destino'],
                        registro_transito=registro_viaje,
                    )
                    validacion_regsitro.save()
                    registro_viaje.validacion_llave=validacion_regsitro
                    registro_viaje.save()
                    return redirect('gestionTransporte:inicioEmpresa')
                else:
                    mensaje_error="La fecha de arribo no puede ser antes que la fecha actual"
                    return render(request,'gestionTransporte/registroManifiesto.html',
                                  {'formulario':formulario,'fecha_ahora':fecha_ahora,'motoristas':motoristas_disponibles,'vehiculos':vehiculos_diponibles,"error":mensaje_error}
                                 )
            else:
                return render(request,'gestionTransporte/registroManifiesto.html',
                          {'formulario':formulario,'fecha_ahora':fecha_ahora,'motoristas':motoristas_disponibles,'vehiculos':vehiculos_diponibles,"error":mensaje_error})
        else:
            mensaje_error="Falta seleccionar el vehiculo o el motorista"
            return render(request,'gestionTransporte/registroManifiesto.html',
                          {'formulario':formulario,'fecha_ahora':fecha_ahora,'motoristas':motoristas_disponibles,'vehiculos':vehiculos_diponibles,"error":mensaje_error}
                          )
    else:
        formulario= FormularioRegistroTransito()
        return render(request,'gestionTransporte/registroManifiesto.html',
                      {'formulario':formulario,"fecha_ahora":fecha_ahora,'motoristas':motoristas_disponibles,'vehiculos':vehiculos_diponibles,"error":mensaje_error}
                      )
                      
def registrarUsuario(request):
    if request.method== "POST":
        formularioRegistro= FormularioRegistroUsuario(request.POST)
        if formularioRegistro.is_valid():
            campos_formulario= formularioRegistro.cleaned_data
            nuevo_usuario= UsuarioSistema()
            print(campos_formulario['password2'],campos_formulario['password'])
            if campos_formulario['password2']==campos_formulario['password']:
                nuevo_usuario.username=campos_formulario['username']
                nuevo_usuario.set_password(campos_formulario['password2'])
                if campos_formulario['rolUsuario']=='1': 
                    nuevo_usuario.rol="empresa"
                    nuevo_usuario.save()
                    login(request, nuevo_usuario)
                    print(campos_formulario['rolUsuario'])
                    return redirect("gestionTransporte:registrarEmpresa")
                else:
                    nuevo_usuario.rol="aduana"
                    nuevo_usuario.save()
                    login(request, nuevo_usuario)
                    print(campos_formulario['rolUsuario'])
                    return redirect("gestionTransporte:gestionAduana")
                
        else:
            return render (request,"gestionTransporte/registrarUsuario.html",{"formularioRegistro":formularioRegistro})     
    
    formularioRegsitro= FormularioRegistroUsuario()
    return render (request,"gestionTransporte/registrarUsuario.html",{"formularioRegistro":formularioRegsitro})


@csrf_protect 
def iniciar_sesion(request):
    if request.method== "POST":
        formularioInicioSesion= FormularioIniciarSesion(request.POST)
        if formularioInicioSesion.is_valid():
            usuario_form= formularioInicioSesion.cleaned_data.get("username")
            usuario_pass= formularioInicioSesion.cleaned_data.get("password")
            user= authenticate(request,username=usuario_form,password=usuario_pass)
            print(user)
            if user is not None:
                print("entre a user is not none")
                login(request, user)
                if user.is_superuser:
                        return redirect("gestionTransporte:inicioAdministrador")
                if user.rol=="aduana":
                    return redirect("gestionTransporte:gestionAduana")
                else:
                    return redirect("/inicioEmpresa") 
                #return redirect("gestionTransporte:index")
            else:
                messages.error(request, "Usuario o contraseña incorrectos")
        else:
            messages.error(request, "Formulario no valido")

    formularioInicioSesion= FormularioIniciarSesion()
    return render(request,"gestionTransporte/login.html",{"formulario":formularioInicioSesion})
    #return render(request,"gestionTransporte/home_prueba.html")

def mostrar_inicio_empresa(request):
    return render(request,"gestionTransporte/inicio_empresas.html")

def realizar_logout(request):
    logout(request)
    return redirect("gestionTransporte:index")

@login_required
def registrarEmpresa(request):
    if request.method== "POST":
        formularioRegistro= FormularioRegistroEmpresa(request.POST)
        if formularioRegistro.is_valid():
            campos_formulario= formularioRegistro.cleaned_data
            nuevo_empresa= Empresa()
            nuevo_empresa.nit=campos_formulario['nitEmpresa']
            nuevo_empresa.correo=campos_formulario['correoEmpresa']
            nuevo_empresa.nombre=campos_formulario['nombreEmpresa']
            nuevo_empresa.direccion=campos_formulario['direccionEmpresa']
            nuevo_empresa.telefono=campos_formulario['telefonoEmpresa']
            nuevo_empresa.pais=campos_formulario['pais']
            nuevo_empresa.rubro=campos_formulario['rubroEmpresa']
            nuevo_empresa.usuario_sistema=UsuarioSistema.objects.get(username=request.user)
            nuevo_empresa.tipo_documento_empresa=campos_formulario['tipo_documento_empresa']
            nuevo_empresa.save()
            return redirect("gestionTransporte:iniciar_sesion")
        else:
            messages.error(request, "Formulario no valido")
            return render (request,"gestionTransporte/registrarEmpresa.html",{"formularioRegistro":formularioRegistro})  
               
    else:
        
        formularioRegsitro= FormularioRegistroEmpresa()
        return render (request,"gestionTransporte/registrarEmpresa.html",{"formularioRegistro":formularioRegsitro})

@login_required
def gestionAduana(request):
    usuarioAduana=AduanaUsuario.objects.filter(usuario_sistema_id=request.user.id)
    return render(request, 'gestionTransporte/gestionAduana.html',{"aduanas":usuarioAduana})

def ver_modal(request):
    registro_temporal= RegistroTransito.objects.get(id=2)
    registro= FormularioRegistroTransito(request.POST,instance=registro_temporal)
    return render(request,'gestionTransporte/ver_registro.htm',{'registro':registro})

@login_required
def trasnporte_list(request,id_aduana):
    nombreAduana=Aduana.objects.get(id=id_aduana)
    request.session['idAduana']=id_aduana
    f = RegistroTransporteFilter(request.GET, queryset=RegistroTransito.objects.filter(aduana_destino_id=id_aduana))
    return render(request, 'gestionTransporte/registroTransporte.html', {'filter': f,'nombreAduana': nombreAduana.nombre})

@csrf_protect 
def agregar_detalles_validacion(request,id_validacion):
    idAduana=request.session['idAduana']
    registro_en_validacion= Validacion.objects.get(id=id_validacion)
    cadena_redirecccionar="/detalle_validacion/"+str(id_validacion)
    registro_transito_validado= RegistroTransito.objects.get(id=registro_en_validacion.registro_transito_id)
    formulario_validacion= FormularioValidarRegistro(instance=registro_en_validacion)
    request.session['id_validacion']=id_validacion
    if request.method=="POST":
        formulario= FormularioAgregarDetallesValidacion(request.POST)
        if formulario.is_valid():
            datos_formulario= formulario.cleaned_data
            if request.POST['tipo_validacion']=='transportista':
                validacion_tipo= TipoValidacion.objects.get(id=1)
                nuevo_detalle_validacion= DetalleRegistroValidacion(
                    tipo_validacion=validacion_tipo,
                    descripcion_validacion=datos_formulario['descripcion_validacion'],
                    validacion= registro_en_validacion
                )
                nuevo_detalle_validacion.save()
                return redirect(cadena_redirecccionar)
            elif request.POST['tipo_validacion']=='vehiculo':
                validacion_tipo= TipoValidacion.objects.get(id=2)
                nuevo_detalle_validacion= DetalleRegistroValidacion(
                    tipo_validacion=validacion_tipo,
                    descripcion_validacion=datos_formulario['descripcion_validacion'],
                    validacion=registro_en_validacion
                )
                nuevo_detalle_validacion.save()
                return redirect(cadena_redirecccionar)
            elif request.POST['tipo_validacion']=='carga':
                validacion_tipo= TipoValidacion.objects.get(id=3)
                nuevo_detalle_validacion= DetalleRegistroValidacion(
                    tipo_validacion=validacion_tipo,
                    descripcion_validacion=datos_formulario['descripcion_validacion'],
                    validacion=registro_en_validacion
                )
                nuevo_detalle_validacion.save()
                return redirect(cadena_redirecccionar)
            elif formulario_validacion.is_valid() :
                print("llegamos a donde queriamos")
                datos_formulario_validacion= formulario_validacion.cleaned_data
                registro_en_validacion.estado_validacion=datos_formulario_validacion['estado_validacion']
                registro_en_validacion.fecha_validacion= datos_formulario_validacion['fecha_validacion']
                registro_en_validacion.aduana= datos_formulario_validacion['aduana']
                registro_en_validacion.save()
                return redirect(cadena_redirecccionar)
            else:
                motorista= Motorista.objects.get(id=registro_transito_validado.motorista_id)
                vehiculo = Vehiculo.objects.get(id=registro_transito_validado.vehiculo_id)
                carga= Carga.objects.get(id=registro_transito_validado.carga_id)
                detalles_validacion_motorista= DetalleRegistroValidacion.objects.filter(validacion_id=registro_en_validacion.id,tipo_validacion=1)
                detalles_validacion_vehiculos= DetalleRegistroValidacion.objects.filter(validacion_id=registro_en_validacion.id,tipo_validacion=2)
                detalles_validacion_carga= DetalleRegistroValidacion.objects.filter(validacion_id= registro_en_validacion.id,tipo_validacion=3)
                formulario_agregar_validacion= FormularioAgregarDetallesValidacion()
                return render(request,'gestionTransporte/detalle_validacion.html',{'motorista':motorista,'formulario':formulario_agregar_validacion
                     ,'observaciones_motorista':detalles_validacion_motorista,'observaciones_vehiculo':detalles_validacion_vehiculos,
                     'vehiculo':vehiculo,'carga':carga,
                     'observaciones_carga':detalles_validacion_carga,'formulario_validacion':formulario_validacion,'idAduana':idAduana}
                     )
        else:
           formulario_validacion= FormularioValidarRegistro(request.POST)
           if formulario_validacion.is_valid():
            datos_formulario=formulario_validacion.cleaned_data
            registro_en_validacion.estado_validacion=datos_formulario['estado_validacion']
            registro_en_validacion.fecha_validacion=datos_formulario['fecha_validacion']
            registro_en_validacion.aduana= datos_formulario['aduana']
            registro_en_validacion.save()
            return redirect(cadena_redirecccionar)
           else:
            return render(request,'gestionTransporte/detalle_validacion.html',{'motorista':motorista,'formulario':formulario_agregar_validacion
                     ,'observaciones_motorista':detalles_validacion_motorista,'observaciones_vehiculo':detalles_validacion_vehiculos,
                     'vehiculo':vehiculo,'carga':carga,
                     'observaciones_carga':detalles_validacion_carga,'formulario_validacion':formulario_validacion,'idAduana':idAduana}
                     )
            
    else:
        motorista= Motorista.objects.get(id=registro_transito_validado.motorista_id)
        vehiculo = Vehiculo.objects.get(id=registro_transito_validado.vehiculo_id)
        carga= Carga.objects.get(id=registro_transito_validado.carga_id)
        detalles_validacion_motorista= DetalleRegistroValidacion.objects.filter(validacion_id=registro_en_validacion.id,tipo_validacion=1)
        detalles_validacion_vehiculos= DetalleRegistroValidacion.objects.filter(validacion_id=registro_en_validacion.id,tipo_validacion=2)
        detalles_validacion_carga= DetalleRegistroValidacion.objects.filter(validacion_id= registro_en_validacion.id,tipo_validacion=3)
        formulario_agregar_validacion= FormularioAgregarDetallesValidacion()
        
        return render(request,'gestionTransporte/detalle_validacion.html',{'motorista':motorista,'formulario':formulario_agregar_validacion
                     ,'observaciones_motorista':detalles_validacion_motorista,'observaciones_vehiculo':detalles_validacion_vehiculos,
                     'vehiculo':vehiculo,'carga':carga,
                     'observaciones_carga':detalles_validacion_carga,'formulario_validacion':formulario_validacion,'idAduana':idAduana}
                     )

def eliminar_observacion(request, id_detalle):
    id_validacion=request.session.get('id_validacion')
    tmp_observacion= DetalleRegistroValidacion.objects.get(id=id_detalle)
    tmp_observacion.delete()
    return HttpResponseRedirect(reverse('gestionTransporte:agregar_detalles_validacion',args=(id_validacion,)))


def inicioEmpresa(request):
    empresa = Empresa.objects.get(usuario_sistema=UsuarioSistema.objects.get(username=request.user))
    registros = RegistroTransito.objects.filter(empresa_dueña = empresa)
    aceptados = []
    rechazados = []
    pendientes = []
    for registro in registros:
        if registro.validacion_llave.estado_validacion == 'aceptado':
            aceptados.append(registro)
        elif registro.validacion_llave.estado_validacion == 'denegado':
            rechazados.append(registro)
        else:
            pendientes.append(registro)
    return render(request,'gestionTransporte/inicioEmpresa.html', {"aceptados":aceptados,"empresa":empresa,"denegados":rechazados,"pendientes":pendientes})

def verRegistroTransito(request, id):
    registro = RegistroTransito.objects.get(id=id)
    detalleValidacion = DetalleRegistroValidacion.objects.filter(validacion=registro.validacion_llave)
    validacion = Validacion.objects.get(registro_transito=registro.id)
    return render(request, 'gestionTransporte/verRegistroTransito.html',{"registro":registro,"validacion":validacion,"detalleValidacion":detalleValidacion} )


def inicioAdministrador(request):
    modeloAduana= AduanaUsuario.objects.all()
    modeloAduana= AduanaUsuario.objects.all()
    return render(request,'gestionTransporte/inicioAdministrador.html',{"aduanas":modeloAduana})

def inicioAdministrador(request):
    if request.method == "POST":
        formulario_usuario_aduana=FormularioUsuario(request.POST)
        if formulario_usuario_aduana.is_valid():
            campos_formulario= formulario_usuario_aduana.cleaned_data
            usuarioAduana=AduanaUsuario()
            usuarioAduana.aduana_id=campos_formulario['aduana_id']
            usuarioAduana.usuario_sistema_id=UsuarioSistema.objects.get(username=campos_formulario['usuario_sistema_id'])
            result=AduanaUsuario.objects.filter(usuario_sistema_id=usuarioAduana.usuario_sistema_id,aduana_id=usuarioAduana.aduana_id)
            if result.count()==0:  
                usuarioAduana.save()                
    formulario_usuario_aduana=FormularioUsuario()  
    usuarioAduana=AduanaUsuario.objects.all().distinct('aduana_id','usuario_sistema_id')
    return render(request,'gestionTransporte/inicioAdministrador.html',{"usuarios":formulario_usuario_aduana,"usuarioAduana":usuarioAduana,})