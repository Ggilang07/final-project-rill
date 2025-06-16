import { Component } from '@angular/core';
import { AuthService } from '../services/auth.service';
import { Router } from '@angular/router';

@Component({
  standalone: false,
  selector: 'app-login',
  templateUrl: './login.page.html',
  styleUrls: ['./login.page.scss'],
})
export class LoginPage {
  credentials = {
    email: '',
    password: ''
  };
  isLoading = false;
  errorMessage = '';
  passwordVisible = false;

  constructor(private authService: AuthService, private router: Router) {}

  togglePasswordVisibility() {
    this.passwordVisible = !this.passwordVisible;
  }

   goToForgotPassword() {
    this.router.navigate(['/forgot-password']);
  }

  login() {
    this.isLoading = true;
    this.errorMessage = '';
    this.authService.login(this.credentials).subscribe({
      next: (res) => {
        this.authService.setToken(res.token);
        this.router.navigate(['/home']);
        this.isLoading = false;
      },
      error: (error: any) => {
        this.errorMessage = error.error?.message || 'Login failed';
        this.isLoading = false;
      }
    });
  }
}