<?php
session_start();

// Redirect to dashboard if already logged in
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("Location: dashboard.php");
    exit;
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $credentials = file("credentials.txt", FILE_IGNORE_NEW_LINES);

    foreach ($credentials as $line) {
        list($username, $password) = explode(",", trim($line));
        if ($_POST["username"] == $username && $_POST["password"] == $password) {
            $_SESSION['loggedin'] = true;
            header("Location: dashboard.php");
            exit;
        }
    }

    $error = "Invalid username or password!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        /* Reset and Base Styles */
        body, html {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
                
                         
             background-image: url('trip.png');
  background-size: cover;  /* Ensure the image covers the entire screen */
  background-position: center; /* Center the image */
  background-repeat: no-repeat; /* Prevent the image from repeating */

        }

        /* Container Styling */
        form {
            background-color: ;
            border-radius: 10px;
           box-shadow: 0 10px 50px rgba(0, 0, 0, 0.5);
            padding: 30px;
            width: 100%;
            max-width: 400px;
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        form:hover {
            transform: translateY(-5px);
           box-shadow: 0 10px 50px rgba(0, 0, 0, 0.7);
        }

        /* Heading Style */
        form h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        /* Label Styling */
        form label {
            font-size: 16px;
            display: block;
            text-align: left;
            margin: 10px 0 5px;
            color: #555;
        }

        /* Input Fields */
        form input[type="text"], 
        form input[type="password"] {
            width: 85%;
            padding: 12px 15px;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 15px;
            outline: none;
            transition: border-color 0.3s;
        }

        form input[type="text"]:focus, 
        form input[type="password"]:focus {
            border-color: #4caf50;
            box-shadow: 0 0 5px rgba(76, 175, 80, 0.5);
        }

        /* Submit Button */
        form button {
            background-color: #4caf50;
            color: #fff;
            border: none;
            padding: 12px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            width: 85%;
            transition: background-color 0.3s;
        }

        form button:hover {
            background-color: #45a049;
        }

        /* Toast Message */
        .toast {
            visibility: hidden;
            width: 300px;
            height: auto;
            background-color: #ffcccb;
            color: #333;
            text-align: center;
            border-radius: 10px;
            padding: 15px;
            position: fixed;
            z-index: 1;
            left: 50%;
            top: 10%;
            transform: translateX(-50%);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            font-size: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: visibility 0.5s, transform 0.5s ease-in-out;
        }

        .toast.show {
            visibility: visible;
            transform: translateX(-50%) translateY(15px);
        }

        /* Mobile Responsive */
        @media only screen and (max-width: 600px) {
            form {
                padding: 20px;
            }

            form h2 {
                font-size: 20px;
            }

            form label {
                font-size: 14px;
            }

            form input[type="text"], 
            form input[type="password"] {
                font-size: 12px;
                padding: 10px 12px;
            }

            form button {
                font-size: 14px;
                padding: 10px;
            }
        }
            
/* Mobile Responsive */
@media only screen and (max-width: 600px) {
    /* Form adjustments */
    form {
        padding: 20px;
    }

    form h2 {
        font-size: 20px;
    }

    form label {
        font-size: 14px;
    }

    form input[type="text"], 
    form input[type="password"] {
        font-size: 12px;
        padding: 10px 12px;
        width: 85%; /* Ensure inputs take full width on smaller screens */
    }

    form button {
        font-size: 14px;
        padding: 10px;
        width: 85%; /* Full width button on smaller screens */
    }
}

/* Additional styles for very small screens (below 400px) */
@media only screen and (max-width: 400px) {
    form {
        padding: 15px;
    }

    form h2 {
        font-size: 18px;
    }

    form label {
        font-size: 12px;
    }

    form input[type="text"], 
    form input[type="password"] {
        font-size: 10px;
        padding: 8px 10px;
    }

    form button {
        font-size: 12px;
        padding: 8px 10px;
    }
}
            /* Profile Container */
.profile-container {
  position: absolute;
  top: 20px;
  right: 20px;
  cursor: pointer;
  text-align: center;
  z-index: 1000;
}

.profile-pic {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  border: 2px solid black;
  transition: transform 0.2s;
}

.profile-pic:hover {
  transform: scale(1.1);
}

.profile-menu {
  display: none;
  position: absolute;
  top: 50px;
  right: 0;
  background-color: #f1f1f1;
  border: 1px solid #ccc;
  border-radius: 8px;
  box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
  z-index: 1;
  padding: 15px;
  width: 300px;
  text-align: center;
  max-height: 400px;
  overflow-y: auto;
}

.profile-menu img {
  width: 90px;
  height: 90px;
  border-radius: 50%;
  margin-bottom: 15px;
}

.profile-menu p {
  margin: 10px 0;
  color: #333;
  font-size: 16px;
}

/* Responsive Styles */
@media (max-width: 768px) {
  .profile-container {
    top: 10px;
    right: 10px;
  }

  .profile-menu {
    width: 250px;
    top: 40px;
  }

  .profile-menu img {
    width: 70px;
    height: 70px;
  }
}
    a {
  text-decoration: none; /* Removes the underline */
  color: inherit; /* Inherits the color of its parent */
}

a:hover, a:focus {
  color: inherit; /* Ensures hover/focus states match parent color */
  text-decoration: none; /* Ensures no underline appears on hover/focus */
}
            /* Button Styles */
button {
  padding: 10px 20px;
  font-size: 16px;
  margin: 10px 5px;
  border: none;
  color: #fff;
  cursor: pointer;
  border-radius: 5px;
  transition: background-color 0.3s;
}
/* Table Styles */
    </style>
</head>
<body>
        <div class="profile-container d-flex align-items-center">
            <img src="pic.jpg" alt="Profile" class="profile-pic" onclick="toggleProfileMenu()">  
            <p class="profile-text mb-0">Menu</p>
            <div class="profile-menu" id="profileMenu" style="display: none;">
                    <img src="pic.jpg" alt="Profile" class="profile-pic-large">
                 
                    <p id="userName"><strong>Form:</strong><br></p>
                  
                    <button  class="logout-btn btn btn-danger btn-block" style="background-color: black; border-color: #320ca0;"><a href="index.html">Form</a></button>
    
    </div>

                </div>
            </div>
    <form method="POST" action="login.php">
        <h2>Login</h2>
        <?php if (!empty($error)): ?>
            <div class="toast show"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <button type="submit">Login</button>
    </form>
          <script>
      
    function toggleProfileMenu() {
        var menu = document.getElementById("profileMenu");
        menu.style.display = (menu.style.display === "block") ? "none" : "block";
    }

    window.onclick = function(event) {
        var menu = document.getElementById("profileMenu");
        var profilePic = document.querySelector('.profile-pic');
        
        if (!event.target.matches('.profile-pic') && !menu.contains(event.target)) {
            menu.style.display = "none";
        }

        // Handle the navbar collapsing when clicking outside of it
        var navbarCollapse = document.getElementById("navbarNav");
        if (!navbarCollapse.contains(event.target)) {
            $('.navbar-collapse').collapse('hide');
        }
    }

    </script>
</body>
</html>
