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
<!-- <script>
    $(document).ready(function() {
        // Handle pagination clicks
        $(document).on('click', '#pagination-container .pagination a', function(e) {
            e.preventDefault();
            var page = $(this).attr('href').split('index/')[1];
            loadNews(page);
        });

        function loadNews(page) {
            $.ajax({
                url: '<?php #echo site_url("news/load_news"); 
                        ?>',
                type: 'GET',
                data: {
                    page: page
                },
                dataType: 'json',
                success: function(response) {
                    var newsHtml = '';

                    // Generate HTML for news items
                    response.news.forEach(function(item) {
                        newsHtml += `
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <img src="<?php #echo base_url(); 
                                            ?>${item.image}" class="card-img-top" alt="Article Image">
                                <div class="card-body">
                                    <h5 class="card-title">${item.title}</h5>
                                    <p class="card-text" style="font-size: 12px; color: gray;">
                                        ${item.updated_at}
                                    </p>
                                    <p class="card-text">
                                        ${item.content.split(' ').slice(0, 20).join(' ')}...
                                    </p>
                                    <a href="<?php #echo site_url('news/'); 
                                                ?>${item.slug}" class="btn btn-primary">Read More</a>
                                </div>
                            </div>
                        </div>
                    `;
                    });

                    // Update the news container
                    $('#news-container').html(newsHtml);

                    // Update URL without refreshing
                    window.history.pushState({}, '', '<?php #echo site_url("news/index"); 
                                                        ?>' + page);

                    // Scroll to top of news section
                    $('html, body').animate({
                        scrollTop: $("#news-container").offset().top
                    }, 500);
                },
                error: function(xhr, status, error) {
                    console.error('Error loading news:', error);
                }
            });
        }
    });
</script> -->


</body>

</html>