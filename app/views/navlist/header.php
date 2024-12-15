<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodBridge</title>
    <link rel="stylesheet" href="/foodbridge/public/assets/css/styles.css">
</head>
<body>
    <header style="display: flex; justify-content: space-between; align-items: center; padding: 10px 20px; border-bottom: 1px solid #ccc;">
        
        <!-- Logo -->
        <div>
            <a href="/foodbridge/home">
                <img src="/foodbridge/public/assets/images/foodbridge-logo-ver1.png" alt="FoodBridge Logo" style="height: 40px;">
            </a>
        </div>

        <!-- Navigation -->
        <nav>
            <ul style="list-style: none; display: flex; align-items: center; justify-content: center; padding: 0; margin: 0;">
                <li style="margin: 0 10px;">
                    <button style="background: none; color: black; border: none; padding: 10px 20px; font-size: 16px; cursor: pointer; display: flex; align-items: center;">
                        Learn
                        <span style="margin-left: 5px; display: inline-block; transform: rotate(45deg) translateY(-2px); border: solid black; border-width: 0 2px 2px 0; padding: 4px;"></span>
                    </button>
                </li>
                <li style="margin: 0 10px;">
                    <button style="background: none; color: black; border: none; padding: 10px 20px; font-size: 16px; cursor: pointer; display: flex; align-items: center;">
                        Get Involved
                        <span style="margin-left: 5px; display: inline-block; transform: rotate(45deg) translateY(-2px); border: solid black; border-width: 0 2px 2px 0; padding: 4px;"></span>
                    </button>
                </li>
                <li style="margin: 0 10px;">
                    <button style="background: none; color: black; border: none; padding: 10px 20px; font-size: 16px; cursor: pointer; display: flex; align-items: center;">
                        Support
                        <span style="margin-left: 5px; display: inline-block; transform: rotate(45deg) translateY(-2px); border: solid black; border-width: 0 2px 2px 0; padding: 4px;"></span>
                    </button>
                </li>
                <li style="margin: 0 10px;">
                    <button style="background: none; color: black; border: none; padding: 10px 20px; font-size: 16px; cursor: pointer; display: flex; align-items: center;">
                        Locations
                        <span style="margin-left: 5px; display: inline-block; transform: rotate(45deg) translateY(-2px); border: solid black; border-width: 0 2px 2px 0; padding: 4px;"></span>
                    </button>
                </li>
                <li style="margin: 0 10px;">
                    <button style="background: none; color: black; border: none; padding: 10px 20px; font-size: 16px; cursor: pointer; display: flex; align-items: center;">
                        About
                        <span style="margin-left: 5px; display: inline-block; transform: rotate(45deg) translateY(-2px); border: solid black; border-width: 0 2px 2px 0; padding: 4px;"></span>
                    </button>
                </li>
            </ul>
        </nav>

        <!-- User Actions -->
        <div style="display: flex; align-items: center;">
            
            <!-- Login Button -->
            <a href="/foodbridge/login" style="background: white; color: black; border: 1px solid black; padding: 10px 15px; font-size: 16px; cursor: pointer; border-radius: 5px; margin-right: 10px;">
                Login
            </a>
            
            <!-- Donate Button -->
            <a href="/foodbridge/donation" style="background: red; color: white; text-decoration: none; padding: 10px 20px; font-size: 16px; cursor: pointer; border-radius: 20px;">
                Donate
            </a>
        </div>
    </header>
</body>
</html>
