from django import forms
import django_filters
from modulo_general.models import *

class PartidaListaFilter(django_filters.FilterSet):
    fecha_partida = django_filters.DateRangeFilter(widget=forms.Select(attrs={'class':'custom-select'}))
    class Meta:
        model = Partida
        fields = ['fecha_partida']
        