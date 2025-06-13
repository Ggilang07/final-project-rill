import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { 
  AlertController, 
  LoadingController, 
  NavController, 
  ToastController 
} from '@ionic/angular';
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
    private toastController: ToastController
  ) {
    this.forgotPasswordForm = this.formBuilder.group({
      email: ['', [Validators.required, Validators.email]]
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

    try {
      // Simulate API call - replace with your actual service
      await this.simulateApiCall();
      
      await this.showSuccessAlert(email);
      
      // Navigate back to login after success
      setTimeout(() => {
        this.navController.navigateBack('/login');
      }, 1000);
      
    } catch (error) {
      await this.showErrorAlert();
    } finally {
      this.isLoading = false;
    }
  }

  private simulateApiCall(): Promise<void> {
    return new Promise((resolve, reject) => {
      setTimeout(() => {
        // Simulate success (90% chance) or failure (10% chance)
        const success = Math.random() > 0.1;
        if (success) {
          resolve();
        } else {
          reject(new Error('Network error'));
        }
      }, 2000);
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

  private async showErrorAlert() {
    const alert = await this.alertController.create({
      header: 'Gagal Mengirim',
      message: 'Terjadi kesalahan saat mengirim email reset password. Silakan coba lagi.',
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

  // Get error message for field
  getErrorMessage(fieldName: string): string {
    const field = this.forgotPasswordForm.get(fieldName);
    if (!field?.errors) return '';
    
    if (field.errors['required']) {
      return 'Email wajib diisi';
    }
    
    if (field.errors['email']) {
      return 'Format email tidak valid';
    }
    
    return 'Input tidak valid';
  }
}
