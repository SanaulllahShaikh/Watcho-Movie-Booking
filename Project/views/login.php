<?php
$page = "login";
include('../includes/header.php');
if (isset($_SESSION['user_id'])) {
    session_destroy();
}
?>



<div class="primary-container min-h-screen flex flex-col mx-auto w-full p-6 bg-gray-800">
    <h1 class="font-bold text-4xl text-gray-100 pt-5 pb-4 text-center tracking-wide uppercase">
        Login
    </h1>
    <main class="flex items-center justify-center px-8 py-8 sm:px-12 lg:col-span-7 lg:px-16 lg:py-10 xl:col-span-6">
        <div class="w-full sm:max-w-2xl lg:w-[550px]">
            <form method="post" id="loginForm" class="mt-8 grid grid-cols-6 gap-6">
                <div class="col-span-6 text-center">
                    <span id="error" class="text-red-500 text-xs text-center">
                        <?php
                        if (isset($_SESSION['user_id'])) {
                            echo "Already user logged in";
                        }
                        ?>
                    </span>
                    <span id="successMessage" class="text-green-500 text-lg text-center" style="display: none;"></span>

                </div>

                <div class="col-span-6">
                    <label for="Email" class="block text-sm font-medium text-gray-300">Email</label>
                    <input type="email" id="Email" name="email"
                        class="mt-1 w-full h-12 rounded-md border-gray-700 bg-gray-700 px-4 text-sm text-gray-100 shadow-sm focus:border-cyan-500 focus:ring-2 focus:ring-cyan-400 focus:ring-opacity-50" />
                    <span id="errorEmail" class="text-red-500 text-xs"></span>
                </div>

                <div class="col-span-6">
                    <label for="Password" class="block text-sm font-medium text-gray-300">Password</label>
                    <input type="password" id="Password" name="password"
                        class="mt-1 w-full h-12 rounded-md border-gray-700 bg-gray-700 px-4 text-sm text-gray-100 shadow-sm focus:border-cyan-500 focus:ring-2 focus:ring-cyan-400 focus:ring-opacity-50" />
                    <span id="errorPassword" class="text-red-500 text-xs"></span>
                </div>

                <div class="col-span-6 flex items-center">
                    <label for="RememberMe" class="flex gap-4">
                        <input type="checkbox" id="RememberMe" name="remember_me"
                            class="h-5 w-5 rounded-md border-gray-700 bg-gray-700 text-cyan-500 shadow-sm focus:ring-2 focus:ring-cyan-400 focus:ring-opacity-50" />
                        <span class="text-sm text-gray-300">Remember Me</span>
                    </label>
                </div>

                <div class="col-span-6 sm:flex sm:items-center sm:gap-4">
                    <button type="submit"
                        class="inline-block w-full rounded-md bg-cyan-600 px-12 py-3 text-sm font-medium text-gray-100 transition hover:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:ring-opacity-50 sm:w-auto">
                        Log In
                    </button>

                    <p class="mt-4 text-sm text-gray-400 sm:mt-0">
                        Don't have an account?
                        <a href="./register.php" class="text-cyan-400 underline hover:text-cyan-500">Create one</a>.
                    </p>
                </div>
            </form>

        </div>
    </main>
</div>










<?php require_once '../includes/footer.php'; ?>



<script>
    const menuBtn = document.getElementById('menu-btn');
    const menu = document.getElementById('menu');
    const mobileMenu = document.getElementById('mobile-menu');

    menuBtn.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
        menuBtn.classList.toggle('active-btn');
        menuBtn.classList.toggle('text-black');
    });


    $("#loginForm").on("submit", function(event) {
        event.preventDefault();

        $(".text-red-500").text("");

        const submitButton = $(this).find("button[type='submit']");
        submitButton.prop("disabled", true);

        $.ajax({
            url: "../controllers/login.controller.php",
            type: "POST",
            data: $(this).serialize(),
            dataType: "json",
            success: function(response) {
                console.log(response);

                if (response.status === "error") {
                    if (response.errors.general) {
                        $("#error").text(response.errors.general);
                    }
                    for (const [field, message] of Object.entries(response.errors)) {
                        if (field !== "general") {
                            $(`#error${field.charAt(0).toUpperCase() + field.slice(1)}`).text(message);
                        }
                    }
                } else if (response.status === "success") {
                    $("#successMessage").fadeIn().text(response.message);
                    console.log(response.is_admin);
                    
                    setTimeout(() => {
                        window.location.href = "../index.php";
                    }, 1500);
                }
            },
            error: function(xhr, status, error) {
                console.error("An error occurred:", error);
                $("#error").text("An unexpected error occurred. Please try again.");
            },
            complete: function() {
                submitButton.prop("disabled", false);
            }
        });
    });
</script>
</body>

</html>