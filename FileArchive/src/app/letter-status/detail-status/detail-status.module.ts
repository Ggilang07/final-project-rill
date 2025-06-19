import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { DetailStatusPageRoutingModule } from './detail-status-routing.module';

import { DetailStatusPage } from './detail-status.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    DetailStatusPageRoutingModule
  ],
  declarations: [DetailStatusPage]
})
export class DetailStatusPageModule {}
