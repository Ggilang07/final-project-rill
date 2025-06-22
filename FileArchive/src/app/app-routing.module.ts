import { NgModule } from '@angular/core';
import { PreloadAllModules, RouterModule, Routes } from '@angular/router';
import { AuthGuard } from './guards/auth.guard';
import { DetailStatusPage } from './letter-status/detail-status/detail-status.page';
import { SplashPage } from './splash/splash.page';

const routes: Routes = [
  {
    path: 'home',
    loadChildren: () => import('./home/home.module').then( m => m.HomePageModule),
    canActivate: [AuthGuard]
  },
  {
    path: '',
    component: SplashPage
  },
  {
    path: 'login',
    loadChildren: () => import('./login/login.module').then( m => m.LoginPageModule)
  },
  {
    path: 'letter-status',
    loadChildren: () => import('./letter-status/letter-status.module').then( m => m.LetterStatusPageModule),
    canActivate: [AuthGuard]
  },
  {
    path: 'profile',
    loadChildren: () => import('./profile/profile.module').then( m => m.ProfilePageModule)
  },
{
  path: 'forgot-password/verify-otp',
  loadChildren: () => import('./forgot-password/verify-otp/verify-otp.module').then(m => m.VerifyOtpPageModule)
},
{
  path: 'forgot-password/reset-password',
  loadChildren: () => import('./forgot-password/reset-password/reset-password.module').then(m => m.ResetPasswordPageModule)
},
{
  path: 'forgot-password',
  loadChildren: () => import('./forgot-password/forgot-password.module').then( m => m.ForgotPasswordPageModule)
},
  {
    path: 'letter-request',
    loadChildren: () => import('./letter-request/letter-request.module').then( m => m.LetterRequestPageModule)
  },
  {
    path: 'letter-status/detail-status/:id',
    loadChildren: () => import('./letter-status/detail-status/detail-status.module').then(m => m.DetailStatusPageModule)
  },
  {
    path: 'verfy-otp',
    loadChildren: () => import('./forgot-password/verfy-otp/verfy-otp.module').then(m => m.VerfyOtpPageModule)
  },
  {
    path: 'splash',
    loadChildren: () => import('./splash/splash.module').then( m => m.SplashPageModule)
  },



  
];

@NgModule({
  imports: [
    RouterModule.forRoot(routes, { preloadingStrategy: PreloadAllModules })
  ],
  exports: [RouterModule]
})
export class AppRoutingModule { }
