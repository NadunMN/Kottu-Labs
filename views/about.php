<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="About Kottu Labs - A cozy restaurant offering a variety of Kottu dishes in multiple locations across Sri Lanka">
    <title>About Us - Kottu Labs</title>
    <link rel="stylesheet" href="/CSS/about.css">
    <!-- Preload important images -->
    <link rel="preload" as="image" href="/Photo/Thirani_pics/Wattala.png">
    <link rel="preload" as="image" href="/Photo/Thirani_pics/Kelaniya.jpg">
    <link rel="preload" as="image" href="/Photo/Thirani_pics/Kotahena.jpg">
</head>

<body>
    <main>
        <!-- Hero Section -->
        <section class="container1" aria-label="Page Header">
            <div class="title">
                <h1>About Us</h1>
            </div>
        </section>

        <!-- Welcome Section -->
        <section class="container2" aria-label="Welcome Message">
            <h2>Welcome to</h2>
            <div class="Name"><span style="color: white;">KOTTU</span><span style="color: red;">LABS</span></div>

            <p class="welcome-text">
                A cozy restaurant offering a large variety of Kottu dishes, 
                served in an inviting atmosphere with attentive service.
            </p>
        </section>

        <!-- Branches Section -->
        <h2 class="topic">Our Locations</h2>
        <section class="container3" >
            <!-- Wattala Branch Card -->
            <article class="card">
                <img src="/Photo/Thirani_pics/Wattala.png" 
                     alt="Wattala Branch Exterior" 
                     loading="lazy">
                <div class="intro">
                    <h3>Wattala Branch</h3>
                    <p>
                        Kottu Labs' <strong>Wattala branch</strong> offers a vibrant dining experience, 
                        specializing in a wide variety of freshly made kottu dishes. With its modern 
                        ambiance and friendly staff, it's the perfect spot to enjoy Sri Lanka's 
                        beloved street food with a creative twist.
                    </p>
                </div>
            </article>

            <!-- Kelaniya Branch Card -->
            <article class="card">
                <img src="/Photo/Thirani_pics/Kelaniya.jpg" 
                     alt="Kelaniya Branch Interior" 
                     loading="lazy">
                <div class="intro">
                    <h3>Kelaniya Branch</h3>
                    <p>
                        Kottu Labs' <strong>Kelaniya branch</strong> offers a wide variety of 
                        freshly made kottu dishes in an aesthetic dining area that blends 
                        traditional charm with contemporary design. The friendly and attentive 
                        staff ensure that every visit is not just a meal, but an enjoyable experience.
                    </p>
                </div>
            </article>

            <!-- Kotahena Branch Card -->
            <article class="card">
                <img src="/Photo/Thirani_pics/Kotahena.jpg" 
                     alt="Kotahena Branch Dining Area" 
                     loading="lazy">
                <div class="intro">
                    <h3>Kotahena Branch</h3>
                    <p>
                        Kottu Labs' <strong>Kotahena branch</strong>, the newly opened branch 
                        elevates the kottu dining experience with its fine dining area, where 
                        elegance meets comfort. Specializing in a range of expertly crafted 
                        kottu dishes, this branch offers the perfect setting for a sophisticated taste.
                    </p>
                </div>
            </article>
        </section>
    </main>
</body>
</html>