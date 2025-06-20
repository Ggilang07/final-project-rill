import { ComponentFixture, TestBed } from '@angular/core/testing';
import { VerfyOtpPage } from './verfy-otp.page';

describe('VerfyOtpPage', () => {
  let component: VerfyOtpPage;
  let fixture: ComponentFixture<VerfyOtpPage>;

  beforeEach(() => {
    fixture = TestBed.createComponent(VerfyOtpPage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
