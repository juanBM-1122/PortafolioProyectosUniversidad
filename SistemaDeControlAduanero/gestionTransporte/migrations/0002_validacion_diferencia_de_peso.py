# Generated by Django 4.0.3 on 2022-06-16 13:18

from django.db import migrations, models


class Migration(migrations.Migration):

    dependencies = [
        ('gestionTransporte', '0001_initial'),
    ]

    operations = [
        migrations.AddField(
            model_name='validacion',
            name='diferencia_de_peso',
            field=models.CharField(blank=True, max_length=30),
        ),
    ]