import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { LetterStatusPage } from './letter-status.page';

const routes: Routes = [
  {
    path: '',
    component: LetterStatusPage
  },  {
    path: 'detail-status',
    loadChildren: () => import('./detail-status/detail-status.module').then( m => m.DetailStatusPageModule)
  }

];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class LetterStatusPageRoutingModule {}
