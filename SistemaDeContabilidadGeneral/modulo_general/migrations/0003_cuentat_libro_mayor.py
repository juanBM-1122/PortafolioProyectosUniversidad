# Generated by Django 4.1.1 on 2022-10-16 06:31

from django.db import migrations, models
import django.db.models.deletion


class Migration(migrations.Migration):

    dependencies = [
        ('modulo_general', '0002_libromayor'),
    ]

    operations = [
        migrations.AddField(
            model_name='cuentat',
            name='libro_mayor',
            field=models.ForeignKey(blank=True, null=True, on_delete=django.db.models.deletion.PROTECT, to='modulo_general.libromayor'),
        ),
    ]