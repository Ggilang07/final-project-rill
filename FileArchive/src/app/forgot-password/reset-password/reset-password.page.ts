import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { AuthService } from '../../services/auth.service';
import { ToastController, NavController } from '@ionic/angular';

@Component({
  standalone: false,
  selector: 'app-reset-password',
  templateUrl: './reset-password.page.html',
  styleUrls: ['./reset-password.page.scss'],
})
export class ResetPasswordPage implements OnInit {
  password: string = '';
  passwordConfirmation: string = '';
  email: string = '';
  resetToken: string = '';
  showPassword: boolean = false;
  showPasswordConfirm: boolean = false;

  constructor(
    private route: ActivatedRoute,
    private authService: AuthService,
    private toastController: ToastController,
    private navCtrl: NavController
  ) {}

  ngOnInit() {
    this.route.queryParams.subscribe(params => {
      this.email = params['email'] || '';
      this.resetToken = params['reset_token'] || '';
    });
  }

  async onSubmit() {
    if (!this.email || !this.resetToken) {
      const toast = await this.toastController.create({
        message: 'Token reset tidak ditemukan. Silakan ulangi proses.',
        color: 'danger',
        duration: 2000
      });
      toast.present();
      return;
    }

    this.authService.resetPassword(
      this.email,
      this.resetToken,
      this.password,
      this.passwordConfirmation
    ).subscribe({
      next: async (res) => {
        if (res.success) {
          const toast = await this.toastController.create({
            message: 'Password berhasil diubah.',
            color: 'success',
            duration: 2000
          });
          toast.present();
          this.navCtrl.navigateRoot(['/login']);
        } else {
          const toast = await this.toastController.create({
            message: res.message || 'Gagal reset password.',
            color: 'danger',
            duration: 2000
          });
          toast.present();
        }
      },
      error: async (err) => {
        const toast = await this.toastController.create({
          message: err?.error?.message || 'Gagal reset password.',
          color: 'danger',
          duration: 2000
        });
        toast.present();
      }
    });
  }
}
