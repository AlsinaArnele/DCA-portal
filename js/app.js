function checkStatus() {
    const element = document.getElementById("user-status-data");
            const status = element.innerText.toLowerCase().trim();

            if (status === 'disabled') {
                element.style.backgroundColor = 'red';
            } else if (status === 'active') {
                element.style.backgroundColor = 'green';
            }
}
document.addEventListener('DOMContentLoaded', function() {
    checkStatus();
});

function toggleView(containerToShow) {
    var containers = {
        'user': document.getElementById('user-accounts'),
        'task': document.getElementById('task-container'),
        'time': document.getElementById('time-container')
    };

    for (var key in containers) {
        if (key === containerToShow) {
            containers[key].style.display = 'flex';
        } else {
            containers[key].style.display = 'none';
        }
    }
}
window.addEventListener('beforeunload', function() {
    
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'actions/closed-browser.php', true);
    xhr.send();

});
      
