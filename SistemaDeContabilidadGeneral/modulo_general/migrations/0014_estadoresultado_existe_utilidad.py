# Generated by Django 4.1.1 on 2022-10-24 01:15

from django.db import migrations, models


class Migration(migrations.Migration):

    dependencies = [
        ('modulo_general', '0013_balancegeneral_fecha_de_fin_and_more'),
    ]

    operations = [
        migrations.AddField(
            model_name='estadoresultado',
            name='existe_utilidad',
            field=models.BooleanField(blank=True, default=True, null=True),
        ),
    ]
