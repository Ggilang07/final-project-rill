import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { LetterRequestPageRoutingModule } from './letter-request-routing.module';

import { LetterRequestPage } from './letter-request.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    LetterRequestPageRoutingModule
  ],
  declarations: [LetterRequestPage]
})
export class LetterRequestPageModule {}
