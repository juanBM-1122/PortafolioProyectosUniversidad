# Generated by Django 4.1.1 on 2022-10-26 16:36

from django.db import migrations


class Migration(migrations.Migration):

    dependencies = [
        ('modulo_costo', '0002_hoja_mano_obra_numero_hora_and_more'),
    ]

    operations = [
        migrations.RemoveField(
            model_name='proyecto',
            name='id_hoja_mano_obra',
        ),
    ]
