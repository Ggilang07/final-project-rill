import { HttpClient } from '@angular/common/http';
import { Component, OnInit } from '@angular/core';
import { ApiService } from '../services/api.service';
import { AuthService } from '../services/auth.service';
import { BASE_IMAGE_URL } from '../services/api.service';
import { Router } from '@angular/router';
import { NavController } from '@ionic/angular';

@Component({
  selector: 'app-home',
  templateUrl: 'home.page.html',
  styleUrls: ['home.page.scss'],
  standalone: false,
})
export class HomePage implements OnInit {
  user: any;
  today: Date = new Date();
  letterCounts: any = { pending: 0, approved: 0, rejected: 0 };
  lastLetter: any = null;
  recentLetters: any[] = [];

  constructor(
    private api: ApiService,
    private auth: AuthService,
    private router: Router,
    private navCtrl: NavController,
  ) {}

  ngOnInit() {
    this.loadData();
  }

  ionViewWillEnter() {
    this.loadData();
  }

  loadData() {
    this.api.getProfile().subscribe({
      next: (res) => {
        this.user = res;
      },
      error: (err) => {
        console.error('Gagal mengambil profil:', err);
      },
    });

    this.api.getHomeStatus().subscribe({
      next: (res: any) => {
        const summary = res.data || {};
        this.letterCounts = {
          pending: summary.pending_requests || 0,
          approved: summary.approved_requests || 0,
          rejected: summary.rejected_requests || 0,
          cancelled: summary.cancelled_requests || 0,
        };
      },
      error: (err) => {
        console.error('Gagal mengambil status surat:', err);
      },
    });

    this.api.getStatusLetter().subscribe({
      next: (res: any) => {
        let suratArr = res.data || [];
        suratArr = suratArr.sort(
          (a: any, b: any) =>
            new Date(b.created_at).getTime() - new Date(a.created_at).getTime(),
        );
        this.lastLetter = suratArr.length > 0 ? suratArr[0] : null;
        this.recentLetters = suratArr.slice(0, 5);
      },
      error: (err) => {
        console.error('Gagal mengambil daftar surat:', err);
      },
    });
  }

  getProfilePhotoUrl(): string {
    return this.user?.p_profile
      ? `${BASE_IMAGE_URL}${this.user.p_profile}`
      : `${BASE_IMAGE_URL}icon-profile.jpg`;
  }

  // Navigasi dengan animasi smooth
  navigateTo(page: string, status?: string) {
    if (page === 'letter-status' && status) {
      this.navCtrl.navigateForward([`/letter-status`], {
        queryParams: { status },
        animated: true,
        animationDirection: 'forward',
      });
    } else {
      this.navCtrl.navigateForward([`/${page}`], {
        animated: true,
        animationDirection: 'forward',
      });
    }
  }

  viewLetterDetail(id: string) {
    this.navCtrl.navigateForward([`/letter-detail`, id], {
      animated: true,
      animationDirection: 'forward',
    });
  }

  getStatusColor(status: string): string {
    switch ((status || '').toLowerCase()) {
      case 'pending':
        return 'warning';
      case 'approved':
        return 'success';
      case 'rejected':
        return 'danger';
      case 'cancelled':
        return 'medium';
      default:
        return 'medium';
    }
  }

  getLetterIcon(type: string): string {
    // Ganti sesuai kebutuhan jenis surat
    switch ((type || '').toLowerCase()) {
      case 'izin':
        return 'document-text-outline';
      case 'pengantar':
        return 'mail-outline';
      default:
        return 'document-outline';
    }
  }

  getStatusLabel(status: string): string {
    switch ((status || '').toLowerCase()) {
      case 'pending':
        return 'Menunggu';
      case 'approved':
        return 'Disetujui';
      case 'rejected':
        return 'Ditolak';
      case 'cancelled':
        return 'Dibatalkan';
      default:
        return status;
    }
  }
}
