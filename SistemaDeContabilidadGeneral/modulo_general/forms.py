from dataclasses import field
from pyexpat import model
from django import forms

from modulo_general.models import Registro

class PartidaDiarioForm(forms.ModelForm):
    class Meta:
        model = Registro
        fields = [
            'monto',
            'tipo_registro',
            'cuenta',
        ]
        labels = {
            'monto': 'Monto',
            'tipo_registro': 'Tipo de Registro',
            'cuenta': 'Cuenta',
        }
        widgets = {
            'monto': forms.TextInput(attrs={'class': 'form-control'}),
            'tipo_registro': forms.Select(attrs={'class': 'form-control'}),
            'cuenta': forms.Select(attrs={'class': 'form-control'}),
        }

class LibroMayor():
    pass