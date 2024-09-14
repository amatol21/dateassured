async function linkClickHandler(e) {
    e.preventDefault();
    if (this._toggleActive) {
        let active = this.parentNode.querySelector('.active');
        if (active !== null) active.classList.remove('active');
        this.classList.add('active');
    }
    window.history.pushState(null, '', this.getAttribute('href'));
    let res = await fetch(this.getAttribute('href'), {
        method: 'GET',
        headers: {'X-Requested-With': 'XMLHttpRequest'}
    });
    if (res.ok) {
        let html = await res.text();
        setInnerHtml(this._target, html);
    }
}

window.makeSmartLinks = function(selector, target, toggleActive) {
    toggleActive = toggleActive === true;
    if (target === undefined) target = '#content';
    let links = document.querySelectorAll(selector);
    for (let i = 0; i < links.length; i++) {
        links[i]._target = target;
        links[i]._toggleActive = toggleActive;
        links[i].addEventListener('click', linkClickHandler);
    }
}
