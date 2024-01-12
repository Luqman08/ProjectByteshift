<style>
    body {
        margin-bottom: 100px;
        /* Add margin at the bottom of the body to prevent the footer from overlapping content */
    }

    .footer {
        opacity: 0;
        transition: opacity 0.5s ease;
        position: fixed;
        left: 50%;
        transform: translateX(-50%);
        bottom: 0;
        width: 97%;
        text-align: center;
        /* Set a higher z-index to ensure the footer appears above other content */
    }
</style>

<div class="footer" id="myFooter">
    <div class="bg-secondary rounded-top p-4">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-6 text-center text-sm-start">
                    &copy; <a href="#">ACAMS</a>, All Right Reserved.
                </div>
                <div class="col-12 col-sm-6 text-center text-sm-end">
                    Designed By <a href="https://htmlcodex.com">Byteshift</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Check if the page requires scrolling
        if (document.body.scrollHeight > window.innerHeight) {
            window.addEventListener("scroll", function() {
                var scrollPosition = window.scrollY;
                var windowHeight = window.innerHeight;
                var documentHeight = document.body.offsetHeight;

                // Adjust this value to control when the footer appears (e.g., 80% from the top)
                var scrollTrigger = 0.8;

                if (scrollPosition > (documentHeight - windowHeight) * scrollTrigger) {
                    document.getElementById("myFooter").style.opacity = "1";
                } else {
                    document.getElementById("myFooter").style.opacity = "0";
                }
            });
        } else {
            // If the page doesn't require scrolling, show the footer
            document.getElementById("myFooter").style.opacity = "1";
        }
    });
</script>