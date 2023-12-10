import os
import django 
import pandas

def main():
    os.environ.setdefault("DJANGO_SETTINGS_MODULE","scta_g16.settings")
    django.setup()
    from gestionTransporte.models import Pais
    direccion_archivo=datos_departamentos=open(os.path.dirname(os.path.abspath(__file__))+"\paises.xls")
    print("la direccion que estoy cargando es: {}".format(direccion_archivo.name))
    try:
        open_file= pandas.read_excel(direccion_archivo.name,engine='openpyxl')
        try:
            for valor in open_file.values:
                temp_pais= Pais(nombre_pais=valor[1])
                temp_pais.save()
        except Exception as error:
            print("Ocurrio un error 1. En la clase: {}".format(type(error).__name__))
    except Exception as error:
        print("Ocurrio un error. En la clase: {}".format(type(error).__name__))
if __name__=="__main__":
    main()