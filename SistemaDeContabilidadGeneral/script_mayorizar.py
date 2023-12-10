from cgi import print_arguments
import os

import django

os.environ.setdefault("DJANGO_SETTINGS_MODULE","scg_22.settings")

django.setup()

from modulo_general.views import *

# libro_mayor=LibroMayor()
# dt_inicial="2022-10-17"
# dt_final="2022-10-20"

# partidas= libro_mayor.obtener_partidas_periodo(dt_inicial,dt_final)
# transacciones= libro_mayor.obtener_registros(partidas)
# print("las transacciones del periodo son {}".format(transacciones))
# libro_mayor.mayorizar(transacciones,dt_inicial,dt_final)

# balance_comprobacion= BalanceComprobacion()
# registros= balance_comprobacion.obtener_registros_de_ajuste()

# diccionario_registros= balance_comprobacion.ordenar_registro_por_nombre_cuenta(registros)
# saldos= balance_comprobacion.obtener_saldo_por_cuenta_ajuste(diccionario_registros)
vista_balance_general = VistaBalanceGeneral()
diccionario=vista_balance_general.obtener_registros_balance(11)
diccionario_2 = vista_balance_general.ordenar_cuentas_para_mostrar(diccionario)
print("Aqui esta la prueba de los diccionarios")
for valores in diccionario_2["debe"]:
    print(valores.nombre_cuenta+" : ",valores.saldo_cuenta, valores.codigo_cuenta)




