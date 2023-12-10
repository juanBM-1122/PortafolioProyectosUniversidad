from django.urls import path
from .views import *


app_name='modulo_costo'

urlpatterns = [
    path('inicio_costos',Inicio.as_view(), name="inicio_costos"),
    path('agregar_proyecto/',proyectoPost.as_view(),name="agregar_proyecto"),
    #path('control_costos/',controlCostos,name="control_costos"),
    path('control_costos/',controlCostos,name="control_costos"),
    path('agregar_hoja_mano_obra/',hoja_mano_obraPost.as_view(),name="agregar_hoja_mano_obra"),
]