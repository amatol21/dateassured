function easeInOutQuad(x) { return x < 0.5 ? 2 * x * x : 1 - Math.pow(-2 * x + 2, 2) / 2; }

window.animate = async function (callback, duration) {
	return new Promise(resolve => {
		if (!duration) duration = 250;
		let startTime = Date.now();

		let f = () => {
			let k = (Date.now() - startTime) / duration;
			if (k < 1) {
				callback(k);
				requestAnimationFrame(f);
			} else {
				callback(1);
				requestAnimationFrame(resolve);
			}
		};
		requestAnimationFrame(f);
	});
};

window.makeElement = function (tag, className, appendTo) {
	let node = document.createElement(tag);
	node.className = className;
	if (appendTo !== undefined) appendTo.appendChild(node);
	return node;
}


window.fadeIn = async function (el, duration) {
	return new Promise(resolve => {
		if (el.style.display === '' && el.style.opacity === '') return resolve();
		if (!duration) duration = 250;
		let startTime = Date.now();
		el.style.display = null;
		let f = () => {
			let k = (Date.now() - startTime) / duration;
			if (k < 1) {
				el.style.opacity = easeInOutQuad(k);
				requestAnimationFrame(f);
			} else {
				el.style.opacity = null;
				resolve();
			}
		};
		requestAnimationFrame(f);
	});
};

window.fadeOut = async function (el, duration, hide) {
	return new Promise(resolve => {
		if (el.style.display === 'none') return resolve();
		if (el.style.opacity === '0' && hide) {
			el.style.display = 'none';
			return resolve();
		}
		if (!duration) duration = 250;
		let startTime = Date.now();
		let f = () => {
			let k = (Date.now() - startTime) / duration;
			if (k < 1) {
				el.style.opacity = 1 - easeInOutQuad(k);
				requestAnimationFrame(f);
			} else {
				el.style.opacity = 0;
				if (hide !== false) el.style.display = 'none';
				resolve();
			}
		};
		requestAnimationFrame(f);
	});
};


window.getScrollbarWidth = () => {
	// Creating invisible container
	const outer = document.createElement('div');
	outer.style.visibility = 'hidden';
	outer.style.overflow = 'scroll'; // forcing scrollbar to appear
	outer.style.msOverflowStyle = 'scrollbar'; // needed for WinJS apps
	document.body.appendChild(outer);

	// Creating inner element and placing it in the container
	const inner = document.createElement('div');
	outer.appendChild(inner);

	// Calculating difference between container's full width and the child width
	const scrollbarWidth = (outer.offsetWidth - inner.offsetWidth);

	// Removing temporary elements from the DOM
	outer.parentNode.removeChild(outer);

	return scrollbarWidth;
};

window.disableBodyScrollbar = () => {
	let scrollWidth = getScrollbarWidth();
	document.body.style.overflow = 'hidden';
	if (document.body.scrollHeight > document.body.clientHeight) {
		document.body.style.paddingRight = scrollWidth + 'px';
		let header = document.getElementById('header');
		if (header !== null) header.style.paddingRight = scrollWidth + 'px';
	}
};

window.enableBodyScrollbar = () => {
	document.body.style.overflow = null;
	document.body.style.paddingRight = null;
	let header = document.getElementById('header');
	if (header !== null) header.style.paddingRight = null;
};

window.prepareForm = (form) => {
	let placeholders = form.getElementsByClassName('input-placeholder');
	for (let i = 0; i < placeholders.length; i++) {
		placeholders[i].classList.remove('shown');
		let input = placeholders[i].querySelector('input');
		if (input !== null) input.style.display = null;
	}
};

window.showFormErrors = (form, data) => {
	if (data.errors !== null && Object.keys(data.errors).length > 0) {
		for (let p in data.errors) {
			if (data.errors[p].length > 0) {
				let error = form.querySelector('.error[data-for="' + p + '"]');
				if (error !== null) {
					error.textContent = data.errors[p][0];
					error.style.visibility = 'visible';
				}
			}
		}
	}
};

