</div>

<footer>
    <p>&copy; 2024 NewsSite. All rights reserved.</p>
</footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    let headlines = [];
    let currentHeadlineIndex = 0;

    function updateHeadline() {
        if (headlines.length === 0) return;

        const headline = headlines[currentHeadlineIndex];
        $('#headline-title').text(headline.title);

        // Move to the next headline, loop back to the start
        currentHeadlineIndex = (currentHeadlineIndex + 1) % headlines.length;
    }

    // Fetch headlines via AJAX
    function fetchHeadlines() {
        $.ajax({
            url: '<?php echo site_url('news'); ?>',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                console.log(data);
                headlines = data; // Save the headlines
                currentHeadlineIndex = 0; // Reset to the first headline
                updateHeadline(); // Update the first headline immediately

                // Rotate every 10 seconds
                setInterval(updateHeadline, 10000);
            },
            error: function() {
                console.error('Failed to fetch recent news');
            }
        });
    }

    $(document).ready(function() {
        fetchHeadlines();
    });
</script>

</body>

</html>