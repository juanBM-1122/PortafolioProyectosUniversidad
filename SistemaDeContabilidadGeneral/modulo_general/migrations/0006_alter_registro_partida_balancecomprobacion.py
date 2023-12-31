# Generated by Django 4.1.1 on 2022-10-20 00:14

from django.db import migrations, models
import django.db.models.deletion


class Migration(migrations.Migration):

    dependencies = [
        ('modulo_general', '0005_alter_partida_fecha_partida'),
    ]

    operations = [
        migrations.AlterField(
            model_name='registro',
            name='partida',
            field=models.ForeignKey(on_delete=django.db.models.deletion.CASCADE, to='modulo_general.partida', verbose_name='partida'),
        ),
        migrations.CreateModel(
            name='BalanceComprobacion',
            fields=[
                ('id', models.BigAutoField(auto_created=True, primary_key=True, serialize=False, verbose_name='ID')),
                ('saldo_debe', models.FloatField(verbose_name='saldo_debe')),
                ('saldo_haber', models.FloatField(verbose_name='saldo_haber')),
                ('libro_mayor', models.OneToOneField(on_delete=django.db.models.deletion.CASCADE, to='modulo_general.libromayor')),
            ],
        ),
    ]
