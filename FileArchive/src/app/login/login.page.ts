import { Component } from '@angular/core';

@Component({
  standalone: false,
  selector: 'app-login',
  templateUrl: './login.page.html',
  styleUrls: ['./login.page.scss'],
})


export class LoginPage {
  passwordVisible = false;

  constructor() {}

  togglePasswordVisibility() {
    this.passwordVisible = !this.passwordVisible;
    
    // Ubah tipe input
    const passwordInput = document.getElementById('password-input') as HTMLInputElement;
    passwordInput.type = this.passwordVisible ? 'text' : 'password';

    
  }

  
}