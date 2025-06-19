import { Component, OnInit } from '@angular/core';
import { ApiService } from '../services/api.service';
import { Router } from '@angular/router'; // Mengimpor Router

@Component({
  selector: 'app-profile',
  templateUrl: './profile.page.html',
  styleUrls: ['./profile.page.scss'],
  standalone: false,
})
export class ProfilePage implements OnInit {
  user: any;
  isEdit = false;
  backupUser: any;

  constructor(private api: ApiService, private router: Router) {}

  ngOnInit() {
    this.api.getProfile().subscribe((res) => {
      this.user = res;
    });
  }

  editProfile() {
    this.isEdit = true;
    this.backupUser = { ...this.user }; // backup data untuk cancel
  }

  saveProfile() {
    this.isEdit = false;
  }

  cancelEdit() {
    this.user = { ...this.backupUser };
    this.isEdit = false;
  }

  handleInput(field: string, event: Event) {
    const input = event.target as HTMLInputElement;
    if (this.user) {
      this.user[field] = input.value;
    }
  }

  // Fungsi logout
  logout() {
    // Menghapus data sesi, misalnya token autentikasi
    localStorage.removeItem('authToken');

    // Arahkan pengguna ke halaman login setelah logout
    this.router.navigate(['/login']);
  }
}
