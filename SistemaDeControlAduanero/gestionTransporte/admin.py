from django.contrib import admin
from django.contrib.auth.admin import UserAdmin
# Register your models here.

from gestionTransporte.models import *

class AdminUsuarioSistema(UserAdmin):
    fieldsets =fieldsets = (
        (None, {"fields": ("username", "password","rol")}),
        ("Personal info", {"fields": ("first_name", "last_name", "email")}),
        (
            "Permissions",
            {
                "fields": (
                    "is_active",
                    "is_staff",
                    "is_superuser",
                    "groups",
                    "user_permissions",
                ),
            },
        ),
    )
admin.site.register(Motorista)
admin.site.register(UsuarioSistema,AdminUsuarioSistema)
admin.site.register(Vehiculo)
admin.site.register(Empresa)
admin.site.register(Aduana)
admin.site.register(RegistroTransito)
admin.site.register(Carga)
admin.site.register(Validacion)
admin.site.register(Pais)
admin.site.register(Departamento)
admin.site.register(Municipio)
admin.site.register(DetalleRegistroValidacion)
admin.site.register(TipoDocumento)
admin.site.register(Sexo)