window.clearFormErrors = (form) => {
	let errors = form.getElementsByClassName('error');
	for (let i = 0; i < errors.length; i++) {
		errors[i].textContent = '';
		errors[i].style.visibility = null;
	}
};



class Countdown {
	constructor() {
		this.targetTime = Date.now();
		this.__updateHandler = null;
		this.__task = setInterval(() => {
			if (this.__updateHandler !== null) {
				this.__updateHandler(this.toString());
			}
		}, 1000);
	}


	onUpdate(handler) {
		this.__updateHandler = handler;
	}

	setTargetTime(timestamp) {
		this.targetTime = timestamp;
	}

	toString() {
		let d = (this.targetTime - Date.now()) / 1000;
		if (d < 0) return "00:00";
		let days = Math.floor(d / (86400));
		let hours = Math.floor((d - (86400 * days)) / (3600));
		let minutes = Math.floor((d - (86400 * days) - (3600 * hours)) / 60);
		let seconds = Math.floor(d - (86400 * days) - (3600 * hours) - (60 * minutes));
		let res = days > 0 ? days + (days > 1 ? 'days, ' : 'day, ') : '';
		return res + hours.toString().padStart(2, '0')
			+ ':' + minutes.toString().padStart(2, '0')
			+ ':' + seconds.toString().padStart(2, '0');
	}
}
window.Countdown = Countdown;




window.closeModal = function (node) {
	while (node !== null && !node.classList.contains('modal')) {
		node = node.parentNode;
	}
	if (node !== null) {
		node.classList.remove('shown');
	}

	setTimeout(() => {
		enableBodyScrollbar();
		clearFormErrors(node)
	}, 250);
};



window.showSpinner = async function (target, duration) {
	if (duration === undefined) duration = 250;
	let wrap = document.createElement('div');
	wrap.classList.add('spinner-wrap');
	wrap.innerHTML = '<div class="spinner">' +
		'<div class="spinner-circle">' +
		'<div></div><div></div><div></div><div></div><div></div><div></div><div></div>' +
		'<div></div><div></div><div></div><div></div><div></div><div></div><div></div>' +
		'<div></div><div></div>' +
		'</div>' +
		'</div>';
	wrap.style.opacity = '0';
	target.appendChild(wrap);
	await animate(k => wrap.style.opacity = k.toString(), duration);
};


window.hideSpinner = async function (target, message) {
	let spinner = target.querySelector('.spinner-wrap');

	if (message !== undefined) {
		let msg = document.createElement('div');
		msg.classList.add('spinner-message');
		msg.textContent = message;
		msg.style.opacity = '0';
		spinner.appendChild(msg);

		let circle = spinner.querySelector('.spinner-circle');
		await animate(k => circle.style.opacity = (1 - k).toString(), 150);
		await animate(k => msg.style.opacity = k.toString(), 150);
		await delay(250);
	}

	await animate(k => spinner.style.opacity = (1 - k).toString(), 250);
	spinner.parentNode.removeChild(spinner);
};


window.delay = function (duration) {
	return new Promise(resolve => setTimeout(resolve, duration));
};

// Sets inner HTML for the element and executes all scripts inside.
window.setInnerHtml = function (elm, html) {
	if (typeof elm === 'string') elm = document.querySelector(elm);
	elm.innerHTML = html;

	// Copy title.
	let title = elm.getElementsByTagName('title');
	if (title.length) {
		document.head.getElementsByTagName('title')[0].textContent = title[0].textContent;
		elm.removeChild(title[0]);
	}

	let metas = elm.getElementsByTagName('meta');
	for (let i = 0; i < metas.length; i++) {
		let m = document.head.querySelector('meta[name="' + metas[i].getAttribute('name') + '"]');
		if (m !== null) document.head.replaceChild(metas[i], m);
		metas[i].parentNode.removeChild(metas[i]);
	}

	Array.from(elm.querySelectorAll("script")).forEach(oldScript => {
		const newScript = document.createElement("script");
		Array.from(oldScript.attributes)
			.forEach(attr => newScript.setAttribute(attr.name, attr.value));
		newScript.appendChild(document.createTextNode(oldScript.innerHTML));
		oldScript.parentNode.replaceChild(newScript, oldScript);
	});
};

