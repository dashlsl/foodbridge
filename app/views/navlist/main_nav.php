<?php

if (!defined('ACCESS')) {
    http_response_code(404);
    die();
}

use App\Models\UserModel;

$curRole = UserModel::getCurUserRole();

if ($curRole == 'guest' || $curRole == 'donate') :
    $navBtnUrl = 'donate-form';

    $navBtn = 'DONATE';

elseif ($curRole == 'volunteer') :
    $navBtnUrl = 'volunteer-form';

    $navBtn = "DELIVER / PICKUP";

elseif ($curRole == 'admin') :
    $navBtnUrl = 'admin-recycle';
    $navBtnUrl = $navProfileUrl;

    $navBtn = 'ADMIN VIEW';
endif;

$nav['header'] = <<<HTML
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
            
            <!-- Action Button -->
            <a href="$root/$navBtnUrl" style="background: red; color: white; text-decoration: none; padding: 10px 20px; font-size: 16px; cursor: pointer; border-radius: 20px;">
                $navBtn
            </a>
        </div>
    </header>
HTML;

$nav['footer'] = <<<HTML
    <footer style="display: flex; justify-content: space-between; padding: 20px; border-top: 1px solid #ccc; font-size: 14px; color: black;">
        
        <div style="text-align: center; margin-right: 20px;">
            <img src="/foodbridge/public/assets/images/foodbridge-logo-ver1.png" alt="FoodBridge Logo" style="height: 40px; margin-bottom: 20px;">
            <p style="margin: 0; font-size: 14px; color: black; font-weight: bold;">&copy; Copyright 2024 FoodBridge</p>
            <p style="margin-top: 10px;">All Rights Reserved</p>
        </div>

        <!-- About Section -->
        <div style="margin-right: 40px;">
            <p style="font-weight: bold; margin-bottom: 15px;">About</p>
            <ul style="list-style: none; padding: 0; margin: 0;">
                <li style="margin-bottom: 10px;"><a href="#" style="text-decoration: none; color: black;">History</a></li>
                <li style="margin-bottom: 10px;"><a href="#" style="text-decoration: none; color: black;">Our Team</a></li>
                <li><a href="#" style="text-decoration: none; color: black;">Locations</a></li>
            </ul>
        </div>

        <!-- Support Section -->
        <div style="margin-right: 40px;">
            <p style="font-weight: bold; margin-bottom: 15px;">Support</p>
            <ul style="list-style: none; padding: 0; margin: 0;">
                <li style="margin-bottom: 10px;"><a href="#" style="text-decoration: none; color: black;">FAQ</a></li>
                <li style="margin-bottom: 10px;"><a href="#" style="text-decoration: none; color: black;">Terms of Service</a></li>
                <li><a href="#" style="text-decoration: none; color: black;">Privacy Policy</a></li>
            </ul>
        </div>

        <!-- Contact Us Section -->
        <div>
            <p style="font-weight: bold; margin-bottom: 15px;">Contact Us</p>
            <p style="margin: 0; margin-bottom: 10px;">012-345 6789</p>
            <p style="margin: 0; margin-bottom: 10px;">foodbridge@gmail.com</p>
            <p style="margin: 0; margin-bottom: 5px;">123, Jalan Street 123,</p>
            <p style="margin: 0;">Selangor, Malaysia 23123</p>
        </div>
    </footer>
HTML;
