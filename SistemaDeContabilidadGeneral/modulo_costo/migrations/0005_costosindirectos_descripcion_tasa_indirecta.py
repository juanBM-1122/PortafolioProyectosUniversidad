# Generated by Django 4.1.1 on 2022-10-26 16:53

from django.db import migrations, models


class Migration(migrations.Migration):

    dependencies = [
        ('modulo_costo', '0004_remove_costosindirectos_id_proyecto'),
    ]

    operations = [
        migrations.AddField(
            model_name='costosindirectos',
            name='descripcion_tasa_indirecta',
            field=models.CharField(blank=True, max_length=50, null=True),
        ),
    ]