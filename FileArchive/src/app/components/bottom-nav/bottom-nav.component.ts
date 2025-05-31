// File: src/app/components/bottom-nav/bottom-nav.component.ts

import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  standalone: false,
  selector: 'app-bottom-nav',
  templateUrl: './bottom-nav.component.html',
  styleUrls: ['./bottom-nav.component.scss'],
})
export class BottomNavComponent implements OnInit {
  activeTab: string = 'home';
  notLogin : boolean = true;

  constructor(public router: Router) {
  }

  ngOnInit() {
    // Mendeteksi URL saat ini untuk mengatur tab aktif
    const currentUrl = window.location.href;
    if (currentUrl.includes('/login')){
      this.notLogin = false;
    }
    if (currentUrl.includes('/home')) {
      this.activeTab = 'home';
    } else if (currentUrl.includes('/letter-request')) {
      this.activeTab = 'letter-request';
    } else if (currentUrl.includes('/letter-status')) {
      this.activeTab = 'letter-status';
    } else if (currentUrl.includes('/letter-request')) {
      this.activeTab = 'letter-request';
    } else if (currentUrl.includes('/profile')) {
      this.activeTab = 'profile';
    }
  }

  navigateTo(route: string) {
    this.activeTab = route;
    this.router.navigateByUrl(`/${route}`);
  }
}