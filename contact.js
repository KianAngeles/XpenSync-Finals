document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("contactForm");
    const responseMessage = document.getElementById("formResponse");

    form.addEventListener("submit", function (event) {
        event.preventDefault(); // Prevent default form submission

        const formData = new FormData(form);

        fetch("https://api.web3forms.com/submit", {
            method: "POST",
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                responseMessage.innerHTML = "✅ Your message has been sent successfully!";
                responseMessage.style.color = "green";
                form.reset(); // Clear the form
            } else {
                responseMessage.innerHTML = "❌ Failed to send message. Try again later.";
                responseMessage.style.color = "red";
            }
        })
        .catch(error => {
            responseMessage.innerHTML = "⚠️ Error sending message. Please check your connection.";
            responseMessage.style.color = "red";
        });
    });
});
