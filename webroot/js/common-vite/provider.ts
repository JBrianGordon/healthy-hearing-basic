/***
 * Provider Tab Code -- used on admin/location/edit && clinic/locations/edit
 ***/
/*** TODO: check this once on main branch ***/

interface ErrorStyle {
  background: string;
  [key: string]: string;
}

class Provider {
  private errorStyle: ErrorStyle;

  constructor() {
    this.errorStyle = {
      'background': 'rgba(200,100,100,.5)'
    };

    document.body.addEventListener('click', (e: MouseEvent) => {
      const target = e.target as HTMLElement;

      if (target.matches('.credLink')) {
        this.addCredential(target);
        e.preventDefault();
      } else if (target.matches('.js-provider-up')) {
        this.moveProviderUp(target);
        e.preventDefault();
      } else if (target.matches('.js-provider-down')) {
        this.moveProviderDown(target);
        e.preventDefault();
      }
    });
  }

  checkEmpty(obj: HTMLInputElement): boolean {
    const { errorStyle } = this;

    if (obj.value.length === 0) {
      // Apply all of the error styles to the input
      for (const key in errorStyle) {
        const style = errorStyle[key];
        (obj.style as any)[key] = style;
      }

      return false;
    } else {
      // Remove all of the error styles from the input.
      for (const key in errorStyle) {
        (obj.style as any)[key] = '';
      }

      return true;
    }
  }

  moveProviderUp(obj: HTMLElement): void {
    const providerDiv = obj.closest('.provider') as HTMLElement;
    if (!providerDiv) return;

    const providerKey = providerDiv.getAttribute('provider');
    if (!providerKey) return;

    const swapKey = parseInt(providerKey) - 1;
    this.swapProviders(providerDiv, providerKey, swapKey);
  }

  moveProviderDown(obj: HTMLElement): void {
    const providerDiv = obj.closest('.provider') as HTMLElement;
    if (!providerDiv) return;

    const providerKey = providerDiv.getAttribute('provider');
    if (!providerKey) return;

    const swapKey = parseInt(providerKey) + 1;
    this.swapProviders(providerDiv, providerKey, swapKey);
  }

  swapProviders(providerDiv: HTMLElement, providerKey: string, swapKey: number): boolean {
    // Check if there's a Provider with specified swap Key
    const swapProvider = document.querySelector<HTMLElement>(`.provider[provider="${swapKey}"]`);

    // Provider doesn't exist, let's get out.
    if (!swapProvider) {
      return false;
    }

    // Change provider attr in div, and the priority input.
    const swapDiv = swapProvider;
    swapDiv.setAttribute('provider', providerKey);

    const swapPriorityInput = swapDiv.querySelector<HTMLInputElement>('.provider-priority');
    if (swapPriorityInput) {
      swapPriorityInput.value = (parseInt(providerKey) + 1).toString();
    }

    providerDiv.setAttribute('provider', swapKey.toString());

    const providerPriorityInput = providerDiv.querySelector<HTMLInputElement>('.provider-priority');
    if (providerPriorityInput) {
      providerPriorityInput.value = (swapKey + 1).toString();
    }

    return true;
  }

  addCredential(obj: HTMLElement): boolean {
    const fieldName = obj.getAttribute('field');
    if (!fieldName) return false;

    const field = document.getElementById(fieldName) as HTMLInputElement;
    if (!field) return false;

    const credential = obj.textContent?.trim() || '';

    // Make sure we don't add a credential that's already in the list.
    const credentialList = field.value.split(', ');

    if (credentialList.includes(credential)) {
      return false;
    }

    // If the field already has a credential, add it to the end.
    if (field.value.length > 0) {
      field.value += ', ';
    }

    field.value += credential;
    return false;
  }
}

const provider = new Provider();

document.querySelectorAll<HTMLElement>(".provider").forEach((element, index) => {
  const audOrHisElement = document.getElementById("Provider" + index + "AudOrHis") as HTMLInputElement;
  if (audOrHisElement !== null && audOrHisElement.value === "AUD") {
    audOrHisElement.value = "Audiologist";
  }
});