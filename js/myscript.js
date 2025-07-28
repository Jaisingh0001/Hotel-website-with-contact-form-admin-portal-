console.log("myscript.js loaded!");

document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("contactForm");

    if (form) {
        form.addEventListener("submit", function (e) {
            e.preventDefault(); // Stop normal form submit

            const formData = new FormData(form);

            fetch(form.action, {
                method: "POST",
                body: formData
            })
                .then(response => response.text())
                .then(data => {
                    alert(data);   // This will show popup with PHP echo
                    form.reset();  // Clear form after successful submission
                })
                .catch(error => {
                    alert("Something went wrong!");
                    console.error("Error:", error);
                });
        });
    }
});