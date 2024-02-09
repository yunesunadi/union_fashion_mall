<?php include(__DIR__ . "/../vendor/autoload.php"); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./node_modules/@fortawesome/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="./node_modules/@flaticon/flaticon-uicons/css/all/all.css">
    <link rel="stylesheet" href="./node_modules/@splidejs/splide/dist/css/splide.min.css">
    <link rel="stylesheet" href="./assets/css/custom.css">
    <title>About Us</title>
</head>

<body>
    <?php include(__DIR__ . "/components/nav.php"); ?>

    <main class="pt-5 pb-3 py-md-5">
        <section class="hero">
            <div class="card position-relative">
                <img src="assets/images/aboutus.jpg" class="card-img object-fit-cover d-none d-md-block" height="450"
                    alt="Image by unsplash - https://images.unsplash.com/photo-1552664730-d307ca884978?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D">
                <img src="assets/images/aboutus.jpg" class="card-img object-fit-cover d-md-none" height="250"
                    alt="Image by unsplash - https://images.unsplash.com/photo-1552664730-d307ca884978?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D">
                <div class="card-img-overlay text-white d-grid justify-content-center align-content-center text-center mt-5 mt-md-0 z-1"
                    id="hero-content">
                    <h1 class="card-title display-6">About Us</h1>
                </div>
                <div class="position-absolute top-0 start-0 w-100 h-100 bg-primary opacity-25"></div>
            </div>
        </section>
        <section class="info mt-4 mt-md-5 mb-3">
            <div class="container">
                <div class="mx-auto mb-4 mb-md-5 ourstory px-3">
                    <h3 class="text-primary text-center mb-3">Our Story</h3>
                    <p>
                        UNION, a pioneering ecommerce company, emerged in the bustling digital landscape with a vision
                        to redefine online shopping. Founded by a dynamic team of tech enthusiasts and business
                        visionaries, UNION quickly gained prominence for its seamless user experience, cutting-edge
                        technology integration, and a commitment to sustainability. The company differentiated itself by
                        curating a diverse range of high-quality products while prioritizing ethical sourcing and
                        eco-friendly practices. UNION's innovative approach to customer engagement, leveraging augmented
                        reality for virtual try-ons and personalized recommendations, set it apart in the competitive
                        market. As a result, UNION swiftly garnered a dedicated customer base and became synonymous with
                        the future of conscientious and tech-savvy online retail.</p>
                </div>
                <div class="mb-4 mb-md-5 ourmission px-3">
                    <h3 class="text-center text-primary mb-3">Our Mission</h3>
                    <div class="row align-items-center g-2 g-md-5">
                        <div class="col-lg-6 col-xl-7">
                            <p>
                                The mission of UNION, an innovative e-commerce company, is to seamlessly connect
                                individuals
                                with a diverse range of high-quality products and services, fostering a sense of unity
                                and
                                empowerment. Committed to enhancing the online shopping experience, UNION prioritizes
                                customer
                                satisfaction by providing a user-friendly platform that embraces cutting-edge technology
                                and
                                personalized recommendations. With a dedication to ethical business practices,
                                sustainability,
                                and community engagement, UNION aims to not only meet but exceed the evolving needs and
                                expectations of its customers, creating a harmonious and inclusive digital marketplace
                                that
                                transcends traditional boundaries.</p>
                        </div>
                        <div class="col-lg-6 col-xl-5">
                            <img src="assets/images/ourmission.jpg" class="img-fluid img-thumbnail"
                                alt="Image by unsplash - https://images.unsplash.com/photo-1542744173-8e7e53415bb0?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D">
                        </div>
                    </div>
                </div>
                <div class="px-3 ourvision">
                    <h3 class="text-center text-primary mb-3">Our Vision</h3>
                    <div class="row align-items-center g-3 g-md-5">
                        <div class="col-lg-6 col-xl-5">
                            <img src="assets/images/ourvision.jpg" class="img-fluid img-thumbnail"
                                alt="Image by unsplash - https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D">
                        </div>
                        <div class="col-lg-6 col-xl-7">
                            <p>UNION envisions a revolutionary e-commerce landscape that transcends traditional
                                boundaries,
                                fostering a seamless connection between consumers and a diverse array of products and
                                services.
                                Committed to innovation and inclusivity, UNION strives to create a digital marketplace
                                where
                                every individual, irrespective of background or location, can discover, engage with, and
                                purchase high-quality goods. Embracing cutting-edge technology, UNION aims to redefine
                                the
                                online shopping experience through personalized recommendations, immersive virtual
                                interactions,
                                and a commitment to sustainability. By integrating social responsibility, advanced
                                technology, and a
                                customer-centric approach, UNION endeavors to shape the future of e-commerce into a
                                space that
                                reflects the diverse needs and aspirations of its users.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include(__DIR__ . "/components/footer.php"); ?>

    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>