from django.urls import path
from .views import *


app_name='modulo_general'

urlpatterns = [
    path('',Inicio.as_view(), name="mostrar_inicio"),
    path('partida_diario/', LibroDiario.as_view(), name="mostrar_partida_diario"),
    path('libro_mayor/', LibroMayor.as_view(), name="libro_mayor"),
    path('control-mayorizacion/',control_mayorizacion,name="control-mayorizacion"),
    path('partida/',PartidaFilterView.as_view(),name="partida"),
    path('mostrar_libro_mayor/<int:id_libro_mayor>',mostrar_libro_mayor,name="mostrar_libro_mayor"),
    path('balance_comprobacion/', BalanceComprobacion.as_view(),name="balance_comprobacion"),
    path('ajustar_balance/',ajustar_balance,name="ajustar_balance"),
    path('lista-estado-resultados',EstadoDeResultadoVista.as_view(),name="lista-estado-resultado"),
    path('lista-estado-capital',VistaEstadoCapital.as_view(),name="lista-estado-capital"),
    path('lista-balance-general',VistaBalanceGeneral.as_view(),name="lista-balance-general"),
]