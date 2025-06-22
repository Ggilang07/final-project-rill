import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { IonicModule } from '@ionic/angular';

import { VerifyOtpPageRoutingModule } from './verify-otp-routing.module';
import { VerifyOtpPage } from './verify-otp.page';

@NgModule({
  declarations: [VerifyOtpPage],
  imports: [
    CommonModule,
    FormsModule,         // <-- INI WAJIB ADA
    IonicModule,
    VerifyOtpPageRoutingModule
  ],
})
export class VerifyOtpPageModule {}
