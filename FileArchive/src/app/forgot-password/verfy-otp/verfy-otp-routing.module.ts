import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { VerfyOtpPage } from './verfy-otp.page';

const routes: Routes = [
  {
    path: '',
    component: VerfyOtpPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class VerfyOtpPageRoutingModule {}
