# Generated by Django 4.0.5 on 2022-12-03 18:06

from django.db import migrations, models


class Migration(migrations.Migration):

    dependencies = [
        ('cherooms', '0028_alter_cheros_favorito_user_alter_cheros_perfil_user_and_more'),
    ]

    operations = [
        migrations.AddField(
            model_name='perfiluser',
            name='foto64',
            field=models.CharField(blank=True, default='', max_length=1024, null=True),
        ),
    ]