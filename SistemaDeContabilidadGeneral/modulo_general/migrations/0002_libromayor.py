# Generated by Django 4.1.1 on 2022-10-16 06:27

from django.db import migrations, models


class Migration(migrations.Migration):

    dependencies = [
        ('modulo_general', '0001_initial'),
    ]

    operations = [
        migrations.CreateModel(
            name='LibroMayor',
            fields=[
                ('id_libro_mayor', models.AutoField(primary_key=True, serialize=False, unique=True, verbose_name='id_tipo_registro')),
                ('fecha_de_inicio_periodo', models.DateField()),
                ('fecha_fin_periodo', models.DateField()),
            ],
        ),
    ]
