from time import process_time_ns
from django.shortcuts import render
from django.views.generic import TemplateView, ListView, CreateView
from django.urls import reverse_lazy
from .models import *
from .forms import *

# Create your views here.

class Inicio(ListView):
    model = Proyecto
    template_name= 'index.html'
    context_object_name = 'proyectos'

class proyectoPost(CreateView):
    template_name = 'registro_proyecto.html'
    model = Proyecto
    form_class = ProyectoForm
    success_url = reverse_lazy('modulo_costo:inicio_costos')


#definir funcion que reciba el id del proyecto renderice el template y mande el objeto proyecto
def controlCostos(request):
    pk = request.GET.get('pk', "")
    if pk!="":
        proyecto = Proyecto.objects.get(id_proyecto=int(pk))
        hoja_costos= hoja_mano_obra.objects.filter(id_proyecto=int(pk))
        tasa_del_proyecto = proyecto.id_costos_indirectos.tasa_costo_indirecto
        descripion_tasa = proyecto.id_costos_indirectos.descripcion_tasa_indirecta
        longitud_hoja_costos =  len(hoja_costos)
        costo_total_cif =  0
        
        for hoja in hoja_costos:
            print(hoja.cantidad_cargo)
            print(hoja.numero_hora)
            costo_total_cif+= hoja.cantidad_cargo*hoja.numero_hora*hoja.salario_hora
        total_importe_cif = tasa_del_proyecto * costo_total_cif
        #costos_indirectos= CostosIndirectos.objects.filter(id_proyecto=pk)
        return render(request, 'control_costos.html', {'proyecto': proyecto, 'hoja_costos': hoja_costos,'tasa': tasa_del_proyecto,'longitud' : longitud_hoja_costos,'costo_total':costo_total_cif,"importe_cif":total_importe_cif,"descripcion":descripion_tasa})


class hoja_mano_obraPost(CreateView):
    template_name = 'agregar_hoja_mano_obra.html'
    model = hoja_mano_obra
    form_class = HojaManoObraForm
    success_url = reverse_lazy('modulo_costo:inicio_costos')
