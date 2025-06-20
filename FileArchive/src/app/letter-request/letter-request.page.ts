import { Component, OnInit, ViewChild } from '@angular/core';
import { IonDatetime, ToastController } from '@ionic/angular';
import { Router } from '@angular/router';
import { ApiService, LetterRequest, User } from '../services/api.service';

@Component({
  standalone: false,
  selector: 'app-letter-request',
  templateUrl: './letter-request.page.html',
  styleUrls: ['./letter-request.page.scss'],
})
export class LetterRequestPage implements OnInit {
  @ViewChild('datetime') datetime!: IonDatetime;
  isDatePickerOpen = false;
  formattedDate: string = '';

  categories: string[] = [];
  letterRequest: LetterRequest = {
    category: '',
    letter_date: new Date().toISOString(),
    reason: '',
    user_id: 0,
    name: '',
  };

  isInformasiOpen = true;
  userData: User | null = null;
  minDate: string;

  constructor(
    private apiService: ApiService,
    private router: Router,
    private toastController: ToastController,
  ) {
    // Set minimum date to today
    const today = new Date();
    this.minDate = today.toISOString();

    // Initialize letterRequest with today's date
    this.letterRequest = {
      category: '',
      letter_date: today.toISOString(),
      reason: '',
      user_id: 0,
      name: '',
    };
  }

  openDatePicker() {
    this.isDatePickerOpen = true;
  }

  closeDatePicker() {
    this.isDatePickerOpen = false;
  }

  onDateChange(event: any) {
    const date = new Date(event.detail.value);
    // Format date as DD/MM/YYYY
    this.formattedDate = date.toLocaleDateString('id-ID', {
      day: '2-digit',
      month: '2-digit',
      year: 'numeric',
    });
    this.letterRequest.letter_date = date.toISOString().split('T')[0];
    this.closeDatePicker();
  }

  ngOnInit() {
    this.loadCategories();
    this.loadUserData();
  }

  loadUserData() {
    this.apiService.getProfile().subscribe({
      next: (response: any) => {
        if (response && response.data) {
          this.userData = response.data;
          if (this.userData) {
            this.letterRequest.user_id = this.userData.user_id;
            this.letterRequest.name = this.userData.name;
          }
        } else {
          this.userData = response;
          this.letterRequest.user_id = response.user_id;
          this.letterRequest.name = response.name;
        }
      },
      error: (error) => {
        console.error('Error loading user data:', error);
      },
    });
  }

  loadCategories() {
    this.apiService.getCategories().subscribe({
      next: (response) => {
        this.categories = response.data;
      },
      error: (error) => {
        console.error('Error loading categories:', error);
      },
    });
  }

  resetForm() {
    const today = new Date();
    this.letterRequest = {
      category: '',
      letter_date: today.toISOString(),
      reason: '',
      user_id: this.userData?.user_id || 0,
      name: this.userData?.name || '',
    };
    this.formattedDate = ''; // Reset the displayed date
  }

  async submitRequest() {
    // Create request payload matching DB fields
    const requestPayload = {
      category: this.letterRequest.category,
      letter_date: this.letterRequest.letter_date,
      reason: this.letterRequest.reason,
      user_id: this.letterRequest.user_id,
    };

    try {
      await this.apiService.createLetterRequest(requestPayload).toPromise();

      const toast = await this.toastController.create({
        message: 'Surat berhasil dibuat!',
        duration: 2000,
        color: 'success',
      });
      toast.present();

      this.resetForm(); // Add this line to reset form
      this.router.navigate(['/letter-status']);
    } catch (error: any) {
      const message = error.error?.message || 'Gagal membuat surat';
      const toast = await this.toastController.create({
        message: message,
        duration: 2000,
        color: 'danger',
      });
      toast.present();
    }
  }

  toggleInformasi() {
    this.isInformasiOpen = !this.isInformasiOpen;
  }

  formatCategory(category: string): string {
    return category.split('_').map(word => 
      word.charAt(0).toUpperCase() + word.slice(1).toLowerCase()
    ).join(' ');
  }
}
