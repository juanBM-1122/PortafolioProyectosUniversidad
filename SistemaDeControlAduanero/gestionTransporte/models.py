from pyexpat import model
from django.db import models
from django.contrib.auth.models import AbstractUser
from .manager import UserManager

#tipo usuario ¿empresa  ---- aduana?

# Create your models here.
class TipoDocumento(models.Model):
    tipo_documento= models.CharField(max_length=50)
    
    def __str__(self) -> str:
        return "{}".format(self.tipo_documento)

class Sexo(models.Model):
    nombre_sexo=models.CharField(max_length=30)

    def __str__(self) -> str:
        return "{}".format(self.nombre_sexo)

class UsuarioSistema(AbstractUser):
    rol = models.CharField(max_length=15)
    REQUIRED_FIELDS=['email']

class Departamento(models.Model):
    codigo_departamento= models.CharField(max_length=2, primary_key=True)
    nombre_departamento= models.CharField(max_length=100)

class Municipio(models.Model):
    departamento= models.ForeignKey(Departamento, on_delete=models.PROTECT)
    codigo_municipio= models.CharField(max_length=4, primary_key=True)
    nombre_municipio= models.CharField(max_length=100)

    def __str__(self) -> str:
        return "{}".format(self.nombre_municipio)

class Pais(models.Model):
    nombre_pais=models.CharField(max_length=75)

    def __str__(self) -> str:
        return "{}".format(self.nombre_pais)
    
class Aduana(models.Model):
    nombre = models.CharField(max_length=30)
    direccion = models.CharField(max_length=70)
    municipio= models.ForeignKey(Municipio,on_delete=models.PROTECT)
    usuario_sistema = models.ManyToManyField(UsuarioSistema)

    def __str__(self) -> str:
        return "{}".format(self.nombre)

class Empresa(models.Model):
    nit = models.CharField(max_length=15)
    nombre = models.CharField(max_length=30)
    correo = models.EmailField()
    direccion = models.CharField(max_length=70)
    telefono = models.CharField(max_length=15)
    pais = models.ForeignKey(Pais, on_delete=models.PROTECT, null=True)
    rubro = models.CharField(max_length=30)
    usuario_sistema = models.OneToOneField(UsuarioSistema,on_delete=models.CASCADE)
    tipo_documento_empresa= models.ForeignKey(TipoDocumento,on_delete=models.PROTECT)

    def __str__(self) -> str:
        return "{}".format(self.nombre)

class Motorista(models.Model):
    nombre = models.CharField(max_length=30)
    apellido = models.CharField(max_length=30)
    doc_identificacion = models.CharField(max_length=30)
    licencia = models.CharField(max_length=30)
    sexo = models.CharField(max_length=30)
    nombre = models.CharField(max_length=30)
    estado_motorista= models.BooleanField(default=True)
    empresa = models.ForeignKey(Empresa, on_delete=models.CASCADE)
    sexo= models.ForeignKey(Sexo, on_delete=models.PROTECT)

    def __str__(self) -> str:
        return "{}, Licencia: {}".format(self.nombre,self.licencia)

class Vehiculo(models.Model):
    marca = models.CharField(max_length=30)
    modelo = models.CharField(max_length=30)
    placa = models.CharField(max_length=30)
    anio = models.IntegerField()
    motor = models.CharField(max_length=30)
    chasis = models.CharField(max_length=30)
    num_ejes = models.IntegerField()
    capacidad = models.DecimalField(max_digits=10, decimal_places=2)
    estado = models.BooleanField(default=True)
    empresa = models.ForeignKey(Empresa, on_delete=models.CASCADE)

    def __str__(self) -> str:
        return "{}".format(self.placa)

class Carga(models.Model):
    tipo = models.CharField(max_length=30)
    descripcion = models.CharField(max_length=250)
    peso = models.DecimalField(max_digits=10,decimal_places=2)

    def __str__(self) -> str:
        return "{}, {} kg".format(self.tipo,self.peso)

class RegistroTransito(models.Model):
    numero_registro = models.IntegerField()
    origen = models.CharField(max_length=150)
    pais_consignatario = models.ForeignKey(Pais, on_delete=models.PROTECT)
    fecha_registro = models.DateField(auto_now_add=True)
    fecha_destino = models.DateField()
    motorista = models.ForeignKey(Motorista, on_delete=models.CASCADE)
    vehiculo = models.ForeignKey(Vehiculo, on_delete = models.CASCADE)
    carga = models.OneToOneField(Carga, on_delete=models.CASCADE)
    aduana_destino= models.ForeignKey(Aduana, on_delete=models.PROTECT,null=True)
    tipo_de_viaje= models.CharField(max_length=20)
    empresa_dueña=models.ForeignKey("Empresa", on_delete=models.PROTECT)
    validacion_llave= models.ForeignKey("Validacion",on_delete=models.CASCADE, blank=True, null=True)

    def __str__(self) -> str:
        return "numero registro: {}".format(self.numero_registro)


class Validacion(models.Model):
    estado_validacion=models.CharField(max_length=50)#validado denegado en proceso)
    fecha_validacion= models.DateField(blank=True,null=True)
    aduana = models.ForeignKey(Aduana, on_delete=models.CASCADE, blank=True)
    registro_transito = models.OneToOneField(RegistroTransito, on_delete=models.PROTECT)

class TipoValidacion(models.Model):
    tipo_validacion=models.CharField(max_length=45)

    def __str__(self) -> str:
        return "{}".format(self.tipo_validacion)

class DetalleRegistroValidacion(models.Model):
    validacion= models.ForeignKey(Validacion,on_delete=models.PROTECT)
    tipo_validacion=models.ForeignKey(TipoValidacion, on_delete=models.PROTECT)
    descripcion_validacion=models.CharField(max_length=250)

class AduanaUsuario(models.Model):
    aduana_id=models.ForeignKey(Aduana,on_delete=models.PROTECT)
    usuario_sistema_id= models.ForeignKey(UsuarioSistema,on_delete=models.PROTECT)