function getQueryParam(variable, defaultValue) {
	let query = window.location.search.substring(1);
	let vars = query.split('&');
	for (let i = 0; i < vars.length; i++) {
		let pair = vars[i].split('=');
		if (decodeURIComponent(pair[0]) === variable) {
			return decodeURIComponent(pair[1]);
		}
	}
	return defaultValue;
}


window.initTableSorting = function (table, searchForm) {
	if (typeof table === 'string') table = document.querySelector(table);
	if (typeof searchForm === 'string') searchForm = document.querySelector(searchForm);

	let sortInput = searchForm.querySelector('input[name="sort"]');
	let orderInput = searchForm.querySelector('input[name="order"]');

	if (sortInput === null) {
		sortInput = document.createElement('input');
		sortInput.setAttribute('type', 'hidden');
		sortInput.setAttribute('name', 'sort');
		sortInput.value = getQueryParam('sort', '');
		searchForm.appendChild(sortInput);
	}

	if (orderInput === null) {
		orderInput = document.createElement('input');
		orderInput.setAttribute('type', 'hidden');
		orderInput.setAttribute('name', 'order');
		orderInput.value = getQueryParam('order', 'asc');
		searchForm.appendChild(orderInput);
	}


	function tableHeaderHandler() {
		sortInput.value = this.dataset.sort;
		orderInput.value = orderInput.value === 'asc' ? 'desc' : 'asc';
		searchForm.submit();
	}

	let ths = table.getElementsByTagName('th');
	for (let i = 0; i < ths.length; i++) {
		ths[i].addEventListener('click', tableHeaderHandler);
		let name = ths[i].dataset.sort;
		if (name !== sortInput.value) continue;
		let arrow = document.createElement('div');
		arrow.className = 'table_sorting-arrow';
		arrow.classList.add(orderInput.value);
		ths[i].appendChild(arrow);
	}
}

function tabClickHandler(e) {
	let active = this.parentNode.querySelector('.active');
	if (active !== null) {
		let activeContent = document.querySelector(active.dataset.for);
		if (activeContent !== null) {
			activeContent.style.display = 'none';
		}
		active.classList.remove('active');
	}
	this.classList.add('active');
	let content = document.querySelector(this.dataset.for);
	if (content !== null) {
		content.style.display = null;
	}
}
document.addEventListener('DOMContentLoaded', () => {
	let tabs = document.getElementsByClassName('tabs');
	for (let i = 0; i < tabs.length; i++) {
		let items = tabs[i].getElementsByClassName('tab');
		for (let j = 0; j < items.length; j++) {
			items[j].addEventListener('click', tabClickHandler);
		}
	}
});



window.makeTextareaAsMessageInput = function (textarea) {
	if (typeof textarea === 'string') textarea = document.querySelector(textarea);
	if (textarea === null) {
		console.error('Textarea is null');
		return;
	}

	textarea.addEventListener('keydown', e => {
		if (!e.shiftKey && !e.ctrlKey && e.key === 'Enter') {
			if (textarea.value.trim() !== '') {
				textarea.dispatchEvent(new CustomEvent('send', { detail: textarea.value }));
				textarea.value = '';
			}
			e.preventDefault();
		}
	});

	textarea.addEventListener('input', e => {
		textarea.style.height = 0;
		textarea.style.height = textarea.scrollHeight + 'px';
		textarea.style.overflowY = textarea.scrollHeight > 180 ? 'auto' : 'hidden';
	});
}
