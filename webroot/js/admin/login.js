const stdTimezoneOffset = () => {
	let jan = new Date(Date.prototype.getFullYear(), 0, 1),
		jul = new Date(Date.prototype.getFullYear(), 6, 1);
	return Math.max(jan.getTimezoneOffset(), jul.getTimezoneOffset());
}

const dst = () => {
	return Date.prototype.getTimezoneOffset() < stdTimezoneOffset();
}

const getUserTimezoneOffset = () => {
	return new Date().getTimezoneOffset()/60;
}

const getUserTimezone = () => {
	return new Date().toLocaleTimeString('en-us',{timeZoneName:'short'}).split(' ')[2];
};

// On page load, get the users timezone
let userTimezoneOffset = getUserTimezoneOffset(),
	userTimezone = getUserTimezone(),
	userTimezoneOffsetElem = document.getElementById('UserTimezoneOffset'),
	userTimezoneElem = document.getElementById('UserTimezone');
	
userTimezoneOffsetElem.value = userTimezoneOffset.toString();
userTimezoneElem.value = userTimezone;