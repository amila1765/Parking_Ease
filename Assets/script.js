document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("signup-form");

    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        const firstName = document.getElementById("first-name").value.trim();
        const lastName = document.getElementById("last-name").value.trim();
        const email = document.getElementById("email").value.trim();
        const password = document.getElementById("password").value;
        const confirmPassword = document.getElementById("confirm-password").value;

        if (password !== confirmPassword) {
            alert("Passwords do not match!");
            return;
        }

        const data = {
            first_name: firstName,
            last_name: lastName,
            email,
            password,
            confirm_password: confirmPassword
        };

        try {
            const response = await fetch("../api/register_user.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(data)
            });

            const result = await response.json();
            if (result.success) {
                alert("Registration successful!");
                window.location.href = "login.php";
            } else {
                alert(result.message || "Failed to register. Please try again.");
            }
            } catch (error) 
            {
            console.error("Error:", error);
            alert("Something went wrong. Please try again.");
            }
    });
});