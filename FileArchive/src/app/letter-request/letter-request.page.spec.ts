import { ComponentFixture, TestBed } from '@angular/core/testing';
import { LetterRequestPage } from './letter-request.page';

describe('LetterRequestPage', () => {
  let component: LetterRequestPage;
  let fixture: ComponentFixture<LetterRequestPage>;

  beforeEach(() => {
    fixture = TestBed.createComponent(LetterRequestPage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
