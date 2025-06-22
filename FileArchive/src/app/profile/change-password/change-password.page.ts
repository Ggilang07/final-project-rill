import { Component, OnInit } from '@angular/core';
import { ApiService } from 'src/app/services/api.service';
import { ToastController } from '@ionic/angular';

@Component({
  standalone: false,
  selector: 'app-change-password',
  templateUrl: './change-password.page.html',
  styleUrls: ['./change-password.page.scss'],
})
export class ChangePasswordPage implements OnInit {
  currentPassword = '';
  newPassword = '';
  confirmPassword = '';

  showCurrentPassword = false;
  showNewPassword = false;
  showConfirmPassword = false;

  constructor(
    private api: ApiService,
    private toastController: ToastController,
  ) {}

  ngOnInit() {}

  async showToast(message: string, color: 'success' | 'danger' = 'danger') {
    const toast = await this.toastController.create({
      message,
      duration: 2000,
      color,
      position: 'top',
    });
    toast.present();
  }

  changePassword() {
    if (this.newPassword !== this.confirmPassword) {
      this.showToast('Konfirmasi password baru tidak cocok!', 'danger');
      return;
    }
    this.api
      .changePassword(
        this.currentPassword,
        this.newPassword,
        this.confirmPassword,
      )
      .subscribe({
        next: (res) => {
          this.showToast('Password berhasil diubah!', 'success');
          this.currentPassword = '';
          this.newPassword = '';
          this.confirmPassword = '';
        },
        error: (err) => {
          if (err.error?.message) {
            this.showToast(err.error.message, 'danger');
          } else if (err.error?.errors) {
            const messages = Object.values(err.error.errors)
              .map((v: any) => (Array.isArray(v) ? v.join('\n') : v))
              .join('\n');
            this.showToast(messages, 'danger');
          } else {
            this.showToast('Gagal mengubah password!', 'danger');
          }
        },
      });
  }
}
