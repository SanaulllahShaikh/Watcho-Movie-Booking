<?php
$active_tab = 'reviews';
include './includes/header.php';

?>


<div class="flex-grow px-6">

    <main class="text-[#FEF9F2]">
        <div class="px-8 py-6 flex items-center justify-between border-b border-gray-800">
            <h1 class="text-3xl font-base">REVIEWS </h1>
            <div class="relative">
                <input type="text" id="searchReview" placeholder="Search review by user name or review"
                    class="w-80 py-2 pr-16 pl-6 rounded-full border border-gray-700 bg-[#222831] text-white placeholder-gray-400 transition duration-300 focus:outline-none focus:ring-2 focus:ring-[#CC2B52]">
                <button
                    class="absolute right-0 top-1/2 transform -translate-y-1/2 text-[#CC2B52] h-full pl-4 pr-6 rounded-r-full transition duration-300  hover:bg-[#CC2B52]  hover:text-white ">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5 " viewBox="0 0 24 24" fill="currentColor">
                        <path d="M18.031 16.6168L22.3137 20.8995L20.8995 22.3137L16.6168 18.031C15.0769 19.263 13.124 20 11 20C6.032 20 2 15.968 2 11C2 6.032 6.032 2 11 2C15.968 2 20 6.032 20 11C20 13.124 19.263 15.0769 18.031 16.6168ZM16.0247 15.8748C17.2475 14.6146 18 12.8956 18 11C18 7.1325 14.8675 4 11 4C7.1325 4 4 7.1325 4 11C4 14.8675 7.1325 18 11 18C12.8956 18 14.6146 17.2475 15.8748 16.0247L16.0247 15.8748Z"></path>
                    </svg>
                </button>
            </div>
        </div>

        <div class="mt-4">
            <table class="min-w-full text-white">
                <thead class="py-2">
                    <tr>
                        <th class="py-3 px-4 text-center text-xs font-normal">ID</th>
                        <th class="py-3 px-4 text-center text-xs font-normal">MOVIE ID</th>
                        <th class="py-3 px-4 text-center text-xs font-normal">MOVIE TITLE</th>
                        <th class="py-3 px-4 text-center text-xs font-normal">RATING</th>
                        <th class="py-3 px-4 text-center text-xs font-normal">REVIEW</th>
                        <th class="py-3 px-4 text-center text-xs font-normal">REVIEW DATE</th>
                        <th class="py-3 px-4 text-center text-xs font-normal">STATUS</th>
                        <th class="py-3 px-4 text-center text-xs font-normal">ACTIONS</th>
                    </tr>
                </thead>
                <tbody id="reviewsBody">
                    <tr class="bg-[#021526]">
                        <td class="py-5 px-4 text-center text-md">1</td>
                        <td class="py-5 px-4 text-center text-md">101</td> 
                        <td class="py-5 px-4 text-center text-md">Inception</td> 
                        <td class="py-5 px-4 text-center text-md">5/10</td> 
                        <td class="py-5 px-4 text-center text-md">Amazing movie with a great plot and stunning visuals!</td>
                        <td class="py-5 px-4 text-center text-md">2024-01-15</td>
                        <td class="py-5 px-4 text-center text-md">Approved</td>
                        <td class="py-5 px-4 space-x-2 flex items-center justify-center">
                            <button
                                class="bg-[#1E5128] text-[#03C988] p-1 rounded-md transition duration-300 hover:bg-[#3B5249]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-6" viewBox="0 0 24 24"
                                    fill="currentColor">
                                    <path
                                        d="M19 10H20C20.5523 10 21 10.4477 21 11V21C21 21.5523 20.5523 22 20 22H4C3.44772 22 3 21.5523 3 21V11C3 10.4477 3.44772 10 4 10H5V9C5 5.13401 8.13401 2 12 2C15.866 2 19 5.13401 19 9V10ZM5 12V20H19V12H5ZM11 14H13V18H11V14ZM17 10V9C17 6.23858 14.7614 4 12 4C9.23858 4 7 6.23858 7 9V10H17Z">
                                    </path>
                                </svg>
                            </button>
                            <button
                                class="bg-[#821131] text-[#CC2B52] p-1 rounded-md transition duration-300 hover:bg-[#800000]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-6" viewBox="0 0 24 24"
                                    fill="currentColor">
                                    <path
                                        d="M17 6H22V8H20V21C20 21.5523 19.5523 22 19 22H5C4.44772 22 4 21.5523 4 21V8H2V6H7V3C7 2.44772 7.44772 2 8 2H16C16.5523 2 17 2.44772 17 3V6ZM18 8H6V20H18V8ZM9 11H11V17H9V11ZM13 11H15V17H13V11ZM9 4V6H15V4H9Z">
                                    </path>
                                </svg>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>




        </div>

    </main>
</div>
</div>
<script>
    $.ajax({
        url: './controllers/fetch_reviews.php',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            $('#reviewsBody').empty();
            console.log(data);

            if (data.length <= 0) {
                let reviewRow = `
                        <tr>
                        
                         <td class="py-5 px-4 text-center text-md" colspan="8">No reviews found</td>
                        </tr>
                                        `
                $('#reviewsBody').append(reviewRow);
            }

            data.forEach(function(review) {

                const reviewRow = `
                        <tr class="bg-[#021526]" id="reviewRow${review.reviewId}">
                            <td class="py-5 px-4 text-center text-md">${review.review_id}</td>
                            <td class="py-5 px-4 text-center text-md">${review.movie_id}</td>
                            <td class="py-5 px-4 text-center text-md" data-title="${review.movie_title}">${review.movie_title}</td>
                            <td class="py-5 px-4 text-center text-md">${review.rating}/10</td>
                            <td class="py-5 px-4 text-center text-md">${review.review_text}</td>
                            <td class="py-5 px-4 text-center text-md">${review.review_date}</td>
                            <td class="py-5 px-4 text-center text-md">Approved</td>
                            <td class="py-5 px-4 space-x-2 flex items-center justify-center">
                                <button onclick="deleteReview(${review.review_id})" class="bg-[#821131] text-[#CC2B52] p-1 rounded-md transition duration-300 hover:bg-[#800000]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M17 6H22V8H20V21C20 21.5523 19.5523 22 19 22H5C4.44772 22 4 21.5523 4 21V8H2V6H7V3C7 2.44772 7.44772 2 8 2H16C16.5523 2 17 2.44772 17 3V6ZM18 8H6V20H18V8ZM9 11H11V17H9V11ZM13 11H15V17H13V11ZM9 4V6H15V4H9Z"></path>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    `;
                $('#reviewsBody').append(reviewRow);
            });
            document.getElementById("searchReview").addEventListener("input", function() {
                const searchValue = this.value.toLowerCase();
                const rows = document.querySelectorAll("#reviewsBody tr");

                rows.forEach((row) => {
                    const title = row.getAttribute("data-title").toLowerCase();
                    if (title.includes(searchValue)) {
                        row.style.display = "";
                    } else {
                        row.style.display = "none";
                    }
                });
            });


        },
        error: function(xhr, status, error) {
            console.error('AJAX request failed:', error);
        }
    });

    function deleteReview(reviewId) {
        if (confirm("Are you sure you want to delete this review?")) {
            $.ajax({
                url: './controllers/delete_review.php',
                method: 'GET',
                data: {
                    review_id: reviewId
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        alert(response.message);
                        $(`#reviewRow${reviewId}`).remove();
                        window.location.reload();
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX request failed:', error);
                    alert("An error occurred while trying to delete the review.");
                }
            });
        }
    }
</script>
</body>

</html>