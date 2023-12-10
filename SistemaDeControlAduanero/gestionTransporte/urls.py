from django.urls import path, re_path
from .views import *
from django.contrib.auth import views
app_name="gestionTransporte"

urlpatterns = [
    path('index/', index, name="index"),
    path('registrarVehiculo/', registrarVehiculo, name="registrarVehiculo"),
    path('eliminarVehiculo/<id>',eliminarVehiculo),
    path('edicionVehiculo/<id>',edicionVehiculo),
    path('editarVehiculo/', editarVehiculo),
    path('registrarMotorista/', registrarMotorista,name="registrarMotorista"),
    path('eliminarMotorista/<id>',eliminarMotorista),
    path('edicionMotorista/<id>',edicionMotorista),
    path('editarMotorista/', editarMotorista),
    path('registroManifiesto/',registrarManifiestoCarga, name="registroManifiesto"),
    path('registrarEmpresa/', registrarEmpresa,name="registrarEmpresa"),
    path('registroUsuario/',registrarUsuario, name="registroUsuario"),
    path('empresa_home/',mostrar_inicio_empresa, name="inicioEmpresa"),
    path('login/',iniciar_sesion, name="iniciar_sesion"),
    path('logout/',realizar_logout, name="logout_sesion"),
    path('accounts/login/', iniciar_sesion, name='login_autenticacion'),
    path('modal_registro/',ver_modal,name="ver_modal"),
    path('listadoRegistroTransporte/<int:id_aduana>', trasnporte_list, name='trasnporte_list'),
    path('detalle_validacion/<int:id_validacion>',agregar_detalles_validacion,name="agregar_detalles_validacion"),
    path('eliminar_observacion/<int:id_detalle>',eliminar_observacion,name="eliminar_observacion"),
    path('inicioEmpresa/', inicioEmpresa, name="inicioEmpresa"),
    path('inicioAdministrador/', inicioAdministrador, name="inicioAdministrador"),
    path('verRegistroTransito/<id>', verRegistroTransito, name='verRegistroTransito'),
    path('inicioAdministrador/', inicioAdministrador, name="inicioAdministrador"),
    path('gestionAduana/', gestionAduana, name="gestionAduana"),
    ]