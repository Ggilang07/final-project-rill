import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { 
  AlertController, 
  LoadingController, 
  NavController, 
  ToastController 
} from '@ionic/angular';
import { AuthService } from '../services/auth.service'; // pastikan sudah di-import

@Component({
  standalone: false, 
  selector: 'app-forgot-password',
  templateUrl: './forgot-password.page.html',
  styleUrls: ['./forgot-password.page.scss'],
})
export class ForgotPasswordPage implements OnInit {
  forgotPasswordForm: FormGroup;
  isSubmitted = false;
  isLoading = false;

  constructor(
    private formBuilder: FormBuilder,
    private alertController: AlertController,
    private loadingController: LoadingController,
    private navController: NavController,
    private toastController: ToastController,
    private authService: AuthService // tambahkan ini
  ) {
    this.forgotPasswordForm = this.formBuilder.group({
      email: [
        '',
        [
          Validators.required,
          Validators.email,
          this.atSignValidator // custom validator
        ]
      ]
    });
  }

  ngOnInit() {
    // Add custom email validation if needed
    this.setupFormValidation();
  }

  private setupFormValidation() {
    // Real-time validation feedback
    this.forgotPasswordForm.get('email')?.valueChanges.subscribe(() => {
      if (this.isSubmitted) {
        // Reset submission state when user starts typing
        this.isSubmitted = false;
      }
    });
  }

  async onSubmit() {
    this.isSubmitted = true;
    
    if (!this.forgotPasswordForm.valid) {
      await this.showValidationToast();
      return;
    }

    const email = this.forgotPasswordForm.get('email')?.value;
    await this.sendResetLink(email);
  }

  private async sendResetLink(email: string) {
    this.isLoading = true;

    this.authService.sendOtp(email).subscribe({
      next: async (res) => {
        if (res.success) {
          // Tampilkan toast sukses
          const toast = await this.toastController.create({
            message: 'Kode OTP berhasil dikirim ke email Anda.',
            duration: 1800,
            color: 'success',
            position: 'top'
          });
          await toast.present();

          // Setelah toast selesai, redirect ke halaman verifikasi OTP
          setTimeout(() => {
            this.navController.navigateForward(['/forgot-password/verify-otp'], {
              queryParams: { email }
            });
          }, 1800);
        } else {
          await this.showErrorAlert(res.message || 'Gagal mengirim OTP.');
        }
        this.isLoading = false;
      },
      error: async (err) => {
        await this.showErrorAlert(
          err?.error?.message || 'Terjadi kesalahan saat mengirim email reset password. Silakan coba lagi.'
        );
        this.isLoading = false;
      }
    });
  }

  private async showSuccessAlert(email: string) {
    const alert = await this.alertController.create({
      header: 'Email Terkirim',
      message: `Link reset password telah dikirim ke <strong>${email}</strong>. Silakan cek inbox atau folder spam Anda.`,
      buttons: [
        {
          text: 'OK',
          role: 'confirm',
          cssClass: 'alert-button-confirm'
        }
      ],
      cssClass: 'success-alert'
    });
    
    await alert.present();
  }

  private async showErrorAlert(message: string) {
    const alert = await this.alertController.create({
      header: 'Gagal Mengirim',
      message: message,
      buttons: [
        {
          text: 'Coba Lagi',
          role: 'confirm',
          cssClass: 'alert-button-confirm'
        }
      ],
      cssClass: 'error-alert'
    });
    await alert.present();
  }

  private async showValidationToast() {
    const toast = await this.toastController.create({
      message: 'Mohon periksa kembali email yang Anda masukkan',
      duration: 3000,
      position: 'top',
      color: 'danger',
      buttons: [
        {
          text: 'OK',
          role: 'cancel'
        }
      ]
    });
    
    await toast.present();
  }

  goToLogin() {
    this.navController.navigateBack('/login');
  }

  // Utility method to check if field has error
  hasError(fieldName: string, errorType?: string): boolean {
    const field = this.forgotPasswordForm.get(fieldName);
    if (!field) return false;
    
    if (errorType) {
      return !!(field.errors?.[errorType] && (field.dirty || field.touched || this.isSubmitted));
    }
    
    return !!(field.invalid && (field.dirty || field.touched || this.isSubmitted));
  }

  // real-time validation for email field
  atSignValidator(control: import('@angular/forms').AbstractControl) {
    const value = control.value;
    if (value && !value.includes('@')) {
      return { atSign: true };
    }
    return null;
  }
}
