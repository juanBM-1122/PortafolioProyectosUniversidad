# Generated by Django 4.1.1 on 2022-10-21 20:19

from django.db import migrations, models


class Migration(migrations.Migration):

    dependencies = [
        ('modulo_general', '0009_alter_cuentat_libro_mayor_alter_registro_cuenta_and_more'),
    ]

    operations = [
        migrations.AddField(
            model_name='balancecomprobacion',
            name='esta_ajustado',
            field=models.BooleanField(default=False),
        ),
        migrations.AddField(
            model_name='partida',
            name='es_partidad_ajuste',
            field=models.BooleanField(default=False),
        ),
    ]
