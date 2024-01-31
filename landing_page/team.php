<br><br><br><br><br><br>
<div class="row text-center">
    <h1 style="color: rgb(148, 54, 236);">Our Leading, Strong
        <br> And Creative Team
    </h1>
</div>

<!-- pictures  -->

<br><br><br>
<div class="container">
    <!-- <div class="row justify-content-center"> -->
        <?php
        $teamMembers = [
            [
                "name" => "Sk Md Altab",
                "role" => "UI/UX DESIGNER, Back-End Developer",
                "image" => "../assets/img/landing_page_img/teamMember1.png",
            ],
            [
                "name" => "Samarpita Mukherjee",
                "role" => "Front-End Developer,Tester",
                "image" => "../assets/img/landing_page_img/samarpita-modified.png",
            ],
            [
                "name" => "Soumik Halder",
                "role" => "UI/UX DESIGNER",
                "image" => "../assets/img/landing_page_img/soumik-modified.png",
            ],
            [
                "name" => "Soumyadeep Choudhury",
                "role" => "Front_End Developer",
                "image" => "../assets/img/landing_page_img/soumyadeep-modified.png",
            ],
            [
                "name" => "Shobhan Sen",
                "role" => "Back-End Developer",
                "image" => "../assets/img/landing_page_img/shobhan-modified.png",
            ],
       
         
       
            // Add more team members as needed
        ];

        $count = 0;

        foreach ($teamMembers as $member) {
            if ($count % 3 === 0) {
                echo '</div><div class="row justify-content-center">';
            }
            ?>
            <div class="col-md-4 d-flex justify-content-center" style="margin-bottom: 20px;">
                <div class="card popupEffect rounded-5" style="width: 15rem;">
                    <img src="<?php echo $member['image']; ?>" class="card-img-top" alt="..." loading="lazy">
                    <div class="card-body">
                        <h5 class="card-title text-center">
                            <?php echo $member['name']; ?>
                        </h5>
                        <p class="text-center" style="font-size: 10px">
                            <?php echo $member['role']; ?>
                        </p>
                        <ul class="ul mt-3" style="font-size: 18px;
                            list-style: none;
                            display: flex;
                            align-items: center;
                            justify-content: evenly;">
                            <li id="g"><i class="bi bi-google p-3"></i></li>
                            <li id="f"><i class="bi bi-facebook p-3"></i></li>
                            <li id="t"><i class="bi bi-twitter p-3"></i></li>
                        </ul>
                    </div>
                </div>
            </div>
            <?php
            $count++;
        }
        ?>
    </div>


<br><br><br><br>