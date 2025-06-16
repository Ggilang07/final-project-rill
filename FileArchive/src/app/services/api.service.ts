import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root',
})
export class ApiService {
  private apiUrl = 'http://127.0.0.1:8000/api';
  constructor(private http: HttpClient) {}

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
    return this.http.get(`${this.apiUrl}/status-letters`, {
      headers: { Authorization: `Bearer ${token}` },
    });
  }

  requestLetter(): Observable<any> {
    const token = localStorage.getItem('token');
    return this.http.get(`${this.apiUrl}/letter-request`, {
      headers: { Authorization: `Bearer ${token}` },
    });
  }

  getProfile(): Observable<any> {
    const token = localStorage.getItem('token');
    return this.http.get(`${this.apiUrl}/profile`, {
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
}

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
