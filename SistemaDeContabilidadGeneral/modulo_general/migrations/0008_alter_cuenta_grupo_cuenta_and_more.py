# Generated by Django 4.1.1 on 2022-10-21 19:40

from django.db import migrations, models
import django.db.models.deletion


class Migration(migrations.Migration):

    dependencies = [
        ('modulo_general', '0007_cuentat_cuenta'),
    ]

    operations = [
        migrations.AlterField(
            model_name='cuenta',
            name='grupo_cuenta',
            field=models.ForeignKey(on_delete=django.db.models.deletion.CASCADE, to='modulo_general.grupocuenta', verbose_name='grupo_cuenta'),
        ),
        migrations.AlterField(
            model_name='grupocuenta',
            name='clase_cuenta',
            field=models.ForeignKey(on_delete=django.db.models.deletion.CASCADE, to='modulo_general.clasecuenta'),
        ),
    ]
