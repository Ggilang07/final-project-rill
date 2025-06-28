import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { environment } from 'src/environments/environment';

@Injectable({
  providedIn: 'root',
})
export class AuthService {
  private apiUrl = environment.apiUrl;

  constructor(private http: HttpClient) {}

  login(credentials: { email: string; password: string }): Observable<any> {
    return this.http.post(
      `${this.apiUrl}/login`,
      credentials,
    );
  }

  setToken(token: string) {
    localStorage.setItem('token', token);
  }

  getToken(): string | null {
    return localStorage.getItem('token');
  }

  isLoggedIn(): boolean {
    return !!this.getToken();
  }

  logout() {
    localStorage.removeItem('token');
  }

  sendOtp(email: string): Observable<any> {
    return this.http.post(`${this.apiUrl}/auth/forgot-password`, { email });
  }

  verifyOtp(email: string, otp: string): Observable<any> {
    // Ganti endpoint di sini:
    return this.http.post(`${this.apiUrl}/auth/verify-otp`, { email, otp });
  }

  resetPassword(
    email: string,
    resetToken: string,
    password: string,
    passwordConfirmation: string,
  ): Observable<any> {
    return this.http.post(`${this.apiUrl}/auth/reset-password`, {
      email,
      reset_token: resetToken,
      password,
      password_confirmation: passwordConfirmation,
    });
  }
}
