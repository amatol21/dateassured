

window.formatTime = function(time) {
    let startedAt = new Date(time);
    let day = startedAt.getDate().toString().padStart(2, '0');
    let month = startedAt.getMonth().toString().padStart(2, '0');
    let year = startedAt.getFullYear();
    let hours = startedAt.getHours().toString().padStart(2, '0');
    let minutes = startedAt.getMinutes().toString().padStart(2, '0');
    return ''+day+'.'+month+'.'+year+' at '+hours+':'+minutes;
}

window.createSessionInfo = function(vs, showDeleteButton, deleteSessionInfoHandler)
{
    let startedAt = new Date(vs.startedAt);
    let day = startedAt.getDate().toString().padStart(2, '0');
    let month = startedAt.getMonth().toString().padStart(2, '0');
    let year = startedAt.getFullYear();
    let hours = startedAt.getHours().toString().padStart(2, '0');
    let minutes = startedAt.getMinutes().toString().padStart(2, '0');
    let sexuality = vs.sexuality === 0 ? 'straight' : (vs.sexuality === 1 ? 'lesbian' : 'gay');
    if (vs.sexuality === 3) sexuality = 'straight';


    let info = document.createElement('div');
    info.className = 'vs-list-item__info';
    info.dataset.id = vs.id;
    info.innerHTML = `
        <div class="vs-list-item__icon-wrap">
            <svg viewBox="0 0 13 14" width="36" height="36">
                <use href="/images/icons.svg#sexuality-${sexuality}"></use>
            </svg>
        </div>
        <div class="vs-list-item__age">
            <div class="vs-list-item__age-label">Age limit:</div>
            <div class="vs-list-item__age-text">${vs.minAge === 0 ? 'Any age' : vs.minAge + ' - ' + vs.maxAge}</div>
        </div>
        <div class="vs-list-item__purpose">
            <div class="vs-list-item__purpose-label">Purpose:</div>
            <div class="vs-list-item__purpose-text">${localization.enums.purpose[vs.purpose]}</div>
        </div>
        <div class="vs-list-item__location">
            <div class="vs-list-item__location-label">Location:</div>
            <div class="vs-list-item__location-text">${localization.enums.country[vs.country]}</div>
        </div>
        <div class="vs-list-item__date-wrap">
            <div class="vs-list-item__date">${day}.${month}.${year}</div>
            <div class="vs-list-item__time">${hours}:${minutes}</div>
        </div>`;

    if (showDeleteButton) {
        let deleteButton = document.createElement('div');
        deleteButton.className = 'vs-list-item__delete-button';
        deleteButton.innerHTML = "&times;";
        deleteButton.addEventListener('click', deleteSessionInfoHandler);
        info.appendChild(deleteButton);
    }
    return info;
}
