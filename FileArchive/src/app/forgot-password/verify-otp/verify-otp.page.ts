import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { AuthService } from '../../services/auth.service';
import { ToastController, NavController } from '@ionic/angular';

@Component({
  standalone: false,
  selector: 'app-verify-otp',
  templateUrl: './verify-otp.page.html',
  styleUrls: ['./verify-otp.page.scss'],
})
export class VerifyOtpPage implements OnInit {
  otp: string[] = ['', '', '', '', '', ''];
  email: string = '';

  constructor(
    private route: ActivatedRoute,
    private authService: AuthService,
    private toastController: ToastController,
    private navCtrl: NavController
  ) {}

  ngOnInit() {
    this.route.queryParams.subscribe(params => {
      this.email = params['email'] || '';
    });
  }

  onOtpInput(event: any, index: number) {
    const input = event.target;
    const value = input.value.replace(/[^0-9]/g, '');
    this.otp[index] = value;
    input.value = value;
    // Pindah ke input berikutnya jika ada angka
    if (value && index < 5) {
      const next = input.parentElement.querySelectorAll('.otp-input')[index + 1];
      if (next) next.focus();
    }
  }

  onOtpKeydown(event: KeyboardEvent, index: number) {
    const input = event.target as HTMLInputElement;
    if (event.key === 'Backspace' && !input.value && index > 0) {
      const prev = input.parentElement!.querySelectorAll('.otp-input')[index - 1] as HTMLInputElement;
      if (prev) prev.focus();
    }
  }

  onOtpPaste(event: ClipboardEvent) {
    event.preventDefault();
    const pasteData = event.clipboardData?.getData('text') || '';
    const digits = pasteData.replace(/[^0-9]/g, '').split('');
    for (let i = 0; i < 6; i++) {
      this.otp[i] = digits[i] || '';
      // Set value ke input secara visual juga
      const inputs = (event.target as HTMLInputElement).parentElement!.querySelectorAll('.otp-input');
      if (inputs[i]) {
        (inputs[i] as HTMLInputElement).value = this.otp[i];
      }
    }
    // Fokus ke input terakhir yang terisi
    const inputs = (event.target as HTMLInputElement).parentElement!.querySelectorAll('.otp-input');
    for (let i = 0; i < 6; i++) {
      if (this.otp[i] === '' && inputs[i]) {
        (inputs[i] as HTMLInputElement).focus();
        return;
      }
    }
    // Jika semua terisi, fokus tetap di input terakhir
    if (inputs[5]) (inputs[5] as HTMLInputElement).focus();
  }

  get otpValue(): string {
    return this.otp.join('');
  }

  async onSubmit() {
    if (this.otpValue.length !== 6) return;

    if (!this.email) {
      const toast = await this.toastController.create({
        message: 'Email tidak ditemukan. Silakan ulangi proses.',
        color: 'danger',
        duration: 2000
      });
      toast.present();
      return;
    }

    this.authService.verifyOtp(this.email, this.otpValue).subscribe({
      next: async (res) => {
        if (res.success) {
          this.navCtrl.navigateForward(['/forgot-password/reset-password'], {
            queryParams: { email: this.email, reset_token: res.reset_token }
          });
        } else {
          this.otp = ['', '', '', '', '', '']; // <-- reset semua input OTP
          const toast = await this.toastController.create({
            message: res.message || 'OTP salah atau sudah kadaluarsa.',
            color: 'danger',
            duration: 2000
          });
          toast.present();
        }
      },
      error: async (err) => {
        this.otp = ['', '', '', '', '', '']; // <-- reset juga jika error
        const toast = await this.toastController.create({
          message: err?.error?.message || 'Gagal verifikasi OTP.',
          color: 'danger',
          duration: 2000
        });
        toast.present();
      }
    });
  }
}
