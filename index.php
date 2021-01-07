<?php
/*
Group 13
September 29, 2016
WEBD3201
The main page 
*/
$title = "Home Page";
$date = "September 29, 2016";
$filename = "index.php";
$description = "Home Page for realtor";
include("header.php");
?>
	<!--Content body -->
	<section class="home" id="home">
        <div class="max-width">
            <div class="home-content">
                <div class="text-1">#1 Durham Region </div>
                <div class="text-2">Real Estate Market</div>
                <div class="text-3">HousesConnected has <span class="typing"></span></div>
                <a href="#">Search</a>
                <a href="#">Login</a>
            </div>
        </div>
    </section>

    <!-- about section start -->
    <section class="about" id="about">
        <div class="max-width">
            <h2 class="title">We are top reviewed company</h2>
            <div class="about-content">
                <div class="column left">
                    <img src="images/LogoFinal2.png" alt="">
                </div>
                <div class="column right">
                    <div class="text">We are here to assist <span class="typing-2"></span></div>
                    <p>We have helped over thousands of buyers and sellers completing a transaction. We have done this for plenty of years and we will coninue to improve our website for Durham Region.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- services section start -->
    <section class="services" id="services">
        <div class="max-width">
            <h2 class="title">Our services</h2>
            <div class="serv-content">
                <div class="card">
                    <div class="box">
                        <i class="fas fa-comments-dollar"></i>
                        <div class="text">Negotiate</div>
                        <p>Chat with the Seller or Agent to negotiate a price for you.</p>
                    </div>
                </div>
                <div class="card">
                    <div class="box">
                        <i class="fas fa-search"></i>
                        <div class="text">Find the new home</div>
                        <p>Use our advanced search, to discover the new home you may want.</p>
                    </div>
                </div>
                <div class="card">
                    <div class="box">
                        <i class="fas fa-dollar-sign"></i>
                        <div class="text">Purchase your home</div>
                        <p>Purchase the home online, bet for the home you desire. </p>
                    </div>
                </div>
               </div>
            </div>
        </div>
    </section>

    <!-- showCase section start -->
    <section class="showCase" id="showCase">
        <div class="max-width">
            <h2 class="title">The Current Listings</h2>
            <div class="showCase-content">
                <div class="column left">
                    <div class="text">Abundant Number of Houses.</div>
                    <p>We have a whole list of different houses that have been sold, ready to be sold or is currently being sold.</p>
                    <a href="#">Read more</a>
                </div>
                <div class="column right">
                    <div class="bars">
                        <div class="info">
                            <span>Townhouses</span>
                            <span>18%</span>
                        </div>
                        <div class="line html"></div>
                    </div>
                    <div class="bars">
                        <div class="info">
                            <span>Semi</span>
                            <span>22%</span>
                        </div>
                        <div class="line css"></div>
                    </div>
                    <div class="bars">
                        <div class="info">
                            <span>Detach</span>
                            <span>34%</span>
                        </div>
                        <div class="line js"></div>
                    </div>
                    <div class="bars">
                        <div class="info">
                            <span>Apartment</span>
                            <span>26%</span>
                        </div>
                        <div class="line php"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- teams section start -->
    <section class="teams" id="teams">
        <div class="max-width">
            <h2 class="title">Our team</h2>
            <div class="carousel owl-carousel">
                <div class="card">
                    <div class="box">
                        <img src="images/profile-1.jpeg" alt="">
                        <div class="text">Danial Cook</div>
                    </div>
                </div>
                <div class="card">
                    <div class="box">
                        <img src="images/profile-2.jpeg" alt="">
                        <div class="text">Robert Jackson</div>
                    </div>
                </div>
                <div class="card">
                    <div class="box">
                        <img src="images/profile-3.jpeg" alt="">
                        <div class="text">Emilly Wright</div>
                    </div>
                </div>
                <div class="card">
                    <div class="box">
                        <img src="images/profile-4.jpeg" alt="">
                        <div class="text">Quinn Fang</div>
                    </div>
                </div>
                <div class="card">
                    <div class="box">
                        <img src="images/profile-5.jpeg" alt="">
                        <div class="text">Maya Summer</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
		
<?php include 'footer.php'; ?>
