# Generated by Django 4.1.3 on 2022-12-01 03:08

from django.db import migrations, models


class Migration(migrations.Migration):

    dependencies = [
        ('cherooms', '0028_alter_cheros_favorito_user_alter_cheros_perfil_user_and_more'),
    ]

    operations = [
        migrations.AddField(
            model_name='perfiluser',
            name='necesita_cuarto',
            field=models.BooleanField(default=False),
        ),
    ]