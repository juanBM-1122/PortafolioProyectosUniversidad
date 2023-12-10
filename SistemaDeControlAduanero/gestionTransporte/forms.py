from dataclasses import field, fields
from random import choices
from secrets import choice
from tkinter import Widget
from tkinter.tix import Select
from warnings import filters
from django import forms
from django.contrib.auth.forms import ReadOnlyPasswordHashField
from django.contrib.admin.widgets import AdminDateWidget
from django.db import connection
from numpy import empty
from .models import *
import django_filters

prueba=[]

class DateInput(forms.DateInput):
    input_type="date"

class FormularioRegistroTransito(forms.ModelForm):
    tipo_carga= forms.CharField(max_length=30,widget=forms.TextInput(attrs={'class':"form-control"}))
    descripcion_carga=forms.CharField(max_length=250,
                                      widget=forms.Textarea(attrs={'cols':80,'rows':24,'class':'form-control'}))
    peso= forms.DecimalField(max_digits=10, decimal_places=2,min_value=0, widget=forms.NumberInput(attrs={'step':0.01,'class':'form-control'}))
    
    class Meta:
        model= RegistroTransito
        fields="__all__"
        exclude=['carga','numero_registro','motorista','vehiculo','tipo_de_viaje','empresa_dueña']
        widgets={
            'fecha_registro':DateInput(attrs={'class':"form-control"}),
            'fecha_destino':DateInput(attrs={'class':'form-control'}),
            'origen':forms.TextInput(attrs={'class':"form-control"}),
            'pais_consignatario':forms.Select(attrs={'class':"form-select"}),
            #'motorista':forms.Select(attrs={'class':'form-select'}),
            #'vehiculo':forms.Select(attrs={'class':'form-select'}),
            'aduana_destino': forms.Select(attrs={'class':'form-select'}),
        }
    def definir_tipo_viaje(self,pais_origen_empresa,pais_consignatario):
        tipo_de_viaje=""
        if pais_origen_empresa=="EL SALVADOR" and pais_consignatario.nombre_pais!="EL SALVADOR":
            tipo_de_viaje="exportacion"
        elif pais_origen_empresa!="EL SALVADOR" and pais_consignatario.nombre_pais=="EL SALVADOR":
            tipo_de_viaje="importacion"
        elif pais_origen_empresa!="EL SALVADOR" and pais_consignatario.nombre_pais!="EL SALVADOR":
            tipo_de_viaje="transito"
        return tipo_de_viaje
    def validar_fechas(self,fecha_actual,fecha_arribo):
        if fecha_actual < fecha_arribo:
            return True
        elif fecha_actual > fecha_arribo:
            return False

class FormularioRegistroUsuario(forms.Form):
    password= forms.CharField(widget=forms.PasswordInput)
    password2= forms.CharField(widget=forms.PasswordInput)
    username= forms.CharField()
    CHOICES = [('1', 'Usuario Empresa'), ('2', 'Usuario Aduana')]
    rolUsuario=forms.CharField(label='Rol',widget=forms.RadioSelect(choices=CHOICES))

    def clean_password2(self):
        password1=self.cleaned_data.get('password')
        passwordDos= self.cleaned_data.get("password2")
        if password1 and passwordDos and password1 != passwordDos:
            raise forms.ValidationError("Contraseña no coinciden")
        return passwordDos

    def clean_username(self):
        usuario= self.cleaned_data.get('username')
        query_existe= UsuarioSistema.objects.filter(username=usuario)
        if query_existe.exists():
            raise forms.ValidationError("Usuario ya registrado")
        return usuario


#registrar un usuario en consola
class FormaRegistro(forms.ModelForm):
    password= forms.CharField(widget=forms.PasswordInput)
    password2= forms.CharField(label='Confirm password',widget=forms.PasswordInput)

    class Meta:
        model= UsuarioSistema
        fields= ('username','password')

    def clean_username(self):
        usuario= self.cleaned_data.get('username')
        query_existe= UsuarioSistema.objects.filter(username=usuario)
        if query_existe.exists():
            raise forms.ValidationError("Correo ya registrado")
        return usuario

    def clean_password2(self):
        password1=self.cleaned_data.get('password1')
        password2= self.cleaned_data.get("password2")
        if password1 and password2 and password1 != password2:
            raise forms.ValidationError("Contraseña no coinciden")
        return password2



