from django.db import models

# Create your models here.
from django.db import models

# Create your models here.

class ClaseCuenta(models.Model):
    id_clase_cuenta= models.AutoField(primary_key=True, unique=True,verbose_name="id_clase_cuenta")
    nombre_clase_cuenta=models.CharField(max_length=40,blank=False,null=False,verbose_name="nombre_clase_cuenta")
    codigo_clase_cuenta=models.CharField(max_length=1, blank=False, null=False,verbose_name="codigo_clase_cuenta")

    def __str__(self) -> str:
        return ("{} {}".format(self.codigo_clase_cuenta,self.nombre_clase_cuenta))

class GrupoCuenta(models.Model):
    id_grupo_cuenta=models.AutoField(primary_key=True,unique=True,verbose_name="id_grupo_cuenta")
    nombre_grupo_cuenta= models.CharField(max_length=40,blank=False,null=False,verbose_name="nombre_grupo_cuenta")
    codigo_grupo_cuenta=models.CharField(max_length=2,blank=False,null=False,verbose_name="codigo_grupo_cuenta")
    clase_cuenta= models.ForeignKey(ClaseCuenta,on_delete=models.CASCADE)
    def __str__(self) -> str:
        return ("{} {}".format(self.codigo_grupo_cuenta,self.nombre_grupo_cuenta))

class Cuenta(models.Model):
    id_cuenta=models.AutoField(primary_key=True,unique=True, verbose_name="id_cuenta")
    nombre_cuenta= models.CharField(max_length=40,blank=False,null=False,verbose_name="nombre_cuenta")
    codigo_cuenta=models.CharField(max_length=3,null=False,blank=False,verbose_name="codigo_cuenta")
    grupo_cuenta=models.ForeignKey(GrupoCuenta,on_delete=models.CASCADE,verbose_name="grupo_cuenta")
    def __str__(self):
        return self.nombre_cuenta
    

class TipoRegistro(models.Model):
    id_tipo_registro= models.AutoField(primary_key=True,unique=True,verbose_name="id_tipo_regsitro")
    nombre_tipo_registro=models.CharField(max_length=5,blank=False,null=False,verbose_name="nombre_tipo_registro")
    def __str__(self):
        return self.nombre_tipo_registro

class LibroMayor(models.Model):
    id_libro_mayor= models.AutoField(primary_key=True,unique=True,verbose_name="id_tipo_registro")
    fecha_de_inicio_periodo= models.DateField()
    fecha_fin_periodo= models.DateField()
    
    def __str__(self) -> str:
        return "{} {}".format(self.fecha_de_inicio_periodo,self.fecha_fin_periodo)
    
class CuentaT(models.Model):
    id_cuenta_T= models.AutoField(primary_key=True,unique=True,verbose_name="id_cuenta_T")
    saldo_cuenta_T=models.FloatField(verbose_name="saldo_cuenta_T")
    libro_mayor= models.ForeignKey(LibroMayor,on_delete=models.CASCADE,blank=True, null=True)
    cuenta=models.ForeignKey(Cuenta,on_delete=models.CASCADE,blank=True, null=True)

    def __str__(self) -> str:
        return ("{}".format(self.saldo_cuenta_T))

class Partida(models.Model):
    id_partida= models.AutoField(primary_key=True,unique=True,verbose_name="id_partida")
    fecha_partida= models.DateTimeField(null=True, blank= True)
    descripcion_partida= models.CharField(max_length=350, null=True)
    numero_partida= models.IntegerField(null=True,blank=True)
    es_partida_ajuste=models.BooleanField(default=False)

    def __str__(self) -> str:
        return ("{} {}".format(self.fecha_partida.strftime('%d-%m-%Y'),self.descripcion_partida))

class Registro(models.Model):
    id_registro= models.AutoField(primary_key=True,unique=True,verbose_name="id_registro")
    monto= models.FloatField(blank=False,null=False,verbose_name="monto")
    partida= models.ForeignKey(Partida,on_delete=models.CASCADE,verbose_name="partida")
    cuenta= models.ForeignKey(Cuenta,on_delete=models.CASCADE)
    libro_mayor= models.ForeignKey(CuentaT,on_delete=models.CASCADE,null=True, blank=True)#este campo hace referencia a la cuenta T correspondiente en la mayorizacion
    tipo_registro= models.ForeignKey(TipoRegistro,on_delete=models.CASCADE)


    def __str__(self) -> str:
        return "{} {} {}".format(self.id_registro,self.monto,self.partida)

class BalanceComprobacion(models.Model):
    saldo_debe= models.FloatField(blank=False,null=False,verbose_name="saldo_debe")
    saldo_haber=models.FloatField(blank=False,null=False,verbose_name="saldo_haber")
    libro_mayor=models.OneToOneField(LibroMayor,on_delete=models.CASCADE)
    esta_ajustado= models.BooleanField(default=False)

    def __str__(self) -> str:
        return "id: {}".format(self.id)

class EstadoResultado(models.Model):
    fecha_de_inicio= models.DateField(blank=True, null=True)
    fecha_de_fin= models.DateField(blank=True, null=True)
    utilidad= models.FloatField(blank=False,null=False, verbose_name="utilidad")
    balance_comprobacion= models.ForeignKey(BalanceComprobacion,on_delete=models.CASCADE)
    existe_utilidad= models.BooleanField(default=True,blank= True, null=True)

class EstadoCapital(models.Model):
    fecha_de_inicio= models.DateField(blank=True, null=True)
    fecha_de_fin= models.DateField(blank=True, null=True)
    reservas= models.FloatField()
    capital_social= models.FloatField()
    balance_comprobacion= models.ForeignKey(BalanceComprobacion,on_delete=models.CASCADE)

class BalanceGeneral(models.Model):
    fecha_de_inicio = models.DateField(blank=True, null=True)
    fecha_de_fin = models.DateField(blank=True, null=True)
    saldo_debe = models.FloatField()
    saldo_haber = models.FloatField()
    balance_comprobacion= models.ForeignKey(BalanceComprobacion,on_delete= models.CASCADE)
    




