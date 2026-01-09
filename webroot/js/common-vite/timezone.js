class Timezone {
  static stdTimezoneOffset() {
    const jan = new Date(Date.prototype.getFullYear(), 0, 1);
    const jul = new Date(Date.prototype.getFullYear(), 6, 1);
    return Math.max(jan.getTimezoneOffset(), jul.getTimezoneOffset());
  }

  static dst() {
    return Date.prototype.getTimezoneOffset() < Timezone.stdTimezoneOffset();
  }

  static getUserTimezoneOffset() {
    return new Date().getTimezoneOffset() / 60;
  }

  static getUserTimezone() {
    return new Date().toLocaleTimeString('en-us', { timeZoneName: 'short' }).split(' ')[2];
  }
}

export { Timezone };