from django.contrib.auth.base_user import BaseUserManager
from django.forms import PasswordInput

class UserManager(BaseUserManager):
    use_in_migrations: True

    def create_user(self,email,password):
        if not email:
            raise ValueError("Email is require")
        usuario=self.model(
            email=self.normalize_email(email)
        )
        usuario.set_password(password)
        usuario.save(using=self._db)
        return usuario

    def create_superuser(self,email,password,username):
        usuario=self.create_user(
            email,
            password=password,
            username=username
        )
        usuario.staff= True
        usuario.admin= True
        usuario.save(using=self._db)
        
        return usuario
