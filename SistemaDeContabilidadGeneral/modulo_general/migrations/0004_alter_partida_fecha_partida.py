# Generated by Django 4.1.1 on 2022-10-18 14:30

from django.db import migrations, models


class Migration(migrations.Migration):

    dependencies = [
        ('modulo_general', '0003_cuentat_libro_mayor'),
    ]

    operations = [
        migrations.AlterField(
            model_name='partida',
            name='fecha_partida',
            field=models.DateTimeField(auto_now=True, null=True),
        ),
    ]