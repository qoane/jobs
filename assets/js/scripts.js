// Wait for the DOM to be ready
document.addEventListener("DOMContentLoaded", function() {

    // Form Validation Example (Optional)
    const forms = document.querySelectorAll("form");
    forms.forEach(form => {
        form.addEventListener("submit", function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
                alert("Please fill out all required fields before submitting.");
            }
            form.classList.add("was-validated");
        });
    });

    // Animation for card elements (optional)
    const cards = document.querySelectorAll(".card");
    cards.forEach(card => {
        card.addEventListener("mouseover", function() {
            card.classList.add("shadow-lg");
            card.style.transform = "scale(1.05)";
        });
        card.addEventListener("mouseout", function() {
            card.classList.remove("shadow-lg");
            card.style.transform = "scale(1)";
        });
    });

    // Smooth scroll to sections (for future navigation)
    const scrollLinks = document.querySelectorAll("a[href^='#']");
    scrollLinks.forEach(link => {
        link.addEventListener("click", function(event) {
            event.preventDefault();
            const targetId = link.getAttribute("href").substring(1);
            const targetElement = document.getElementById(targetId);
            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop,
                    behavior: "smooth"
                });
            }
        });
    });

    // Toggle job filter form section (optional)
    const toggleFiltersButton = document.getElementById("toggle-filters");
    const filterForm = document.getElementById("filter-form");

    if (toggleFiltersButton && filterForm) {
        toggleFiltersButton.addEventListener("click", function() {
            filterForm.classList.toggle("d-none");
            if (!filterForm.classList.contains("d-none")) {
                toggleFiltersButton.textContent = "Hide Filters";
            } else {
                toggleFiltersButton.textContent = "Show Filters";
            }
        });
    }

    // AJAX loader for job listings (Optional future feature)
    /*
    document.getElementById("job-search-form").addEventListener("submit", function(event) {
        event.preventDefault();
        const formData = new FormData(this);
        fetch("jobs.php", {
            method: "POST",
            body: formData,
        })
        .then(response => response.text())
        .then(data => {
            document.getElementById("job-listings").innerHTML = data;
        })
        .catch(error => {
            console.error("Error fetching jobs:", error);
        });
    });
    */
});
