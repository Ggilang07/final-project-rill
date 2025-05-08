import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { LetterStatusPage } from './letter-status.page';

const routes: Routes = [
  {
    path: '',
    component: LetterStatusPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class LetterStatusPageRoutingModule {}
