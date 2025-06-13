import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { IonicModule } from '@ionic/angular';
import { Routes, RouterModule } from '@angular/router';
import { ForgotPasswordPage } from './forgot-password.page';

const routes: Routes = [
  {
    path: '',
    component: ForgotPasswordPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class ForgotPasswordPageRoutingModule {}

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    ReactiveFormsModule,
    IonicModule,
    ForgotPasswordPageRoutingModule
  ],
  declarations: [ForgotPasswordPage]
})
export class ForgotPasswordPageModule {}

// forgot-password.service.ts (Optional - untuk API integration)
import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

export interface ForgotPasswordRequest {
  email: string;
}

export interface ForgotPasswordResponse {
  success: boolean;
  message: string;
}

@Injectable({
  providedIn: 'root'
})
export class ForgotPasswordService {
  private apiUrl = 'your-api-url-here';

  constructor(private http: HttpClient) {}

  sendResetLink(email: string): Observable<ForgotPasswordResponse> {
    const request: ForgotPasswordRequest = { email };
    return this.http.post<ForgotPasswordResponse>(`${this.apiUrl}/forgot-password`, request);
  }

  // Alternative method with error handling
  async sendResetLinkAsync(email: string): Promise<ForgotPasswordResponse> {
    try {
      const response = await this.http.post<ForgotPasswordResponse>(
        `${this.apiUrl}/forgot-password`, 
        { email }
      ).toPromise();
      
      return response || { success: false, message: 'No response from server' };
    } catch (error) {
      console.error('Forgot password error:', error);
      throw error;
    }
  }
}