class FormularioIniciarSesion(forms.Form):
    username=forms.CharField(max_length=150,
    widget=forms.TextInput(attrs={"class":"form-control"})
    )
    password=forms.CharField(
        widget=forms.PasswordInput(attrs={"class":"form-control"})
    )

class FormularioTransportista(forms.ModelForm):

    nombreTransportista = forms.CharField(label="Nombre", widget=forms.TextInput(attrs={'class':"form-control"}))
    apellidoTransportista = forms.CharField(label='Apellido', widget=forms.TextInput(attrs={'class':"form-control"}))
    docIdentificacion = forms.CharField(label='Pasaporte/DUI', widget=forms.TextInput(attrs={'class':"form-control"}))
    licencia = forms.CharField(label='Licencia', widget=forms.TextInput(attrs={'class':"form-control"}))
    class Meta:
        model = Motorista
        fields="__all__"
        exclude=['nombre','apellido','doc_identificacion','licencia','estado_motorista','empresa']
        widgets={
            'sexo':forms.Select(attrs={'class':"form-select"})
        }
         #sexo = forms.ChoiceField(label='sexo',widget=forms.Select(attrs={'class':"form-select"}))
    #empresa = forms.CharField(label = 'Empresa', widget=forms.TextInput(attrs={'class':"form-control"}))

class FormularioVehiculo(forms.Form):
    marca = forms.CharField(label='Marca', widget=forms.TextInput(attrs={'class':"form-control"}))
    modelo = forms.CharField(label='Modelo', widget=forms.TextInput(attrs={'class':"form-control"}))
    placa = forms.CharField(label='Placa', widget=forms.TextInput(attrs={'class':"form-control"}))
    anio = forms.IntegerField(label='Año', widget=forms.NumberInput(attrs={'class':"form-control",'min':1900,'max':2100,'step':1}))
    motor = forms.CharField(label='Motor', widget=forms.TextInput(attrs={'class':"form-control"}))
    chasis = forms.CharField(label='Chasis', widget=forms.TextInput(attrs={'class':"form-control"}))
    num_ejes = forms.IntegerField(label='Número de ejes', widget=forms.NumberInput(attrs={'class':"form-control", 'step':"1"}))
    capacidad = forms.DecimalField(label='Capacidad', widget=forms.TextInput(attrs={'class':"form-control"}))
    #estado = forms.BooleanField(label='Estado', widget=forms.TextInput(attrs={'class':"form-control"}))
    #empresa = forms.CharField(label='Empresa', widget=forms.TextInput(attrs={'class':"form-control"}))
    
class FormularioRegistroEmpresa(forms.ModelForm):
    nitEmpresa= forms.CharField(label="NIT",max_length=20,widget=forms.TextInput(attrs={'class':"form-control col-md-2"}))
    nombreEmpresa= forms.CharField(label="Nombre",max_length=50,widget=forms.TextInput(attrs={'class':"form-control col-md-4"}))
    correoEmpresa= forms.EmailField(label="Correo",max_length=50,widget=forms.EmailInput(attrs={'class':"form-control"}))
    direccionEmpresa= forms.CharField(label="Direccion",max_length=50,widget=forms.TextInput(attrs={'class':"form-control"}))
    telefonoEmpresa= forms.CharField(label="Telefono",max_length=20,widget=forms.TextInput(attrs={'class':"form-control"}))
    rubroEmpresa= forms.CharField(label="Rubro",max_length=50,widget=forms.TextInput(attrs={'class':"form-control"}))
    
    class Meta:
        model= Empresa
        fields=('pais','tipo_documento_empresa',)
        widgets={
            'pais': forms.Select(attrs={'class':'form-select'}),
            'tipo_documento_empresa': forms.Select(attrs={'class':'form-select col-md-2'}),
        }

    def clean_nitEmpresa(self):
        nit= self.cleaned_data.get('nitEmpresa')
        query_existe= Empresa.objects.filter(nit=nit)
        if query_existe.exists():
            raise forms.ValidationError("Empresa ya registrada")
        return nit


class FormularioGestionAduana(forms.Form):
    filtroNombre= forms.CharField(label="Nombre",max_length=50,widget=forms.TextInput(attrs={'class':"form-control"}))
    searchBar= forms.CharField(label="Buscar",max_length=50,widget=forms.TextInput(attrs={'class':"form-control me-sm-2", 'placeholder':'Search'}))


def empresas(request):
    if request is None or request:
        empresas_lista_1= RegistroTransito.objects.select_related('empresa_dueña_id').distinct('empresa_dueña').values_list('empresa_dueña')
        empresas_lista= Empresa.objects.filter(id__in=empresas_lista_1)
        return empresas_lista
        
