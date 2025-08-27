<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        /* background-color: green; */
        font-family: "Poppins", sans-serif;

    }

    body {

        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        height: 100vh;
        /* margin: 0; */
        background-image: url("images/92.jpeg");

        background-size: cover;
        background-position: center;
    }

    .wrapper {
        width: 420px;
        background-color: aliceblue;
        color: darkgreen;
        border-radius: 10px;
        padding: 30px 40px;
        /* box-shadow: 0 0 10px 0 rgba(0,0,0); */


    }

    .wrapper h1 {
        font-size: 36px;
        text-align: center;
    }

    .wrapper .input-box {
        width: 100%;
        height: 50px;
        /* background-color: pink; */
        margin: 30px 0;
    }

    .input-box input {
        width: 100%;
        height: 100%;
        background-color: transparent;
        border: none;
        outline: none;
        border: 2px solid lightgray;
        border-radius: 20px;
        font-size: 13px;
        color: black;
        padding: 10px 25px 10px 10px;
        margin-bottom: 10px;

    }

    .input-box input ::placeholder {
        color: #fff;
    }

    /* .wrapper .btn{
        width: 100%;
        height: 45px;
        background-color:pink;
        border: none;
        outline :none;
        border-radius: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, -1);
        cursor: pointer;
        font-size: 16px;
        color: #333;
        font-weight: 600;

    } */
    .wrapper .btn {
        width: 70%;
        height: 45px;
        background-color: pink;
        border: none;
        outline: none;
        border-radius: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, -1);
        cursor: pointer;
        font-size: 16px;
        color: darkmagenta;
        font-weight: 600;
        /* padding-left: 30px; */
        margin-right: 20px;
        margin-top: 20px;
        margin-left: 15px;

    }

    <script>
    document.querySelector("form").addEventListener("submit", function (e) {
        const password = document.getElementById("password").value;
        const errorSpan = document.getElementById("password-error");
        const strongPasswordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;

        if (!strongPasswordPattern.test(password)) {
            e.preventDefault(); // Stop form submission
            errorSpan.textContent = "Password must be at least 8 characters and include uppercase, lowercase, number, and special character.";
        } else {
            errorSpan.textContent = ""; // Clear error if valid
        }
    });
</script>



</style>

<body>
    <div class="wrapper">
        <h1>Register Now </h1>
        <form action="register2.php" method="POST">
            <table class="input-box">
                <tr>
                    <td>Name : </td>
                    <td><input type="text" name="name" placeholder="Name : "></td>

                </tr>
                <tr>
                    <td> Username : </td>
                    <td><input type="text" name="username" placeholder="Username : "></td>

                </tr>
                <tr>
                    <td> Password : </td>
                    <td><input type="password" name="password" id="password" placeholder="Password :
                     " required>
                     <span id="password-error" style="color:red; font-size: 12px;"></span></td>

                </tr>
                
                <tr>
                    <td> Phone : </td>
                    <td><input type="text" name="phone" placeholder="phone : "></td>

                </tr>
                <tr>
                    <td> Address : </td>
                    <td><input type="text" name="address" placeholder="address : "></td>

                </tr>
                <tr>
                    <td><input class="btn" type="reset"></td>
                    <td><input class="btn" type="submit" value="Sign up"></td>

                </tr>
                <?php
if (isset($_GET['error']) && $_GET['error'] == 'weak_password') {
    echo "<script>
        window.onload = function() {
            alert('❌ Password must be at least 8 characters long and include uppercase, lowercase, number, and special character.');
        };
    </script>";
}
?>

                

            </table>
        </form>
    </div>
</body>

</html>