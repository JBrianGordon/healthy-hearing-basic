import $ from 'jquery';

import './common';

interface TestResults {
  answers: number[];
  firstName: string;
  lastName: string;
  email: string;
  hearingResult: 'normal' | 'possible' | 'significant' | '';
  emailSymptoms: string[];
}

interface ResultKey {
  [key: string]: {
    div: string;
  };
}

interface NewsletterResponse {
  success: boolean;
  errorMessage?: string;
}

declare global {
  interface Window {
    HT: OnlineHearingTest;
    online_answers?: TestResults | null;
    grecaptcha: {
      getResponse: () => string;
      execute: () => void;
      reset: () => void;
    };
  }
}

class OnlineHearingTest {
  results: TestResults | null;
  mobile: boolean;
  responsive: boolean;
  debug: boolean;
  fastAdvance: boolean;
  lastPage: number;
  numberOfQuestions: number;
  totalPages: number;
  resultsDiv: string;
  testCounter: string;
  modal: string;
  startTest: string;
  currentPage: number;
  symptoms: string[];
  resultKey: ResultKey;

  constructor(results: TestResults | null = null, mobile: boolean = false, responsive: boolean = false) {
    this.results = results || null;
    this.mobile = mobile;
    this.responsive = responsive;
    this.debug = false;
    this.fastAdvance = true;
    this.lastPage = this.numberOfQuestions = document.querySelectorAll('.test-page').length - 1;
    this.totalPages = this.lastPage + 1;
    this.resultsDiv = '#Results';
    this.testCounter = '#test-counter';
    this.modal = '#HearingTest';
    this.startTest = '#start-test';
    this.currentPage = 0;

    if (this.mobile) {
      this.fastAdvance = false;
    }

    this.symptoms = [
      'Difficulty hearing on the telephone',
      'Misunderstanding, disagreements or being encouraged to have hearing checked by loved ones',
      'Difficulty hearing the television without increasing the volume',
      'Difficulty understanding women\'s and children\'s voices',
      'A history of excessive noise exposure',
      'Perception of people mumbling or not speaking clearly',
      'Difficulty hearing in noisy places',
      'Missing what was said but pretending to hear',
      'Tinnitus (ringing, buzzing or other noises in the ears)',
      'Avoidance of social situations, conversations and hobbies you once enjoyed'
    ];

    this.resultKey = {
      "normal": {
        "div": "#test-result-normal"
      },
      "possible": {
        "div": "#test-result-possible"
      },
      "significant": {
        "div": "#test-result-significant"
      }
    };

    document.querySelectorAll<HTMLInputElement>('.test-yes-no-radio').forEach((element) => {
      element.addEventListener('click', this.radioClick.bind(this));
    });

    document.querySelectorAll<HTMLElement>('.answer-detail').forEach((element) => {
      element.addEventListener('click', this.detailClick.bind(this));
    });

    const modalElement = document.querySelector<HTMLElement>(this.modal);
    if (modalElement) {
      modalElement.addEventListener('hide.bs.modal', this.modalHide.bind(this));
    }

    this.start();
  }

  modalHide(e: Event): boolean {
    if (!this.completed()) {
      const result = confirm('You have not completed the online hearing test, are you sure?');
      if (!result) {
        e.preventDefault();
      }
    }
    const footerContainer = document.getElementById('footerContainer');
    if (footerContainer) {
      footerContainer.style.display = 'block';
    }
    return true;
  }

  radioClick(event: MouseEvent): void {
    this.log('radioClick');
    if (this.fastAdvance) {
      const target = event.target as HTMLInputElement;
      if (target.checked) {
        const page = target.getAttribute('page');
        if (page) {
          this.nextButton(page);
        }
      }
    } else {
      this.log('fastAdvance disabled.');
    }
  }

  detailClick(event: MouseEvent): void {
    // Placeholder for detail click implementation
    this.log('detailClick');
  }

  start(): void {
    this.log('start');
    if (this.completed()) {
      this.showResult();
    } else {
      this.showPage(0, true);
    }
  }

  showPage(page: number | string, instant: boolean = false): boolean | void {
    if (this.mobile) {
      instant = true;
    }
    this.log(`showPage: ${page} instant: ${instant}`);
    const fade_duration = 400;
    const number = parseInt(String(page));

    if (number < 0) {
      return false;
    }

    const testCounterElement = document.querySelector<HTMLElement>(this.testCounter);
    if (testCounterElement) {
      if (number >= 0 && number < this.lastPage) {
        const questionNumber = number + 1;
        testCounterElement.textContent = `Question ${questionNumber} of ${this.numberOfQuestions}`;
      } else {
        testCounterElement.textContent = 'Almost done!';
      }
    }

    const testpage = `#test-page-${page}`;
    if (!instant) {
      document.querySelectorAll<HTMLElement>(".test-page").forEach(element => {
        element.style.transitionDuration = `${fade_duration}ms`;
        element.style.opacity = '0';
      });
      setTimeout(() => {
        document.querySelectorAll<HTMLElement>(".test-page").forEach(element => {
          element.style.transitionDuration = "0ms";
          element.style.display = "none";
        });
        const testPageElement = document.querySelector<HTMLElement>(testpage);
        if (testPageElement) {
          testPageElement.style.display = "block";
          testPageElement.style.transitionDuration = `${fade_duration}ms`;
          testPageElement.style.opacity = '1';
        }
      }, fade_duration + 50);
    } else {
      document.querySelectorAll<HTMLElement>(".test-page").forEach(element => {
        element.style.display = "none";
      });
      const testPageElement = document.querySelector<HTMLElement>(testpage);
      if (testPageElement) {
        testPageElement.style.display = "block";
      }
    }
    if (this.mobile) {
      this.scrollTo(testpage);
    }
    this.currentPage = number;
  }

