<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>

    
    <link rel="stylesheet" href="/foodbridge/public/assets/css/styles.css">
    
</head>
<body>
<?php include(ROOT . '/app/views/includes/header.php'); ?>

    <div class="home-container">
    <a href="/foodbridge/donation" class="donate-button">Donate Now</a>
        <div class="main-text">
            <h1>Bringing Food</h1>
            <h2>Fighting Hunger</h2>
        </div>

        <div class="lorem-text">
            Lorem ipsum dolor sit amet consectetur adipiscing elit mattis sit.
        </div>

        <div class="columns">
            <div class="column">
                <p>Phasellus mollis sit aliquam sit nullam neque ultrices.</p>
            </div>
        </div>

        <a href="#" class="volunteer-button">Become a Volunteer</a>

        <div class="subtitle">SUBTITLE</div>
        <div class="what-we-do">What We Do</div>

        <div class="lorem-text-bottom">
            Lorem ipsum dolor sit amet consectetur adipiscing elit mattis sit.
        </div>

        <div class="column-bottom">
            <p>Phasellus mollis sit aliquam sit nullam neque ultrices.</p>
        </div>

        
        <div class="square-box">
    <h3>RECOVER</h3>
    <p class="sub-text">Surplus Food</p>
    <p class="description-text">We recruit volunteers to transport fresh food surpluses from local businesses to social service agencies that assist the food insecure.</p>
    
    <a href="#" class="square-box-button">RECOVER FOOD</a>
</div>

<div class="square-box">
    <h3>HELP</h3>
    <p class="sub-text">The Environment</p>
    <p class="description-text">In Malaysia, approximately 16,688 tonnes of food are wasted every day -- enough to feed 12 million people.</p>
   
    <a href="#" class="square-box-button">DONATE FOOD</a>
</div>

<div class="square-box">
    <h3>EMPOWER</h3>
    <p class="sub-text">Communities</p>
    <p class="description-text">Food donated helps thousands of struggling communities.</p>
    <!-- Empower Button -->
    <a href="#" class="square-box-button">RECEIVE FOOD</a>
</div>

        <!-- Image Below the Three Boxes -->
        <div class="image-container">
            <img src="/foodbridge/public/assets/images/fruit.png" alt="Image Description" class="full-width-image">
        </div>

        <!-- Admin Button (added here) -->
        <div class="admin-button-container">
            <a href="/foodbridge/admin" class="admin-button">Go to Admin</a>
        </div>


        <div class="news-updates">
             <p>News and Updates</p>
         </div>

    </div>

<div class="news-row-container">
            <button class="scroll-button left" onclick="scrollNews('left')">←</button>
            <div class="news-frames-container">
                <div class="news-frame">News 1</div>
                <div class="news-frame">News 2</div>
                <div class="news-frame">News 3</div>
                <div class="news-frame">News 4</div>
                <div class="news-frame">News 5</div>
                <div class="news-frame">News 6</div>
                <div class="news-frame">News 7</div>
                <div class="news-frame">News 8</div>
                <div class="news-frame">News 9</div>
                <div class="news-frame">News 10</div>
            </div>
            <button class="scroll-button right" onclick="scrollNews('right')">→</button>
        </div>
    </div>

<?php include(ROOT . '/app/views/includes/footer.php'); ?>

    <script>
        function scrollNews(direction) {
            const container = document.querySelector('.news-frames-container');
            const scrollAmount = 350; 

            if (direction === 'right') {
                container.scrollBy({
                    left: scrollAmount,
                    behavior: 'smooth'
                });
            } else if (direction === 'left') {
                container.scrollBy({
                    left: -scrollAmount,
                    behavior: 'smooth'
                });
            }
        }
    </script>
</body>
</html>