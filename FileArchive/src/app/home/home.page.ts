import { HttpClient } from '@angular/common/http';
import { Component, OnInit } from '@angular/core';
import { ApiService } from '../services/api.service';
import { AuthService } from '../services/auth.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-home',
  templateUrl: 'home.page.html',
  styleUrls: ['home.page.scss'],
  standalone: false,
})
export class HomePage implements OnInit {
  user: any;
  lastLetter: any = null;

  constructor(private api: ApiService, private auth: AuthService, private router: Router) {}

  ngOnInit() {
    this.api.getProfile().subscribe((res) => {
      this.user = res;
    });

    this.api.getStatusLetter().subscribe((res) => {
      if (Array.isArray(res) && res.length > 0) {
        // Ambil surat terakhir (misal: data pertama)
        this.lastLetter = res[0];
      }
    });
  }

  logout() {
    this.auth.logout();
    this.router.navigate(['/login']);
  }
}