def paises(request):
    if request is None or request:
        return Pais.objects.all()

class RegistroTransporteFilter(django_filters.FilterSet):

    
    #filtro por empresa 
    #l = []
    #for c in RegistroTransito.objects.all():
    #    l.append((c.empresa_dueña.id, c.empresa_dueña.nombre))
    #empresa_dueña = django_filters.ChoiceFilter(
        #choices=set(l),empty_label="Empresas",widget=forms.Select(attrs={'class':'form-select'}))
    empresa_dueña=django_filters.ModelChoiceFilter(queryset=empresas,widget=forms.Select(attrs={'class':'form-select'}),empty_label="Empresas")
    #filtro por fecha de arrivo
    fecha_destino = django_filters.DateRangeFilter(empty_label='Fecha de arrivo',widget=forms.Select(attrs={'class':'form-select'}))

    #filtro por tipo de viaje
    tipo_de_viaje =  django_filters.AllValuesFilter(empty_label='Categorias',widget=forms.Select(attrs={'class':'form-select'}))

    #filtrar por fecha de registro
    fecha_registro = django_filters.DateRangeFilter(empty_label='Fecha de registro',widget=forms.Select(attrs={'class':'form-select'}))

    #Filtro por pais
    j = []
    #for c in RegistroTransito.objects.all():
    #    j.append((c.pais_consignatario.id, c.pais_consignatario.nombre_pais))
    #pais_consignatario = django_filters.ChoiceFilter(
    #    choices=set(j),empty_label="Paises",widget=forms.Select(attrs={'class':'form-select'}))
    pais_consignatario=django_filters.ModelChoiceFilter(queryset=paises,widget=forms.Select(attrs={'class':'form-select'}), empty_label='Pais Consignatario')

    #Filtro por numero de registro
    numero_registro = django_filters.CharFilter(label='Número de registro',widget=forms.TextInput(attrs={'class':"form-control"}))

     #Filtro por validacion

    
    class Meta:
        model = RegistroTransito
        fields ={
        'empresa_dueña', 
        'pais_consignatario', 
        'tipo_de_viaje',
        'fecha_registro',
        'fecha_destino'
        }
    



class FormularioValidarRegistro(forms.ModelForm):
    class Meta:
        estados_validacion_choices=(
        ('proceso','proceso'),
        ('aceptado','aceptado'),
        ('denegado','denegado'),
        )
        model=Validacion
        fields=('estado_validacion','aduana','fecha_validacion')
        widgets={
            'estado_validacion': forms.Select(attrs={'class':'form-select'},choices=estados_validacion_choices),
            'aduana':forms.Select(attrs={'class':'form-select'}),
            'fecha_validacion':DateInput(attrs={'class':"form-control"}),
        }

class FormularioAgregarDetallesValidacion(forms.ModelForm):
    class Meta:
        model=DetalleRegistroValidacion
        fields="__all__"
        exclude=['validacion','tipo_validacion']
        widgets={
            'tipo_validacion': forms.Select(attrs={'class':'form-control'}),
            'descripcion_validacion':forms.Textarea(attrs={'rows':'3','col':'10','class':'form-control'})
        }
class FormularioPrueba(forms.ModelForm):
    lista_usuarios_aduana=[]
    for c in UsuarioSistema.objects.all():
        if c.rol=='aduana':
            lista_usuarios_aduana.append((c.username, c.username))
    usuario_sistema_id= forms.CharField(widget=forms.Select(attrs={'class':'form-select'},choices=lista_usuarios_aduana))
    class Meta:
        model=AduanaUsuario
        fields=('aduana_id',)
        widgets={
            'aduana_id':forms.Select(attrs={'class':'form-select'})
        }
    pass

class FormularioUsuario(forms.ModelForm):
    def __init__(self, *args, **kwargs):
        super(FormularioUsuario, self).__init__(*args, **kwargs)
        self.fields['usuario_sistema_id']=forms.ModelChoiceField(
            required=True,queryset=UsuarioSistema.objects.filter(rol='aduana'),
            widget=forms.Select(attrs={'class':'form-select'})
        )

    #usuario_sistema_id= forms.CharField(widget=forms.Select(attrs={'class':'form-select'}))
    class Meta:
        model=AduanaUsuario
        fields={'aduana_id'}
        widgets={
            'aduana_id':forms.Select(attrs={'class':'form-select'}),
        }
