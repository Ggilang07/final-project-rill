import { Component, OnInit } from '@angular/core';

@Component({
  standalone: false,
  selector: 'app-profile',
  templateUrl: './profile.page.html',
  styleUrls: ['./profile.page.scss'],
})
export class ProfilePage implements OnInit {
// Model data pengguna
  // userData = {
  //   name: 'Muhammad Gilang Khaliq Nur Rahman',
  //   birthDate: '07 - Juli - 2005',
  //   password: '****************',
  //   address: 'Jl. Anjunkanoman RT 06 RW 12 Kec. Karawang Barat Kab. Karawang',
  //   nik: '3215014707050002',
  //   noKK: '3215014707050002'
  // };
  // Method untuk menangani klik tombol Edit Profil
editProfile() {
  console.log('Edit profile clicked');

}
  ngOnInit() {
  }

}
