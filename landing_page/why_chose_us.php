<div class="container">
    <div id="wt" class="row text-center">
        <h1 style="color: rgb(148, 54, 236);">Why Choose Us</h1>
    </div>
</div>
<br><br><br><br>

<div class="row">
    <!-- Define a list of cards with their content -->
    <?php
    $cards = array(
        array(
            "image" => "../assets/img/landing_page_img/ex1.png",
            "title" => "Peer-Driven Expertise",
            "description" => "Our platform is built on the belief that the collective wisdom of students can effectively identify exceptional teaching quality."
        ),
        array(
            "image" => "../assets/img/landing_page_img/ex2.png",
            "title" => "Verified Ratings",
            "description" => "Say goodbye to uncertainty. Our verified ratings reflect the real impact tutors have on their students."
        ),
        array(
            "image" => "../assets/img/landing_page_img/ex3.png",
            "title" => "Interactive Q&A",
            "description" => "Engage directly with tutors through our interactive Q&A section and receive accurate insights to your questions."
        ),
        array(
            "image" => "../assets/img/landing_page_img/ex4.png",
            "title" => "Empowering Educators",
            "description" => "For tutors, this platform serves as a channel to showcase expertise and connect with students seeking their guidance."
        )
    );

    // Loop through the cards and generate HTML
    foreach ($cards as $card) {
        echo '<div class="col-md-3 d-flex justify-content-center">';
        echo '<div class="card popupEffect align-items-center" style="width: 16rem; height: 25rem; margin-top: 5px; background-color: rgb(148, 54, 236);">';
        echo '<br>';
        echo '<img src="' . $card["image"] . '" class="card-img-top" alt="logo" loading="lazy" style="height: 120px; width: 120px;">';
        echo '<br>';
        echo '<div class="card-body text-white">';
        echo '<h5 class="card-title text-center">' . $card["title"] . '</h5>';
        echo '<br>';
        echo '<p class="card-text text-center">' . $card["description"] . '</p>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
    ?>
</div>