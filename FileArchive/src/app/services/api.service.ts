import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { environment } from 'src/environments/environment';

@Injectable({
  providedIn: 'root',
})
export class ApiService {
  private apiUrl = environment.apiUrl;
  constructor(private http: HttpClient) {}

  getHomeStatus(): Observable<any> {
    const token = localStorage.getItem('token');
    return this.http.get(`${this.apiUrl}/home-summary`, {
      headers: {
        Authorization: `Bearer ${token}`,
        Accept: 'application/json',
      },
    });
  }

  getStatusLetter(): Observable<any> {
    const token = localStorage.getItem('token');
    return this.http.get(`${this.apiUrl}/status-letters`, {
      headers: {
        Authorization: `Bearer ${token}`,
        Accept: 'application/json',
      },
    });
  }

  getLinkNValidator(): Observable<any> {
    const token = localStorage.getItem('token');
    return this.http.get(`${this.apiUrl}/status-letters/detail-status`, {
      headers: { Authorization: `Bearer ${token}` },
    });
  }

  requestLetter(): Observable<any> {
    const token = localStorage.getItem('token');
    return this.http.get(`${this.apiUrl}/letter-request`, {
      headers: { Authorization: `Bearer ${token}` },
    });
  }

  createLetterRequest(data: LetterRequest): Observable<any> {
    const token = localStorage.getItem('token');
    return this.http.post(`${this.apiUrl}/letter-request`, data, {
      headers: {
        Authorization: `Bearer ${token}`,
        Accept: 'application/json',
      },
    });
  }

  getCategories(): Observable<any> {
    const token = localStorage.getItem('token');
    return this.http.get(`${this.apiUrl}/categories`, {
      headers: {
        Authorization: `Bearer ${token}`,
        Accept: 'application/json',
      },
    });
  }

  getLetterDetail(id: string): Observable<any> {
    const token = localStorage.getItem('token');
    return this.http.get(`${this.apiUrl}/status-letters/${id}`, {
      headers: {
        Authorization: `Bearer ${token}`,
        Accept: 'application/json',
      },
    });
  }

  cancelLetter(id: string): Observable<any> {
    const token = localStorage.getItem('token');
    return this.http.put(
      `${this.apiUrl}/status-letters/${id}/cancel`,
      {},
      {
        headers: {
          Authorization: `Bearer ${token}`,
          Accept: 'application/json',
        },
      },
    );
  }

  getProfile(): Observable<any> {
    const token = localStorage.getItem('token');
    return this.http.get(`${this.apiUrl}/profile`, {
      headers: { Authorization: `Bearer ${token}` },
    });
  }

  updateProfile(profileData: FormData): Observable<any> {
    const token = localStorage.getItem('token');
    return this.http.post(`${this.apiUrl}/profile/update`, profileData, {
      headers: { Authorization: `Bearer ${token}` },
    });
  }

  changePassword(
    currentPassword: string,
    newPassword: string,
    confirmPassword: string,
  ): Observable<any> {
    const token = localStorage.getItem('token');
    return this.http.post(
      `${this.apiUrl}/profile/change-password`,
      {
        current_password: currentPassword,
        new_password: newPassword,
        new_password_confirmation: confirmPassword,
      },
      {
        headers: {
          Authorization: `Bearer ${token}`,
          Accept: 'application/json',
        },
      },
    );
  }
}

export const BASE_IMAGE_URL =
  'https://filearchive.grandmutiara.my.id/images/profiles/';

export interface User {
  user_id: number;
  name: string;
  email: string;
}

export interface LetterRequest {
  category: string;
  letter_date: string;
  reason: string;
  user_id: number;
  name?: string;
  letter_number?: string;
  status?: string;
}
