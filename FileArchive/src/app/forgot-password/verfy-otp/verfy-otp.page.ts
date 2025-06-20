import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';

@Component({
  standalone: false,
  selector: 'app-verfy-otp',
  templateUrl: './verfy-otp.page.html',
  styleUrls: ['./verfy-otp.page.scss'],
})
export class VerfyOtpPage implements OnInit {
  otpForm: FormGroup;
  isSubmitted = false;

  constructor(private fb: FormBuilder) {
    this.otpForm = this.fb.group({
      otp: ['', [Validators.required, Validators.pattern(/^\d{6}$/)]]
    });
  }

  ngOnInit() {}

  onSubmit() {
    this.isSubmitted = true;
    if (this.otpForm.valid) {
      // Panggil API verifikasi OTP di sini
      console.log('OTP:', this.otpForm.value.otp);
    }
  }

  resendOtp() {
    // Panggil API kirim ulang OTP di sini
    console.log('Kirim ulang OTP');
  }
}
