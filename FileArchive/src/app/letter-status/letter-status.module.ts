import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { LetterStatusPageRoutingModule } from './letter-status-routing.module';

import { LetterStatusPage } from './letter-status.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    LetterStatusPageRoutingModule
  ],
  declarations: [LetterStatusPage]
})
export class LetterStatusPageModule {}
