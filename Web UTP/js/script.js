document.addEventListener('DOMContentLoaded', function() {
    
    const darkModeToggle = document.getElementById('darkModeToggle');
    const isDarkMode = localStorage.getItem('darkMode') === 'true';
    
    if (isDarkMode) {
        document.body.classList.add('light-mode');
    } else {
        document.body.classList.remove('light-mode');
    }
    
    darkModeToggle.addEventListener('click', function() {
        document.body.classList.toggle('light-mode');
        const shouldBeLight = !document.body.classList.contains('light-mode');
        localStorage.setItem('darkMode', shouldBeLight);
        
        if (shouldBeLight) {
            this.innerHTML = 'Disable';
        } else {
            this.innerHTML = 'Activate';
        }
    });
});