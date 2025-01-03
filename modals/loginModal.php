<div id="loginModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Login</h2>

        <form id="loginForm">
            <input type="email" id="email" placeholder="Email" required>
            <input type="password" id="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>

        <?php
        // Dynamic path handling for the signup link
        $basePath = (basename($_SERVER['SCRIPT_FILENAME']) === 'index.php') ? './pages/' : './';
        ?>

        <p>Don't have an account? <a href="<?= $basePath ?>signup.php">Sign up</a></p>
    </div>
</div>

<script>

    function openModal() {
        document.getElementById('loginModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('loginModal').style.display = 'none';
    }

    window.onclick = function(event) {
        const modal = document.getElementById('loginModal');
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }

    // Handle Form Submission
    document.getElementById('loginForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    const data = {
        email: email,
        password: password
    };

    fetch('./api/login_API.php', {  // API path
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(responseData => {
        if (responseData.status === 'success') {
            alert('Login successful!');
            window.location.href = '/Parking_Ease/pages/reservation.php'; // Redirect to user dashboard or home
        } else {
            alert('Error: ' + responseData.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Something went wrong!');
    });
});

</script>

<style>
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-content {
        background-color: white;
        margin: 15% auto;
        padding: 20px;
        border-radius: 5px;
        width: 90%;
        max-width: 400px;
        text-align: center;
    }

    .modal-content h2 {
        margin-bottom: 1rem;
    }

    .modal-content input {
        width: 80%;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .modal-content button {
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        background: #ff6f61;
        color: white;
        font-size: 1rem;
        cursor: pointer;
    }

    .modal-content button:hover {
        background: #e05548;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
    }

    .close:hover {
        color: black;
    }
</style>