  reset(): void {
    const firstPage = document.querySelector<HTMLElement>('#test-page-0');
    if (firstPage) {
      firstPage.style.opacity = '1';
    }
    this.log('reset');
    this.results = {
      answers: [],
      firstName: '',
      lastName: '',
      email: '',
      hearingResult: '',
      emailSymptoms: []
    };
    const footerContainer = document.getElementById('footerContainer');
    if (footerContainer) {
      footerContainer.style.display = 'none';
    }
    this.start();
  }

  nextButton(page: number | string): void {
    this.log('nextButton: ' + page);
    const pageNum = parseInt(String(page));
    if (this.processAnswer(pageNum)) {
      if (pageNum === this.lastPage) {
        const finalResults = this.getResults();
        this.saveTest(finalResults);
        this.showResult();
      } else {
        this.showPage(pageNum + 1);
      }
    } else {
      this.showPage(pageNum, true);
    }
  }

  prevButton(page: number | string): void {
    this.log('prevButton: ' + page);
    const pageNum = parseInt(String(page));
    if (pageNum !== 0) {
      this.showPage(pageNum - 1);
    }
  }

  getTestResult(): void {
    if (!this.results) return;

    const totalScore = this.results.answers.reduce((a, b) => a + b, 0);
    this.log('Total Score: ' + totalScore);

    if (totalScore <= 2) {
      this.results.hearingResult = 'normal';
    } else if (totalScore <= 9) {
      this.results.hearingResult = 'possible';
    } else {
      this.results.hearingResult = 'significant';
    }
  }

  getResult(): string {
    return this.results?.hearingResult || '';
  }

  processAnswer(page: number): boolean {
    this.log('ProcessAnswer: ' + page);
    if (!this.results) return false;

    let retval = false;
    const answerIndex = page;

    if (page === 10) {
      const firstNameInput = document.querySelector<HTMLInputElement>('#inputFirstName');
      const lastNameInput = document.querySelector<HTMLInputElement>('#inputLastName');
      const emailInput = document.querySelector<HTMLInputElement>('#testerEmail');

      if (firstNameInput && lastNameInput && emailInput) {
        this.results.firstName = firstNameInput.value;
        this.results.lastName = lastNameInput.value;
        this.results.email = emailInput.value;
        if (this.contactInfoFilled()) {
          retval = true;
        }
      }
    } else {
      retval = true;
      const checkedInput = document.querySelector<HTMLInputElement>(`input[name=quizAnswers${page}]:checked`);

      if (checkedInput !== null) {
        switch (checkedInput.value) {
          case 'sometimes':
            this.results.answers[answerIndex] = 1;
            break;
          case 'yes':
            this.results.answers[answerIndex] = 2;
            break;
          case 'no':
            this.results.answers[answerIndex] = 0;
            break;
        }
      } else {
        retval = false;
      }

      if (page === 9) {
        this.getTestResult();

        this.results.emailSymptoms = this.symptoms.filter((symptom, index) => {
          return this.results!.answers[index] > 0;
        });

        const urlResultInput = document.querySelector<HTMLInputElement>('#url-result');
        if (urlResultInput) {
          urlResultInput.value = this.getResults();
        }
      }
    }

    this.log('processAnswer outcome: ' + retval);
    const errorElement = document.querySelector<HTMLElement>("#error-" + page);
    if (errorElement) {
      errorElement.style.display = retval ? 'none' : 'block';
    }
    return retval;
  }

  completed(): boolean {
    if (this.results !== null) {
      return this.results.answers.length === this.numberOfQuestions && this.contactInfoFilled();
    } else {
      return false;
    }
  }

  contactInfoFilled(): boolean {
    if (!this.results) return false;
    return this.results.firstName.length > 0 &&
      this.results.lastName.length > 0 &&
      this.results.email.length > 0;
  }

