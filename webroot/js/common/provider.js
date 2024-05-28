/***
 * Provider Tab Code -- used on admin/location/edit && clinic/locations/edit
 ***/
/*** TODO: check this once on main branch ***/
class Provider {
  constructor() {
    this.errorStyle = {
      'background': 'rgba(200,100,100,.5)'
    };

    document.body.addEventListener('click', (e) => {
      const target = e.target;
      
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

  checkEmpty(obj) {
    const { errorStyle } = this;

    if (obj.value.length === 0) {
      // Apply all of the error styles to the input
      for (const key in errorStyle) {
        const style = errorStyle[key];
        obj.style[key] = style;
      }

      return false;
    } else {
      // Remove all of the error styles from the input.
      for (const key in errorStyle) {
        obj.style[key] = '';
      }

      return true;
    }
  }

  moveProviderUp(obj) {
    const providerDiv = obj.closest('.provider');
    const providerKey = providerDiv.getAttribute('provider');
    const swapKey = parseInt(providerKey) - 1;
    this.swapProviders(providerDiv, providerKey, swapKey);
  }

  moveProviderDown(obj) {
    const providerDiv = obj.closest('.provider');
    const providerKey = providerDiv.getAttribute('provider');
    const swapKey = parseInt(providerKey) + 1;
    this.swapProviders(providerDiv, providerKey, swapKey);
  }

  swapProviders(providerDiv, providerKey, swapKey) {
    // Check if there's a Provider with specified swap Key
    const swapProvider = document.querySelector(`.provider[provider="${swapKey}"]`);

    // Provider doesn't exist, let's get out.
    if (!swapProvider) {
      return false;
    }

    // Change provider attr in div, and the priority input.
    const swapDiv = swapProvider;
    swapDiv.setAttribute('provider', providerKey);
    swapDiv.querySelector('.provider-priority').value = parseInt(providerKey) + 1;
    providerDiv.setAttribute('provider', swapKey);
    providerDiv.querySelector('.provider-priority').value = parseInt(swapKey) + 1;
  }

  addCredential(obj) {
    const fieldName = obj.getAttribute('field');
    const field = document.getElementById(fieldName);
    const credential = obj.textContent.trim();

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

document.querySelectorAll(".provider").forEach((element, index) => {
  const audOrHisElement = document.getElementById("Provider" + index + "AudOrHis");
  if (audOrHisElement !== null && audOrHisElement.value === "AUD") {
    audOrHisElement.value = "Audiologist";
  }
});
