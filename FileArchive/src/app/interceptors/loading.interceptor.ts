import { Injectable } from '@angular/core';
import {
  HttpRequest,
  HttpHandler,
  HttpEvent,
  HttpInterceptor
} from '@angular/common/http';
import { Observable, finalize } from 'rxjs';
import { LoadingController } from '@ionic/angular';

@Injectable()
export class LoadingInterceptor implements HttpInterceptor {

  private loading: HTMLIonLoadingElement | null = null;
  private requestCount = 0;
  private loadingPromise: Promise<HTMLIonLoadingElement> | null = null;

  constructor(private loadingCtrl: LoadingController) {}

  intercept(request: HttpRequest<unknown>, next: HttpHandler): Observable<HttpEvent<unknown>> {
    const excludedUrls = [
      '/auth/check',
      '/auth/refresh-token',
      '/notifications/count',
      '/analytics/ping'
    ];

    const shouldExclude = excludedUrls.some(url => request.url.includes(url));
    if (shouldExclude) {
    //   console.log('[LOADING] EXCLUDED:', request.url);
      return next.handle(request);
    }

    this.requestCount++;
    // console.log('[LOADING] REQUEST START:', request.url, '| requestCount:', this.requestCount);
    const showLoaderPromise = this.showLoader();

    return next.handle(request).pipe(
      finalize(() => {
        this.requestCount = Math.max(this.requestCount - 1, 0);
        // console.log('[LOADING] FINALIZE:', request.url, '| requestCount:', this.requestCount);
        showLoaderPromise.then(() => {
          if (this.requestCount === 0) {
            this.hideLoader();
          } else {
            // console.log('[LOADING] Loader NOT hidden, still pending:', this.requestCount);
          }
        });
      })
    );
  }

  private async showLoader() {
    if (!this.loading && !this.loadingPromise) {
    //   console.log('[LOADING] SHOW LOADER');
      this.loadingPromise = this.loadingCtrl.create({
        message: 'Mohon tunggu...',
        spinner: 'crescent',
        backdropDismiss: false
      });
      this.loading = await this.loadingPromise;
      await this.loading.present();
      this.loadingPromise = null;
    //   console.log('[LOADING] Loader presented');
    } else {
      console.log('[LOADING] Loader already shown or being created');
    }
  }

  private async hideLoader() {
    if (this.loading) {
      console.log('[LOADING] HIDE LOADER');
      try {
        await this.loading.dismiss();
        // console.log('[LOADING] Loader dismissed');
      } catch (e) {
        // console.warn('[LOADING] Loader dismiss error:', e);
      }
      this.loading = null;
    } else {
    //   console.log('[LOADING] No loader to hide');
    }
  }
}
