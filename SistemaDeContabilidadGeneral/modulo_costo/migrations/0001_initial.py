# Generated by Django 4.1.1 on 2022-10-23 14:14

from django.db import migrations, models
import django.db.models.deletion


class Migration(migrations.Migration):

    initial = True

    dependencies = [
    ]

    operations = [
        migrations.CreateModel(
            name='CostosIndirectos',
            fields=[
                ('id_costos_indirectos', models.AutoField(primary_key=True, serialize=False, unique=True, verbose_name='id_costos_indirectos')),
                ('tasa_costo_indirecto', models.FloatField(verbose_name='tasa_costo_indirecto')),
            ],
        ),
        migrations.CreateModel(
            name='hoja_mano_obra',
            fields=[
                ('id_hoja_mano_obra', models.AutoField(primary_key=True, serialize=False, unique=True, verbose_name='id_hoja_mano_obra')),
                ('nombre_cargo', models.CharField(max_length=40, verbose_name='nombre_cargo')),
                ('cantidad_cargo', models.IntegerField(verbose_name='cantidad_cargo')),
            ],
        ),
        migrations.CreateModel(
            name='Proyecto',
            fields=[
                ('id_proyecto', models.AutoField(primary_key=True, serialize=False, unique=True, verbose_name='id_proyecto')),
                ('nombre_proyecto', models.CharField(max_length=40, verbose_name='nombre_proyecto')),
                ('fecha_expedicion', models.DateField()),
                ('departamento', models.CharField(max_length=40, verbose_name='departamento')),
                ('servicio', models.CharField(max_length=40, verbose_name='servicio')),
                ('presupuesto_cliente', models.FloatField(verbose_name='presupuesto_cliente')),
                ('numero_orden', models.IntegerField(blank=True, null=True)),
                ('descripcion', models.TextField(blank=True, max_length=200, null=True, verbose_name='descripcion')),
                ('id_costos_indirectos', models.ForeignKey(on_delete=django.db.models.deletion.CASCADE, to='modulo_costo.costosindirectos', verbose_name='id_costos_indirectos')),
                ('id_hoja_mano_obra', models.ForeignKey(on_delete=django.db.models.deletion.CASCADE, to='modulo_costo.hoja_mano_obra', verbose_name='id_hoja_mano_obra')),
            ],
        ),
        migrations.AddField(
            model_name='hoja_mano_obra',
            name='id_proyecto',
            field=models.ForeignKey(on_delete=django.db.models.deletion.CASCADE, to='modulo_costo.proyecto', verbose_name='id_proyecto'),
        ),
        migrations.AddField(
            model_name='costosindirectos',
            name='id_proyecto',
            field=models.ForeignKey(on_delete=django.db.models.deletion.CASCADE, to='modulo_costo.proyecto', verbose_name='id_proyecto'),
        ),
    ]
