
document.addEventListener('DOMContentLoaded', function() {
    const readMoreButtons = document.querySelectorAll('.article-card .btn');
    readMoreButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            alert('You clicked "Read More"!');
        });
    });
});