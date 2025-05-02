document.addEventListener('DOMContentLoaded', function () {
    // Select all 'See More' links
    const seeMoreLinks = document.querySelectorAll('.see-more');

    // Add click event listener to each link
    seeMoreLinks.forEach(link => {
        link.addEventListener('click', function () {
            // Extract data attributes from the clicked link
            const itemName = this.getAttribute('data-name');
            const itemDescription = this.getAttribute('data-description');

            // Update modal content
            document.getElementById('modal-title').innerText = itemName;
            document.getElementById('modal-description').innerText = itemDescription;
        });
    });
});
