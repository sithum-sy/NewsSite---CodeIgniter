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
                url: '<?php echo site_url("news"); ?>',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    headlines = data; // Save the headlines
                    currentHeadlineIndex = 0; // Reset to the first headline
                    updateHeadline(); // Update the first headline immediately

                    // Rotate every 5 seconds
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

        $(document).ready(function() {
            // AJAX for pagination
            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();

                // Get the page number from the link
                const page = $(this).attr('data-ci-pagination-page');

                // Log the URL to the console to check the generated URL
                const url = '<?php echo site_url('news/fetch_news'); ?>'; // URL being used
                console.log('AJAX Request URL:', url + '?page=' + page); // Log it to check the full URL


                // Send AJAX request to fetch the news for the selected page
                $.ajax({
                    url: '<?php echo site_url('news/fetch_news'); ?>',
                    type: 'GET',
                    data: {
                        page: page
                    },
                    dataType: 'json',
                    success: function(response) {
                        // Update the news container with the new news items
                        let html = '';
                        $.each(response.news, function(index, news_item) {
                            html += `
                            <div class="col-md-4 mb-4">
                                <div class="card">
                                    <img src="${news_item.image}" class="card-img-top" alt="Article Image">
                                    <div class="card-body">
                                        <h5 class="card-title">${news_item.title}</h5>
                                        <p class="card-text">${news_item.content.substring(0, 100)}...</p>
                                        <a href="<?php echo site_url('news/'); ?>${news_item.slug}" class="btn btn-primary">Read More</a>
                                    </div>
                                </div>
                            </div>
                        `;
                        });
                        $('#news-container').html(html);

                        // Update the pagination links
                        $('#pagination-links').html(response.pagination_links);
                    },
                    error: function() {
                        alert('Failed to fetch news.');
                    }
                });
            });
        });
    </script>

    </body>

    </html>