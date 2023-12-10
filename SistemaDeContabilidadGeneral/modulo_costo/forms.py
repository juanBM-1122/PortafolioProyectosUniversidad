from django import forms
from modulo_costo.models import *

class ProyectoForm(forms.ModelForm):
    class Meta:
        model = Proyecto
        fields = [
            'nombre_proyecto',
            'fecha_expedicion',
            'departamento',
            'servicio',
            'presupuesto_cliente',
            'numero_orden',
            'descripcion',
            #'id_hoja_mano_obra',
            'id_costos_indirectos',
        ]
        labels = {
            'nombre_proyecto': 'Nombre del Proyecto',
            'fecha_expedicion': 'Fecha de Expedicion',
            'departamento': 'Departamento',
            'servicio': 'Servicio',
            'presupuesto_cliente': 'Presupuesto del Cliente',
            'numero_orden': 'Numero de Orden',
            'descripcion': 'Descripcion',
            #'id_hoja_mano_obra': 'Hoja de Mano de Obra',
            'id_costos_indirectos': 'Costos Indirectos',
        }
        widgets = {
            'nombre_proyecto': forms.TextInput(attrs={'class': 'form-control'}),
            'fecha_expedicion': forms.DateInput(attrs={'class': 'form-control'}),
            'departamento': forms.TextInput(attrs={'class': 'form-control'}),
            'servicio': forms.TextInput(attrs={'class': 'form-control'}),
            'presupuesto_cliente': forms.TextInput(attrs={'class': 'form-control'}),
            'numero_orden': forms.TextInput(attrs={'class': 'form-control'}),
            'descripcion': forms.TextInput(attrs={'class': 'form-control'}),
            #'id_hoja_mano_obra': forms.Select(attrs={'class': 'form-control'}),
            'id_costos_indirectos': forms.Select(attrs={'class': 'form-control'}),
        }

class CostosIndirectosForm(forms.ModelForm):
    class Meta:
        model = CostosIndirectos
        fields = [
            'tasa_costo_indirecto',
            #'id_proyecto',
        ]
        labels = {
            'tasa_costo_indirecto': 'Tasa de Costo Indirecto',
            #'id_proyecto': 'Proyecto',
        }
        widgets = {
            'tasa_costo_indirecto': forms.TextInput(attrs={'class': 'form-control'}),
            #'id_proyecto': forms.Select(attrs={'class': 'form-control'}),
        }

class HojaManoObraForm(forms.ModelForm):
    class Meta:
        model = hoja_mano_obra
        fields = [
            'id_proyecto',
            'nombre_cargo',
            'cantidad_cargo',
            'numero_hora',
            'salario_hora', 
        ]
        labels = {
            'id_proyecto': 'Proyecto',
            'nombre_cargo': 'Nombre del Cargo',
            'cantidad_cargo': 'Cantidad del Cargo',
            'numero_hora': 'Numero de Horas',
            'salario_hora': 'Salario por Hora',
        }
        widgets = {
            'id_proyecto': forms.Select(attrs={'class': 'form-control'}),
            'nombre_cargo': forms.TextInput(attrs={'class': 'form-control'}),
            'cantidad_cargo': forms.TextInput(attrs={'class': 'form-control'}),
            'numero_hora': forms.TextInput(attrs={'class': 'form-control'}),
            'salario_hora': forms.TextInput(attrs={'class': 'form-control'}),
        }