  showResult(): void {
    this.log('showResult');
    const hearingTestElement = document.querySelector<HTMLElement>('#HearingTest');

    if (this.mobile) {
      if (hearingTestElement) {
        hearingTestElement.style.display = 'none';
      }
    } else {
      ($ as any)("#HearingTest").modal('hide');
    }

    if (!this.completed()) {
      this.reset();
      if (this.mobile) {
        if (hearingTestElement) {
          hearingTestElement.style.display = 'block';
        }
      } else {
        ($ as any)("#HearingTest").modal('show');
      }
      return;
    }

    const startTestElement = document.querySelector<HTMLElement>(this.startTest);
    if (startTestElement) {
      startTestElement.style.display = 'none';
    }

    this.resultSelect();
    this.updateHeader();
    this.autoFillNewsletterForm();
    this.addRecaptcha();
    ($ as any)(this.resultsDiv).slideDown();
    window.scrollTo(0, 0);
  }

  updateHeader(): void {
    const startH1 = document.querySelector<HTMLElement>('#start-h1');
    const resultH2 = document.querySelector<HTMLElement>('#result-h2');

    if (startH1) {
      startH1.style.display = 'none';
    }
    if (resultH2) {
      resultH2.style.display = 'block';
    }
  }

  resultSelect(): boolean {
    const result = this.getResult();

    Object.entries(this.resultKey).forEach(([key, value]) => {
      const resultElement = document.querySelector<HTMLElement>(value.div);
      if (resultElement) {
        resultElement.style.display = 'none';
      }
    });

    const selectedResultElement = document.querySelector<HTMLElement>(this.resultKey[result].div);
    const testResultElement = document.querySelector<HTMLElement>('#test-result');

    if (selectedResultElement) {
      selectedResultElement.style.display = 'block';
    }
    if (testResultElement) {
      testResultElement.style.display = 'block';
    }
    return true;
  }

  getResults(): string {
    return JSON.stringify(this.results);
  }

  async saveTest(results: string): Promise<void> {
    this.log('Saving Test');
    try {
      const csrfTokenInput = document.getElementsByName("_csrfToken")[0] as HTMLInputElement;
      const csrfToken = csrfTokenInput?.value || '';

      await fetch("/QuizResults/emailResults", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          'X-Requested-With': 'XMLHttpRequest',
          "X-CSRF-Token": csrfToken
        },
        body: JSON.stringify({ results, _csrfToken: csrfToken })
      });
    } catch (error) {
      console.error("Error saving test:", error);
    }
  }

  scrollTo(selector: string, offset: number = 50): boolean {
    this.log(`scrollTo: ${selector} offset: ${offset}`);
    const element = document.querySelector<HTMLElement>(selector);
    if (element) {
      window.scrollTo({
        top: element.offsetTop - offset,
        behavior: 'smooth'
      });
      return true;
    }
    return false;
  }

  autoFillNewsletterForm(): void {
    if (!this.results) return;

    const newsletterForm = document.querySelector<HTMLFormElement>("#HearingTestNewsletterForm");
    if (newsletterForm) {
      const firstNameInput = document.querySelector<HTMLInputElement>('#newsletterFirstName');
      const lastNameInput = document.querySelector<HTMLInputElement>('#newsletterLastName');
      const emailInput = document.querySelector<HTMLInputElement>('#newsletterEmail');

      if (firstNameInput) firstNameInput.value = this.results.firstName;
      if (lastNameInput) lastNameInput.value = this.results.lastName;
      if (emailInput) emailInput.value = this.results.email;
    }
  }

  addRecaptcha(): void {
    const recaptchaScript = document.createElement('script');
    recaptchaScript.src = 'https://www.google.com/recaptcha/api.js';
    document.head.appendChild(recaptchaScript);
  }

  log(message: string): void {
    if (this.debug) {
      try {
        console.log(message);
      } catch (e) {
        // Silent fail
      }
    }
  }
}

const answers = window.online_answers ?? null;
window.HT = new OnlineHearingTest(answers, false, true);

function onSubmit(e: Event): void {
  e.preventDefault();
  if (!window.grecaptcha.getResponse()) {
    window.grecaptcha.execute();
  }
}

function addSubmitListener(): void {
  const form = document.getElementById('HearingTestNewsletterForm');
  if (form !== null) {
    form.addEventListener('submit', onSubmit);
  }
}

function submitNewsletterSignup(): void {
  const form = document.querySelector<HTMLFormElement>("#HearingTestNewsletterForm");
  if (form && form.reportValidity()) {
    const formData = new FormData(form);
    fetch("/quiz_results/newsletter_subscribe", {
      method: "POST",
      body: formData
    })
      .then(response => response.json())
      .then((data: NewsletterResponse) => {
        const subscribeSuccess = document.querySelector<HTMLElement>("#subscribe_success");
        const subscribeError = document.querySelector<HTMLElement>("#subscribe_error");

        if (data.success === true) {
          form.style.display = "none";
          if (subscribeSuccess) {
            subscribeSuccess.style.display = "block";
          }
        } else {
          if (subscribeError) {
            subscribeError.innerHTML = data.errorMessage || 'An error occurred';
            subscribeError.style.display = "block";
          }
        }
        window.grecaptcha.reset();
      })
      .catch((error: Error) => {
        console.error("Error:", error);
      });
  }
}

addSubmitListener();