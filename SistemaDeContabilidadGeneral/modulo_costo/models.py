from django.db import models

# Create your models here.
class Proyecto(models.Model):
    id_proyecto= models.AutoField(primary_key=True,unique=True,verbose_name="id_proyecto")
    nombre_proyecto= models.CharField(max_length=40,blank=False,null=False,verbose_name="nombre_proyecto")
    fecha_expedicion= models.DateField()
    departamento= models.CharField(max_length=40,blank=False,null=False,verbose_name="departamento")
    servicio= models.CharField(max_length=40,blank=False,null=False,verbose_name="servicio")
    presupuesto_cliente= models.FloatField(verbose_name="presupuesto_cliente")
    numero_orden= models.IntegerField(null=True,blank=True)
    descripcion= models.TextField(max_length=200,blank=True,null=True,verbose_name="descripcion")
    #relaciones
    id_costos_indirectos= models.ForeignKey('CostosIndirectos',on_delete=models.CASCADE,verbose_name="id_costos_indirectos")

    def __str__(self):
        return self.nombre_proyecto

class CostosIndirectos(models.Model):
    id_costos_indirectos= models.AutoField(primary_key=True,unique=True,verbose_name="id_costos_indirectos")
    tasa_costo_indirecto= models.FloatField(verbose_name="tasa_costo_indirecto")
    descripcion_tasa_indirecta = models.CharField(max_length=50, blank= True, null = True)
    #relaciones
    #id_proyecto= models.ForeignKey('Proyecto',on_delete=models.CASCADE,verbose_name="id_proyecto")
    def __str__(self):
        return self.tasa_costo_indirecto.__str__()+" "+self.descripcion_tasa_indirecta

class hoja_mano_obra(models.Model):
    id_hoja_mano_obra= models.AutoField(primary_key=True,unique=True,verbose_name="id_hoja_mano_obra")
    nombre_cargo= models.CharField(max_length=40,blank=False,null=False,verbose_name="nombre_cargo")
    cantidad_cargo= models.IntegerField(verbose_name="cantidad_cargo",null=True,blank=True)
    numero_hora= models.FloatField(verbose_name="salario_cargo",null=True,blank=True)
    salario_hora= models.FloatField(verbose_name="salario_hora",null=True,blank=True)
    es_costo_real = models.BooleanField(verbose_name = "es_costo_real")

    #relaciones
    id_proyecto= models.ForeignKey('Proyecto',on_delete=models.CASCADE,verbose_name="id_proyecto")
    def __str__(self):
        return self.nombre_cargo

