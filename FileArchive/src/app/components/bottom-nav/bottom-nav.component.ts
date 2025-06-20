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
  showNav: boolean = true;

  constructor(public router: Router) {}

  ngOnInit() {
    this.updateNavVisibility();
    // Listen to route changes
    this.router.events.subscribe(() => {
      this.updateNavVisibility();
    });
  }

  updateNavVisibility() {
    const url = this.router.url;
    // Hide nav in login and forgot-password pages
    this.showNav = !url.includes('/login') && !url.includes('/forgot-password') && !url.includes('/letter-status/detail-status') && !url.includes('/forgot-password/verfy-otp'); 

    if (url.includes('/home')) {
      this.activeTab = 'home';
    } else if (url.includes('/letter-request')) {
      this.activeTab = 'letter-request';
    } else if (url.includes('/letter-status')) {
      this.activeTab = 'letter-status';
    } else if (url.includes('/profile')) {
      this.activeTab = 'profile';
    }
  }

  navigateTo(route: string) {
    this.activeTab = route;
    this.router.navigateByUrl(`/${route}`);
  }
}
