import os
import json
import django 

def main():
    #indicar que utilize el archivo settings
    os.environ.setdefault("DJANGO_SETTINGS_MODULE","scta_g16.settings")
    django.setup()
    from gestionTransporte.models import Municipio, Departamento
    datos_departamentos=open(os.path.dirname(os.path.abspath(__file__))+"\departamentos.json")
    datos_departamentos= json.load(datos_departamentos)
    for departamento in datos_departamentos:
        nuevo_departamento= Departamento(codigo_departamento=departamento['id'],
                                         nombre_departamento=departamento['nombre'])
        nuevo_departamento.save()
        departamento_temporal= Departamento.objects.get(codigo_departamento=departamento['id'])
        for municipios in departamento['municipios'] :
            municipio=Municipio(departamento=departamento_temporal,
                                codigo_municipio=municipios['id_mun'],
                                nombre_municipio=municipios['nombre'])
            municipio.save()
if __name__=="__main__":
    main()