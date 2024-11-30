<?php
$page = "register";
include('../includes/header.php');
if (isset($_SESSION['user_id'])) {
    session_destroy();
}
?>




<div class="primary-container min-h-screen flex flex-col gap-2 mx-auto w-full p-6 bg-gray-800">
    <h1 class="font-bold text-4xl text-gray-100 pt-5 pb-4 text-center tracking-wide uppercase">
        Register
    </h1>
    <main class="flex items-center justify-center px-8 py-2 sm:px-6 lg:col-span-7 lg:px-16 lg:py-4 xl:col-span-6">
        <div class="w-full sm:max-w-2xl lg:w-[550px]">
            <form method="post" id="registrationForm" class="mt-2 grid grid-cols-6 gap-4">
                <div class="col-span-6 text-center">
                    <div id="errorEmailExist" class="text-red-500 text-xs text-center">

                    </div>
                    <div id="errorRegisterFail" class="text-red-500 text-xs text-center">

                    </div>
                    <span id="successMessage" class="text-green-500 text-lg text-center" style="display: none;"></span>

                </div>

                <div class="col-span-6 sm:col-span-6">
                    <label for="Username" class="block text-sm font-medium text-gray-300"> Username </label>
                    <input type="text" id="Username" name="user_name" class="mt-1 w-full h-12 rounded-md border-gray-700 bg-gray-700 px-4 text-sm text-gray-100 shadow-sm focus:border-cyan-500 focus:ring-2 focus:ring-cyan-400 focus:ring-opacity-50" />
                    <span id="errorUsername" class="text-red-500 text-xs"></span>

                </div>

                <div class="col-span-6">
                    <label for="Email" class="block text-sm font-medium text-gray-300"> Email </label>
                    <input type="email" id="Email" name="email" class="mt-1 w-full h-12 rounded-md border-gray-700 bg-gray-700 px-4 text-sm text-gray-100 shadow-sm focus:border-cyan-500 focus:ring-2 focus:ring-cyan-400 focus:ring-opacity-50" />
                    <span id="errorEmail" class="text-red-500 text-xs"></span>

                </div>
                <div class="col-span-6 sm:col-span-3 relative">
                    <label for="Password" class="block text-sm font-medium text-gray-300"> Password </label>
                    <input type="password" id="Password" name="password" class="mt-1 w-full h-12 rounded-md border-gray-700 bg-gray-700 px-4 pr-10 text-sm text-gray-100 shadow-sm focus:border-cyan-500 focus:ring-2 focus:ring-cyan-400 focus:ring-opacity-50" />
                    <span id="errorPassword" class="text-red-500 text-xs"></span>

                    <span onclick="togglePassword('Password')" class="absolute top-3 text-zinc-300 right-0 flex items-center justify-center h-full pr-3 cursor-pointer">
                        <svg id="PasswordIcon" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 " viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2ZM12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4ZM12 7C14.7614 7 17 9.23858 17 12C17 14.7614 14.7614 17 12 17C9.23858 17 7 14.7614 7 12C7 11.4872 7.07719 10.9925 7.22057 10.5268C7.61175 11.3954 8.48527 12 9.5 12C10.8807 12 12 10.8807 12 9.5C12 8.48527 11.3954 7.61175 10.5269 7.21995C10.9925 7.07719 11.4872 7 12 7Z"></path>
                        </svg>
                        <svg id="PasswordIconClose" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 hidden" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M9.34268 18.7819L7.41083 18.2642L8.1983 15.3254C7.00919 14.8874 5.91661 14.2498 4.96116 13.4534L2.80783 15.6067L1.39362 14.1925L3.54695 12.0392C2.35581 10.6103 1.52014 8.87466 1.17578 6.96818L3.14386 6.61035C3.90289 10.8126 7.57931 14.0001 12.0002 14.0001C16.4211 14.0001 20.0976 10.8126 20.8566 6.61035L22.8247 6.96818C22.4803 8.87466 21.6446 10.6103 20.4535 12.0392L22.6068 14.1925L21.1926 15.6067L19.0393 13.4534C18.0838 14.2498 16.9912 14.8874 15.8021 15.3254L16.5896 18.2642L14.6578 18.7819L13.87 15.8418C13.2623 15.9459 12.6376 16.0001 12.0002 16.0001C11.3629 16.0001 10.7381 15.9459 10.1305 15.8418L9.34268 18.7819Z"></path>
                        </svg> </span>
                </div>

                <div class="col-span-6 sm:col-span-3 relative">
                    <label for="PasswordConfirmation" class="block text-sm font-medium text-gray-300"> Password Confirmation </label>
                    <input type="password" id="PasswordConfirmation" name="password_confirmation" class="mt-1 w-full h-12 rounded-md border-gray-700 bg-gray-700 px-4 pr-10 text-sm text-gray-100 shadow-sm focus:border-cyan-500 focus:ring-2 focus:ring-cyan-400 focus:ring-opacity-50" />
                    <span id="errorPasswordConfirmation" class="text-red-500 text-xs"></span>

                    <span onclick="togglePassword('PasswordConfirmation')" class="absolute top-3 text-zinc-300 right-0 flex items-center justify-center h-full pr-3 cursor-pointer">

                        <svg id="PasswordConfirmationIcon" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 " viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2ZM12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4ZM12 7C14.7614 7 17 9.23858 17 12C17 14.7614 14.7614 17 12 17C9.23858 17 7 14.7614 7 12C7 11.4872 7.07719 10.9925 7.22057 10.5268C7.61175 11.3954 8.48527 12 9.5 12C10.8807 12 12 10.8807 12 9.5C12 8.48527 11.3954 7.61175 10.5269 7.21995C10.9925 7.07719 11.4872 7 12 7Z"></path>
                        </svg>
                        <svg id="PasswordConfirmationIconClose" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 hidden" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M9.34268 18.7819L7.41083 18.2642L8.1983 15.3254C7.00919 14.8874 5.91661 14.2498 4.96116 13.4534L2.80783 15.6067L1.39362 14.1925L3.54695 12.0392C2.35581 10.6103 1.52014 8.87466 1.17578 6.96818L3.14386 6.61035C3.90289 10.8126 7.57931 14.0001 12.0002 14.0001C16.4211 14.0001 20.0976 10.8126 20.8566 6.61035L22.8247 6.96818C22.4803 8.87466 21.6446 10.6103 20.4535 12.0392L22.6068 14.1925L21.1926 15.6067L19.0393 13.4534C18.0838 14.2498 16.9912 14.8874 15.8021 15.3254L16.5896 18.2642L14.6578 18.7819L13.87 15.8418C13.2623 15.9459 12.6376 16.0001 12.0002 16.0001C11.3629 16.0001 10.7381 15.9459 10.1305 15.8418L9.34268 18.7819Z"></path>
                        </svg> </span>

                    </span>
                </div>

                <div class="col-span-6 sm:col-span-3">
                    <label for="dob" class="block text-sm font-medium text-gray-300"> Date of Birth </label>
                    <input type="date" id="dob" name="dob" class="mt-1 w-full h-12 rounded-md border-gray-700 bg-gray-700 px-4 text-sm text-gray-100 shadow-sm focus:border-cyan-500 focus:ring-2 focus:ring-cyan-400 focus:ring-opacity-50" />
                    <span id="errorDob" class="text-red-500 text-xs"></span>
                </div>



                <div class="col-span-6">
                    <label for="remember" class="flex gap-4">
                        <input type="checkbox" id="remember" name="remember"
                            class="h-5 w-5 rounded-md border-gray-700 bg-gray-700 text-cyan-500 shadow-sm focus:ring-2 focus:ring-cyan-400 focus:ring-opacity-50" />
                        <span class="text-sm text-gray-300"> Remember me </span>
                    </label>
                </div>

                <div class="col-span-6 sm:flex sm:items-center sm:gap-4">
                    <button type="submit"
                        class="inline-block w-full rounded-md bg-cyan-600 px-12 py-3 text-sm font-medium text-gray-100 transition hover:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:ring-opacity-50 sm:w-auto">
                        Create an account
                    </button>

                    <p class="mt-4 text-sm text-gray-400 sm:mt-0">
                        Already have an account?
                        <a href="./login.php" class="text-cyan-400 underline hover:text-cyan-500">Log in</a>.
                    </p>
                </div>
            </form>
            <div id="responseMessage" class="text-gray-300 mt-4"></div>

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


    function togglePassword(inputId) {
        const passwordInput = document.getElementById(inputId);
        const passwordIcon = document.getElementById(inputId + "Icon");
        const passwordIconClose = document.getElementById(inputId + "IconClose");

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            passwordIcon.classList.add('hidden');
            passwordIconClose.classList.remove('hidden');
        } else {
            passwordInput.type = "password";
            passwordIconClose.classList.add('hidden');
            passwordIcon.classList.remove('hidden');
        }
    }
    $("#registrationForm").on("submit", function(event) {
        event.preventDefault();

        $(".text-red-500").text(""); 

        $.ajax({
            url: "../controllers/register.controller.php",
            type: "POST",
            data: $(this).serialize(),
            dataType: "json",
            success: function(response) {
                if (response.status === "error") {
                    for (const [field, message] of Object.entries(response.errors)) {
                        $(`#error${field.charAt(0).toUpperCase() + field.slice(1)}`).text(message);
                    }
                }
                if (response.status === "errorFail") {
                    $("#errorRegisterFail").text(response.registerFail);
                }
                if (response.status === "errorExist") {
                    $("#errorEmailExist").text(response.emailExist);
                }
                if (response.status === "errorUsername") {
                    $("#errorUsername").text(response.usernameExist);
                }
                if (response.status === "success") {
                    $("#successMessage").fadeIn().text(response.message);
                    setTimeout(() => {
                        window.location.href = "./login.php";
                    }, 1500);
                }
            },
            error: function(xhr, status, error) {
                console.error("An error occurred:", error);
            }
        });
    });
</script>
</body>

</html>