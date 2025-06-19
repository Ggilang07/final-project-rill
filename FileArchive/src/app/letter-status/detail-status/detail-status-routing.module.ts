import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { DetailStatusPage } from './detail-status.page';

const routes: Routes = [
  {
    path: '',
    component: DetailStatusPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class DetailStatusPageRoutingModule {}
