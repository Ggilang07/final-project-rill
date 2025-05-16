import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { LetterRequestPage } from './letter-request.page';

const routes: Routes = [
  {
    path: '',
    component: LetterRequestPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class LetterRequestPageRoutingModule {}
