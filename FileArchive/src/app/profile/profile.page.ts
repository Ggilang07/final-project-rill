import { Component, OnInit } from '@angular/core';
import { ApiService, BASE_IMAGE_URL } from '../services/api.service';
import { Router } from '@angular/router'; // Mengimpor Router
import { ToastController, NavController } from '@ionic/angular';

@Component({
  selector: 'app-profile',
  templateUrl: './profile.page.html',
  styleUrls: ['./profile.page.scss'],
  standalone: false,
})
export class ProfilePage implements OnInit {
  user: any;
  isEdit = false;
  isUsingDefaultPassword = false;
  backupUser: any;
  selectedPhoto: File | null = null;
  photoPreview: string | ArrayBuffer | null = null;

  constructor(
    private api: ApiService,
    private router: Router,
    private toastController: ToastController,
    private navCtrl: NavController,
  ) {}

  ngOnInit() {
    this.api.getProfile().subscribe((res) => {
      // console.log('API PROFILE:', res);
      this.user = res.user ?? res;
      this.isUsingDefaultPassword = res.is_using_default_password ?? false;
    });
  }

  ionViewWillEnter() {
    this.ngOnInit();
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
    localStorage.removeItem('token');

    // Arahkan pengguna ke halaman login setelah logout
    this.router.navigate(['/login']);
  }

  async showToast(message: string, color: 'success' | 'danger' = 'success') {
    const toast = await this.toastController.create({
      message,
      duration: 2000,
      color,
      position: 'top',
    });
    toast.present();
  }

  updateProfile() {
    const formData = new FormData();
    formData.append('name', this.user.name);
    formData.append('email', this.user.email);
    formData.append('address', this.user.address);
    // Jika ada upload foto:
    if (this.selectedPhoto) {
      formData.append('photo', this.selectedPhoto);
    }

    this.api.updateProfile(formData).subscribe({
      next: (res) => {
        this.showToast('Profil berhasil diperbarui!', 'success');
        this.isEdit = false;
        this.ngOnInit();
      },
      error: (err) => {
        this.showToast('Gagal memperbarui profil!', 'danger');
      },
    });
  }

  getProfilePhotoUrl(): string {
    return this.user?.p_profile
      ? `${BASE_IMAGE_URL}${this.user.p_profile}`
      : `${BASE_IMAGE_URL}icon-profile.jpg`;
  }

  onPhotoSelected(event: any) {
    const file = event.target.files[0];
    if (file) {
      this.selectedPhoto = file;
      const reader = new FileReader();
      reader.onload = (e) => {
        this.photoPreview = e.target?.result ?? null;
      };
      reader.readAsDataURL(file);
    }
  }

  // Menambahkan fungsi untuk menghapus foto yang dipilih
  removePhoto() {
    this.photoPreview = null;
    this.selectedPhoto = null;
  }

  // Fungsi navigasi smooth
  goToChangePassword() {
    this.navCtrl.navigateForward('/profile/change-password', {
      animated: true,
      animationDirection: 'forward',
    });
  }
}
