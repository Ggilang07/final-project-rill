import { Component, OnInit } from '@angular/core';
import { ApiService } from '../services/api.service';

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

  constructor(private api: ApiService) {}

  ngOnInit() {
    this.api.getProfile().subscribe((res) => {
      // console.log('profile data', res);
      this.user = res;
    });
  }

  editProfile() {
    this.isEdit = true;
    this.backupUser = { ...this.user }; // backup data untuk cancel
  }

  saveProfile() {
    // Panggil API update profile di sini, misal:
    // this.api.updateProfile(this.user).subscribe(...)
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
}
